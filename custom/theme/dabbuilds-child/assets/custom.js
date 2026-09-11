/**
 * Scroll state and Replit URL rewrite.
 * Nav is always visible (catalog bar); no hamburger.
 */
(function () {
  'use strict';

  var root = document.body;
  if (!root) return;

  function onScroll() {
    if (window.scrollY > 8) {
      root.classList.add('dab-scrolled');
    } else {
      root.classList.remove('dab-scrolled');
    }
  }

  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  document.querySelectorAll('a[href*="grokreplitopen2025.replit.app"]').forEach(function (link) {
    link.setAttribute('href', '/play/');
  });
})();
