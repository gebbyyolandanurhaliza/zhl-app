(function () {
  'use strict';

  var PREFIX_CARRIER = {
    ONEU: 'Ocean Network Express',
    MAEU: 'Maersk', MSKU: 'Maersk', MRKU: 'Maersk',
    MSCU: 'MSC', MEDU: 'MSC',
    CMAU: 'CMA CGM', APLU: 'APL',
    EGHU: 'Evergreen', EISU: 'Evergreen', EMCU: 'Evergreen',
    EGSU: 'Evergreen', EITU: 'Evergreen',
    CSNU: 'COSCO', CBHU: 'COSCO', OOLU: 'OOCL',
    HLXU: 'Hapag-Lloyd', HLBU: 'Hapag-Lloyd',
    YMLU: 'Yang Ming', ZIMU: 'ZIM',
    PCIU: 'PIL', HMMU: 'HMM', WHLU: 'Wan Hai',
    SITU: 'SITC', KMTU: 'KMTC', TSLU: 'TS Lines'
  };

  var KNOWN_CARRIERS = [
    ['OCEAN NETWORK EXPRESS', 'Ocean Network Express'],
    ['EVERGREEN', 'Evergreen'],
    ['HAPAG-LLOYD', 'Hapag-Lloyd'],
    ['CMA CGM', 'CMA CGM'],
    ['YANG MING', 'Yang Ming'],
    ['WAN HAI', 'Wan Hai'],
    ['TS LINES', 'TS Lines'],
    ['X-PRESS FEEDERS', 'X-Press Feeders'],
    ['PACIFIC INTERNATIONAL LINES', 'PIL'],
    ['MAERSK', 'Maersk'],
    ['COSCO', 'COSCO'],
    ['OOCL', 'OOCL'],
    ['SINOKOR', 'Sinokor'],
    ['HEUNG-A', 'Heung-A'],
    ['NAMSUNG', 'Namsung'],
    ['INTERASIA', 'Interasia'],
    ['SWIRE', 'Swire Shipping'],
    ['KMTC', 'KMTC'],
    ['SITC', 'SITC'],
    ['ZIM', 'ZIM'],
    ['HMM', 'HMM'],
    ['MSC', 'MSC'],
    ['APL', 'APL'],
    ['PIL', 'PIL']
  ];

  var CONTAINER_RE = /^[A-Z]{4}\d{7}$/;

  var TYPE_PATTERNS = [
    /^[A-Z]\d$/,
    /^[245][A-Z]{2,3}$/,
    /^\d{2}[A-Z]\d$/,
    /^(20|40|45)[A-Z]{2}$/
  ];

  var SEAL_RE = /^(?=.*\d)[A-Z0-9]{6,15}$/;

  function isTypeCode(tok) {
    var t = String(tok || '').toUpperCase().replace(/[^A-Z0-9]/g, '');
    for (var i = 0; i < TYPE_PATTERNS.length; i++) {
      if (TYPE_PATTERNS[i].test(t)) return true;
    }
    return false;
  }

  function cleanCompany(name) {
    if (!name) return null;

    var s = String(name).trim().replace(/\s{2,}/g, ' ');
    var suffix = /[\s,.]*(CO\.?\s*,?\s*LTD\.?|PTE\.?\s*LTD\.?|SDN\.?\s*BHD\.?|LIMITED|LTD\.?|INC\.?|CORPORATION|CORP\.?|GMBH|B\.?V\.?|N\.?V\.?)\s*$/i;

    for (var i = 0; i < 4 && suffix.test(s); i++) {
      s = s.replace(suffix, '').trim();
    }

    s = s.replace(/[\s,.]+$/, '').trim();
    return s || null;
  }

  function findDate(str) {
    var s = String(str || '');

    var iso = s.match(/\b(\d{4})[-\/.](\d{1,2})[-\/.](\d{1,2})\b/);
    if (iso) return iso[0];

    var loose = s.match(/\b(\d{1,2})[-\s\/.]([A-Za-z]{3,}|\d{1,2})[-\s\/.](\d{2,4})\b/);
    return loose ? loose[0] : null;
  }

  function detectCarrier(upper, containers) {
    for (var i = 0; i < KNOWN_CARRIERS.length; i++) {
      if (upper.indexOf(KNOWN_CARRIERS[i][0]) !== -1) {
        return KNOWN_CARRIERS[i][1];
      }
    }

    if (containers && containers.length) {
      var pfx = containers[0].container_number.substring(0, 4);
      if (PREFIX_CARRIER[pfx]) return PREFIX_CARRIER[pfx];
    }

    return null;
  }

  function detectFactory(text) {
    var s = String(text || '').toUpperCase();

    if (/\bPSG\b|PULAU\s+SAMBU\s+GUNTUNG/.test(s)) return 'PSG';
    if (/\bRSUP\b|RIAU\s+SAKTI|PULAU\s+SAMBU\s+SINGAPORE/.test(s)) return 'RSUP';

    return null;
  }

  function readTypeAndSeal(tokens) {
    var type = null;
    var seal = null;

    tokens.forEach(function (raw) {
      var t = String(raw).toUpperCase().replace(/[^A-Z0-9]/g, '');
      if (!t) return;

      if (!type && isTypeCode(t)) { type = t; return; }
      if (!seal && !isTypeCode(t) && SEAL_RE.test(t)) { seal = t; }
    });

    return { type: type, seal: seal };
  }

  function emptyResult(source) {
    return {
      loading_port: null,
      arrival_date: null,
      supplier: null,
      import_bl_no: null,
      carrier: null,
      factory: null,
      free_time: null,
      containers: [],
      _source: source
    };
  }

  function findFreeTime(text) {
    var m = text.match(/FREE\s*TIME\s*:?\s*(\d{1,3})\s*(?:DAYS?|HARI)?/i);
    return m ? m[1] : null;
  }

  function parseONE(pages) {
    var P = window.ZhlPdf;
    var lines = P.pagesToLines(pages);
    var fullText = lines.join('\n');
    var upper = fullText.toUpperCase();

    var out = emptyResult('one');

    var bl = fullText.match(/B\s*\/\s*L\s*No\.?\s*:?\s*([A-Z0-9]{6,})/i);
    if (bl) out.import_bl_no = bl[1].trim();

    var receipt = P.findRow(pages, /Place\s+of\s+Receipt/i);
    if (receipt) {
      var v = P.valueRightOf(receipt.row, ['Place', 'of', 'Receipt']);
      if (v) out.loading_port = v;
    }

    for (var i = 0; i < pages.length && !out.arrival_date; i++) {
      var rows = pages[i].rows;
      for (var r = 0; r < rows.length; r++) {
        var val = P.valueRightOf(rows[r], ['ETA']);
        if (!val) continue;
        var d = findDate(val);
        if (d) { out.arrival_date = d; break; }
      }
    }

    var shipper = P.blockBelow(pages, /SHIPPER\s+ADDRESS/i, 1);
    if (shipper.length) out.supplier = cleanCompany(shipper[0]);

    var consignee = P.blockBelow(pages, /CONSIGNEE\s+ADDRESS/i, 1);
    out.factory = detectFactory(consignee.join(' ')) || detectFactory(upper);

    pages.forEach(function (page) {
      page.rows.forEach(function (row) {
        P.splitColumns(row).forEach(function (grp) {
          for (var k = 0; k < grp.length; k++) {
            var tok = grp[k].text.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (!CONTAINER_RE.test(tok)) continue;

            var rest = [];
            for (var j = k + 1; j < grp.length; j++) rest.push(grp[j].text);

            var ts = readTypeAndSeal(rest);

            out.containers.push({
              container_number: tok,
              container_type: ts.type,
              seal: ts.seal,
              remark: null
            });
            return;
          }
        });
      });
    });

    out.carrier = detectCarrier(upper, out.containers);
    out.free_time = findFreeTime(fullText);

    return out;
  }

  function parseEvergreen(pages) {
    var P = window.ZhlPdf;
    var lines = P.pagesToLines(pages);
    var fullText = lines.join('\n');
    var upper = fullText.toUpperCase();

    var out = emptyResult('evergreen');

    var bl = fullText.match(/B\s*\/\s*L\s*NO\.?\s*:?\s*([A-Z0-9]{6,})/i);
    if (bl) out.import_bl_no = bl[1].trim();

    var route = fullText.match(/RCT\s*\/\s*POL\s*\/\s*POD\s*\/\s*DLY\s*:?\s*([^\n]+)/i);
    if (route) {
      var parts = route[1].split('/').map(function (x) { return x.trim(); });
      if (parts[1]) out.loading_port = parts[1];
    }

    var eta = fullText.match(/\bETA\b[^\n:]*:?\s*([^\n]+)/i);
    if (eta) {
      var d = findDate(eta[1]);
      if (d) out.arrival_date = d;
    }

    var shipper = fullText.match(/^\s*Shipper\s*:?\s*(.+)$/im);
    if (shipper) out.supplier = cleanCompany(shipper[1]);

    var consignee = fullText.match(/^\s*Consignee\s*:?\s*(.+)$/im);
    out.factory = detectFactory(consignee ? consignee[1] : '') ||
                  detectFactory(upper);

    lines.forEach(function (line) {
      var tokens = line.split(/\s+/).filter(Boolean);

      for (var k = 0; k < tokens.length; k++) {
        var tok = tokens[k].toUpperCase().replace(/[^A-Z0-9]/g, '');
        if (!CONTAINER_RE.test(tok)) continue;

        var ts = readTypeAndSeal(tokens.slice(k + 1, k + 7));

        out.containers.push({
          container_number: tok,
          container_type: ts.type,
          seal: ts.seal,
          remark: null
        });
        return;
      }
    });

    out.carrier = detectCarrier(upper, out.containers);
    out.free_time = findFreeTime(fullText);

    return out;
  }

  function detect(text) {
    var t = String(text || '');
    return /ARRIVAL\s*NOTICE/i.test(t) && /B\s*\/\s*L\s*NO/i.test(t);
  }

  function score(fields) {
    if (!fields) return 0;

    var core = ['loading_port', 'arrival_date', 'supplier', 'import_bl_no', 'carrier'];
    var n = 0;

    core.forEach(function (k) { if (fields[k]) n++; });
    if (fields.containers && fields.containers.length) n++;

    return n;
  }

  function parse(pages) {
    var text = window.ZhlPdf.pagesToLines(pages).join('\n');
    var upper = text.toUpperCase();

    var isEvergreen = /RCT\s*\/\s*POL\s*\/\s*POD/i.test(text) ||
                      /LOADING\s+VSL\s*\/\s*VOY/i.test(text) ||
                      upper.indexOf('EVERGREEN') !== -1;

    var isONE = /PLACE\s+OF\s+RECEIPT/i.test(text) ||
                /AVAILABLE\s+CONTAINER\s+YARD/i.test(text);

    var primary = null;

    try {
      if (isEvergreen && !isONE) {
        primary = parseEvergreen(pages);
      } else {
        primary = parseONE(pages);
      }
    } catch (e) {
      console.warn('[ZHL] parser utama gagal:', e);
    }

    if (score(primary) < 5) {
      var alt = null;
      try {
        alt = (primary && primary._source === 'evergreen')
          ? parseONE(pages)
          : parseEvergreen(pages);
      } catch (e) {}

      if (score(alt) > score(primary)) return alt;
    }

    return primary;
  }

  window.ZhlArrivalNotice = {
    detect: detect,
    parse: parse,
    score: score,
    cleanCompany: cleanCompany
  };
})();
