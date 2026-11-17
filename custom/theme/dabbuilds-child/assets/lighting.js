/**
 * Day / Night lighting for DAB Builds ("Capitol Daylight").
 *
 * Auto: Day (Ivory) from 06:00 to 17:59 on the visitor's local clock, Night otherwise.
 * Day / Night buttons lock the choice in localStorage (dab-light-mode).
 * Colors live in custom.css under html[data-dab-period="day|night"]; this file only
 * flips the attribute. Nothing is sent anywhere.
 *
 * Debug: ?dab-hour=0..23 forces the Auto hour for this page load.
 */
(function () {
  'use strict';

  var KEY = 'dab-light-mode';
  var DAY_START = 6;
  var NIGHT_START = 18;
  var timer = null;

  function wrapHour(n) {
    n = parseInt(n, 10);
    if (isNaN(n)) return new Date().getHours();
    return ((n % 24) + 24) % 24;
  }

  function forcedHour() {
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
    try { window.localStorage.setItem(KEY, mode); } catch (e) { /* private mode */ }
  }

  function currentHour() {
    var f = forcedHour();
    return f !== null ? f : new Date().getHours();
  }

  function periodFor(mode, hour) {
    if (mode === 'day') return 'day';
    if (mode === 'night') return 'night';
    return hour >= DAY_START && hour < NIGHT_START ? 'day' : 'night';
  }

  function hint(mode, period) {
    if (mode === 'auto') {
      return 'Auto lighting: ' + period + ' right now. Day runs 6 AM to 6 PM on your clock.';
    }
    return 'Lighting locked to ' + period + '. Choose Auto to follow your clock.';
  }

  function apply() {
    var mode = readMode();
    var hour = currentHour();
    var period = periodFor(mode, hour);
    var root = document.documentElement;
    root.dataset.dabMode = mode;
    root.dataset.dabHour = String(hour);
    root.dataset.dabPeriod = period;
    root.style.colorScheme = period === 'night' ? 'dark' : 'light';
    document.querySelectorAll('[data-dab-light-hint]').forEach(function (el) {
      el.textContent = hint(mode, period);
    });
    document.querySelectorAll('[data-dab-mode]').forEach(function (btn) {
      var on = btn.getAttribute('data-dab-mode') === mode;
      btn.classList.toggle('is-active', on);
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  }

  function setMode(mode) {
    if (mode !== 'auto' && mode !== 'day' && mode !== 'night') mode = 'auto';
    writeMode(mode);
    apply();
  }

  function schedule() {
    if (timer) window.clearTimeout(timer);
    var n = new Date();
    var ms = (60 - n.getMinutes()) * 60000 - n.getSeconds() * 1000 - n.getMilliseconds() + 50;
    timer = window.setTimeout(function () {
      apply();
      schedule();
    }, ms);
  }

  function onReady(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  apply();
  schedule();
  onReady(function () {
    document.querySelectorAll('[data-dab-mode]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        setMode(btn.getAttribute('data-dab-mode'));
      });
    });
    apply();
  });

  window.DABLighting = {
    setMode: setMode,
    getMode: readMode,
    apply: apply,
    period: function () { return periodFor(readMode(), currentHour()); }
  };
})();
