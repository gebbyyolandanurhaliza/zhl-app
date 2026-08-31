<?php
/**
 * Gmail Agent Background Worker
 * ==============================
 * Menggantikan scripts/gmail-worker.js dari pss-app.
 *
 * Cara menjalankan di terminal:
 *   cd c:/xampp/htdocs/zhl-app
 *   php scripts/gmail_worker.php
 *
 * Worker akan berjalan terus (loop) dan mengecek email baru setiap 1 menit.
 * Tekan Ctrl+C untuk menghentikannya.
 */

// ── Konfigurasi ──────────────────────────────────────────────────────────────
define('NEXT_APP_URL', 'http://localhost/zhl-app');
define('STATUS_FILE',  dirname(__DIR__) . '/cron-status-gmail.json');

// ── Helper functions ─────────────────────────────────────────────────────────
function read_status() {
    $default = array('enabled' => true, 'lastCheck' => null, 'lastDownload' => null);
    if (!file_exists(STATUS_FILE)) return $default;
    $raw  = file_get_contents(STATUS_FILE);
    $data = json_decode($raw, true);
    return is_array($data) ? array_merge($default, $data) : $default;
}

function write_status($data) {
    file_put_contents(STATUS_FILE, json_encode($data, JSON_PRETTY_PRINT));
}

function update_last_check() {
    $status = read_status();
    $status['lastCheck'] = date('c');
    write_status($status);
}

function update_last_download() {
    $status = read_status();
    $status['lastDownload'] = date('c');
    write_status($status);
}

function call_cron() {
    $url = NEXT_APP_URL . '/Gmail_agent/run_cron';
    $ch  = curl_init($url);

    // POST dengan field dummy (controller mengecek method=POST)
    curl_setopt_array($ch, array(
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query(array('_worker' => 1)),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 90,
        CURLOPT_CONNECTTIMEOUT => 10,
    ));

    $res  = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($err || $res === false) {
        echo "[Worker] cURL error: $err\n";
        return null;
    }

    if ($code < 200 || $code >= 300) {
        echo "[Worker] HTTP $code dari server\n";
        return null;
    }

    return json_decode($res, true);
}

// ── Banner ───────────────────────────────────────────────────────────────────
echo "=========================================\n";
echo "  Gmail Agent Worker - ZHL App\n";
echo "  Mengecek email baru setiap 1 menit\n";
echo "  Tekan Ctrl+C untuk berhenti\n";
echo "=========================================\n";

// ── Main Loop ────────────────────────────────────────────────────────────────
while (true) {
    $status    = read_status();
    $timestamp = '[' . date('H:i:s') . ']';

    if (!$status['enabled']) {
        echo "$timestamp Mode Automasi NONAKTIF. Menunggu 1 menit...\n";
        sleep(60);
        continue;
    }

    echo "$timestamp Automasi AKTIF. Mengeksekusi Gmail Cron...\n";
    update_last_check();

    $data = call_cron();

    if ($data === null) {
        echo "$timestamp Gagal menghubungi server. Pastikan XAMPP berjalan.\n";
    } elseif (isset($data['error'])) {
        echo "$timestamp Error: " . $data['error'] . "\n";
    } else {
        $count = isset($data['processedCount']) ? (int) $data['processedCount'] : 0;
        if ($count > 0) {
            echo "$timestamp Berhasil memproses $count email.\n";
            if (!empty($data['downloadedFiles'])) {
                echo "$timestamp File terdownload: " . implode(', ', $data['downloadedFiles']) . "\n";
            }
            update_last_download();
        } else {
            echo "$timestamp Tidak ada email baru dengan attachment.\n";
        }
    }

    echo "$timestamp Menunggu 1 menit...\n";
    sleep(60);
}

