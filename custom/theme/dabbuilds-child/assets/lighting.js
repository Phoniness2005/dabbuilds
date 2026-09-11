/**
 * Hourly object lighting for DAB Builds.
 *
 * Follows the viewer's local clock in 24 discrete hour steps.
 * Does not read location, does not send time or mode anywhere.
 *
 * Mode (localStorage dab-light-mode): auto | day | night
 * Debug: ?dab-hour=0..23 forces a palette for this page load (Auto only).
 */
(function () {
  'use strict';

  var KEY = 'dab-light-mode';
  var LOCK_DAY = 12;
  var LOCK_NIGHT = 22;

  /**
   * 24 palettes. Names and hex values are the source of truth for docs too.
   * period: "day" | "night" — coarse fallback and color-scheme.
   */
  var PALETTES = [
    { h: 0,  name: 'midnight',      period: 'night', luma: 0.12, ground: '#141210', panel: '#1C1916', ink: '#EDE6D8', muted: '#C4B6A6', dim: '#9A8E80', accent: '#C4924A', accentDim: 'rgba(196,146,74,0.18)', line: 'rgba(237,230,216,0.12)', lineStrong: 'rgba(237,230,216,0.22)', glow: 'rgba(196,146,74,0.16)', elev: '0 18px 48px rgba(0,0,0,0.42)', btnFg: '#1A1610' },
    { h: 1,  name: 'late night',    period: 'night', luma: 0.12, ground: '#151311', panel: '#1D1A17', ink: '#EDE6D8', muted: '#C4B6A6', dim: '#9A8E80', accent: '#C4924A', accentDim: 'rgba(196,146,74,0.17)', line: 'rgba(237,230,216,0.12)', lineStrong: 'rgba(237,230,216,0.22)', glow: 'rgba(196,146,74,0.15)', elev: '0 18px 48px rgba(0,0,0,0.42)', btnFg: '#1A1610' },
    { h: 2,  name: 'late night',    period: 'night', luma: 0.13, ground: '#161412', panel: '#1E1B18', ink: '#EDE6D8', muted: '#C3B5A5', dim: '#9A8E80', accent: '#C5944C', accentDim: 'rgba(197,148,76,0.16)', line: 'rgba(237,230,216,0.12)', lineStrong: 'rgba(237,230,216,0.22)', glow: 'rgba(197,148,76,0.14)', elev: '0 18px 48px rgba(0,0,0,0.40)', btnFg: '#1A1610' },
    { h: 3,  name: 'late night',    period: 'night', luma: 0.14, ground: '#171513', panel: '#1F1C19', ink: '#EEE7D9', muted: '#C3B5A5', dim: '#9B8F81', accent: '#C6964E', accentDim: 'rgba(198,150,78,0.15)', line: 'rgba(238,231,217,0.12)', lineStrong: 'rgba(238,231,217,0.22)', glow: 'rgba(198,150,78,0.12)', elev: '0 18px 48px rgba(0,0,0,0.40)', btnFg: '#1A1610' },
    { h: 4,  name: 'late night',    period: 'night', luma: 0.16, ground: '#191614', panel: '#221F1B', ink: '#EEE7D9', muted: '#C2B4A4', dim: '#9C9082', accent: '#C89852', accentDim: 'rgba(200,152,82,0.14)', line: 'rgba(238,231,217,0.13)', lineStrong: 'rgba(238,231,217,0.23)', glow: 'rgba(200,152,82,0.11)', elev: '0 18px 48px rgba(0,0,0,0.38)', btnFg: '#1A1610' },
    { h: 5,  name: 'pre-dawn',      period: 'night', luma: 0.20, ground: '#1C1A18', panel: '#26221E', ink: '#E8E4DC', muted: '#B8B0A6', dim: '#948C84', accent: '#B8A078', accentDim: 'rgba(184,160,120,0.16)', line: 'rgba(232,228,220,0.13)', lineStrong: 'rgba(232,228,220,0.24)', glow: 'rgba(180,190,200,0.08)', elev: '0 18px 48px rgba(0,0,0,0.36)', btnFg: '#1A1610' },
    { h: 6,  name: 'dawn',          period: 'day',   luma: 0.58, ground: '#C9C0B2', panel: '#D4CBBD', ink: '#1E1A16', muted: '#4A433C', dim: '#6A635C', accent: '#8B5E32', accentDim: 'rgba(139,94,50,0.16)', line: 'rgba(30,26,22,0.14)', lineStrong: 'rgba(30,26,22,0.24)', glow: 'rgba(255,236,210,0.35)', elev: '0 16px 40px rgba(30,26,22,0.12)', btnFg: '#F8F4EE' },
    { h: 7,  name: 'early morning', period: 'day',   luma: 0.74, ground: '#DDD4C6', panel: '#E6DDCF', ink: '#1C1915', muted: '#4A433C', dim: '#6C655E', accent: '#8A5C30', accentDim: 'rgba(138,92,48,0.14)', line: 'rgba(28,25,21,0.13)', lineStrong: 'rgba(28,25,21,0.22)', glow: 'rgba(255,244,220,0.28)', elev: '0 16px 40px rgba(28,25,21,0.10)', btnFg: '#F8F4EE' },
    { h: 8,  name: 'morning',       period: 'day',   luma: 0.86, ground: '#F0E8DC', panel: '#E7DFD2', ink: '#1A1714', muted: '#4E4840', dim: '#6E6860', accent: '#8A5A2B', accentDim: 'rgba(138,90,43,0.14)', line: 'rgba(26,23,20,0.12)', lineStrong: 'rgba(26,23,20,0.20)', glow: 'transparent', elev: '0 16px 40px rgba(26,23,20,0.08)', btnFg: '#F8F4EE' },
    { h: 9,  name: 'morning',       period: 'day',   luma: 0.90, ground: '#F3EDE1', panel: '#EBE4D6', ink: '#1A1714', muted: '#4E4840', dim: '#6E6860', accent: '#865828', accentDim: 'rgba(134,88,40,0.13)', line: 'rgba(26,23,20,0.12)', lineStrong: 'rgba(26,23,20,0.20)', glow: 'transparent', elev: '0 16px 40px rgba(26,23,20,0.08)', btnFg: '#F8F4EE' },
    { h: 10, name: 'late morning',  period: 'day',   luma: 0.93, ground: '#F5F0E6', panel: '#EDE6D8', ink: '#1A1714', muted: '#4C463E', dim: '#6C665E', accent: '#825626', accentDim: 'rgba(130,86,38,0.12)', line: 'rgba(26,23,20,0.11)', lineStrong: 'rgba(26,23,20,0.20)', glow: 'transparent', elev: '0 16px 40px rgba(26,23,20,0.07)', btnFg: '#F8F4EE' },
    { h: 11, name: 'midday',        period: 'day',   luma: 0.96, ground: '#F7F3EC', panel: '#EFE9DE', ink: '#191614', muted: '#4C463E', dim: '#6C665E', accent: '#7A5428', accentDim: 'rgba(122,84,40,0.12)', line: 'rgba(25,22,20,0.11)', lineStrong: 'rgba(25,22,20,0.20)', glow: 'transparent', elev: '0 16px 40px rgba(25,22,20,0.07)', btnFg: '#F8F4EE' },
    { h: 12, name: 'midday',        period: 'day',   luma: 0.98, ground: '#F8F4EE', panel: '#F0EAE0', ink: '#191614', muted: '#4A443C', dim: '#6A645C', accent: '#7A5428', accentDim: 'rgba(122,84,40,0.12)', line: 'rgba(25,22,20,0.11)', lineStrong: 'rgba(25,22,20,0.20)', glow: 'transparent', elev: '0 16px 40px rgba(25,22,20,0.06)', btnFg: '#F8F4EE' },
    { h: 13, name: 'afternoon',     period: 'day',   luma: 0.96, ground: '#F6F1E8', panel: '#EEE8DC', ink: '#1A1714', muted: '#4C463E', dim: '#6C665E', accent: '#7E5628', accentDim: 'rgba(126,86,40,0.12)', line: 'rgba(26,23,20,0.11)', lineStrong: 'rgba(26,23,20,0.20)', glow: 'transparent', elev: '0 16px 40px rgba(26,23,20,0.07)', btnFg: '#F8F4EE' },
    { h: 14, name: 'afternoon',     period: 'day',   luma: 0.92, ground: '#F4EADB', panel: '#EBE1D0', ink: '#1A1714', muted: '#4E4840', dim: '#6E6860', accent: '#8A5A2B', accentDim: 'rgba(138,90,43,0.13)', line: 'rgba(26,23,20,0.12)', lineStrong: 'rgba(26,23,20,0.20)', glow: 'transparent', elev: '0 16px 40px rgba(26,23,20,0.08)', btnFg: '#F8F4EE' },
    { h: 15, name: 'afternoon',     period: 'day',   luma: 0.88, ground: '#F2E6D4', panel: '#E9DDC8', ink: '#1A1714', muted: '#4E4840', dim: '#6E6860', accent: '#8E5E2E', accentDim: 'rgba(142,94,46,0.14)', line: 'rgba(26,23,20,0.12)', lineStrong: 'rgba(26,23,20,0.20)', glow: 'rgba(255,214,160,0.12)', elev: '0 16px 40px rgba(26,23,20,0.08)', btnFg: '#F8F4EE' },
    { h: 16, name: 'late afternoon',period: 'day',   luma: 0.84, ground: '#EFE0C8', panel: '#E6D6BA', ink: '#1A1714', muted: '#4C4338', dim: '#6C6358', accent: '#925F30', accentDim: 'rgba(146,95,48,0.15)', line: 'rgba(26,23,20,0.13)', lineStrong: 'rgba(26,23,20,0.22)', glow: 'rgba(255,200,120,0.16)', elev: '0 16px 40px rgba(26,23,20,0.10)', btnFg: '#F8F4EE' },
    { h: 17, name: 'golden hour',   period: 'day',   luma: 0.78, ground: '#E8D4A8', panel: '#DFC898', ink: '#1A1714', muted: '#4A4030', dim: '#6A6050', accent: '#9A6028', accentDim: 'rgba(154,96,40,0.16)', line: 'rgba(26,23,20,0.14)', lineStrong: 'rgba(26,23,20,0.24)', glow: 'rgba(255,186,90,0.22)', elev: '0 16px 40px rgba(26,23,20,0.12)', btnFg: '#F8F4EE' },
    { h: 18, name: 'golden hour',   period: 'day',   luma: 0.68, ground: '#D9B87A', panel: '#D0AC6C', ink: '#1A1610', muted: '#3F3628', dim: '#5E5444', accent: '#8A4818', accentDim: 'rgba(138,72,24,0.18)', line: 'rgba(26,22,16,0.16)', lineStrong: 'rgba(26,22,16,0.26)', glow: 'rgba(255,170,70,0.24)', elev: '0 16px 40px rgba(26,22,16,0.14)', btnFg: '#F8F4EE' },
    { h: 19, name: 'dusk',          period: 'night', luma: 0.32, ground: '#3E3428', panel: '#4A3E30', ink: '#F0E6D4', muted: '#D2C2A8', dim: '#A89880', accent: '#D4A05A', accentDim: 'rgba(212,160,90,0.20)', line: 'rgba(240,230,212,0.14)', lineStrong: 'rgba(240,230,212,0.24)', glow: 'rgba(212,160,90,0.22)', elev: '0 18px 48px rgba(0,0,0,0.32)', btnFg: '#1A1610' },
    { h: 20, name: 'dusk',          period: 'night', luma: 0.24, ground: '#2C261E', panel: '#383028', ink: '#EEE6D6', muted: '#C8B8A0', dim: '#A09078', accent: '#D09A52', accentDim: 'rgba(208,154,82,0.18)', line: 'rgba(238,230,214,0.13)', lineStrong: 'rgba(238,230,214,0.23)', glow: 'rgba(208,154,82,0.18)', elev: '0 18px 48px rgba(0,0,0,0.36)', btnFg: '#1A1610' },
    { h: 21, name: 'evening',       period: 'night', luma: 0.18, ground: '#221E1A', panel: '#2C2822', ink: '#EDE6D8', muted: '#C0B098', dim: '#968A78', accent: '#C4924A', accentDim: 'rgba(196,146,74,0.18)', line: 'rgba(237,230,216,0.12)', lineStrong: 'rgba(237,230,216,0.22)', glow: 'rgba(196,146,74,0.16)', elev: '0 18px 48px rgba(0,0,0,0.40)', btnFg: '#1A1610' },
    { h: 22, name: 'evening',       period: 'night', luma: 0.14, ground: '#1A1714', panel: '#24201C', ink: '#EDE6D8', muted: '#BDB09C', dim: '#94887A', accent: '#C4924A', accentDim: 'rgba(196,146,74,0.18)', line: 'rgba(237,230,216,0.12)', lineStrong: 'rgba(237,230,216,0.22)', glow: 'rgba(196,146,74,0.16)', elev: '0 18px 48px rgba(0,0,0,0.42)', btnFg: '#1A1610' },
    { h: 23, name: 'night',         period: 'night', luma: 0.12, ground: '#161310', panel: '#201C18', ink: '#EDE6D8', muted: '#C0B09C', dim: '#94887A', accent: '#C4924A', accentDim: 'rgba(196,146,74,0.17)', line: 'rgba(237,230,216,0.12)', lineStrong: 'rgba(237,230,216,0.22)', glow: 'rgba(196,146,74,0.16)', elev: '0 18px 48px rgba(0,0,0,0.42)', btnFg: '#1A1610' }
  ];

  var hourTimer = null;

  function wrapHour(n) {
    n = parseInt(n, 10);
    if (isNaN(n)) return 0;
    return ((n % 24) + 24) % 24;
  }

  function readForcedHour() {
    try {
      var q = new URLSearchParams(window.location.search).get('dab-hour');
      if (q === null || q === '') return null;
      return wrapHour(q);
    } catch (e) {
      return null;
    }
  }

  function readMode() {
    try {
      var m = window.localStorage.getItem(KEY);
      if (m === 'day' || m === 'night' || m === 'auto') return m;
    } catch (e) { /* private mode */ }
    return 'auto';
  }

  function writeMode(mode) {
    try {
      window.localStorage.setItem(KEY, mode);
    } catch (e) { /* private mode */ }
  }

  function currentHour(mode) {
    if (mode === 'day') return LOCK_DAY;
    if (mode === 'night') return LOCK_NIGHT;
    var forced = readForcedHour();
    if (forced !== null) return forced;
    return wrapHour(new Date().getHours());
  }

  function applyPalette(hour) {
    hour = wrapHour(hour);
    var p = PALETTES[hour];
    var root = document.documentElement;
    root.style.setProperty('--dab-ground', p.ground);
    root.style.setProperty('--dab-panel', p.panel);
    root.style.setProperty('--dab-ink', p.ink);
    root.style.setProperty('--dab-muted', p.muted);
    root.style.setProperty('--dab-dim', p.dim);
    root.style.setProperty('--dab-accent', p.accent);
    root.style.setProperty('--dab-accent-dim', p.accentDim);
    root.style.setProperty('--dab-line', p.line);
    root.style.setProperty('--dab-line-strong', p.lineStrong);
    root.style.setProperty('--dab-glow', p.glow);
    root.style.setProperty('--dab-elev', p.elev);
    root.style.setProperty('--dab-btn-fg', p.btnFg);
    root.style.setProperty('--dab-luma', String(p.luma));
    root.dataset.dabHour = String(hour);
    root.dataset.dabPeriod = p.period;
    root.dataset.dabLightName = p.name;
    root.style.colorScheme = p.period === 'night' ? 'dark' : 'light';
    syncHint(hour, p);
    syncButtons();
  }

  function labelFor(hour, palette, mode) {
    var hh = hour < 10 ? '0' + hour : String(hour);
    var lock = mode === 'day' ? 'locked day' : mode === 'night' ? 'locked night' : 'auto';
    return 'Light: ' + hh + ':00 ' + palette.name + ' (' + lock + ')';
  }

  function syncHint(hour, palette) {
    var mode = readMode();
    var text = labelFor(hour, palette, mode);
    document.querySelectorAll('[data-dab-light-hint]').forEach(function (el) {
      el.textContent = text;
    });
  }

  function syncButtons() {
    var mode = readMode();
    document.querySelectorAll('[data-dab-mode]').forEach(function (btn) {
      var on = btn.getAttribute('data-dab-mode') === mode;
      btn.classList.toggle('is-active', on);
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  }

  function setMode(mode) {
    if (mode !== 'auto' && mode !== 'day' && mode !== 'night') mode = 'auto';
    writeMode(mode);
    document.documentElement.dataset.dabMode = mode;
    applyPalette(currentHour(mode));
  }

  function msUntilNextHour() {
    var n = new Date();
    return (
      (60 - n.getMinutes()) * 60 * 1000 -
      n.getSeconds() * 1000 -
      n.getMilliseconds() +
      40
    );
  }

  function scheduleHourTick() {
    if (hourTimer) window.clearTimeout(hourTimer);
    hourTimer = window.setTimeout(function () {
      if (readMode() === 'auto') {
        applyPalette(currentHour('auto'));
      }
      scheduleHourTick();
    }, msUntilNextHour());
  }

  function onReady(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  function bindControls() {
    document.querySelectorAll('[data-dab-mode]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        setMode(btn.getAttribute('data-dab-mode'));
      });
    });
  }

  var mode = readMode();
  document.documentElement.dataset.dabMode = mode;
  applyPalette(currentHour(mode));
  scheduleHourTick();
  onReady(function () {
    bindControls();
    syncButtons();
    applyPalette(currentHour(readMode()));
  });

  window.DABLighting = {
    palettes: PALETTES,
    apply: applyPalette,
    setMode: setMode,
    getMode: readMode,
    currentHour: function () {
      return currentHour(readMode());
    }
  };
})();
