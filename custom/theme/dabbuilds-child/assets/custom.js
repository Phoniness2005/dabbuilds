/**
 * Scroll state, legacy game links, and résumé print.
 *
 * Rule 9 framework exceptions (named DOM listeners):
 * - onScroll, bound to window scroll
 * - onPrintClick, bound to [data-dab-print]
 */
(function () {
  'use strict';

  const SCROLL_THRESHOLD = 8;
  const MAX_LINKS = 200;
  const MAX_PRINT_BUTTONS = 8;

  /**
   * @returns {void}
   */
  const onScroll = function onScroll() {
    const root = document.body;
    if (!root) {
      return;
    }
    if (typeof window.scrollY !== 'number') {
      return;
    }
    if (window.scrollY > SCROLL_THRESHOLD) {
      root.classList.add('dab-scrolled');
    } else {
      root.classList.remove('dab-scrolled');
    }
  };

  /**
   * @returns {void}
   */
  const rewriteReplitLinks = function rewriteReplitLinks() {
    const links = document.querySelectorAll('a[href*="grokreplitopen2025.replit.app"]');
    const limit = Math.min(links.length, MAX_LINKS);
    for (let i = 0; i < limit; i += 1) {
      const link = links[i];
      if (!link) {
        continue;
      }
      link.setAttribute('href', '/play/');
    }
  };

  /**
   * @returns {void}
   */
  const onPrintClick = function onPrintClick() {
    if (typeof window.print !== 'function') {
      return;
    }
    window.print();
  };

  /**
   * @returns {void}
   */
  const bindPrint = function bindPrint() {
    const buttons = document.querySelectorAll('[data-dab-print]');
    const limit = Math.min(buttons.length, MAX_PRINT_BUTTONS);
    for (let i = 0; i < limit; i += 1) {
      const btn = buttons[i];
      if (!btn) {
        continue;
      }
      btn.addEventListener('click', onPrintClick);
    }
  };

  const root = document.body;
  if (!root) {
    bindPrint();
  } else if (typeof window.addEventListener !== 'function') {
    rewriteReplitLinks();
    bindPrint();
  } else {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    rewriteReplitLinks();
    bindPrint();
  }
})();
