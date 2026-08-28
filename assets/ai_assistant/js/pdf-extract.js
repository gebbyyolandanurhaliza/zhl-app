(function () {
  'use strict';

  var ASSETS = window.AI_ASSISTANT_ASSETS_URL;

  var MIN_TEXT_LAYER_LENGTH = 20;
  var OCR_CONCURRENCY = 3;
  var ROW_TOLERANCE = 2;      
  var COLUMN_GAP = 14;       

  var workerConfigured = false;
  var ocrPoolPromise = null;

  function ensureWorker() {
    if (typeof pdfjsLib === 'undefined') {
      throw new Error('pdf.js belum termuat.');
    }
    if (workerConfigured) return;
    pdfjsLib.GlobalWorkerOptions.workerSrc = ASSETS + '/vendor/pdfjs/pdf.worker.min.js';
    workerConfigured = true;
  }

  function createOcrPool() {
    if (typeof Tesseract === 'undefined') {
      return Promise.reject(new Error('Tesseract.js belum termuat.'));
    }

    var jobs = [];
    for (var i = 0; i < OCR_CONCURRENCY; i++) {
      jobs.push(Tesseract.createWorker(['eng', 'chi_sim'], 1, {
        workerPath: ASSETS + '/vendor/tesseract/worker.min.js',
        corePath: ASSETS + '/vendor/tesseract/tesseract-core-simd-lstm.wasm.js',
        langPath: ASSETS + '/vendor/tesseract/lang-data/',
        gzip: true
      }));
    }
    return Promise.all(jobs);
  }

  function getOcrPool() {
    if (!ocrPoolPromise) {
      ocrPoolPromise = createOcrPool().catch(function (e) {
        ocrPoolPromise = null;   // jangan cache kegagalan
        throw new Error('Tesseract gagal inisialisasi: ' + e.message);
      });
    }
    return ocrPoolPromise;
  }

  function terminateOcr() {
    if (!ocrPoolPromise) return Promise.resolve();
    var p = ocrPoolPromise;
    ocrPoolPromise = null;
    return p.then(function (workers) {
      return Promise.all(workers.map(function (w) { return w.terminate(); }));
    }).catch(function () {});
  }

  function runWithLimit(tasks, limit, onDone) {
    var results = new Array(tasks.length);
    var next = 0;
    var done = 0;

    function worker() {
      if (next >= tasks.length) return Promise.resolve();
      var idx = next++;
      return tasks[idx]().then(function (r) {
        results[idx] = r;
        done++;
        if (onDone) onDone(done, tasks.length);
        return worker();
      });
    }

    var runners = [];
    var n = Math.min(limit, tasks.length);
    for (var i = 0; i < n; i++) runners.push(worker());

    return Promise.all(runners).then(function () { return results; });
  }

  function renderPage(page, scale) {
    var viewport = page.getViewport({ scale: scale || 1.5 });
    var canvas = document.createElement('canvas');
    canvas.width = viewport.width;
    canvas.height = viewport.height;
    var ctx = canvas.getContext('2d');

    return page.render({ canvasContext: ctx, viewport: viewport }).promise
      .then(function () { return canvas.toDataURL('image/png'); });
  }

  function pageToRows(content) {
    var items = [];

    content.items.forEach(function (raw) {
      var str = raw.str || '';
      if (!str.trim()) return;

      var runX = raw.transform[4];
      var runY = raw.transform[5];
      var runWidth = raw.width || 0;
      var total = str.length;

      var re = /\S+/g;
      var m;
      while ((m = re.exec(str)) !== null) {
        var approxX = total > 0
          ? runX + (m.index / total) * runWidth
          : runX;

        var approxW = total > 0
          ? (m[0].length / total) * runWidth
          : 0;
        items.push({ text: m[0], x: approxX, y: runY, w: approxW });
      }
    });

    items.sort(function (a, b) { return b.y - a.y; });

    var rows = [];
    items.forEach(function (it) {
      var row = null;
      for (var i = 0; i < rows.length; i++) {
        if (Math.abs(rows[i].y - it.y) <= ROW_TOLERANCE) { row = rows[i]; break; }
      }
      if (!row) {
        row = { y: it.y, items: [] };
        rows.push(row);
      }
      row.items.push(it);
    });

    rows.forEach(function (r) {
      r.items.sort(function (a, b) { return a.x - b.x; });
    });

    return rows;
  }

  function extractAll(arrayBuffer, onProgress) {
    ensureWorker();

    return pdfjsLib.getDocument({
      data: new Uint8Array(arrayBuffer),
      cMapUrl: ASSETS + '/vendor/pdfjs/cmaps/',
      cMapPacked: true
    }).promise.then(function (pdf) {

      var chain = Promise.resolve();
      var textParts = [];
      var pages = [];

      for (var i = 1; i <= pdf.numPages; i++) {
        (function (n) {
          chain = chain.then(function () {
            return pdf.getPage(n).then(function (page) {
              return page.getTextContent().then(function (content) {
                textParts.push(
                  content.items.map(function (it) { return it.str; }).join(' ')
                );
                pages.push({ rows: pageToRows(content) });
              });
            });
          });
        })(i);
      }

      return chain.then(function () {
        var full = textParts.join('\n');

        if (full.trim().length >= MIN_TEXT_LAYER_LENGTH) {
          return { text: full, pages: pages, ocr: false };
        }

        if (onProgress) {
          onProgress({
            stage: 'detecting',
            message: 'PDF hasil scan (' + pdf.numPages + ' halaman). Menjalankan OCR...'
          });
        }

        return getOcrPool().then(function (pool) {
          var renderChain = Promise.resolve();
          var urls = [];

          for (var j = 1; j <= pdf.numPages; j++) {
            (function (n) {
              renderChain = renderChain.then(function () {
                return pdf.getPage(n).then(renderPage).then(function (u) {
                  urls.push(u);
                });
              });
            })(j);
          }

          return renderChain.then(function () {
            var tasks = urls.map(function (url, idx) {
              return function () {
                return pool[idx % pool.length].recognize(url)
                  .then(function (r) { return r.data.text || ''; })
                  .catch(function () { return ''; });
              };
            });

            return runWithLimit(tasks, OCR_CONCURRENCY, function (done, total) {
              if (onProgress) {
                onProgress({
                  stage: 'ocr',
                  current: done,
                  total: total,
                  message: 'OCR halaman ' + done + ' dari ' + total + '...'
                });
              }
            });
          }).then(function (texts) {
            var ocrText = texts.join('\n');
            if (!ocrText.trim()) {
              throw new Error('Dokumen kosong atau tidak terbaca, bahkan setelah OCR.');
            }
            return { text: ocrText, pages: null, ocr: true };
          });
        });
      });
    });
  }

  function gapBetween(prev, cur) {
    return cur.x - (prev.x + (prev.w || 0));
  }

  function splitColumns(row, threshold) {
    threshold = threshold || 12;

    var groups = [];
    var cur = [];

    row.items.forEach(function (it, i) {
      if (i > 0 && gapBetween(row.items[i - 1], it) > threshold) {
        if (cur.length) groups.push(cur);
        cur = [];
      }
      cur.push(it);
    });

    if (cur.length) groups.push(cur);
    return groups;
  }

  function groupText(g) {
    return g.map(function (i) { return i.text; }).join(' ').trim();
  }

  function groupStart(g) {
    return g[0].x;
  }

  function rowText(row) {
    return row.items.map(function (i) { return i.text; }).join(' ').trim();
  }

  function pagesToLines(pages) {
    var lines = [];
    pages.forEach(function (p) {
      p.rows.forEach(function (r) {
        var t = rowText(r);
        if (t) lines.push(t);
      });
    });
    return lines;
  }

  function valueRightOf(row, labelWords, gap) {
    gap = gap || COLUMN_GAP;

    var items = row.items;
    var n = labelWords.length;

    for (var i = 0; i + n <= items.length; i++) {
      var hit = true;
      for (var k = 0; k < n; k++) {
        if (items[i + k].text.toUpperCase().replace(/[:.]/g, '') !==
            labelWords[k].toUpperCase()) {
          hit = false;
          break;
        }
      }
      if (!hit) continue;

      var out = [];
      var prev = items[i + n - 1];

      for (var j = i + n; j < items.length; j++) {
        var cur = items[j];
        if (gapBetween(prev, cur) > gap && out.length > 0) break;   // pindah kolom
        if (cur.text === ':') { prev = cur; continue; }
        out.push(cur.text);
        prev = cur;
      }

      return out.join(' ').replace(/^:\s*/, '').trim();
    }

    return '';
  }

  function findRow(pages, re) {
    for (var p = 0; p < pages.length; p++) {
      for (var r = 0; r < pages[p].rows.length; r++) {
        if (re.test(rowText(pages[p].rows[r]))) {
          return { page: p, index: r, row: pages[p].rows[r] };
        }
      }
    }
    return null;
  }

  function blockBelow(pages, re, maxLines) {
    maxLines = maxLines || 1;

    var found = findRow(pages, re);
    if (!found) return [];

    var rows = pages[found.page].rows;

    var labelGroups = splitColumns(found.row);
    var labelGroup = null;

    for (var g = 0; g < labelGroups.length; g++) {
      if (re.test(groupText(labelGroups[g]))) {
        labelGroup = labelGroups[g];
        break;
      }
    }
    if (!labelGroup) labelGroup = labelGroups[0];

    var labelStart = groupStart(labelGroup);
    var labelEnd = labelGroup[labelGroup.length - 1].x +
                   (labelGroup[labelGroup.length - 1].w || 0);
    var labelMid = (labelStart + labelEnd) / 2;

    var out = [];

    for (var r = found.index + 1; r < rows.length && out.length < maxLines; r++) {
      var groups = splitColumns(rows[r]);
      if (!groups.length) continue;

      var best = null;
      var bestDist = Infinity;

      groups.forEach(function (grp) {
        var s = groupStart(grp);
        var last = grp[grp.length - 1];
        var mid = (s + last.x + (last.w || 0)) / 2;
        var d = Math.abs(mid - labelMid);
        if (d < bestDist) { bestDist = d; best = grp; }
      });

      if (!best || bestDist > 220) continue;

      var line = groupText(best);
      if (line) out.push(line);
    }

    return out;
  }

  window.ZhlPdf = {
    extractAll: extractAll,
    pagesToLines: pagesToLines,
    rowText: rowText,
    findRow: findRow,
    valueRightOf: valueRightOf,
    splitColumns: splitColumns,
    groupText: groupText,
    gapBetween: gapBetween,
    blockBelow: blockBelow,
    terminateOcr: terminateOcr,
    COLUMN_GAP: COLUMN_GAP
  };
})();
