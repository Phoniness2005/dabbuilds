/**
 * Day / Night lighting for DAB Builds ("Capitol Daylight").
 *
 * Auto: Day (Ivory) from 06:00 to 17:59 on the visitor's local clock, Night otherwise.
 * Day / Night buttons lock the choice in localStorage (dab-light-mode).
 * Colors live in custom.css under html[data-dab-period="day|night"]; this file only
 * flips the attribute. Nothing is sent anywhere.
 *
 * Debug: ?dab-hour=0..23 forces the Auto hour for this page load.
 *
 * The minute/hour refresh is a named timer callback (onLightTick), capped at
 * one leap year of wakes. Rule 9 framework exception: window.setTimeout.
 * Click handling is onModeClick. Rule 9 framework exception: DOM click.
 */
(function () {
  'use strict';

  const KEY = 'dab-light-mode';
  const DAY_START = 6;
  const NIGHT_START = 18;
  const MAX_LIGHT_TICKS = 366 * 24;
  const MAX_CONTROLS = 32;
  let timer = null;
  let lightTicks = 0;

  /**
   * @returns {number}
   */
  const hoursNow = function hoursNow() {
    const hour = new Date().getHours();
    if (!Number.isFinite(hour) || hour < 0 || hour > 23) {
      return 0;
    }
    return hour;
  };

  /**
   * @param {string|number} n
   * @returns {number}
   */
  const wrapHour = function wrapHour(n) {
    if (typeof n !== 'string' && typeof n !== 'number') {
      return hoursNow();
    }
    const parsed = parseInt(String(n), 10);
    if (!Number.isFinite(parsed)) {
      return hoursNow();
    }
    return ((parsed % 24) + 24) % 24;
  };

  /**
   * @returns {number|null}
   */
  const forcedHour = function forcedHour() {
    try {
      const params = new URLSearchParams(window.location.search);
      const q = params.get('dab-hour');
      if (q === null || q === '') {
        return null;
      }
      return wrapHour(q);
    } catch (_err) {
      return null;
    }
  };

  /**
   * @returns {string}
   */
  const readMode = function readMode() {
    try {
      const stored = window.localStorage.getItem(KEY);
      if (stored === 'day' || stored === 'night' || stored === 'auto') {
        return stored;
      }
    } catch (_err) {
      return 'auto';
    }
    return 'auto';
  };

  /**
   * @param {string} mode
   * @returns {void}
   */
  const writeMode = function writeMode(mode) {
    if (mode !== 'auto' && mode !== 'day' && mode !== 'night') {
      return;
    }
    try {
      window.localStorage.setItem(KEY, mode);
    } catch (_err) {
      return;
    }
  };

  /**
   * @returns {number}
   */
  const currentHour = function currentHour() {
    const forced = forcedHour();
    if (forced === null || !Number.isFinite(forced)) {
      return hoursNow();
    }
    return forced;
  };

  /**
   * @param {string} mode
   * @param {number} hour
   * @returns {string}
   */
  const periodFor = function periodFor(mode, hour) {
    if (mode === 'day') {
      return 'day';
    }
    if (mode === 'night') {
      return 'night';
    }
    if (!Number.isFinite(hour)) {
      return 'night';
    }
    return hour >= DAY_START && hour < NIGHT_START ? 'day' : 'night';
  };

  /**
   * @param {string} mode
   * @param {string} period
   * @returns {string}
   */
  const hintText = function hintText(mode, period) {
    if (mode === 'auto') {
      return 'Auto lighting: ' + period + ' right now. Day runs 6 AM to 6 PM on your clock.';
    }
    return 'Lighting locked to ' + period + '. Choose Auto to follow your clock.';
  };

  /**
   * @returns {void}
   */
  const apply = function apply() {
    const mode = readMode();
    const hour = currentHour();
    const period = periodFor(mode, hour);
    const root = document.documentElement;
    if (!root) {
      return;
    }
    root.dataset.dabMode = mode;
    root.dataset.dabHour = String(hour);
    root.dataset.dabPeriod = period;
    root.style.colorScheme = period === 'night' ? 'dark' : 'light';

    const hints = document.querySelectorAll('[data-dab-light-hint]');
    const hintLimit = Math.min(hints.length, MAX_CONTROLS);
    for (let i = 0; i < hintLimit; i += 1) {
      const el = hints[i];
      if (!el) {
        continue;
      }
      el.textContent = hintText(mode, period);
    }

    const buttons = document.querySelectorAll('[data-dab-mode]');
    const buttonLimit = Math.min(buttons.length, MAX_CONTROLS);
    for (let j = 0; j < buttonLimit; j += 1) {
      const btn = buttons[j];
      if (!btn) {
        continue;
      }
      const on = btn.getAttribute('data-dab-mode') === mode;
      btn.classList.toggle('is-active', on);
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
    }
  };

  /**
   * @param {string} mode
   * @returns {void}
   */
  const setMode = function setMode(mode) {
    let next = mode;
    if (next !== 'auto' && next !== 'day' && next !== 'night') {
      next = 'auto';
    }
    writeMode(next);
    apply();
  };

  /**
   * @returns {number}
   */
  const msUntilNextBoundary = function msUntilNextBoundary() {
    const now = new Date();
    const ms = (60 - now.getMinutes()) * 60000 - now.getSeconds() * 1000 - now.getMilliseconds() + 50;
    if (!Number.isFinite(ms) || ms < 1 || ms > 3700000) {
      return 3600000;
    }
    return ms;
  };

  /**
   * @returns {void}
   */
  const onLightTick = function onLightTick() {
    apply();
    armLightTimer();
  };

  /**
   * @returns {void}
   */
  const armLightTimer = function armLightTimer() {
    if (lightTicks >= MAX_LIGHT_TICKS) {
      return;
    }
    lightTicks += 1;
    if (timer !== null) {
      window.clearTimeout(timer);
      timer = null;
    }
    timer = window.setTimeout(onLightTick, msUntilNextBoundary());
  };

  /**
   * @param {Event} event
   * @returns {void}
   */
  const onModeClick = function onModeClick(event) {
    const target = event.currentTarget;
    if (!(target instanceof Element)) {
      return;
    }
    const mode = target.getAttribute('data-dab-mode');
    if (mode !== 'auto' && mode !== 'day' && mode !== 'night') {
      return;
    }
    setMode(mode);
  };

  /**
   * @returns {void}
   */
  const bindControls = function bindControls() {
    const buttons = document.querySelectorAll('[data-dab-mode]');
    const limit = Math.min(buttons.length, MAX_CONTROLS);
    for (let i = 0; i < limit; i += 1) {
      const btn = buttons[i];
      if (!btn) {
        continue;
      }
      btn.addEventListener('click', onModeClick);
    }
    apply();
  };

  /**
   * @returns {void}
   */
  const onReady = function onReady() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', bindControls);
      return;
    }
    bindControls();
  };

  apply();
  armLightTimer();
  onReady();

  window.DABLighting = {
    setMode: setMode,
    getMode: readMode,
    apply: apply,
    period: function periodNow() {
      return periodFor(readMode(), currentHour());
    },
  };
})();
