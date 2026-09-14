# Product Still redesign — draft notes

**Status:** Draft only — not published. For a future build-log entry.  
**Date:** 2026-09-14  
**Tags (suggested):** site, design, lighting

---

## Working title options

- Product Still: dark frame, amber signal
- From cream catalog to Product Still
- Build · Iterate · Launch — quieter chrome

---

## Outline (for later polish)

### Why

dabbuilds.com already had a catalog object and hourly lighting. It still read a little like a warm theme skin more than a product of someone who ships hardware and code. Recruiters need resume + proof in about ten seconds; makers need the build log to feel like *work happened here*.

### Concepts → mix

Three directions:

1. **Mission Chassis** — ground-station rails, serial chrome.
2. **Product Still** — Tesla × Apple: one focal object, almost no chrome.
3. **Ops Ledger** — Palantir-dense table for the log.

The pick was a **mix**: Product Still as the hero and overall frame; dark void/panel kept; amber `#F5A524` only (cyan already retired); ledger calmed into Apple-list spacing. Mission Chassis rails stripped from hero/nav.

### What shipped (theme)

- `:root` and Night → void `#0A0A0B`, panel `#141416`, ink `#F4F4F5`, muted `#8B8B93`, accent `#F5A524`.
- Day → cooler cream/charcoal so Auto still works.
- Hero: more whitespace, soft amber stage light, quiet CTAs (one primary amber).
- Build log: hairline rows, more vertical air, muted serials/dates, amber title hover.
- Type unchanged: Instrument Serif + IBM Plex Sans.
- Lighting control unchanged — `lighting.js` still drives `data-dab-period`.

### Deploy

```bash
./scripts/deploy-sftp.sh --yes --theme-only
```

### What this is not

Not a CMS rewrite. Not WebGL. Not a claim that Elementor hire-strip / contact blocks from the static prototype are live yet. This draft should wait until the live site matches the notes before publishing.

### Open follow-ups

- Port hire strip + mailto contact from the static prototype if still wanted.
- Optional real hero artifact photo instead of the CSS panel stage.
- HTML resume surface beyond the PDF viewer.

---

*Do not publish until Daniel reviews and the live verify checklist in `docs/changes/2026-09-14-product-still-redesign.md` is green.*
