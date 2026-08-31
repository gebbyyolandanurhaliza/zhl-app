<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="<?= base_url('assets/gmail_agent/css/gmail_agent.css'); ?>?v=<?= time(); ?>">

<div class="page-content">
  <div class="container-fluid">
    <div class="ga-page">

      <!-- ===== HEADER ===== -->
      <div class="ga-header">
        <div class="ga-header-left">
          <div class="ga-header-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect width="20" height="16" x="2" y="4" rx="2"/>
              <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
          </div>
          <div>
            <p class="ga-header-title">Gmail Agent</p>
            <p class="ga-header-sub">Auto-downloader lampiran email untuk operasional ZHL</p>
          </div>
        </div>
        <div class="ga-stats">
          <div class="ga-stat">
            <div class="ga-stat-val" id="statTotal">0</div>
            <div class="ga-stat-lbl">Total</div>
          </div>
          <div class="ga-stat green">
            <div class="ga-stat-val" id="statDone">0</div>
            <div class="ga-stat-lbl">Selesai</div>
          </div>
          <div class="ga-stat red">
            <div class="ga-stat-val" id="statError">0</div>
            <div class="ga-stat-lbl">Gagal</div>
          </div>
        </div>
      </div>


      <!-- ===== ACTION BAR ===== -->
      <div class="ga-actions">
        <button class="ga-btn ga-btn-primary" id="btnRun">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/>
          </svg>
          Jalankan Agent
        </button>
        <button class="ga-btn ga-btn-outline" id="btnRefreshFiles">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-.18-3.6"/>
          </svg>
          Refresh File
        </button>
        <span id="fetchStatus" style="font-size:12px;color:#64748b;margin-left:4px"></span>
      </div>

      <!-- ===== TABS ===== -->
      <div class="ga-tabs">
        <button class="ga-tab active" data-tab="emails">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          Email <span class="ga-tab-badge" id="tabBadgeEmails">0</span>
        </button>
        <button class="ga-tab" data-tab="files">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
          Lampiran File <span class="ga-tab-badge" id="tabBadgeFiles">0</span>
        </button>
        <button class="ga-tab" data-tab="results">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          Hasil <span class="ga-tab-badge" id="tabBadgeResults">0</span>
        </button>
        <button class="ga-tab" data-tab="code">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
          Kode Agent
        </button>
      </div>

      <!-- ===== TAB: EMAILS ===== -->
      <div class="ga-tab-content active" id="tab-emails">
        <div class="ga-split">
          <!-- Daftar Email -->
          <div class="ga-email-list">
            <div class="ga-email-list-head">Daftar Email</div>
            <div id="emailList">
              <div class="ga-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                <div class="ga-empty-title">Belum ada email</div>
                <div class="ga-empty-sub">Klik "Jalankan Agent" untuk memuat</div>
              </div>
            </div>
          </div>
          <!-- Detail Email -->
          <div class="ga-detail" id="emailDetail">
            <div class="ga-detail-empty">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
              <p>Pilih email dari daftar untuk melihat detail</p>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== TAB: FILES ===== -->
      <div class="ga-tab-content" id="tab-files">
        <div class="ga-files-toolbar">
          <input type="text" class="ga-search" id="fileSearch" placeholder="Cari nama file...">
          <select class="ga-select" id="fileTypeFilter">
            <option value="all">Semua Tipe</option>
            <option value="pdf">PDF</option>
            <option value="xlsx">Excel</option>
            <option value="csv">CSV</option>
            <option value="jpg,jpeg,png">Gambar</option>
          </select>
        </div>
        <div id="filesGrid">
          <div class="ga-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
            <div class="ga-empty-title">Belum ada file lampiran</div>
            <div class="ga-empty-sub">File yang didownload otomatis akan muncul di sini</div>
          </div>
        </div>
      </div>

      <!-- ===== TAB: RESULTS ===== -->
      <div class="ga-tab-content" id="tab-results">
        <div id="resultsList">
          <div class="ga-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <div class="ga-empty-title">Belum ada hasil</div>
            <div class="ga-empty-sub">Jalankan agent untuk melihat riwayat proses</div>
          </div>
        </div>
      </div>

      <!-- ===== TAB: CODE ===== -->
      <div class="ga-tab-content" id="tab-code">
        <div class="ga-code-block" id="codeBlock"></div>
      </div>

    </div>
  </div>
</div>

