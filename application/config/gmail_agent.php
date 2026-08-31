<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ======================================================
// Gmail OAuth2 Credentials (sama dengan pss-app)
// ======================================================
$config['gmail_client_id']     = getenv('GMAIL_CLIENT_ID')     ?: '686885388477-gq6ccm5sf2tibb385ln9fm8j80qdcj0u.apps.googleusercontent.com';
$config['gmail_client_secret'] = getenv('GMAIL_CLIENT_SECRET') ?: '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';
$config['gmail_refresh_token'] = getenv('GMAIL_REFRESH_TOKEN') ?: '1//04MaGTuMSlqqSCgYIARAAGAQSNwF-L9IrfPcvFDl4zw_4W8lDJn2bVfayMqk4F0sFvTo4gdt9RonhO5RP19h1v01Kt-yYWMVKKkc';

// ======================================================
// Konfigurasi Gmail API
// ======================================================
$config['gmail_token_url']   = 'https://oauth2.googleapis.com/token';
$config['gmail_api_base']    = 'https://gmail.googleapis.com/gmail/v1/users/me';

// ======================================================
// Query Gmail: hanya email dengan attachment, lalu filter PDF di sisi aplikasi
// agar email PDF yang namanya tidak berakhiran .pdf tetap tertangkap
// ======================================================
$config['gmail_query']       = 'is:unread has:attachment newer_than:7d';
$config['gmail_max_results'] = 10;

// ======================================================
// Folder penyimpanan attachment (di dalam uploads/)
// ======================================================
$config['gmail_attachments_path'] = FCPATH . 'uploads/gmail_attachments/';

// ======================================================
// Path file status cron (di root project)
// ======================================================
$config['gmail_cron_status_file'] = FCPATH . 'cron-status-gmail.json';

// ======================================================
// Secret token untuk webhook external cron
// ======================================================
$config['gmail_webhook_secret'] = 'ZHL_GMAIL_2024_SECRET';

