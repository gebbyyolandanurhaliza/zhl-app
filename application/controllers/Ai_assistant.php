<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_assistant extends MY_Controller
{

    private $allowed_roles = array('user', 'assistant');

    private $last_error = '';


    public function __construct()
    {
        parent::__construct();

        $this->load->config('ai_assistant');

        $this->load->model('M_ai_assistant');

        $this->load->helper(array(
            'url',
            'common'
        ));
    }


    public function index()
    {
        $data = array();

        $data['title'] = 'AI Assistant';

        $this->template->display(
            'ai_assistant/index',
            $data
        );
    }

    public function chat()
    {
        if (!$this->_json_only()) {
            return;
        }

        $message = trim(
            (string) $this->input->post('message')
        );

        if ($message === '') {

            return $this->_respond(
                400,
                array(
                    'error' => 'Pesan kosong'
                )
            );
        }

        $history = json_decode(
            (string) $this->input->post('history'),
            true
        );

        if (!is_array($history)) {
            $history = array();
        }

        $context = trim(
            (string) $this->input->post('context')
        );

        $sys =
            'Kamu adalah AI Assistant internal untuk sistem ZHL. ' .
            'Jawab singkat, jelas, dan gunakan Bahasa Indonesia ' .
            'kecuali diminta lain.';

        if ($context !== '') {

            $sys .=
                "\n\nKonteks dokumen yang sedang dibuka user:\n" .
                $this->_clean_utf8(
                    mb_substr($context, 0, 12000)
                );
        }

        $messages = array();

        $messages[] = array(
            'role'    => 'system',
            'content' => $sys
        );

        foreach ($history as $h) {

            if (!isset($h['role'], $h['content'])) {
                continue;
            }

            if (
                !in_array(
                    $h['role'],
                    $this->allowed_roles,
                    true
                )
            ) {
                continue;
            }

            $content = trim(
                (string) $h['content']
            );

            if ($content === '') {
                continue;
            }

            $messages[] = array(
                'role'    => $h['role'],
                'content' => $this->_clean_utf8($content)
            );
        }

        $messages[] = array(
            'role'    => 'user',
            'content' => $this->_clean_utf8($message)
        );


        $text = $this->_call_groq_chat($messages);

        if ($text === false) {

            return $this->_respond(
                502,
                array(
                    'error'  => 'AI provider tidak dapat dihubungi',
                    'detail' => $this->last_error
                )
            );
        }

        $this->M_ai_assistant->log(
            $this->_userid(),
            'chat',
            null,
            'groq',
            $message,
            $text
        );

        return $this->_respond(
            200,
            array(
                'reply'    => $text,
                'provider' => 'groq'
            )
        );
    }

    public function vision()
    {
        if (!$this->_json_only()) {
            return;
        }

        $b64 = (string) $this->input->post('image_base64');

        if ($b64 === '') {

            return $this->_respond(
                400,
                array(
                    'error' => 'image_base64 wajib diisi'
                )
            );
        }

        if (strpos($b64, 'base64,') !== false) {

            $b64 = substr(
                $b64,
                strpos($b64, 'base64,') + 7
            );
        }

        $b64 = preg_replace('/\s+/', '', $b64);

        $filename = (string) $this->input->post('filename');

        if ($filename === '') {
            $filename = 'image';
        }

        $prompt = trim(
            (string) $this->input->post('prompt')
        );

        if ($prompt === '') {

            $prompt =
                'Baca semua teks pada gambar dokumen ini ' .
                'apa adanya (transkrip), pertahankan angka ' .
                'dan tanggal persis seperti yang tertulis.';
        }

        $text = $this->_call_groq_vision($b64, $prompt);

        if ($text === false) {

            return $this->_respond(
                502,
                array(
                    'error'  => 'AI vision provider tidak dapat dihubungi',
                    'detail' => $this->last_error
                )
            );
        }

        $this->M_ai_assistant->log(
            $this->_userid(),
            'vision',
            $filename,
            'groq',
            $prompt,
            $text
        );

        return $this->_respond(
            200,
            array(
                'text'     => $text,
                'provider' => 'groq'
            )
        );
    }

    public function extract()
    {
        if (!$this->_json_only()) {
            return;
        }

        $raw_text = trim(
            (string) $this->input->post('raw_text')
        );

        $schema = json_decode(
            (string) $this->input->post('schema'),
            true
        );

        if (
            $raw_text === '' ||
            !is_array($schema) ||
            empty($schema)
        ) {

            return $this->_respond(
                400,
                array(
                    'error' => 'raw_text dan schema wajib diisi'
                )
            );
        }

        $field_lines = array();

        foreach ($schema as $key => $desc) {
            $field_lines[] = '- ' . $key . ': ' . $desc;
        }

        $prompt =
            'Dari TEKS DOKUMEN di bawah, ' .
            'ekstrak field berikut ke JSON. ' .
            'Balas HANYA dengan JSON object valid ' .
            '(tanpa markdown, tanpa penjelasan). ' .
            'Kalau sebuah field tidak ditemukan, ' .
            "isi dengan null.\n\n" .
            "FIELD YANG DIMINTA:\n" .
            implode("\n", $field_lines) .
            "\n\nTEKS DOKUMEN:\n" .
            $this->_clean_utf8(
                mb_substr($raw_text, 0, 15000)
            );

        $messages = array(

            array(
                'role'    => 'system',
                'content' =>
                    'Kamu adalah extractor dokumen ' .
                    'yang HANYA membalas JSON valid, ' .
                    'tanpa teks lain.'
            ),

            array(
                'role'    => 'user',
                'content' => $prompt
            )
        );

        $text = $this->_call_groq_chat(
            $messages,
            array(
                'response_format' => array(
                    'type' => 'json_object'
                )
            )
        );

        if ($text === false) {

            return $this->_respond(
                502,
                array(
                    'error'  => 'AI provider tidak dapat dihubungi',
                    'detail' => $this->last_error
                )
            );
        }

        $parsed = $this->_parse_json_reply($text);

        $this->M_ai_assistant->log(
            $this->_userid(),
            'extract',
            null,
            'groq',
            $prompt,
            $parsed
        );

        return $this->_respond(
            200,
            array(
                'fields'   => $parsed,
                'provider' => 'groq'
            )
        );
    }

    private function _call_groq_chat(
        $messages,
        $extra_payload = array()
    ) {

        $this->last_error = '';

        $key = $this->_groq_key();

        if ($key === '') {
            return false;
        }

        $payload = array(
            'model'       => $this->config->item('ai_groq_chat_model'),
            'messages'    => $messages,
            'temperature' => 0.2
        );

        $payload = $this->_apply_reasoning_effort(
            $payload,
            $this->config->item('ai_groq_reasoning_effort')
        );

        if (!empty($extra_payload)) {
            $payload = array_merge($payload, $extra_payload);
        }

        $res = $this->_http_post_json(
            $this->config->item('ai_groq_endpoint'),
            $payload,
            array('Authorization: Bearer ' . $key)
        );

        return $this->_extract_text($res);
    }


    private function _call_groq_vision(
        $image_base64,
        $prompt
    ) {

        $this->last_error = '';

        $key = $this->_groq_key();

        if ($key === '') {
            return false;
        }

        $payload = array(

            'model' => $this->config->item('ai_groq_vision_model'),

            'messages' => array(
                array(
                    'role' => 'user',
                    'content' => array(
                        array(
                            'type' => 'text',
                            'text' => $prompt
                        ),
                        array(
                            'type' => 'image_url',
                            'image_url' => array(
                                'url' =>
                                    'data:image/jpeg;base64,' .
                                    $image_base64
                            )
                        )
                    )
                )
            ),

            'temperature' => 0.1
        );

        $payload = $this->_apply_reasoning_effort(
            $payload,
            $this->config->item('ai_groq_vision_reasoning_effort')
        );

        $res = $this->_http_post_json(
            $this->config->item('ai_groq_endpoint'),
            $payload,
            array('Authorization: Bearer ' . $key)
        );

        return $this->_extract_text($res);
    }


    private function _groq_key()
    {
        $key = trim(
            (string) $this->config->item('ai_groq_api_key')
        );

        if ($key === '') {

            $this->last_error =
                'GROQ_API_KEY kosong (cek environment variable / config)';

            log_message('error', 'Ai_assistant: GROQ_API_KEY kosong');
        }

        return $key;
    }

    private function _apply_reasoning_effort(
        $payload,
        $effort
    ) {

        $effort = trim((string) $effort);

        if ($effort !== '') {
            $payload['reasoning_effort'] = $effort;
        }

        return $payload;
    }


    private function _extract_text($res)
    {
        if ($res === false) {
            return false;
        }

        $json = json_decode($res, true);

        if (isset($json['error']['message'])) {

            $this->last_error = 'Groq: ' . $json['error']['message'];

            log_message(
                'error',
                'Ai_assistant Groq error: ' . $json['error']['message']
            );

            return false;
        }

        if (!isset($json['choices'][0]['message']['content'])) {

            $this->last_error = 'Groq: struktur response tidak dikenali';

            log_message(
                'error',
                'Ai_assistant Groq response aneh: ' . substr($res, 0, 500)
            );

            return false;
        }

        return $this->_strip_reasoning(
            $json['choices'][0]['message']['content']
        );
    }

    private function _strip_reasoning($text)
    {
        $clean = preg_replace(
            '/<think>.*?<\/think>/is',
            '',
            (string) $text
        );

        return trim($clean);
    }

    private function _http_post_json(
        $url,
        $payload,
        $extra_headers = array()
    ) {

        $url = trim((string) $url);

        if ($url === '' || strpos($url, 'http') !== 0) {

            $this->last_error =
                'Endpoint tidak valid (config belum ter-load?)';

            log_message(
                'error',
                'Ai_assistant: endpoint tidak valid -> "' . $url . '"'
            );

            return false;
        }

        $flags = 0;

        if (defined('JSON_INVALID_UTF8_SUBSTITUTE')) {
            $flags = JSON_INVALID_UTF8_SUBSTITUTE;
        }

        $body = json_encode($payload, $flags);

        if ($body === false) {

            $this->last_error =
                'json_encode gagal: ' . json_last_error_msg();

            log_message(
                'error',
                'Ai_assistant json_encode gagal: ' . json_last_error_msg()
            );

            return false;
        }

        $headers = array_merge(
            array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
            $extra_headers
        );

        $ch = curl_init($url);

        curl_setopt_array(
            $ch,
            array(
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $body,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 120,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2
            )
        );

        $res   = curl_exec($ch);
        $code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($ch);
        $err   = curl_error($ch);

        curl_close($ch);

        if ($res === false || $errno !== 0) {

            $this->last_error =
                'cURL errno ' . $errno . ': ' . $err;

            log_message(
                'error',
                'Ai_assistant cURL errno=' . $errno . ' msg=' . $err
            );

            return false;
        }

        if ($code < 200 || $code >= 300) {

            $this->last_error =
                'HTTP ' . $code . ': ' . substr($res, 0, 300);

            log_message(
                'error',
                'Ai_assistant HTTP ' . $code .
                ' body=' . substr($res, 0, 1000)
            );

            return false;
        }

        return $res;
    }

    private function _clean_utf8($text)
    {
        if (!is_string($text)) {
            return '';
        }

        $text = @iconv('UTF-8', 'UTF-8//IGNORE', $text);

        if ($text === false) {
            return '';
        }

        return preg_replace(
            '/[\x00-\x08\x0B\x0C\x0E-\x1F]/',
            '',
            $text
        );
    }


    private function _parse_json_reply($text)
    {
        $clean = trim((string) $text);

        $clean = preg_replace(
            '/^```(?:json)?\s*|\s*```$/i',
            '',
            $clean
        );

        $parsed = json_decode(trim($clean), true);

        if (is_array($parsed)) {
            return $parsed;
        }

        $start = strpos($clean, '{');
        $end   = strrpos($clean, '}');

        if ($start !== false && $end !== false && $end > $start) {

            $parsed = json_decode(
                substr($clean, $start, $end - $start + 1),
                true
            );

            if (is_array($parsed)) {
                return $parsed;
            }
        }

        return array('_raw' => $text);
    }


    private function _userid()
    {
        return $this->session->userdata('userid_1');
    }

    private function _json_only()
    {
        if (
            strtolower(
                (string) $this->input->method()
            ) !== 'post'
        ) {

            $this->_respond(
                405,
                array(
                    'error' => 'Method not allowed'
                )
            );

            return false;
        }

        return true;
    }


    private function _respond($code, $data)
    {
        $this->output
            ->set_status_header($code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(
                json_encode(
                    $data,
                    defined('JSON_INVALID_UTF8_SUBSTITUTE')
                        ? JSON_INVALID_UTF8_SUBSTITUTE
                        : 0
                )
            );

        return;
    }
}