<script>
(function () {
  'use strict';

  var BASE = '<?= site_url('Gmail_agent') ?>';

  // ─── State ────────────────────────────────────────────────────
  var state = {
    emails: [],
    activeEmailId: null,
    allFiles: [],
    isFetching: false,
            lastDownload: null,
    statusPollInterval: null,
      };

  // ─── DOM refs ─────────────────────────────────────────────────
  var el = {
    btnRun:        document.getElementById('btnRun'),
    btnRefresh:    document.getElementById('btnRefreshFiles'),
    fetchStatus:   document.getElementById('fetchStatus'),
    emailList:     document.getElementById('emailList'),
    emailDetail:   document.getElementById('emailDetail'),
    filesGrid:     document.getElementById('filesGrid'),
    resultsList:   document.getElementById('resultsList'),
    codeBlock:     document.getElementById('codeBlock'),
    fileSearch:    document.getElementById('fileSearch'),
    fileTypeFilter:document.getElementById('fileTypeFilter'),    statTotal:     document.getElementById('statTotal'),
    statDone:      document.getElementById('statDone'),
    statError:     document.getElementById('statError'),
    tabBadgeEmails: document.getElementById('tabBadgeEmails'),
    tabBadgeFiles:  document.getElementById('tabBadgeFiles'),
    tabBadgeResults:document.getElementById('tabBadgeResults'),
  };

  // ─── TABS ─────────────────────────────────────────────────────
  document.querySelectorAll('.ga-tab').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.ga-tab').forEach(function (b) { b.classList.remove('active'); });
      document.querySelectorAll('.ga-tab-content').forEach(function (c) { c.classList.remove('active'); });
      btn.classList.add('active');
      document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
      if (btn.dataset.tab === 'code') renderCode();
    });
  });

  // ─── RUN AGENT ────────────────────────────────────────────────
  el.btnRun.addEventListener('click', runAgent);
  el.btnRefresh.addEventListener('click', loadFiles);

  function runAgent() {
    if (state.isFetching) return;
    state.isFetching = true;
    el.btnRun.disabled = true;
    el.btnRun.innerHTML = '<span class="ga-spinner"></span> Memproses...';
    setStatus('Memulai worker Gmail...');

    postJSON(BASE + '/start_worker', {})
      .then(function (startData) {
        if (!startData || startData.success === false) {
          throw new Error('Gagal memulai worker');
        }
        setStatus('Worker dijalankan. Mengambil email dari Gmail...');
        return postJSON(BASE + '/fetch', {});
      })
      .then(function (data) {
        if (data.error) throw new Error(data.error);
        state.emails = (data.emails || []).map(function (e) {
          return Object.assign(e, { _status: 'done', _errorMsg: '' });
        });
        renderEmailList();
        if (state.emails.length > 0) {
          showEmailDetail(state.emails[0].id);
        }
        updateStats();
        setStatus('Email berhasil dimuat. Menjalankan download attachment...');
        return postJSON(BASE + '/run_cron', {});
      })
      .then(function (cronData) {
        if (cronData && cronData.error) {
          throw new Error(cronData.error);
        }
        setStatus('Download selesai. Memuat file attachment...');
        return loadFiles();
      })
      .then(function () {
        setStatus('Berhasil memuat ' + state.emails.length + ' email dan file attachment terbaru.');
        switchTab('files');
        loadFiles();
      })
      .catch(function (err) {
        setStatus('Gagal: ' + err.message, true);
      })
      .finally(function () {
        state.isFetching = false;
        el.btnRun.disabled = false;
        el.btnRun.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg> Jalankan Agent';
      });
  }

  // ─── EMAIL LIST ───────────────────────────────────────────────
  function renderEmailList() {
    if (state.emails.length === 0) {
      el.emailList.innerHTML = '<div class="ga-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg><div class="ga-empty-title">Tidak ada email</div></div>';
      el.tabBadgeEmails.textContent = '0';
      return;
    }
    el.tabBadgeEmails.textContent = state.emails.length;
    el.emailList.innerHTML = state.emails.map(function (e) {
      var badge = badgeHtml(e._status, e._errorMsg);
      return '<div class="ga-email-item' + (state.activeEmailId === e.id ? ' active' : '') + '" data-id="' + e.id + '">' +
        badge +
        '<div class="ga-email-item-body">' +
          '<div class="ga-email-subject">' + esc(e.subject || '(Tanpa Subjek)') + '</div>' +
          '<div class="ga-email-from">' + esc(e.from) + '</div>' +
          '<div class="ga-email-date">' + esc(e.date) + '</div>' +
        '</div>' +
        '<span style="font-size:10px;color:#94a3b8;flex-shrink:0">' + (e.attachments ? e.attachments.length : 0) + ' &nbsp;📎</span>' +
      '</div>';
    }).join('');

    el.emailList.querySelectorAll('.ga-email-item').forEach(function (item) {
      item.addEventListener('click', function () { showEmailDetail(item.dataset.id); });
    });
  }

  function showEmailDetail(id) {
    state.activeEmailId = id;
    var email = state.emails.find(function (e) { return e.id === id; });
    document.querySelectorAll('.ga-email-item').forEach(function (i) {
      i.classList.toggle('active', i.dataset.id === id);
    });
    if (!email) return;
    var attHtml = '';
    if (email.attachments && email.attachments.length > 0) {
      attHtml = '<div class="ga-detail-section">Attachment (' + email.attachments.length + ')</div>' +
        '<div class="ga-attachment-list">' +
        email.attachments.map(function (a) {
          var icon = fileIcon(a.filename);
          var size = formatSize(a.sizeBytes);
          return '<div class="ga-attachment-item">' +
            '<span class="ga-attachment-icon">' + icon + '</span>' +
            '<div style="flex:1;min-width:0">' +
              '<div class="ga-attachment-name">' + esc(a.filename) + '</div>' +
              '<div class="ga-attachment-size">' + esc(a.mimeType) + ' &nbsp;·&nbsp; ' + size + '</div>' +
            '</div>' +
          '</div>';
        }).join('') + '</div>';
    }
    var errHtml = '';
    if (email._status === 'error' && email._errorMsg) {
      errHtml = '<div class="ga-detail-error"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>' + esc(email._errorMsg) + '</div>';
    }
    el.emailDetail.innerHTML =
      '<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap">' +
        '<div class="ga-detail-subject">' + esc(email.subject || '(Tanpa Subjek)') + '</div>' +
        badgeHtml(email._status, email._errorMsg) +
      '</div>' +
      '<div class="ga-detail-meta">Dari: ' + esc(email.from) + '<br>' + esc(email.date) + '</div>' +
      '<div class="ga-detail-section">Isi Email</div>' +
      '<div class="ga-detail-body">' + esc(email.bodyText || '(kosong)') + '</div>' +
      attHtml + errHtml;
  }

  // ─── FILES ────────────────────────────────────────────────────
  function loadFiles() {
    fetch(BASE + '/list_files')
      .then(function (r) { return r.json(); })
      .then(function (data) {
        state.allFiles = data.files || [];
        el.tabBadgeFiles.textContent = state.allFiles.length;
        renderFiles();
      });
  }

  function renderFiles() {
    var search = el.fileSearch.value.toLowerCase();
    var type   = el.fileTypeFilter.value;
    var filtered = state.allFiles.filter(function (f) {
      var nameOk = f.name.toLowerCase().indexOf(search) !== -1;
      var ext    = f.name.split('.').pop().toLowerCase();
      var typeOk = type === 'all' || type.split(',').indexOf(ext) !== -1;
      return nameOk && typeOk;
    });

    if (filtered.length === 0) {
      el.filesGrid.innerHTML = '<div class="ga-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg><div class="ga-empty-title">Tidak ada file ditemukan</div><div class="ga-empty-sub">Coba ubah kata kunci pencarian</div></div>';
      return;
    }
    el.filesGrid.innerHTML = '<div class="ga-files-grid">' + filtered.map(function (f) {
      var icon = fileIcon(f.name);
      var size = formatSize(f.size);
      var mod  = new Date(f.modified).toLocaleString('id-ID');
      return '<div class="ga-file-card">' +
        '<div class="ga-file-icon">' + icon + '</div>' +
        '<div class="ga-file-name">' + esc(f.name) + '</div>' +
        '<div class="ga-file-meta">' + size + ' &nbsp;·&nbsp; ' + mod + '</div>' +
        '<a href="' + BASE + '/download_file?name=' + encodeURIComponent(f.name) + '" class="ga-file-download" target="_blank">⬇ Download</a>' +
      '</div>';
    }).join('') + '</div>';
  }

  el.fileSearch.addEventListener('input', renderFiles);
  el.fileTypeFilter.addEventListener('change', renderFiles);

  // ─── RESULTS ──────────────────────────────────────────────────
  function renderResults() {
    if (state.emails.length === 0) {
      el.resultsList.innerHTML = '<div class="ga-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg><div class="ga-empty-title">Belum ada hasil</div></div>';
      el.tabBadgeResults.textContent = '0';
      return;
    }
    el.tabBadgeResults.textContent = state.emails.length;
    el.resultsList.innerHTML = '<table class="table table-bordered table-hover" style="font-size:13px">' +
      '<thead><tr><th>Status</th><th>Subjek</th><th>Pengirim</th><th>Lampiran</th></tr></thead><tbody>' +
      state.emails.map(function (e) {
        return '<tr>' +
          '<td>' + badgeHtml(e._status, e._errorMsg) + '</td>' +
          '<td>' + esc(e.subject || '-') + '</td>' +
          '<td>' + esc(e.from) + '</td>' +
          '<td>' + (e.attachments ? e.attachments.length : 0) + '</td>' +
        '</tr>';
      }).join('') + '</tbody></table>';
  }

  // ─── STATS ────────────────────────────────────────────────────
  function updateStats() {
    var done  = state.emails.filter(function (e) { return e._status === 'done'; }).length;
    var error = state.emails.filter(function (e) { return e._status === 'error'; }).length;
    el.statTotal.textContent  = state.emails.length;
    el.statDone.textContent   = done;
    el.statError.textContent  = error;
    renderResults();
  }

  // ─── STATUS POLLING (setiap 10 detik) ─────────────────────────
  function pollStatus() {
    fetch(BASE + '/cron_status')
      .then(function (r) { return r.json(); })
      .then(function (data) {
        // Deteksi file baru dan auto-refresh daftar file
        if (data.lastDownload && data.lastDownload !== state.lastDownload) {
          var prev = state.lastDownload;
          state.lastDownload = data.lastDownload;
          if (prev !== null) {
            loadFiles(); // refresh daftar file otomatis
          }
        }
      })
      .catch(function () {});
  }

  // ─── CODE TAB ─────────────────────────────────────────────────
  function renderCode() {
    el.codeBlock.textContent = [
      '// ============================================',
      '// Gmail Agent - ZHL App Worker Script',
      '// Jalankan di terminal: php scripts/gmail_worker.php',
      '// ============================================',
      '',
      '// Konfigurasi: application/config/gmail_agent.php',
      '// Controller : application/controllers/Gmail_agent.php',
      '// View       : application/views/gmail_agent/index.php',
      '// File disimpan ke: uploads/gmail_attachments/',
      '',
      '// Gmail Query Filter:',
      '// is:unread has:attachment newer_than:1d',
      '',
      '// Status file: cron-status-gmail.json',
      '// { "enabled": true, "lastCheck": "...", "lastDownload": "..." }',
      '',
      '// Untuk menjalankan worker secara manual:',
      '// cd c:/xampp/htdocs/zhl-app && php scripts/gmail_worker.php',
    ].join('\n');
  }

  // ─── UTILITIES ────────────────────────────────────────────────
  function badgeHtml(status, msg) {
    var map = {
      'pending':    ['ga-badge-pending',    '⏳ Menunggu'],
      'processing': ['ga-badge-processing', '⟳ Memproses'],
      'done':       ['ga-badge-done',       '✓ Selesai'],
      'error':      ['ga-badge-error',      '✗ Gagal'],
    };
    var info = map[status] || map['pending'];
    return '<span class="ga-badge ' + info[0] + '" title="' + esc(msg || '') + '">' + info[1] + '</span>';
  }

  function fileIcon(name) {
    var ext = (name || '').split('.').pop().toLowerCase();
    if (ext === 'pdf')  return '📄';
    if (['xlsx','xls','csv'].indexOf(ext) !== -1) return '📊';
    if (['jpg','jpeg','png','webp','gif'].indexOf(ext) !== -1) return '🖼️';
    if (['zip','rar','7z'].indexOf(ext) !== -1) return '🗜️';
    if (['doc','docx'].indexOf(ext) !== -1) return '📝';
    return '📁';
  }

  function formatSize(bytes) {
    if (!bytes) return '0 B';
    var k = 1024;
    var sizes = ['B','KB','MB','GB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
  }

  function esc(str) {
    return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  function setStatus(msg, isErr) {
    el.fetchStatus.textContent = msg;
    el.fetchStatus.style.color = isErr ? '#ef4444' : '#64748b';
  }

  function switchTab(name) {
    document.querySelectorAll('.ga-tab').forEach(function (b) { b.classList.toggle('active', b.dataset.tab === name); });
    document.querySelectorAll('.ga-tab-content').forEach(function (c) { c.classList.toggle('active', c.id === 'tab-' + name); });
  }

  function postJSON(url, data) {
    var fd = new FormData();
    Object.keys(data).forEach(function (k) { fd.append(k, data[k]); });
    return fetch(url, { method: 'POST', body: fd }).then(function (r) { return r.json(); });
  }

  // ─── INIT ─────────────────────────────────────────────────────
  function initAutoStartWorker() {
    fetch(BASE + '/start_worker', { method: 'POST', body: new FormData() })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data && data.success) {
          setStatus('Worker Gmail otomatis aktif.');
        } else {
          setStatus('Worker Gmail belum aktif. Klik Jalankan Agent untuk mulai.', true);
        }
      })
      .catch(function () {
        setStatus('Worker Gmail belum aktif. Klik Jalankan Agent untuk mulai.', true);
      });
  }

  initAutoStartWorker();
  pollStatus();          // baca status saat load
  loadFiles();           // muat daftar file tersimpan
  setInterval(pollStatus, 15000); // background poll tiap 15 detik

})();
</script>


