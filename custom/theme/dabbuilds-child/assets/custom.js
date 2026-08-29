/**
 * UI polish: scroll state, post cards, mobile nav.
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

  // Mobile nav
  var toggle = document.querySelector('.dab-nav-toggle');
  var nav = document.getElementById('dab-primary-nav');
  if (toggle && nav) {
    function setOpen(open) {
      root.classList.toggle('dab-nav-open', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      toggle.setAttribute(
        'aria-label',
        open ? 'Close menu' : 'Open menu'
      );
    }

    toggle.addEventListener('click', function () {
      setOpen(!root.classList.contains('dab-nav-open'));
    });

    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        setOpen(false);
      });
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') setOpen(false);
    });

    // Close on resize to desktop
    window.addEventListener(
      'resize',
      function () {
        if (window.innerWidth > 768) setOpen(false);
      },
      { passive: true }
    );
  }

  // Replit free hosting expired; keep Play Now on-site.
  document.querySelectorAll('a[href*="grokreplitopen2025.replit.app"]').forEach(function (link) {
    link.setAttribute('href', '/play/');
  });
})();
