(function () {
  'use strict';

  var BASE = window.AI_ASSISTANT_BASE_URL;
  var TARGET = window.ZHL_STOCK_CREATE_URL;
  var HANDOFF_KEY = 'zhl_ai_autofill';
  var MIN_SCORE = 4;   

  var btn = document.getElementById('autofillBtn');
  var hint = document.getElementById('autofillHint');
  var noticeBox = document.getElementById('autofillNotice');

  if (!btn) return;

  var SCHEMA = {
    loading_port:
      'Ambil dari label "Place of Receipt". JANGAN pakai "Port of Discharging" ' +
      'atau "Place of Delivery" — itu pelabuhan tujuan. Contoh: "LAEM CHABANG".',
    arrival_date:
      'Ambil dari label "ETA" yang pertama muncul. Buang jamnya. ' +
      'Format dd/mm/yyyy. Contoh: "26-JUL-26 05:30" jadi "26/07/2026".',
    supplier:
      'Baris pertama blok "SHIPPER ADDRESS", nama perusahaannya saja. ' +
      'Contoh: "TETRA PAK (THAILAND) LIMITED".',
    import_bl_no:
      'Ambil dari label "B/L No". Nomornya saja. Contoh: "ONEYBKKGN9690500".',
    carrier:
      'Nama pelayaran penerbit dokumen, tanpa badan hukum. ' +
      'Contoh: "Ocean Network Express".',
    factory:
      'Lihat "CONSIGNEE ADDRESS". Jawab HANYA "RSUP" atau "PSG". Kodenya sering ' +
      'dalam kurung, contoh "PULAU SAMBU SINGAPORE PTE LTD(RSUP)" berarti RSUP. ' +
      'Kalau tidak jelas, null.',
    free_time:
      'Jumlah hari free time, angka saja. Kalau dokumen tidak mencantumkan, ' +
      'kembalikan null. Jangan ambil angka QTY atau Total Piece Count.',
    containers:
      'Array JSON dari tabel berheader "CONTAINER# TP SEAL# QTY". Tiap elemen: ' +
      'container_number (contoh "ONEU2424468"), container_type (kolom TP, salin ' +
      'apa adanya seperti "D2"), seal, dan remark. Kosong kalau tidak ada tabel.'
  };

  function notice(kind, text) {
    if (!noticeBox) return;
    noticeBox.style.display = 'block';
    noticeBox.innerHTML =
      '<div class="ai-notice ' + kind + '"><span>' + text + '</span>' +
      '<button type="button" class="ai-notice-close" ' +
      'onclick="this.parentNode.parentNode.style.display=\'none\'">&times;</button></div>';
  }

  function clearNotice() {
    if (noticeBox) noticeBox.style.display = 'none';
  }

  function refreshState() {
    if (!window.AiAssistant) return;

    var parsed = window.AiAssistant.getParsedFields();
    var docs = window.AiAssistant.getDocCount();

    btn.disabled = docs === 0;

    if (!hint) return;

    if (parsed && window.ZhlArrivalNotice.score(parsed) >= MIN_SCORE) {
      hint.textContent = 'Arrival Notice terbaca langsung — tanpa perlu AI.';
    } else if (docs > 0) {
      hint.textContent = 'Dokumen siap. Field akan dibaca lewat AI.';
    } else {
      hint.textContent = 'Upload BL atau Arrival Notice dulu, lalu isi form otomatis.';
    }
  }

  setInterval(refreshState, 800);
  refreshState();

  function handoff(fields, via) {
    console.log('AUTOFILL (' + via + '):', fields);

    localStorage.setItem(HANDOFF_KEY, JSON.stringify({
      fields: fields,
      via: via,
      ts: Date.now()
    }));

    window.location.href = TARGET;
  }

  function run() {

    var parsed = window.AiAssistant.getParsedFields();

    if (parsed && window.ZhlArrivalNotice.score(parsed) >= MIN_SCORE) {
      handoff(parsed, 'parser');
      return;
    }

    // --- LLM --------------------------------------------------
    var text = (window.AiAssistant.getExtractedText() || '').trim();

    if (text.length < 40) {
      notice('error', 'Belum ada teks dokumen yang terbaca.');
      return;
    }

    clearNotice();
    btn.disabled = true;
    var original = btn.innerHTML;
    btn.textContent = 'Membaca dokumen...';

    var fd = new FormData();
    fd.append('raw_text', text);
    fd.append('schema', JSON.stringify(SCHEMA));

    fetch(BASE + '/extract', { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.error) {
          throw new Error(data.error + (data.detail ? ' — ' + data.detail : ''));
        }

        var fields = data.fields || {};
        if (fields._raw) {
          throw new Error('Model tidak mengembalikan JSON yang bisa dibaca.');
        }

        var any = Object.keys(fields).filter(function (k) {
          var v = fields[k];
          if (v === null || v === undefined || v === '') return false;
          if (Array.isArray(v) && v.length === 0) return false;
          return true;
        });

        if (!any.length) {
          throw new Error('Tidak ada field yang bisa diambil dari dokumen ini.');
        }

        handoff(fields, 'llm');
      })
      .catch(function (e) {
        notice('error', 'Gagal mengisi form: ' + e.message);
        btn.innerHTML = original;
        refreshState();
      });
  }

  btn.addEventListener('click', run);

  window.ZhlAutofill = { run: run };
})();
