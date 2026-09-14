# Design language

dabbuilds.com is framed as a **Product Still on a dark void** — hardware and software shown like a quiet product photograph, with illumination that still follows the hour.

The look synthesizes Tesla/Apple product stillness with a retained dark ops frame (void/panel) and amber signal accents. Earlier catalog language borrowed industrial-design principles used by [Body Shop](https://www.body-shop.co/) (San Francisco). That is **not** an affiliation, and we do not copy their photography, wordmark, or website.

## Locked mix (2026-09-14)

- **Primary:** Product Still hero — quiet copy, oversized focal stage, almost no chrome, one amber primary CTA + secondary ghost.
- **Frame:** Dark void `#0A0A0B` / panel `#141416` / ink `#F4F4F5` / muted `#8B8B93`.
- **Accent:** Amber `#F5A524` only (sparingly). **No cyan.**
- **Build log:** Calm Apple-style list energy — more whitespace, hairline rules, muted serials/dates; not a dense Palantir table.
- **Lighting:** Auto / Day / Night remains. Night = strong Product Still dark. Day = cooler charcoal/cream. See [lighting.md](./lighting.md).

## Principles

1. **The object is the image.** Build-log entries and hero stages lead with the artifact. Chrome recedes.
2. **Catalog, not cards.** Numbered entries (`001`), quiet dates, captions under the object. No rounded app tiles or busy ops rails.
3. **Type that is not a startup sans.** Display is Instrument Serif. UI and body are IBM Plex Sans.
4. **Machined plates, not pills.** Primary actions are 2px-radius amber rectangles on void. Ghost actions are muted text stamps.
5. **Lighting is a switch.** Auto / Day / Night stays in the catalog bar. `lighting.js` drives `data-dab-period`. Defaults (`:root`) match Product Still dark so the page does not flash cream before JS runs.
6. **One primary action per view.** Read the build log / View resume / Contact — never three equal CTAs fighting.

## What did not change

Copy, published posts, the resume file, `/play/` (Wimbledon Pong), navigation labels, URL structure, and the lighting control behavior.

## Type

- Display: [Instrument Serif](https://fonts.google.com/specimen/Instrument+Serif)
- Body / UI / indexes: [IBM Plex Sans](https://fonts.google.com/specimen/IBM+Plex+Sans)

## Color (Product Still)

| Role | Night / default | Day |
|---|---|---|
| Void / ground | `#0A0A0B` | `#F4F1EC` |
| Panel | `#141416` | `#FFFFFF` |
| Ink | `#F4F4F5` | `#141416` |
| Muted | `#8B8B93` | `#6B6B73` |
| Accent | `#F5A524` | `#C47A0A` |

Tokens live in `custom/theme/dabbuilds-child/assets/custom.css`. Change history: [changes/2026-09-14-product-still-redesign.md](./changes/2026-09-14-product-still-redesign.md).
