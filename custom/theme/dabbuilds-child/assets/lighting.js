/**
 * Hourly object lighting for DAB Builds.
 *
 * Product Still dark chassis: Auto follows the clock with dark void hours; Day/Night locks use dedicated palettes.
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


  /* Product Still: Auto hours stay dark void; Day button uses DAY_PALETTE. */
  var DAY_PALETTE = {
    h: 12, name: 'day lock', period: 'day', luma: 0.96,
    ground: '#F4F1EC', panel: '#FFFFFF', ink: '#141416', muted: '#6B6B73', dim: '#8B8B93',
    accent: '#C47A0A', accentDim: 'rgba(196,122,10,0.10)',
    line: '#D8D4CC', lineStrong: 'rgba(20,20,22,0.28)',
    glow: 'rgba(196,122,10,0.12)', elev: 'none', btnFg: '#0A0A0B'
  };

  var NIGHT_PALETTE = {
    h: 22, name: 'night lock', period: 'night', luma: 0.08,
    ground: '#0A0A0B', panel: '#141416', ink: '#F4F4F5', muted: '#8B8B93', dim: '#6B6B73',
    accent: '#F5A524', accentDim: 'rgba(245,165,36,0.14)',
    line: 'rgba(244,244,245,0.12)', lineStrong: 'rgba(244,244,245,0.20)',
    glow: 'rgba(245,165,36,0.18)', elev: '0 24px 80px rgba(0,0,0,0.5)', btnFg: '#0A0A0B'
  };

  function psDark(h, name, luma, ground, panel) {
    return {
      h: h, name: name, period: 'night', luma: luma,
      ground: ground, panel: panel, ink: '#F4F4F5', muted: '#8B8B93', dim: '#6B6B73',
      accent: '#F5A524', accentDim: 'rgba(245,165,36,0.14)',
      line: 'rgba(244,244,245,0.12)', lineStrong: 'rgba(244,244,245,0.20)',
      glow: 'rgba(245,165,36,0.16)', elev: '0 24px 80px rgba(0,0,0,0.45)', btnFg: '#0A0A0B'
    };
  }

  var PALETTES = [
    psDark(0,  'midnight',      0.08, '#0A0A0B', '#141416'),
    psDark(1,  'late night',    0.08, '#0A0A0B', '#141416'),
    psDark(2,  'late night',    0.09, '#0B0B0C', '#151518'),
    psDark(3,  'late night',    0.09, '#0B0B0C', '#151518'),
    psDark(4,  'late night',    0.10, '#0C0C0D', '#161619'),
    psDark(5,  'pre-dawn',      0.11, '#0C0C0E', '#17171A'),
    psDark(6,  'dawn',          0.12, '#0D0D0F', '#18181B'),
    psDark(7,  'early morning', 0.12, '#0D0D0F', '#18181B'),
    psDark(8,  'morning',       0.13, '#0E0E10', '#19191C'),
    psDark(9,  'morning',       0.13, '#0E0E10', '#19191C'),
    psDark(10, 'late morning',  0.14, '#0F0F11', '#1A1A1D'),
    psDark(11, 'midday',        0.14, '#0F0F11', '#1A1A1D'),
    psDark(12, 'midday',        0.15, '#101012', '#1B1B1E'),
    psDark(13, 'afternoon',     0.14, '#0F0F11', '#1A1A1D'),
    psDark(14, 'afternoon',     0.14, '#0F0F11', '#1A1A1D'),
    psDark(15, 'afternoon',     0.13, '#0E0E10', '#19191C'),
    psDark(16, 'late afternoon',0.13, '#0E0E10', '#19191C'),
    psDark(17, 'golden hour',   0.12, '#0D0D0F', '#18181B'),
    psDark(18, 'golden hour',   0.12, '#0D0D0F', '#18181B'),
    psDark(19, 'dusk',          0.11, '#0C0C0E', '#17171A'),
    psDark(20, 'dusk',          0.10, '#0C0C0D', '#161619'),
    psDark(21, 'evening',       0.09, '#0B0B0C', '#151518'),
    psDark(22, 'evening',       0.08, '#0A0A0B', '#141416'),
    psDark(23, 'night',         0.08, '#0A0A0B', '#141416')
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
    var mode = readMode();
    var p = mode === 'day' ? DAY_PALETTE : mode === 'night' ? NIGHT_PALETTE : PALETTES[hour];
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
