<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gmail_cron Controller
 * Handles external cron webhook requests without authentication requirement
 * This extends CI_Controller directly to bypass MY_Controller's session check
 */
class Gmail_cron extends CI_Controller
{
    private $last_error = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->config('gmail_agent');
        $this->load->helper(array('url'));
        $this->_ensure_attachments_dir();
    }

    /**
     * Jalankan proses download attachment & mark as read (mirip api/gmail-cron/route.ts)
     * POST /Gmail_cron/run_cron
     *
     * Endpoint ini dipanggil dari luar (cron-job.org) tiap 1 menit, jadi WAJIB
     * ada verifikasi token supaya tidak bisa dipicu sembarang orang yang tahu URL-nya.
     */
    public function run_cron()
    {
        // Accept both POST and GET for cron compatibility
        $method = strtoupper($this->input->method());
        
        // ── Verifikasi webhook token ──────────────────────────────────────
        // External requests MUST provide valid token
        $secret = $this->config->item('gmail_webhook_secret');
        $sent   = $this->input->post('token') ?: $this->input->get('token');
        $is_internal_worker = (bool) ($this->input->post('_worker') ?: $this->input->get('_worker'));

        if (empty($secret)) {
            return $this->_json(500, array('error' => 'Webhook secret not configured'));
        }

        if ($sent !== $secret && !$is_internal_worker) {
            return $this->_json(401, array(
                'error' => 'Unauthorized: Invalid or missing token',
                'debug' => array(
                    'method' => $method,
                    'secret_configured' => !empty($secret),
                    'token_sent' => $sent,
                    'token_expected' => $secret,
                    'tokens_match' => ($sent === $secret),
                    'post_data' => $_POST,
                    'get_data' => $_GET
                )
            ));
        }
        // ────────────────────────────────────────────────────────────────

        $token = $this->_get_access_token();
        if ($token === false) {
            return $this->_json(500, array('error' => $this->last_error));
        }

        $headers = array('Authorization: Bearer ' . $token, 'Content-Type: application/json');
        $base    = $this->config->item('gmail_api_base');
        // Ambil semua email unread dengan attachment, lalu filter PDF di sisi aplikasi.
        // Ini memastikan setiap email unread tetap diproses meski isi PDF-nya sama.
        $q   = 'is:unread has:attachment newer_than:7d';
        $max = $this->config->item('gmail_max_results');
        $save_dir = rtrim($this->config->item('gmail_attachments_path'), '/\\') . DIRECTORY_SEPARATOR;

        // List emails
        $list_url = $base . '/messages?q=' . urlencode($q) . '&maxResults=' . $max;
        $list_res = $this->_http_get($list_url, $headers);
        if ($list_res === false) {
            return $this->_json(502, array('error' => 'Gagal menghubungi Gmail API'));
        }

        $list_data = json_decode($list_res, true);
        $messages  = isset($list_data['messages']) ? $list_data['messages'] : array();

        $processed_emails   = array();
        $downloaded_files   = array();

        $ids_to_mark_read = array();

        foreach ($messages as $msg_ref) {
            $msg_url = $base . '/messages/' . $msg_ref['id'] . '?format=full';
            $msg_res = $this->_http_get($msg_url, $headers);
            if ($msg_res === false) continue;

            $msg  = json_decode($msg_res, true);
            $hdrs = isset($msg['payload']['headers']) ? $msg['payload']['headers'] : array();

            $subject = $this->_get_header($hdrs, 'Subject');
            $from    = $this->_get_header($hdrs, 'From');
            $has_downloaded = false;

            // Download semua attachment PDF dari email unread.
            // Meski konten PDF sama antar email, masing-masing email tetap diproses.
            $this->_walk_parts_download($msg['payload'], $msg_ref['id'], $headers, $save_dir, $downloaded_files, $has_downloaded);

            if ($has_downloaded) {
                $processed_emails[] = array('id' => $msg_ref['id'], 'subject' => $subject, 'from' => $from);
                $ids_to_mark_read[] = $msg_ref['id'];
            }
        }

        if (!empty($ids_to_mark_read)) {
            $this->_mark_messages_as_read($ids_to_mark_read, $headers, $base);
        }

        // Update lastDownload di status file jika ada yg diproses
        if (count($processed_emails) > 0) {
            $this->_update_last_download();
        }

        return $this->_json(200, array(
            'success'        => true,
            'processedCount' => count($processed_emails),
            'processedEmails'=> $processed_emails,
            'downloadedFiles'=> $downloaded_files,
        ));
    }

    /**
     * GET/POST status cron (mirip api/gmail-cron/status/route.ts)
     * GET  /Gmail_cron/status          => baca status
     * POST /Gmail_cron/status {enabled} => update enabled
     */
    public function status()
    {
        $status_file = $this->config->item('gmail_cron_status_file');
        $status = $this->_read_status($status_file);

        if ($this->input->method() === 'post') {
            $enabled = $this->input->post('enabled');
            if ($enabled !== null) {
                $status['enabled'] = (bool) $enabled;
                $this->_write_status($status_file, $status);
            }
        }

        return $this->_json(200, $status);
    }

    // =========================================================
    // PRIVATE HELPER METHODS
    // =========================================================

    private function _ensure_attachments_dir()
    {
        $dir = rtrim($this->config->item('gmail_attachments_path'), '/\\');
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    private function _get_access_token()
    {
        $client_id     = $this->config->item('gmail_client_id');
        $client_secret = $this->config->item('gmail_client_secret');
        $refresh_token = $this->config->item('gmail_refresh_token');
        $token_url     = $this->config->item('gmail_token_url');

        if (empty($client_id) || empty($client_secret) || empty($refresh_token)) {
            $this->last_error = 'Gmail credentials not configured';
            return false;
        }

        $post_data = array(
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type'    => 'refresh_token',
        );

        $ch = curl_init($token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            $this->last_error = 'Failed to get access token (HTTP ' . $http_code . ')';
            return false;
        }

        $data = json_decode($response, true);
        if (!isset($data['access_token'])) {
            $this->last_error = 'No access token in response';
            return false;
        }

        return $data['access_token'];
    }

    private function _http_get($url, $headers)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            $this->last_error = 'HTTP ' . $http_code;
            return false;
        }

        return $response;
    }

    private function _get_header($headers, $name)
    {
        foreach ($headers as $h) {
            if ($h['name'] === $name) {
                return $h['value'];
            }
        }
        return '';
    }

    private function _walk_parts_download($part, $msg_id, $headers, $save_dir, &$downloaded_files, &$has_downloaded)
    {
        if (isset($part['filename']) && !empty($part['filename'])) {
            $filename = $part['filename'];
            if (strtolower(substr($filename, -4)) === '.pdf' || strtolower(substr($filename, -4)) === '.PDF') {
                $attachment_id = $part['body']['attachmentId'];
                $att_url = $this->config->item('gmail_api_base') . '/messages/' . $msg_id . '/attachments/' . $attachment_id;
                $att_res = $this->_http_get($att_url, $headers);

                if ($att_res !== false) {
                    $att_data = json_decode($att_res, true);
                    if (isset($att_data['data'])) {
                        $file_content = base64_decode(strtr($att_data['data'], '-_', '+/'));
                        $safe_name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
                        $filepath = $save_dir . $safe_name;

                        if (@file_put_contents($filepath, $file_content) !== false) {
                            $downloaded_files[] = $safe_name;
                            $has_downloaded = true;
                        }
                    }
                }
            }
        }

        if (isset($part['parts']) && is_array($part['parts'])) {
            foreach ($part['parts'] as $subpart) {
                $this->_walk_parts_download($subpart, $msg_id, $headers, $save_dir, $downloaded_files, $has_downloaded);
            }
        }
    }

    private function _mark_messages_as_read($ids, $headers, $base)
    {
        foreach ($ids as $id) {
            $modify_url = $base . '/messages/' . $id . '/modify';
            $modify_data = json_encode(array('removeLabelIds' => array('UNREAD')));

            $ch = curl_init($modify_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $modify_data);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            curl_close($ch);
        }
    }

    private function _update_last_download()
    {
        $status_file = $this->config->item('gmail_cron_status_file');
        $status = $this->_read_status($status_file);
        $status['lastDownload'] = date('c');
        $this->_write_status($status_file, $status);
    }

    private function _read_status($file)
    {
        if (!file_exists($file)) {
            return array(
                'enabled' => true,
                'lastDownload' => null,
                'lastError' => null,
            );
        }

        $content = @file_get_contents($file);
        if ($content === false) {
            return array(
                'enabled' => true,
                'lastDownload' => null,
                'lastError' => null,
            );
        }

        return json_decode($content, true) ?: array(
            'enabled' => true,
            'lastDownload' => null,
            'lastError' => null,
        );
    }

    private function _write_status($file, $status)
    {
        @file_put_contents($file, json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    private function _json($code, $data)
    {
        $this->output->set_status_header($code);
        $this->output->set_content_type('application/json');
        return $this->output->set_output(json_encode($data));
    }
}
