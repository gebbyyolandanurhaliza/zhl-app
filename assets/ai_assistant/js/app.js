(function () {
  'use strict';

  var ASSETS = window.AI_ASSISTANT_ASSETS_URL;
  var BASE = window.AI_ASSISTANT_BASE_URL;

  var MAX_TOTAL_DOC_CHARS = 6000;
  var MIN_DOC_TEXT = 20;
  var MAX_FILE_BYTES = 20 * 1024 * 1024;

  var chatLog = document.getElementById('chatLog');
  var chatMsg = document.getElementById('chatMsg');
  var sendBtn = document.getElementById('sendBtn');
  var resetBtn = document.getElementById('resetBtn');
  var assistantStatus = document.getElementById('assistantStatus');

  var uploadBtn = document.getElementById('uploadBtn');
  var uploadMenu = document.getElementById('uploadMenu');
  var documentInput = document.getElementById('documentInput');
  var imageInput = document.getElementById('imageInput');
  var zipInput = document.getElementById('zipInput');
  var autofillInput = document.getElementById('autofillInput');
  var attachmentPreview = document.getElementById('attachmentPreview');
  var docList = document.getElementById('docList');

  var documents = [];      
  var chatHistory = [];
  var selectedFiles = [];

  var WELCOME =
    'Halo! Upload dokumen (PDF/gambar/ZIP) kalau perlu, atau langsung tanya ' +
    'apa saja. Aku bakal bantu jawab berdasarkan dokumen yang kamu upload.';

  function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function botIconSvg() {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' +
      '<path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/>' +
      '<path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>';
  }

  function fileIconSvg(type) {
    if (type === 'image') {
      return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>';
    }
    if (type === 'zip') {
      return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/><path d="M10 12h4"/><path d="M10 16h4"/></svg>';
    }
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8"/><path d="M8 17h6"/></svg>';
  }

  function renderAssistantRow(text, provider, isError) {
    var label = provider ? '<span class="provider">via Groq</span>' : '';
    return '<div class="msg-row">' +
      '<div class="message-bot-icon">' + botIconSvg() + '</div>' +
      '<div class="msg assistant' + (isError ? ' error' : '') + '">' +
      escapeHtml(text) + label + '</div></div>';
  }

  function renderUserRow(text) {
    return '<div class="msg-row user"><div class="msg user">' +
      escapeHtml(text) + '</div></div>';
  }

  function appendRowHtml(html) {
    chatLog.insertAdjacentHTML('beforeend', html);
    chatLog.scrollTop = chatLog.scrollHeight;
  }

  function say(text, isError) {
    appendRowHtml(renderAssistantRow(text, null, isError));
  }

  function formatSize(bytes) {
    return bytes < 1024 * 1024
      ? (bytes / 1024).toFixed(1) + ' KB'
      : (bytes / (1024 * 1024)).toFixed(1) + ' MB';
  }

  function cleanReply(text) {
    var s = String(text || '').replace(/<think>[\s\S]*?<\/think>/gi, '').trim();
    if (s.indexOf('<think>') === 0) return '';
    return s;
  }

  function renderDocs() {
    if (assistantStatus) {
      assistantStatus.textContent = documents.length
        ? documents.length + ' dokumen dimuat'
        : 'Belum ada dokumen dimuat';
    }

    if (!docList) return;

    docList.innerHTML = '';
    if (!documents.length) {
      docList.classList.remove('has-files');
      return;
    }
    docList.classList.add('has-files');

    documents.forEach(function (doc) {
      var chip = document.createElement('div');
      chip.className = 'doc-chip';

      chip.innerHTML =
        '<span class="doc-chip-icon">' + fileIconSvg('document') + '</span>' +
        '<span class="doc-chip-body">' +
        '<span class="doc-chip-name">' + escapeHtml(doc.name) + '</span>' +
        '<span class="doc-chip-meta">' + escapeHtml(doc.size) +
        (doc.parsed ? ' · terbaca otomatis' : '') + '</span></span>' +
        '<button type="button" class="doc-chip-remove" title="Hapus">' +
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12"/><path d="M18 6L6 18"/></svg></button>';

      chip.querySelector('.doc-chip-remove').addEventListener('click', function () {
        documents = documents.filter(function (d) { return d.id !== doc.id; });
        renderDocs();
      });

      docList.appendChild(chip);
    });
  }

  function addDocument(name, bytes, text, pdfPages, parsed) {
    var doc = {
      id: String(Date.now()) + Math.random().toString(16).slice(2),
      name: name,
      size: formatSize(bytes || 0),
      uploadedAt: new Date().toLocaleDateString('id-ID', {
        day: 'numeric', month: 'short', year: 'numeric'
      }),
      text: text,
      pdfPages: pdfPages || null,
      parsed: parsed || null
    };
    documents.push(doc);
    renderDocs();
    return doc;
  }

  function buildDocContext() {
    if (!documents.length) return '';

    var perDoc = Math.floor(MAX_TOTAL_DOC_CHARS / documents.length);

    return documents.map(function (d) {
      var t = d.text;
      if (t.length > perDoc) {
        t = t.slice(0, perDoc) + '\n... (dipotong karena terlalu besar)';
      }
      return '=== Dokumen: ' + d.name + ' ===\n' + t;
    }).join('\n\n');
  }

  function readArrayBuffer(file) {
    return file.arrayBuffer
      ? file.arrayBuffer()
      : new Promise(function (res, rej) {
          var r = new FileReader();
          r.onload = function () { res(r.result); };
          r.onerror = rej;
          r.readAsArrayBuffer(file);
        });
  }

  function fileToBase64(file) {
    return new Promise(function (res, rej) {
      var r = new FileReader();
      r.onload = function () { res(r.result.split(',')[1]); };
      r.onerror = rej;
      r.readAsDataURL(file);
    });
  }

  function fileToText(file) {
    return new Promise(function (res, rej) {
      var r = new FileReader();
      r.onload = function () { res(r.result); };
      r.onerror = rej;
      r.readAsText(file);
    });
  }

  function visionExtract(b64, filename) {
    var fd = new FormData();
    fd.append('image_base64', b64);
    fd.append('filename', filename);

    return fetch(BASE + '/vision', { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (d.error) throw new Error(d.error + (d.detail ? ' (' + d.detail + ')' : ''));
        return d.text;
      });
  }

  function processPdf(buf, name) {
    return window.ZhlPdf.extractAll(buf, function (info) {
      if (assistantStatus) assistantStatus.textContent = info.message;
    }).then(function (res) {
      var parsed = null;

      if (res.pages && window.ZhlArrivalNotice &&
          window.ZhlArrivalNotice.detect(res.text)) {
        try {
          parsed = window.ZhlArrivalNotice.parse(res.pages);
        } catch (e) {
          console.warn('Parser Arrival Notice gagal:', e);
        }
      }

      return { name: name, text: res.text, pages: res.pages, parsed: parsed };
    });
  }

  function processAttachment(item) {
    var file = item.file;
    var ext = file.name.split('.').pop().toLowerCase();

    if (file.size > MAX_FILE_BYTES) {
      return Promise.reject(new Error('Ukuran file maksimal 20MB.'));
    }

    if (item.type === 'zip' || ext === 'zip') {
      if (typeof JSZip === 'undefined') {
        return Promise.reject(new Error('JSZip belum termuat.'));
      }

      return readArrayBuffer(file)
        .then(function (b) { return JSZip.loadAsync(b); })
        .then(function (zip) {
          var entries = [];
          zip.forEach(function (path, entry) {
            if (!entry.dir && path.toLowerCase().endsWith('.pdf')) entries.push(entry);
          });

          if (!entries.length) {
            throw new Error('Tidak ada PDF di dalam ZIP ini.');
          }

          return entries.reduce(function (chain, entry) {
            return chain.then(function (acc) {
              return entry.async('arraybuffer').then(function (b) {
                return processPdf(b, entry.name).then(function (res) {
                  acc.push(res);
                  return acc;
                });
              });
            });
          }, Promise.resolve([]));
        })
        .then(function (list) {
          return { multi: list, label: file.name };
        });
    }

    if (item.type === 'image' ||
        ['jpg', 'jpeg', 'png', 'webp'].indexOf(ext) !== -1) {
      return fileToBase64(file).then(function (b64) {
        return visionExtract(b64, file.name).then(function (text) {
          return { name: file.name, text: text, bytes: file.size };
        });
      });
    }

    if (ext === 'pdf') {
      return readArrayBuffer(file).then(function (b) {
        return processPdf(b, file.name).then(function (r) {
          r.bytes = file.size;
          return r;
        });
      });
    }

    if (['txt', 'csv'].indexOf(ext) !== -1) {
      return fileToText(file).then(function (text) {
        return { name: file.name, text: text, bytes: file.size };
      });
    }

    return Promise.reject(new Error('Format .' + ext + ' belum didukung.'));
  }

  function registerResult(res, bytes) {
    var text = (res.text || '').trim();

    if (text.length < MIN_DOC_TEXT) {
      say('File "' + res.name + '" terbuka tapi teksnya tidak terbaca. ' +
          'Kalau ini scan, coba upload halamannya sebagai gambar (JPG/PNG).', true);
      return false;
    }

    addDocument(res.name, bytes || res.bytes, text, res.pages, res.parsed);

    if (res.parsed && window.ZhlArrivalNotice.score(res.parsed) >= 4) {
      var p = res.parsed;
      var bits = [];
      if (p.import_bl_no) bits.push('B/L ' + p.import_bl_no);
      if (p.loading_port) bits.push('dari ' + p.loading_port);
      if (p.containers.length) bits.push(p.containers.length + ' kontainer');

      say('Terdeteksi Arrival Notice (' + res.name + '): ' + bits.join(', ') +
          '. Field-nya sudah terbaca, tinggal klik "Isi form Container Stock".');
    }

    return true;
  }

  function handleFiles(list, type) {
    if (!list || !list.length) return;

    if (type === 'autofill') {
      uploadAndAutofill(list[0]);
      return;
    }

    Array.prototype.slice.call(list).forEach(function (f) {
      selectedFiles.push({ file: f, type: type });
    });
    renderAttachments();
    updateSendButton();
  }

  function uploadAndAutofill(file) {
    appendRowHtml(renderUserRow('Isi form dari "' + file.name + '"'));

    if (assistantStatus) {
      assistantStatus.textContent = 'Membaca ' + file.name + '...';
    }

    processAttachment({ file: file, type: 'document' })
      .then(function (res) {
        var ok = res.multi
          ? res.multi.map(function (r) { return registerResult(r, 0); })
              .some(Boolean)
          : registerResult(res, file.size);

        renderDocs();
        if (!ok) return;

        if (window.ZhlAutofill && window.ZhlAutofill.run) {
          window.ZhlAutofill.run();
        } else {
          say('Dokumen terbaca, tapi modul autofill belum termuat.', true);
        }
      })
      .catch(function (e) {
        say('Gagal memproses "' + file.name + '": ' + e.message, true);
        renderDocs();
      });
  }

  function renderAttachments() {
    if (!attachmentPreview) return;

    attachmentPreview.innerHTML = '';
    if (!selectedFiles.length) {
      attachmentPreview.classList.remove('has-files');
      return;
    }
    attachmentPreview.classList.add('has-files');

    selectedFiles.forEach(function (item, index) {
      var w = document.createElement('div');
      w.className = 'attachment-item';

      var icon = document.createElement('span');
      icon.className = 'attachment-item-icon';
      icon.innerHTML = fileIconSvg(item.type);

      var name = document.createElement('span');
      name.className = 'attachment-item-name';
      name.textContent = item.file.name;

      var rm = document.createElement('button');
      rm.type = 'button';
      rm.className = 'attachment-remove';
      rm.title = 'Hapus';
      rm.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12"/><path d="M18 6L6 18"/></svg>';
      rm.addEventListener('click', function () {
        selectedFiles.splice(index, 1);
        renderAttachments();
        updateSendButton();
      });

      w.appendChild(icon);
      w.appendChild(name);
      w.appendChild(rm);
      attachmentPreview.appendChild(w);
    });
  }

  function updateSendButton() {
    if (!sendBtn) return;
    sendBtn.disabled = chatMsg.value.trim() === '' && selectedFiles.length === 0;
  }

  function sendMessage() {
    var text = chatMsg.value.trim();
    var queue = selectedFiles.slice();
    if (!text && !queue.length) return;

    appendRowHtml(renderUserRow(text || (queue.length + ' file dilampirkan')));
    chatHistory.push({
      role: 'user',
      content: text || (queue.length + ' file dilampirkan')
    });

    chatMsg.value = '';
    chatMsg.style.height = 'auto';
    selectedFiles = [];
    renderAttachments();
    sendBtn.disabled = true;

    var chain = Promise.resolve();

    if (queue.length) {
      if (assistantStatus) {
        assistantStatus.textContent = 'Memproses ' + queue.length + ' lampiran...';
      }

      chain = queue.reduce(function (c, item) {
        return c.then(function () {
          return processAttachment(item)
            .then(function (res) {
              if (res.multi) {
                res.multi.forEach(function (r) { registerResult(r, 0); });
              } else {
                registerResult(res, item.file.size);
              }
            })
            .catch(function (e) {
              say('Gagal memproses "' + item.file.name + '": ' + e.message, true);
            });
        });
      }, Promise.resolve());
    }

    chain
      .then(function () {
        renderDocs();

        if (!text) {
          var ack = documents.length
            ? 'Dokumen sudah aku baca. Ada yang mau ditanyakan soal isinya?'
            : 'Belum ada teks yang berhasil dibaca dari lampiran itu.';
          say(ack);
          chatHistory.push({ role: 'assistant', content: ack });
          return null;
        }

        var fd = new FormData();
        fd.append('message', text);
        fd.append('history', JSON.stringify(chatHistory.slice(-3, -1)));
        fd.append('context', buildDocContext());

        return fetch(BASE + '/chat', { method: 'POST', body: fd })
          .then(function (r) { return r.json(); });
      })
      .then(function (data) {
        if (!data) return;

        if (data.error) {
          say('Error: ' + data.error + (data.detail ? '\n' + data.detail : ''), true);
          return;
        }

        var reply = cleanReply(data.reply);
        if (!reply) {
          say('Model berhenti di tengah reasoning dan tidak mengeluarkan jawaban. Coba ulangi.', true);
          return;
        }

        appendRowHtml(renderAssistantRow(reply, data.provider));
        chatHistory.push({ role: 'assistant', content: reply });
      })
      .catch(function (e) {
        say('Gagal menghubungi server: ' + e.message, true);
      })
      .finally(function () {
        updateSendButton();
      });
  }

  if (uploadBtn && uploadMenu) {
    uploadBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      uploadMenu.classList.toggle('open');
      uploadBtn.classList.toggle('active', uploadMenu.classList.contains('open'));
    });
  }

  document.addEventListener('click', function (e) {
    if (uploadMenu && uploadBtn &&
        !uploadMenu.contains(e.target) && !uploadBtn.contains(e.target)) {
      uploadMenu.classList.remove('open');
      uploadBtn.classList.remove('active');
    }
  });

  document.querySelectorAll('.upload-menu-item').forEach(function (item) {
    item.addEventListener('click', function () {
      var type = item.getAttribute('data-type');
      uploadMenu.classList.remove('open');
      uploadBtn.classList.remove('active');
      if (type === 'document' && documentInput) documentInput.click();
      if (type === 'image' && imageInput) imageInput.click();
      if (type === 'zip' && zipInput) zipInput.click();
      if (type === 'autofill' && autofillInput) autofillInput.click();
    });
  });

  if (documentInput) documentInput.addEventListener('change', function () {
    handleFiles(documentInput.files, 'document'); documentInput.value = '';
  });
  if (imageInput) imageInput.addEventListener('change', function () {
    handleFiles(imageInput.files, 'image'); imageInput.value = '';
  });
  if (zipInput) zipInput.addEventListener('change', function () {
    handleFiles(zipInput.files, 'zip'); zipInput.value = '';
  });
  if (autofillInput) autofillInput.addEventListener('change', function () {
    handleFiles(autofillInput.files, 'autofill'); autofillInput.value = '';
  });

  if (chatMsg) {
    chatMsg.addEventListener('input', function () {
      updateSendButton();
      chatMsg.style.height = 'auto';
      chatMsg.style.height = Math.min(chatMsg.scrollHeight, 110) + 'px';
    });
    chatMsg.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        if (!sendBtn.disabled) sendBtn.click();
      }
    });
  }

  if (sendBtn) sendBtn.addEventListener('click', sendMessage);

  if (resetBtn && chatLog) {
    resetBtn.addEventListener('click', function () {
      chatLog.innerHTML = renderAssistantRow(WELCOME);
      chatHistory = [];
      documents = [];
      selectedFiles = [];
      renderDocs();
      renderAttachments();
      if (chatMsg) chatMsg.value = '';
      updateSendButton();
      if (uploadMenu) uploadMenu.classList.remove('open');
      if (uploadBtn) uploadBtn.classList.remove('active');
      if (window.ZhlPdf) window.ZhlPdf.terminateOcr();
    });
  }

  renderDocs();
  updateSendButton();

  window.AiAssistant = {
    getDocuments: function () { return documents.slice(); },
    getDocCount: function () { return documents.length; },
    getExtractedText: function () { return buildDocContext(); },

    getParsedFields: function () {
      for (var i = documents.length - 1; i >= 0; i--) {
        if (documents[i].parsed) return documents[i].parsed;
      }
      return null;
    },

    autofill: function (fields, root) {
      root = root || document;
      var filled = 0;
      Object.keys(fields).forEach(function (key) {
        if (fields[key] === null || fields[key] === undefined) return;
        var el = root.querySelector('[name="' + key + '"], [data-ai-field="' + key + '"]');
        if (!el) return;
        el.value = fields[key];
        el.dispatchEvent(new Event('change', { bubbles: true }));
        el.dispatchEvent(new Event('input', { bubbles: true }));
        filled++;
      });
      return filled;
    }
  };
})();
