<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="stylesheet"
      href="<?= base_url('assets/ai_assistant/css/ai_assistant.css'); ?>?v=<?= time(); ?>">

<div class="page-content">
  <div class="container-fluid">
    <div class="zhl-ai">

      <div class="ai-page-head">
        <h1>ZHL AI Assistant</h1>
        <p>Tanya jawab berbasis dokumen untuk operasional ZHL</p>
      </div>

      <div class="ai-panel">

        <div class="ai-panel-head">
          <div class="ai-head-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/>
              <path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/>
            </svg>
          </div>
          <div>
            <p class="ai-head-title">ZHL AI Assistant</p>
            <p class="ai-head-sub">
              <span id="assistantStatus">Belum ada dokumen dimuat</span>
              <span class="ai-dot">·</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                   stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3l1.9 5.8L20 10.7l-5.1 3.7L16 21l-4-3-4 3 1.1-6.6L4 10.7l6.1-1.9z"/>
              </svg>
              PDF, gambar, dan ZIP
            </p>
          </div>

          <div class="ai-head-actions">
            <a href="<?= site_url('Gmail_agent') ?>" class="ai-ghost-btn" title="Buka Gmail Agent" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; color:#475569;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
              </svg>
              Gmail Agent
            </a>
            <button type="button" id="resetBtn" class="ai-ghost-btn" title="Mulai percakapan baru">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                   stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
              </svg>
              Reset
            </button>
          </div>
        </div>

        <div class="ai-log" id="chatLog">
          <div class="msg-row">
            <div class="message-bot-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                   stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/>
                <path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/>
              </svg>
            </div>
            <div class="msg assistant">Halo! Upload dokumen (PDF/gambar/ZIP) kalau perlu, atau langsung tanya apa saja. Aku bakal bantu jawab berdasarkan dokumen yang kamu upload.</div>
          </div>
        </div>

        <div class="ai-composer">

          <!-- Bar autofill -->
          <div class="ai-actionbar">
            <span class="ai-actionbar-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                   stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <path d="M14 2v6h6"/><path d="M9 15l2 2 4-4"/>
              </svg>
              <span id="autofillHint">Upload BL atau dokumen container dulu, lalu isi form otomatis.</span>
            </span>
            <button type="button" id="autofillBtn" class="ai-primary-btn" disabled>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                   stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
              </svg>
              Isi form Container Stock
            </button>
          </div>

          <div id="autofillNotice" style="display:none;"></div>

          <div id="docList"></div>

          <div id="attachmentPreview"></div>

          <div class="ai-input-row">

            <div class="ai-upload-wrap">
              <input type="file" id="autofillInput" accept=".pdf" hidden>
              <input type="file" id="documentInput" accept=".pdf,.txt,.csv" multiple hidden>
              <input type="file" id="imageInput" accept="image/*" multiple hidden>
              <input type="file" id="zipInput" accept=".zip" hidden>

              <button type="button" id="uploadBtn" class="ai-icon-btn" title="Lampirkan berkas">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 5v14"/><path d="M5 12h14"/>
                </svg>
              </button>

              <div class="upload-menu" id="uploadMenu">
                <button type="button" class="upload-menu-item primary" data-type="autofill">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                       stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <path d="M14 2v6h6"/><path d="M9 15l2 2 4-4"/>
                  </svg>
                  Upload &amp; isi form
                </button>
                <div class="upload-menu-sep"></div>
                <button type="button" class="upload-menu-item" data-type="document">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                       stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <path d="M14 2v6h6"/><path d="M8 13h8"/><path d="M8 17h6"/>
                  </svg>
                  Upload dokumen
                </button>
                <button type="button" class="upload-menu-item" data-type="zip">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                       stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/>
                    <path d="M10 12h4"/><path d="M10 16h4"/>
                  </svg>
                  Upload ZIP
                </button>
                <button type="button" class="upload-menu-item" data-type="image">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                       stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/>
                  </svg>
                  Upload gambar
                </button>
              </div>
            </div>

            <textarea id="chatMsg" rows="1"
                      placeholder="Tanya soal dokumen yang kamu upload..."></textarea>

            <button type="button" id="sendBtn" class="ai-send-btn" disabled title="Kirim">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                   stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4z"/>
              </svg>
            </button>
          </div>

          <p class="ai-hint">Shift + Enter untuk baris baru Â· Enter untuk kirim</p>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  window.AI_ASSISTANT_ASSETS_URL = '<?= base_url('assets/ai_assistant'); ?>';
  window.AI_ASSISTANT_BASE_URL   = '<?= site_url('ai_assistant'); ?>';
  window.ZHL_STOCK_CREATE_URL    = '<?= site_url('shipping/container_stock_create'); ?>';
</script>

<script src="<?= base_url('assets/ai_assistant/vendor/pdfjs/pdf.min.js'); ?>"></script>
<script src="<?= base_url('assets/ai_assistant/vendor/tesseract/tesseract.min.js'); ?>"></script>
<script src="<?= base_url('assets/ai_assistant/js/jszip.min.js'); ?>"></script>
<script src="<?= base_url('assets/ai_assistant/js/pdf-extract.js'); ?>?v=<?= time(); ?>"></script>
<script src="<?= base_url('assets/ai_assistant/js/arrival-notice.js'); ?>?v=<?= time(); ?>"></script>
<script src="<?= base_url('assets/ai_assistant/js/app.js'); ?>?v=<?= time(); ?>"></script>
<script src="<?= base_url('assets/ai_assistant/js/autofill-handoff.js'); ?>?v=<?= time(); ?>"></script>

