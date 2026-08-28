(function () {
  'use strict';

  var scriptTag = document.currentScript;

  if (!scriptTag) {
    console.error('[AI Assistant] embed.js: document.currentScript tidak ditemukan');
    return;
  }

  var baseUrl =
    scriptTag.getAttribute('data-base-url') ||
    '/ai_assistant';

  baseUrl = baseUrl.trim();

  var currentPath = window.location.pathname;
  var targetUrl;

  try {
    targetUrl = new URL(baseUrl, window.location.origin);
  } catch (e) {
    console.error('[AI Assistant] URL tidak valid:', baseUrl);
    return;
  }

  var targetPath = targetUrl.pathname.replace(/\/+$/, '');

  if (
    currentPath === targetPath ||
    currentPath.indexOf(targetPath + '/') === 0
  ) {
    return;
  }

  var style = document.createElement('style');

  style.id = 'ai-assistant-fab-style';

  style.textContent = `
    .ai-fab {
      position: fixed !important;

      right: 24px !important;
      bottom: 24px !important;

      z-index: 2147483647 !important;

      width: 58px !important;
      height: 58px !important;

      padding: 0 !important;
      margin: 0 !important;

      border-radius: 50% !important;
      border: none !important;

      cursor: pointer !important;

      display: flex !important;
      align-items: center !important;
      justify-content: center !important;

      background: #1e40af !important;

      box-shadow:
        0 10px 15px -3px rgba(0,0,0,.15),
        0 4px 6px -4px rgba(0,0,0,.15) !important;

      transition:
        background-color .15s ease,
        transform .15s ease,
        box-shadow .15s ease !important;

      text-decoration: none !important;

      line-height: 1 !important;
    }

    .ai-fab:hover {
      background: #1e3a8a !important;

      transform: scale(1.08);

      box-shadow:
        0 15px 25px -5px rgba(0,0,0,.25),
        0 8px 10px -6px rgba(0,0,0,.2) !important;
    }

    .ai-fab:active {
      transform: scale(.95);
    }

    .ai-fab svg {
      width: 30px !important;
      height: 30px !important;

      display: block !important;

      pointer-events: none !important;
    }

    @media (max-width: 768px) {

      .ai-fab {
        right: 16px !important;
        bottom: 16px !important;

        width: 52px !important;
        height: 52px !important;
      }

      .ai-fab svg {
        width: 27px !important;
        height: 27px !important;
      }
    }
  `;

  document.head.appendChild(style);

  var btn = document.createElement('a');

  btn.id = 'aiAssistantFab';

  btn.className = 'ai-fab';

  btn.setAttribute(
    'title',
    'Open AI Assistant'
  );

  btn.setAttribute(
    'aria-label',
    'Open AI Assistant'
  );

  btn.setAttribute(
    'href',
    targetUrl.href
  );

  btn.setAttribute(
    'data-ai-navigation',
    'true'
  );

  btn.innerHTML = `
    <svg
      viewBox="0 0 24 24"
      fill="none"
      stroke="#fff"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
      xmlns="http://www.w3.org/2000/svg">

      <path d="M12 8V4H8"/>

      <rect
        width="16"
        height="12"
        x="4"
        y="8"
        rx="2"
      />

      <path d="M2 14h2"/>
      <path d="M20 14h2"/>
      <path d="M15 13v2"/>
      <path d="M9 13v2"/>

    </svg>
  `;

  btn.addEventListener(
    'click',
    function (event) {

      event.preventDefault();
      event.stopPropagation();
      event.stopImmediatePropagation();

      window.location.assign(targetUrl.href);

      return false;

    },
    true
  );

  function appendFab() {

    if (!document.body) {
      return;
    }

    if (document.getElementById('aiAssistantFab')) {
      return;
    }

    document.body.appendChild(btn);
  }


  if (document.readyState === 'loading') {

    document.addEventListener(
      'DOMContentLoaded',
      appendFab,
      {
        once: true
      }
    );

  } else {

    appendFab();

  }

})();
