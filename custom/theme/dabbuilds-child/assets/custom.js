/**
 * Light UI polish for dabbuilds.com
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

  // Soft-enter for post cards on home
  var cards = document.querySelectorAll('body.home .post, body.blog .post');
  if (cards.length && 'IntersectionObserver' in window) {
    cards.forEach(function (card, i) {
      card.style.opacity = '0';
      card.style.transform = 'translateY(12px)';
      card.style.transition =
        'opacity 0.5s cubic-bezier(0.22,1,0.36,1) ' +
        Math.min(i * 0.08, 0.32) +
        's, transform 0.5s cubic-bezier(0.22,1,0.36,1) ' +
        Math.min(i * 0.08, 0.32) +
        's, border-color 0.25s, box-shadow 0.25s';
    });

    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'none';
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 }
    );

    cards.forEach(function (card) {
      io.observe(card);
    });
  }
})();
