<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$envFile = FCPATH . '.env';
if (file_exists($envFile) && is_readable($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines !== false) {
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);
            $value = trim($value, " \t\n\r\0\x0B\"'");

            if ($key !== '') {
                if (!array_key_exists($key, $_ENV)) {
                    $_ENV[$key] = $value;
                }
                if (getenv($key) === false) {
                    putenv($key . '=' . $value);
                }
            }
        }
    }
}

// ======================================================
// Gmail OAuth2 credentials loaded from environment
// ======================================================
$config['gmail_client_id']     = getenv('GMAIL_CLIENT_ID') ?: '';
$config['gmail_client_secret'] = getenv('GMAIL_CLIENT_SECRET') ?: '';
$config['gmail_refresh_token'] = getenv('GMAIL_REFRESH_TOKEN') ?: '';

// ======================================================
// Gmail API configuration
// ======================================================
$config['gmail_token_url']   = 'https://oauth2.googleapis.com/token';
$config['gmail_api_base']    = 'https://gmail.googleapis.com/gmail/v1/users/me';

// ======================================================
// Query Gmail: fetch unread emails with attachments, then filter PDF in app logic
// to also catch PDFs whose filenames do not end with .pdf
// ======================================================
$config['gmail_query']       = getenv('GMAIL_QUERY') ?: 'is:unread has:attachment newer_than:7d';
$config['gmail_max_results'] = (int) (getenv('GMAIL_MAX_RESULTS') ?: 10);

// ======================================================
// Attachment storage directory under uploads/
// ======================================================
$config['gmail_attachments_path'] = FCPATH . 'uploads/gmail_attachments/';

// ======================================================
// Cron status file path in project root
// ======================================================
$config['gmail_cron_status_file'] = FCPATH . 'cron-status-gmail.json';

// ======================================================
// Secret token for external cron webhook
// ======================================================
$config['gmail_webhook_secret'] = getenv('GMAIL_WEBHOOK_SECRET') ?: 'change-me';

