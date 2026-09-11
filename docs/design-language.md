# Design language

dabbuilds.com is styled as a **physical object whose finish and illumination change with the hour**, not as a launch-trailer HUD.

The look is translated from industrial-design principles used by [Body Shop](https://www.body-shop.co/) (San Francisco — Calvin Lien, Joe Tsao, and collaborators) on objects such as 1X NEO Gamma, Dream Recorder, Quiet Hours, and Walden Time. This is **not** an affiliation, and we do not copy their photography, wordmark, or website.

## Principles we kept

1. **Restraint.** Receding chrome. No cyan glow, no grid overlay, no gradient wordmark.
2. **Warm materials.** Bone paper, plaster, graphite, brass/bakelite accent. Day looks like a product on a table. Night looks like a nightstand object with a low wash.
3. **Time as a product feature.** Walden Time and Quiet Hours mark the day without notifications. The site follows the viewer’s local clock in one-hour steps. See [lighting.md](./lighting.md).
4. **Deference.** Auto lighting plus a labeled Auto / Day / Night control. No geolocation.

## What did not change

Copy, posts, the resume file, `/play/` (Wimbledon Pong), navigation labels, and URL structure. Only the object around them restyled.

## Type

- Display / UI: [Manrope](https://fonts.google.com/specimen/Manrope)
- Body: [Source Sans 3](https://fonts.google.com/specimen/Source+Sans+3)

## Tokens

CSS custom properties, applied by `custom/theme/dabbuilds-child/assets/lighting.js`:

| Token | Role |
|-------|------|
| `--dab-ground` | Page field |
| `--dab-panel` | Cards, article plate, header tools |
| `--dab-ink` | Headings, primary text |
| `--dab-muted` | Body copy |
| `--dab-dim` | Captions, footer hint |
| `--dab-accent` | Links, primary buttons, eyebrows |
| `--dab-btn-fg` | Type on the primary button |
| `--dab-line` / `--dab-line-strong` | Hairline seams |
| `--dab-glow` | Nightstand wash (transparent by day) |
| `--dab-elev` | Soft object shadow |
| `--dab-luma` | 0–1 intensity, documentation / future use |

Midday fallback lives on `:root`. Coarse night fallback lives on `html[data-dab-period="night"]` so the first paint is not a flash of the wrong period.
