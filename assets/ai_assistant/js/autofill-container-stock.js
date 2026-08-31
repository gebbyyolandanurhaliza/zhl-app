(function () {
  'use strict';

  var HANDOFF_KEY = 'zhl_ai_autofill';
  var MAX_AGE_MS = 5 * 60 * 1000; 
  var MONTHS = {
    JAN: 1, FEB: 2, MAR: 3, APR: 4, MAY: 5, JUN: 6,
    JUL: 7, AUG: 8, SEP: 9, OCT: 10, NOV: 11, DEC: 12,
    MEI: 5, AGU: 8, OKT: 10, NOP: 11, DES: 12
  };

  var TP_CODES = {
    D2: { size: 20, kind: 'GP' },
    D4: { size: 40, kind: 'GP' },
    D5: { size: 40, kind: 'HC' },
    R2: { size: 20, kind: 'RF' },
    R4: { size: 40, kind: 'RF' },
    R5: { size: 40, kind: 'RH' },
    O2: { size: 20, kind: 'OT' },
    O4: { size: 40, kind: 'OT' },
    F2: { size: 20, kind: 'FR' },
    F4: { size: 40, kind: 'FR' },
    T2: { size: 20, kind: 'TK' },
    T4: { size: 40, kind: 'TK' }
  };

  var EG_SIZE = { '2': 20, '4': 40, '5': 45 };

  var EG_KIND = {
    SD: 'GP', GP: 'GP', DV: 'GP', DC: 'GP',
    HQ: 'HC', HD: 'HC', HC: 'HC',
    RF: 'RF', RE: 'RF', RH: 'RH', RQ: 'RH',
    OT: 'OT', OP: 'OT',
    FR: 'FR', FL: 'FR', PL: 'FR',
    TK: 'TK', TN: 'TK'
  };

  function log() {
    var args = Array.prototype.slice.call(arguments);
    args.unshift('[ZHL autofill]');
    console.log.apply(console, args);
  }

  function ready(fn) {
    if (document.readyState !== 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }

  function isDatepicker(el) {
    return el.classList.contains('date-picker') ||
           el.classList.contains('datepicker') ||
           el.getAttribute('data-date-format') !== null;
  }

  function setField(name, value) {
    if (value === null || value === undefined || value === '') return false;

    var el = document.querySelector(
      '[name="' + name + '"], [data-ai-field="' + name + '"]'
    );
    if (!el) {
      log('field "' + name + '" tidak ada di halaman ini.');
      return false;
    }

    if (isDatepicker(el) && window.jQuery && window.jQuery(el).datepicker) {
      try {
        window.jQuery(el).datepicker('update', value);
        if (el.value !== value) el.value = value;   
        log('field "' + name + '" diisi lewat datepicker:', el.value);
        return true;
      } catch (e) {
        log('datepicker menolak "' + name + '", pakai cara biasa:', e.message);
      }
    }

    el.value = value;

    el.dispatchEvent(new Event('input', { bubbles: true }));
    if (el.tagName === 'SELECT') {
      el.dispatchEvent(new Event('change', { bubbles: true }));
    }

    if (el.value !== String(value)) {
      log('PERINGATAN: "' + name + '" berubah setelah diisi. ' +
          'Diminta "' + value + '", jadi "' + el.value + '".');
    }

    return true;
  }

  function toDdMmYyyy(raw) {
    if (raw === null || raw === undefined) return '';

    var s = String(raw).toUpperCase().trim();

    s = s.replace(/\b\d{1,2}:\d{2}(:\d{2})?\b/g, ' ').trim();

    var parts = s.split(/[\/\-.,\s]+/).filter(Boolean);
    if (parts.length < 3) return '';
    parts = parts.slice(0, 3);

    var d, m, y;

    if (/^\d{4}$/.test(parts[0])) {        
      y = parts[0]; m = parts[1]; d = parts[2];
    } else {                               
      d = parts[0]; m = parts[1]; y = parts[2];
    }

    if (!/^\d+$/.test(m)) {
      var key = m.substring(0, 3);
      if (!MONTHS[key]) return '';
      m = MONTHS[key];
    }

    d = parseInt(d, 10);
    m = parseInt(m, 10);
    y = parseInt(y, 10);

    if (!d || !m || isNaN(y)) return '';
    if (d < 1 || d > 31 || m < 1 || m > 12) return '';

    if (y < 100) y = 2000 + y;             

    return ('0' + d).slice(-2) + '/' + ('0' + m).slice(-2) + '/' + y;
  }

  function toFactoryCode(raw) {
    if (!raw) return '';
    var s = String(raw).toUpperCase();
    if (s.indexOf('RSUP') !== -1 || s.indexOf('RIAU SAKTI') !== -1) return 'RSUP';
    if (s.indexOf('PSG') !== -1 || s.indexOf('PULAU SAMBU GUNTUNG') !== -1) return 'PSG';
    return '';
  }

  function digitsOnly(raw) {
    if (raw === null || raw === undefined) return '';
    var m = String(raw).match(/\d+/);
    return m ? m[0] : '';
  }

  function normalizeType(raw) {
    if (!raw) return null;

    var s = String(raw).toUpperCase().replace(/[^A-Z0-9]/g, '');
    if (!s) return null;

    if (TP_CODES[s]) return TP_CODES[s];

    var eg = s.match(/^([245])([A-Z]{2,3})$/);
    if (eg && EG_SIZE[eg[1]]) {
      return {
        size: EG_SIZE[eg[1]],
        kind: EG_KIND[eg[2].substring(0, 2)] || 'GP'
      };
    }

    var iso = s.match(/^(2[0-9]|4[0-9]|L[0-9])([A-Z])[0-9]$/);
    if (iso) {
      var isoSize = iso[1].charAt(0) === '2' ? 20 : 40;
      var isoHigh = iso[1] === '45' || iso[1] === '25';
      var isoKind = { G: 'GP', R: 'RF', U: 'OT', P: 'FR', T: 'TK' }[iso[2]] || 'GP';
      if (isoHigh && isoKind === 'GP') isoKind = 'HC';
      if (isoHigh && isoKind === 'RF') isoKind = 'RH';
      return { size: isoSize, kind: isoKind };
    }

    var sizeMatch = s.match(/(20|40|45)/);
    if (!sizeMatch) return null;

    var kind = 'GP';
    if (s.indexOf('HC') !== -1 || s.indexOf('HIGHCUBE') !== -1) kind = 'HC';
    if (s.indexOf('RF') !== -1 || s.indexOf('REEFER') !== -1) kind = 'RF';
    if (s.indexOf('OT') !== -1 || s.indexOf('OPENTOP') !== -1) kind = 'OT';
    if (s.indexOf('FR') !== -1 || s.indexOf('FLAT') !== -1) kind = 'FR';
    if (s.indexOf('TK') !== -1 || s.indexOf('TANK') !== -1) kind = 'TK';

    return { size: parseInt(sizeMatch[1], 10), kind: kind };
  }

  function findContainerType(raw) {
    var sel = document.getElementById('ctr_id');

    if (!sel || !sel.options.length) {
      log('daftar Container Type (#ctr_id) kosong atau tidak ada di halaman. ' +
          'Cek query tampil_container_stock_modal() di controller.');
      return null;
    }

    var want = normalizeType(raw);

    if (!want) {
      log('kode tipe "' + raw + '" tidak dikenali. Tambahkan ke TP_CODES ' +
          'di bagian atas file ini.');
      return null;
    }

    var best = null;
    var bestScore = 0;

    for (var i = 0; i < sel.options.length; i++) {
      var opt = sel.options[i];
      var got = normalizeType(opt.text);
      if (!got || got.size !== want.size) continue;

      var score = 1;
      if (got.kind === want.kind) score = 2;

      if (score > bestScore) {
        bestScore = score;
        best = { id: opt.value, name: opt.text, exact: score === 2 };
      }
    }

    if (!best) {
      var names = [];
      for (var m = 0; m < sel.options.length; m++) names.push(sel.options[m].text);
      log('tidak ada Container Type yang cocok dengan ' + want.size + 'ft ' +
          want.kind + ' (dari kode "' + raw + '"). Pilihan yang tersedia:', names);
    }

    return best;
  }

  function escapeAttr(s) {
    return String(s === null || s === undefined ? '' : s)
      .replace(/&/g, '&amp;')
      .replace(/"/g, '&quot;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');
  }

  function appendRow(typeName, typeId, number, remark) {
    var html =
      '<tr onclick="deleterow(this)">' +
      '<td align="center"><button class="btn btn-sm btn-danger" type="button">' +
      '<i class="fa fa-trash"></i></button></td>' +
      '<td nowrap onclick="event.stopPropagation();return false;">' +
      '<input type="text" class="form-control input-sm" name="container_name[]" value="' +
      escapeAttr(typeName) + '" readonly>' +
      '<input type="hidden" class="form-control input-sm" name="container_id[]" value="' +
      escapeAttr(typeId) + '"></td>' +
      '<td nowrap onclick="event.stopPropagation();return false;">' +
      '<input type="text" class="form-control input-sm" name="container_number[]" value="' +
      escapeAttr(number) + '"></td>' +
      '<td hidden nowrap onclick="event.stopPropagation();return false;" style="width:10px;">' +
      '<select name="Remark2[]" class="form-control input-sm">' +
      '<option value="">SELECT</option>' +
      '<option value="IFT">Insufficient FT</option>' +
      '<option value="QCf">QC fail</option>' +
      '<option value="RNC">Reuse not approved by carrier</option>' +
      '<option value="CC">Customs Checks</option>' +
      '<option value="ULS">Used for local stuffing</option>' +
      '</select></td>' +
      '<td nowrap onclick="event.stopPropagation();return false;" style="width:300px;">' +
      '<input type="text" class="form-control input-sm" name="Remark[]" value="' +
      escapeAttr(remark) + '"></td>' +
      '<td hidden></td><td hidden></td><td hidden></td>' +
      '</tr>';

    var tbody = document.getElementById('tblList_1');
    if (tbody) {
      tbody.insertAdjacentHTML('beforeend', html);
      return true;
    }

    var table = document.getElementById('tblList');
    if (table) {
      table.insertAdjacentHTML('beforeend', html);
      return true;
    }

    return false;
  }

  function banner(kind, title, detail, autoHideMs) {
    var colors = {
      success: ['#f0fdf4', '#bbf7d0', '#15803d'],
      warn: ['#fffbeb', '#fde68a', '#b45309'],
      info: ['#eff6ff', '#bfdbfe', '#1e40af']
    };
    var c = colors[kind] || colors.success;

    var div = document.createElement('div');
    div.style.cssText =
      'margin:0 0 14px;padding:11px 14px;border-radius:8px;font-size:13px;' +
      'display:flex;align-items:flex-start;gap:10px;' +
      'background:' + c[0] + ';border:1px solid ' + c[1] + ';color:' + c[2] + ';';

    div.innerHTML =
      '<div style="flex:1"><strong>' + title + '</strong>' +
      (detail ? '<div style="margin-top:3px;opacity:.9">' + detail + '</div>' : '') +
      '</div>' +
      '<button type="button" style="background:none;border:0;color:inherit;' +
      'cursor:pointer;font-size:16px;line-height:1;padding:0">&times;</button>';

    div.querySelector('button').addEventListener('click', function () {
      div.remove();
    });

    var anchor = document.querySelector('.portlet-body.form') ||
                 document.querySelector('.portlet-body') ||
                 document.querySelector('.container-fluid');

    if (anchor) {
      anchor.insertBefore(div, anchor.firstChild);
    } else {
      div.style.position = 'fixed';
      div.style.top = '70px';
      div.style.left = '20px';
      div.style.right = '20px';
      div.style.zIndex = '9999';
      document.body.appendChild(div);
    }

    if (autoHideMs) {
      setTimeout(function () {
        if (div.parentNode) div.remove();
      }, autoHideMs);
    }

    return div;
  }

  function readPayload() {
    var raw;
    try {
      raw = localStorage.getItem(HANDOFF_KEY);
    } catch (e) {
      log('localStorage tidak bisa dibaca:', e.message);
      return null;
    }

    if (!raw) {
      log('tidak ada titipan di localStorage["' + HANDOFF_KEY + '"].');
      return null;
    }

    var payload;
    try {
      payload = JSON.parse(raw);
    } catch (e) {
      log('titipan rusak, bukan JSON valid.');
      return null;
    }

    if (!payload || !payload.fields) {
      log('titipan ada tapi tidak berisi fields.');
      return null;
    }

    if (payload.ts && Date.now() - payload.ts > MAX_AGE_MS) {
      log('titipan kadaluarsa (lebih dari 5 menit).');
      try { localStorage.removeItem(HANDOFF_KEY); } catch (e) {}
      return null;
    }

    return payload;
  }

  function fill(f) {
    log('mengisi form dengan:', f);

    function tryset(name, value) {
      try {
        return setField(name, value);
      } catch (e) {
        log('gagal mengisi "' + name + '":', e.message);
        return false;
      }
    }

    var filled = [];
    var skipped = [];

    if (tryset('loading_port', f.loading_port)) filled.push('Loading Port');
    if (tryset('supplier', f.supplier)) filled.push('Supplier');
    if (tryset('import_bl_no', f.import_bl_no)) filled.push('Import BL No');
    if (tryset('carrier', f.carrier)) filled.push('Carrier');

    var factory = toFactoryCode(f.factory);
    if (factory && tryset('factory', factory)) {
      filled.push('Factory');
    } else if (f.factory) {
      skipped.push('Factory (nilai "' + f.factory + '" tidak dikenali)');
    }

    var arrival = toDdMmYyyy(f.arrival_date);
    if (arrival && tryset('arrival_date', arrival)) {
      filled.push('Arrival Date');
    } else if (f.arrival_date) {
      skipped.push('Arrival Date (format "' + f.arrival_date + '" tidak terbaca)');
    }

    var freeTime = digitsOnly(f.free_time);
    if (freeTime && tryset('free_time', freeTime)) filled.push('Free Time');

    if (arrival && typeof window.ganti_ref === 'function') {
      try { window.ganti_ref(); } catch (e) {}
    }
    if (arrival && freeTime && typeof window.hitungSelisihHari2 === 'function') {
      try { window.hitungSelisihHari2(); } catch (e) {}
    }

    var rows = 0;
    var unknownType = 0;

    if (Array.isArray(f.containers)) {
      f.containers.forEach(function (c) {
        if (!c) return;

        var number = c.container_number || c.number || '';
        if (!number) return;

        var match = findContainerType(c.container_type || c.type);
        if (!match) unknownType++;

        var remark = '';

        var fallback = '';
        if (!match) {
          var n = normalizeType(c.container_type || c.type);
          fallback = n
            ? n.size + 'ft ' + n.kind + ' (pilih manual)'
            : (c.container_type || '(pilih manual)');
        }

        if (appendRow(
          match ? match.name : fallback,
          match ? match.id : '',
          number,
          remark
        )) {
          rows++;
        }
      });
    }

    if (rows > 0 && typeof window.cekDtl === 'function') {
      try { window.cekDtl(); } catch (e) {}
    }

    if (filled.length === 0 && rows === 0) {
      banner('warn', 'Tidak ada field yang cocok',
        'AI membaca dokumennya, tapi tidak ada isi yang bisa dipetakan ke form ini. ' +
        'Buka Console untuk melihat hasil mentahnya.');
      return false;
    }

    var detail = [];
    if (filled.length) detail.push('Terisi: ' + filled.join(', ') + '.');
    if (rows) detail.push(rows + ' baris kontainer ditambahkan.');
    if (unknownType) {
      detail.push(unknownType + ' baris belum punya Container Type — pilih manual sebelum simpan.');
    }
    if (skipped.length) detail.push('Dilewati: ' + skipped.join('; ') + '.');
    detail.push('Periksa semuanya sebelum klik Save.');

    banner('success', 'Form diisi dari dokumen', detail.join(' '));
    return true;
  }

  function run() {
    var payload = readPayload();

    if (!payload) {
      banner('warn', 'Tidak ada data untuk diisikan',
        'Titipan dari AI Assistant tidak ditemukan atau sudah kadaluarsa.', 9000);
      return false;
    }

    var ok = false;

    try {
      ok = fill(payload.fields);
    } catch (e) {

      console.error('[ZHL autofill] gagal mengisi form:', e);
      banner('warn', 'Autofill gagal di tengah jalan',
        'Lihat Console untuk detailnya. Datanya masih tersimpan — ' +
        'jalankan ZhlAutofillReceiver.run() untuk mencoba lagi.');
      return false;
    }

    if (ok) {
      try { localStorage.removeItem(HANDOFF_KEY); } catch (e) {}
    }

    return ok;
  }

  ready(function () {
    log('receiver aktif di halaman ini.');

    var payload = readPayload();

    if (!payload) {

      banner('info', 'Autofill aktif',
        'Belum ada data dari AI Assistant. Buka AI Assistant, klik + lalu ' +
        '"Upload & isi form".', 9000);
      return;
    }

    run();
  });

  window.ZhlAutofillReceiver = {
    peek: readPayload,
    run: run,
    fill: fill
  };
})();
