<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gmail_agent Controller
 * Mengimplementasikan fitur Gmail Agent dari pss-app ke zhl-app (CodeIgniter 3)
 */
class Gmail_agent extends MY_Controller
{
    private $last_error = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->config('gmail_agent');
        $this->load->helper(array('url'));
        $this->_ensure_attachments_dir();
    }

    // =========================================================
    // PUBLIC ROUTES
    // =========================================================

    /**
     * Halaman utama Gmail Agent
     */
    public function index()
    {
        $data = array('title' => 'Gmail Agent');
        $this->template->display('gmail_agent/index', $data);
    }

    /**
     * Ambil daftar email dari Gmail (mirip api/gmail-agent/route.ts)
     * POST /Gmail_agent/fetch
     */
    public function start_worker()
    {
        if (!$this->_is_ajax()) return;

        $php_bin = 'C:\\xampp\\php\\php.exe';
        $project = rtrim(FCPATH, DIRECTORY_SEPARATOR);
        $script  = $project . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . 'gmail_worker.php';
        $bat     = $project . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . 'run_gmail_worker.bat';

        if (!file_exists($php_bin)) {
            $php_bin = 'php';
        }

        $bat_content = "@echo off\r\n";
        $bat_content .= "cd /d \"" . $project . "\"\r\n";
        $bat_content .= "\"" . $php_bin . "\" \"scripts\\gmail_worker.php\"\r\n";
        @file_put_contents($bat, $bat_content);

        $cmd = 'cmd /c start /B "" "' . str_replace('"', '""', $bat) . '" > NUL 2>&1';
        $started = false;

        if (function_exists('popen')) {
            $h = @popen($cmd, 'r');
            if (is_resource($h)) {
                $started = true;
                @pclose($h);
            }
        }

        if (!$started && function_exists('exec')) {
            @exec($cmd, $output, $code);
            $started = true;
        }

        return $this->_json(200, array(
            'success' => true,
            'started' => $started,
            'php' => $php_bin,
            'script' => $script,
            'bat' => $bat,
            'command' => $cmd,
        ));
    }

    public function fetch()
    {
        if (!$this->_is_ajax()) return;

        $q          = (string) $this->input->post('q')   ?: $this->config->item('gmail_query');
        $max        = (int)    ($this->input->post('max') ?: $this->config->item('gmail_max_results'));

        $token = $this->_get_access_token();
        if ($token === false) {
            return $this->_json(500, array('error' => $this->last_error));
        }

        $headers = array('Authorization: Bearer ' . $token, 'Content-Type: application/json');
        $base    = $this->config->item('gmail_api_base');

        // 1. List message IDs
        $list_url = $base . '/messages?q=' . urlencode($q) . '&maxResults=' . $max;
        $list_res = $this->_http_get($list_url, $headers);
        if ($list_res === false) {
            return $this->_json(502, array('error' => 'Gagal menghubungi Gmail API: ' . $this->last_error));
        }

        $list_data = json_decode($list_res, true);
        if (isset($list_data['error'])) {
            return $this->_json(502, array('error' => 'Gmail API: ' . $list_data['error']['message']));
        }

        $messages = isset($list_data['messages']) ? $list_data['messages'] : array();
        $parsed   = array();

        // 2. Fetch detail setiap email
        foreach ($messages as $msg_ref) {
            $msg_url = $base . '/messages/' . $msg_ref['id'] . '?format=full';
            $msg_res = $this->_http_get($msg_url, $headers);
            if ($msg_res === false) continue;

            $msg  = json_decode($msg_res, true);
            $hdrs = isset($msg['payload']['headers']) ? $msg['payload']['headers'] : array();

            $from    = $this->_get_header($hdrs, 'From');
            $subject = $this->_get_header($hdrs, 'Subject');
            $date    = $this->_get_header($hdrs, 'Date');

            $body_text   = '';
            $attachments = array();
            $this->_walk_parts_preview($msg['payload'], $msg_ref['id'], $headers, $body_text, $attachments);

            $parsed[] = array(
                'id'          => $msg_ref['id'],
                'from'        => $from,
                'subject'     => $subject,
                'date'        => $date,
                'bodyText'    => trim($body_text),
                'attachments' => $attachments,
            );
        }

        return $this->_json(200, array('emails' => $parsed, 'total' => count($parsed)));
    }

    /**
     * Jalankan proses download attachment & mark as read (mirip api/gmail-cron/route.ts)
     * POST /Gmail_agent/run_cron
     *
     * Endpoint ini dipanggil dari luar (cron-job.org) tiap 1 menit, jadi WAJIB
     * ada verifikasi token supaya tidak bisa dipicu sembarang orang yang tahu URL-nya.
     */
    public function run_cron()
    {
        if (!$this->_is_ajax()) return;

        // ── Verifikasi webhook token ──────────────────────────────────────
        // Browser UI dan worker internal boleh dipakai tanpa token tambahan,
        // tetapi request eksternal yang tidak valid tetap ditolak.
        $secret = $this->config->item('gmail_webhook_secret');
        $sent   = $this->input->post('token');
        $is_internal_worker = (bool) $this->input->post('_worker');
        $is_browser_request = (bool) $this->_is_ajax();

        if (!empty($secret) && $sent !== $secret && !$is_internal_worker && !$is_browser_request) {
            return $this->_json(401, array('error' => 'Unauthorized'));
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
     * GET  /Gmail_agent/cron_status          => baca status
     * POST /Gmail_agent/cron_status {enabled} => update enabled
     */
    public function cron_status()
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

    /**
     * Download file attachment yang sudah tersimpan
     * GET /Gmail_agent/download_file?name=xxx
     */
    public function download_file()
    {
        $name     = basename((string) $this->input->get('name'));
        $save_dir = rtrim($this->config->item('gmail_attachments_path'), '/\\') . DIRECTORY_SEPARATOR;
        $filepath = $save_dir . $name;

        if ($name === '' || !file_exists($filepath)) {
            show_404();
            return;
        }

        $this->load->helper('download');
        force_download($filepath, null);
    }

    /**
     * Preview file attachment secara inline untuk PDF / image
     * GET /Gmail_agent/preview_file?name=xxx
     */
    public function preview_file()
    {
        $name     = basename((string) $this->input->get('name'));
        $save_dir = rtrim($this->config->item('gmail_attachments_path'), '/\\') . DIRECTORY_SEPARATOR;
        $filepath = $save_dir . $name;

        if ($name === '' || !file_exists($filepath)) {
            show_404();
            return;
        }

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $mime = 'application/octet-stream';

        if ($ext === 'pdf') {
            $mime = 'application/pdf';
        } elseif (in_array($ext, array('png', 'jpg', 'jpeg', 'gif', 'webp'))) {
            $mime = 'image/' . ($ext === 'jpg' ? 'jpeg' : $ext);
        }

        if (function_exists('finfo_open') && function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $detected = finfo_file($finfo, $filepath);
                if (!empty($detected)) {
                    $mime = $detected;
                }
                finfo_close($finfo);
            }
        }

        header('Content-Type: ' . $mime);
        header('Content-Disposition: inline; filename="' . $name . '"');
        header('Content-Length: ' . filesize($filepath));
        header('Cache-Control: private, must-revalidate, max-age=0');
        header('Pragma: public');

        readfile($filepath);
        exit;
    }

    /**
     * Daftar file yang sudah tersimpan di folder attachment
     * GET /Gmail_agent/list_files
     */
    public function list_files()
    {
        $save_dir = rtrim($this->config->item('gmail_attachments_path'), '/\\') . DIRECTORY_SEPARATOR;
        $files    = array();

        if (is_dir($save_dir)) {
            $items = scandir($save_dir);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') continue;
                $full = $save_dir . $item;
                if (is_file($full)) {
                    $files[] = array(
                        'name'     => $item,
                        'size'     => filesize($full),
                        'modified' => date('c', filemtime($full)),
                    );
                }
            }
        }

        // Sort by modified desc
        usort($files, function($a, $b) {
            return strcmp($b['modified'], $a['modified']);
        });

        return $this->_json(200, array('files' => $files, 'total' => count($files)));
    }

    // =========================================================
    // PRIVATE HELPERS
    // =========================================================


    /**
     * DEBUG: Inspect raw structure of email parts + try download
     * GET /Gmail_agent/debug_email
     */
    public function debug_email()
    {
        $token = $this->_get_access_token();
        if ($token === false) {
            echo "ERROR get token: " . $this->last_error; return;
        }

        $headers = array('Authorization: Bearer ' . $token, 'Content-Type: application/json');
        $base    = $this->config->item('gmail_api_base');

        // List 5 email terbaru dengan attachment (tanpa is:unread agar semua tertangkap)
        $q       = 'has:attachment newer_than:7d';
        $list_url = $base . '/messages?q=' . urlencode($q) . '&maxResults=5';
        $list_res = $this->_http_get($list_url, $headers);
        $list_data = json_decode($list_res, true);

        if (empty($list_data['messages'])) {
            echo "Tidak ada email ditemukan dengan query: " . $q; return;
        }

        $save_dir = rtrim($this->config->item('gmail_attachments_path'), '/\\') . DIRECTORY_SEPARATOR;
        $output   = array();

        foreach ($list_data['messages'] as $msg_ref) {
            $msg_url = $base . '/messages/' . $msg_ref['id'] . '?format=full';
            $msg_res = $this->_http_get($msg_url, $headers);
            $msg     = json_decode($msg_res, true);
            $hdrs    = isset($msg['payload']['headers']) ? $msg['payload']['headers'] : array();

            $subject = $this->_get_header($hdrs, 'Subject');
            $from    = $this->_get_header($hdrs, 'From');

            // Kumpulkan semua parts beserta attachment info
            $parts_info = array();
            $this->_debug_walk($msg['payload'], $parts_info, 0);

            // Coba download semua attachment
            $downloaded = array();
            $failed     = array();
            $has_dl = false;
            $this->_walk_parts_download($msg['payload'], $msg_ref['id'], $headers, $save_dir, $downloaded, $has_dl);

            $output[] = array(
                'id'         => $msg_ref['id'],
                'from'       => $from,
                'subject'    => $subject,
                'parts'      => $parts_info,
                'downloaded' => $downloaded,
            );
        }

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    private function _debug_walk($part, &$result, $depth)
    {
        if (empty($part)) return;
        $result[] = array(
            'depth'        => $depth,
            'mimeType'     => isset($part['mimeType']) ? $part['mimeType'] : '',
            'filename'     => isset($part['filename']) ? $part['filename'] : '',
            'hasAttachId'  => !empty($part['body']['attachmentId']),
            'attachId'     => isset($part['body']['attachmentId']) ? substr($part['body']['attachmentId'], 0, 30) . '...' : '',
            'bodySize'     => isset($part['body']['size']) ? $part['body']['size'] : 0,
            'hasData'      => !empty($part['body']['data']),
        );
        if (!empty($part['parts'])) {
            foreach ($part['parts'] as $child) {
                $this->_debug_walk($child, $result, $depth + 1);
            }
        }
    }
    private function _get_access_token()
    {
        $payload = array(
            'client_id'     => $this->config->item('gmail_client_id'),
            'client_secret' => $this->config->item('gmail_client_secret'),
            'refresh_token' => $this->config->item('gmail_refresh_token'),
            'grant_type'    => 'refresh_token',
        );

        $ch = curl_init($this->config->item('gmail_token_url'));
        curl_setopt_array($ch, array(
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($payload),
            CURLOPT_HTTPHEADER     => array('Content-Type: application/x-www-form-urlencoded'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ));

        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($res === false || $err) {
            $this->last_error = 'cURL error: ' . $err;
            return false;
        }

        $data = json_decode($res, true);

        if ($code < 200 || $code >= 300 || empty($data['access_token'])) {
            $this->last_error = isset($data['error_description']) ? $data['error_description'] : 'Gagal refresh token Gmail';
            return false;
        }

        return $data['access_token'];
    }

    private function _http_get($url, $headers)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_SSL_VERIFYPEER => true,
        ));

        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($res === false || $err) {
            $this->last_error = $err;
            return false;
        }

        if ($code < 200 || $code >= 300) {
            $this->last_error = 'HTTP ' . $code;
            return false;
        }

        return $res;
    }

    private function _http_post_json($url, $payload, $headers)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ));
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    private function _walk_parts_preview($part, $msg_id, $headers, &$body_text, &$attachments)
    {
        if (empty($part)) return;

        if (isset($part['mimeType']) && $part['mimeType'] === 'text/plain' && !empty($part['body']['data'])) {
            $body_text .= $this->_decode_base64url($part['body']['data']);
        }

        if (!empty($part['body']['attachmentId']) && $this->_is_pdf_attachment(isset($part['filename']) ? $part['filename'] : '', isset($part['mimeType']) ? $part['mimeType'] : '')) {
            $attachments[] = array(
                'filename'  => isset($part['filename']) && $part['filename'] !== '' ? $part['filename'] : 'attachment.pdf',
                'mimeType'  => isset($part['mimeType']) ? $part['mimeType'] : 'application/pdf',
                'sizeBytes' => isset($part['body']['size']) ? (int) $part['body']['size'] : 0,
            );
        }

        if (!empty($part['parts']) && is_array($part['parts'])) {
            foreach ($part['parts'] as $child) {
                $this->_walk_parts_preview($child, $msg_id, $headers, $body_text, $attachments);
            }
        }
    }

    private function _walk_parts_download($part, $msg_id, $headers, $save_dir, &$downloaded_files, &$has_downloaded)
    {
        if (empty($part)) return;

        if (!empty($part['body']['attachmentId']) && $this->_is_pdf_attachment(isset($part['filename']) ? $part['filename'] : '', isset($part['mimeType']) ? $part['mimeType'] : '')) {
            $base    = $this->config->item('gmail_api_base');
            $att_url = $base . '/messages/' . $msg_id . '/attachments/' . $part['body']['attachmentId'];
            $att_res = $this->_http_get($att_url, $headers);

            if ($att_res !== false) {
                $att_data = json_decode($att_res, true);
                $b64_data = isset($att_data['data']) ? $att_data['data'] : '';

                if ($b64_data !== '') {
                    $buffer     = $this->_decode_base64url_binary($b64_data);
                    $filename   = isset($part['filename']) && $part['filename'] !== '' ? $part['filename'] : 'attachment.pdf';
                    $safe_name  = preg_replace('/[^a-zA-Z0-9.\-_]/', '_', $filename);
                    $final_name = $safe_name;
                    $file_path  = $save_dir . $final_name;

                    $counter = 1;
                    while (file_exists($file_path)) {
                        $path_info = pathinfo($safe_name);
                        $name_base = $path_info['filename'];
                        $ext       = isset($path_info['extension']) ? '.' . $path_info['extension'] : '';
                        $final_name = $name_base . '_' . $counter . $ext;
                        $file_path  = $save_dir . $final_name;
                        $counter++;
                    }

                    file_put_contents($file_path, $buffer);
                    $downloaded_files[] = $final_name;
                    $has_downloaded     = true;
                }
            }
        }

        if (!empty($part['parts']) && is_array($part['parts'])) {
            foreach ($part['parts'] as $child) {
                $this->_walk_parts_download($child, $msg_id, $headers, $save_dir, $downloaded_files, $has_downloaded);
            }
        }
    }

    private function _is_pdf_attachment($filename, $mime_type = '')
    {
        $file_name = strtolower((string) $filename);
        $mime      = strtolower((string) $mime_type);

        if (stripos($mime, 'pdf') !== false) {
            return true;
        }

        if ($file_name === '') {
            return false;
        }

        if (stripos($file_name, 'pdf') !== false) {
            return true;
        }

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        return $ext === 'pdf';
    }

    private function _decode_base64url($str)
    {
        if (empty($str)) return '';
        $base64 = str_replace(array('-', '_'), array('+', '/'), $str);
        return base64_decode($base64);
    }

    private function _decode_base64url_binary($str)
    {
        $base64 = str_replace(array('-', '_'), array('+', '/'), $str);
        return base64_decode($base64);
    }

    private function _get_header($headers, $name)
    {
        foreach ($headers as $h) {
            if (isset($h['name']) && strcasecmp($h['name'], $name) === 0) {
                return isset($h['value']) ? $h['value'] : '';
            }
        }
        return '';
    }

    private function _mark_messages_as_read($msg_ids, $headers, $base)
    {
        if (empty($msg_ids)) {
            return;
        }

        $url = $base . '/messages/batchModify';
        $payload = array(
            'ids' => array_values($msg_ids),
            'removeLabelIds' => array('UNREAD'),
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => array_merge($headers, array('Content-Type: application/json')),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_SSL_VERIFYPEER => true,
        ));

        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($res === false || $err) {
            $this->last_error = 'Batch modify failed: ' . $err;
            return;
        }

        if ($code < 200 || $code >= 300) {
            $this->last_error = 'Batch modify HTTP ' . $code;
        }
    }

    private function _read_status($file)
    {
        $default = array('enabled' => false, 'lastCheck' => null, 'lastDownload' => null);
        if (!file_exists($file)) return $default;
        $raw = file_get_contents($file);
        $data = json_decode($raw, true);
        return is_array($data) ? array_merge($default, $data) : $default;
    }

    private function _write_status($file, $data)
    {
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }

    private function _update_last_download()
    {
        $status_file = $this->config->item('gmail_cron_status_file');
        $status = $this->_read_status($status_file);
        $status['lastDownload'] = date('c');
        $this->_write_status($status_file, $status);
    }

    private function _read_processed_ids($file)
    {
        if (!file_exists($file)) return array();
        $data = json_decode(file_get_contents($file), true);
        return is_array($data) ? $data : array();
    }

    private function _save_processed_ids($file, $ids)
    {
        // Simpan hanya 500 ID terakhir agar file tidak membengkak
        if (count($ids) > 500) {
            $ids = array_slice($ids, -500);
        }
        file_put_contents($file, json_encode(array_values($ids)));
    }

    private function _ensure_attachments_dir()
    {
        $dir = $this->config->item('gmail_attachments_path');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    private function _is_ajax()
    {
        // Terima POST biasa atau AJAX
        if (strtolower((string) $this->input->method()) !== 'post') {
            $this->_json(405, array('error' => 'Method not allowed'));
            return false;
        }
        return true;
    }

    private function _json($code, $data)
    {
        $this->output
            ->set_status_header($code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}