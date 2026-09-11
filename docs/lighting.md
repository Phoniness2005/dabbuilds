# Hourly object lighting

Copy this onto another WordPress child theme if you want a site that **follows the viewer’s local clock in one-hour steps**, with a smooth token transition at the hour and an Auto / Day / Night override.

Nothing here reads GPS. Nothing is sent to a server. The hour comes from `new Date().getHours()` in the browser.

Live reference: [dabbuilds.com](https://dabbuilds.com) · source: [Phoniness2005/dabbuilds](https://github.com/Phoniness2005/dabbuilds)

## Files to copy

| File | What it does |
|------|----------------|
| `custom/theme/dabbuilds-child/assets/lighting.js` | 24 palettes, timer, localStorage mode, `?dab-hour=` |
| Token block in `assets/custom.css` | `:root` midday fallback + `html[data-dab-period="night"]` |
| Inline boot in `functions.php` (`dabbuilds_child_lighting_boot`) | Sets `data-dab-period` before paint |
| Header control (`.dab-light` buttons with `data-dab-mode`) | Auto / Day / Night |
| Footer hint (`[data-dab-light-hint]`) | “Light: 14:00 afternoon (auto)” |

You can keep your own layout CSS. The lighting engine only writes CSS variables.

## How it decides the hour

Priority:

1. User lock: **Day** → hour 12, **Night** → hour 22
2. Else `?dab-hour=0` … `?dab-hour=23` (this page load only; useful for screenshots)
3. Else the viewer’s local clock

Mode is stored as `localStorage.dab-light-mode` = `auto` | `day` | `night`.

A timer sleeps until the next local hour, then applies the next palette. CSS transitions (`~1.2s`) are the gradual part. `prefers-reduced-motion: reduce` turns those transitions off.

## Markup

```html
<div class="dab-light" role="group" aria-label="Site lighting">
  <button type="button" class="dab-light__btn" data-dab-mode="auto" aria-pressed="true">Auto</button>
  <button type="button" class="dab-light__btn" data-dab-mode="day" aria-pressed="false">Day</button>
  <button type="button" class="dab-light__btn" data-dab-mode="night" aria-pressed="false">Night</button>
</div>

<p data-dab-light-hint>Light follows your local clock, one hour at a time.</p>
```

Enqueue `lighting.js` in `<head>` (`in_footer => false`) so tokens apply before the footer paints. Keep the tiny boot script at `wp_head` priority 0.

## Boot script (paste into `wp_head`)

```js
(function () {
  try {
    var mode = 'auto';
    try { mode = localStorage.getItem('dab-light-mode') || 'auto'; } catch (e) {}
    var hour = new Date().getHours();
    try {
      var q = new URLSearchParams(location.search).get('dab-hour');
      if (q !== null && q !== '') hour = parseInt(q, 10);
    } catch (e) {}
    if (mode === 'day') hour = 12;
    if (mode === 'night') hour = 22;
    hour = ((hour % 24) + 24) % 24;
    var night = (hour < 6 || hour >= 19);
    var el = document.documentElement;
    el.dataset.dabMode = mode;
    el.dataset.dabHour = String(hour);
    el.dataset.dabPeriod = night ? 'night' : 'day';
    el.style.colorScheme = night ? 'dark' : 'light';
  } catch (e) {}
})();
```

## Palettes

Twenty-four rows live in `lighting.js` as `PALETTES`. Tune hex values there. Names:

| Hours | Name |
|------|------|
| 0 | midnight |
| 1–4 | late night |
| 5 | pre-dawn |
| 6 | dawn |
| 7 | early morning |
| 8–9 | morning |
| 10 | late morning |
| 11–12 | midday |
| 13–15 | afternoon |
| 16 | late afternoon |
| 17–18 | golden hour |
| 19–20 | dusk |
| 21–22 | evening |
| 23 | night |

Day hours use dark type on bone/paper. Night hours use warm paper type on charcoal. Primary-button type (`--dab-btn-fg`) flips so it stays at WCAG AA on the brass fill.

## Debug

- `https://yoursite.example/?dab-hour=12` — midday
- `https://yoursite.example/?dab-hour=22` — evening
- In the console: `DABLighting.setMode('night')`, `DABLighting.apply(18)`, `DABLighting.palettes`

`?dab-hour=` is ignored while Day or Night is locked, so the control still wins.

## Accessibility

- Body (`--dab-ink`) and muted copy vs ground are ≥ 4.5:1 at every hour
- Buttons are labeled text, not icon-only
- Reduced motion: no color transition
- Do not add geolocation to “improve” sunrise; the local clock is the product

## Privacy

Do not beacon the hour, timezone, or mode. dabbuilds.com already sends `Permissions-Policy: geolocation=()`. Keep it that way.
