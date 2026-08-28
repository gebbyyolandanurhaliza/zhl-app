(function () {
  'use strict';

  var PREFIX_CARRIER = {
    ONEU: 'Ocean Network Express',
    MAEU: 'Maersk', MSKU: 'Maersk', MRKU: 'Maersk',
    MSCU: 'MSC', MEDU: 'MSC',
    CMAU: 'CMA CGM', APLU: 'APL',
    EGHU: 'Evergreen', EISU: 'Evergreen', EMCU: 'Evergreen',
    CSNU: 'COSCO', CBHU: 'COSCO', OOLU: 'OOCL',
    HLXU: 'Hapag-Lloyd', HLBU: 'Hapag-Lloyd',
    YMLU: 'Yang Ming', ZIMU: 'ZIM',
    PCIU: 'PIL', HMMU: 'HMM', WHLU: 'Wan Hai',
    SITU: 'SITC', KMTU: 'KMTC', TSLU: 'TS Lines'
  };

  var KNOWN_CARRIERS = [
    'Ocean Network Express', 'Maersk', 'MSC', 'CMA CGM', 'Evergreen',
    'COSCO', 'OOCL', 'Hapag-Lloyd', 'Yang Ming', 'ZIM', 'APL',
    'Pacific International Lines', 'HMM', 'Wan Hai', 'SITC',
    'TS Lines', 'Sinokor', 'Heung-A', 'Namsung', 'KMTC',
    'Interasia', 'Gold Star', 'X-Press Feeders', 'Swire Shipping'
  ];

  var CONTAINER_RE = /^[A-Z]{4}\d{7}$/;

  function detect(text) {
    var t = String(text || '');
    return /ARRIVAL\s*NOTICE/i.test(t) && /B\s*\/\s*L\s*No/i.test(t);
  }

  function parse(pages) {
    var P = window.ZhlPdf;
    var lines = P.pagesToLines(pages);
    var fullText = lines.join('\n');
    var upper = fullText.toUpperCase();

    var out = {
      loading_port: null,
      arrival_date: null,
      supplier: null,
      import_bl_no: null,
      carrier: null,
      factory: null,
      free_time: null,
      containers: [],
      _source: 'arrival-notice-parser'
    };

    // --- B/L No -----------------------------------------------------------
    var bl = fullText.match(/B\s*\/\s*L\s*No\s*:?\s*([A-Z0-9]{6,})/i);
    if (bl) out.import_bl_no = bl[1].trim();

    // --- Place of Receipt -> Loading Port ---------------------------------
    var receiptRow = P.findRow(pages, /Place\s+of\s+Receipt/i);
    if (receiptRow) {
      var v = P.valueRightOf(receiptRow.row, ['Place', 'of', 'Receipt']);
      if (v) out.loading_port = v;
    }

    // --- ETA -> Arrival Date ---------------------------------------------
    // Ambil ETA pertama (ETA vessel), bukan Available Date.
    for (var i = 0; i < pages.length && !out.arrival_date; i++) {
      var rows = pages[i].rows;
      for (var r = 0; r < rows.length; r++) {
        var val = P.valueRightOf(rows[r], ['ETA']);
        if (!val) continue;
        var d = val.match(/(\d{1,2})[-\s\/]([A-Za-z]{3,}|\d{1,2})[-\s\/](\d{2,4})/);
        if (d) {
          out.arrival_date = d[0];
          break;
        }
      }
    }

    // --- Shipper -> Supplier ---------------------------------------------
    var shipper = P.blockBelow(pages, /SHIPPER\s+ADDRESS/i, 1);
    if (shipper.length) out.supplier = shipper[0];

    // --- Consignee -> Factory --------------------------------------------
    var consignee = P.blockBelow(pages, /CONSIGNEE\s+ADDRESS/i, 1);
    var consigneeText = consignee.join(' ').toUpperCase();

    if (/RSUP|RIAU\s+SAKTI/.test(consigneeText) || /RSUP|RIAU\s+SAKTI/.test(upper)) {
      out.factory = 'RSUP';
    } else if (/\bPSG\b|PULAU\s+SAMBU\s+GUNTUNG/.test(consigneeText) ||
               /\bPSG\b|PULAU\s+SAMBU\s+GUNTUNG/.test(upper)) {
      out.factory = 'PSG';
    }

    // --- Tabel kontainer --------------------------------------------------
    pages.forEach(function (page) {
      page.rows.forEach(function (row) {

        var groups = P.splitColumns(row);

        groups.forEach(function (grp) {
          for (var k = 0; k < grp.length; k++) {
            var tok = grp[k].text.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (!CONTAINER_RE.test(tok)) continue;

            var rest = [];
            for (var j = k + 1; j < grp.length; j++) {
              rest.push(grp[j].text);
            }

            out.containers.push({
              container_number: tok,
              container_type: rest[0] || null,   
              seal: rest[1] || null,
              remark: null
            });
            return;
          }
        });
      });
    });

    // --- Carrier ----------------------------------------------------------
    for (var c = 0; c < KNOWN_CARRIERS.length && !out.carrier; c++) {
      if (upper.indexOf(KNOWN_CARRIERS[c].toUpperCase()) !== -1) {
        out.carrier = KNOWN_CARRIERS[c];
      }
    }

    if (!out.carrier && out.containers.length) {
      var pfx = out.containers[0].container_number.substring(0, 4);
      if (PREFIX_CARRIER[pfx]) out.carrier = PREFIX_CARRIER[pfx];
    }

    // --- Free Time --------------------------------------------------------
    var ft = fullText.match(/FREE\s*TIME\s*:?\s*(\d{1,3})\s*(?:DAYS?|HARI)?/i);
    if (ft) out.free_time = ft[1];

    return out;
  }

  function score(fields) {
    var core = ['loading_port', 'arrival_date', 'supplier', 'import_bl_no', 'carrier'];
    var n = 0;
    core.forEach(function (k) {
      if (fields[k]) n++;
    });
    if (fields.containers && fields.containers.length) n++;
    return n;
  }

  window.ZhlArrivalNotice = {
    detect: detect,
    parse: parse,
    score: score
  };
})();
