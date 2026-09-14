# 2026-09-14 — Product Still redesign (go-live)

**Owner:** Daniel Bryant / DAB Builds  
**Status:** Approved for theme CSS go-live (Product Still dark frame)  
**Scope:** Child-theme `custom.css` + design docs only (theme-only deploy)

---

## Decision trail

1. **Concepts (design-plan.md §6)**
   - **A — Mission Chassis** (SpaceX × Anduril): serial rails, ground-station chrome, amber micro-accents.
   - **B — Product Still** (Tesla × Apple): quiet hero, huge focal artifact, almost no chrome, one primary CTA.
   - **C — Ops Ledger** (Palantir × xAI): dense serial table, status strips, dashboard density.

2. **Hybrid / mix lock (2026-09-14 Decision)**  
   Daniel approved a **mix**, not a pure concept:
   - **Primary:** Product Still hero (quiet + oversized artifact stage feel).
   - **Keep:** Dark void/panel frame; amber `#F5A524` only (no cyan); BUILD · ITERATE · LAUNCH; hire/resume path; Auto/Day/Night lighting.
   - **Calm:** Ops Ledger → Apple-style list rows (serial · title · date energy, more whitespace, weaker table chrome).
   - **Strip:** Mission Chassis rails / busy ops chrome from hero and nav.

3. **Go-live pick**  
   Product Still as the live look; NIGHT/dark is the stronger Product Still expression. `:root` defaults shift to dark void so the site does not flash cream before `lighting.js` applies `data-dab-period`.

---

## Tokens

| Token | Night / `:root` (Product Still) | Day (`html[data-dab-period="day"]`) |
|---|---|---|
| Ground / void | `#0A0A0B` | `#F4F1EC` |
| Panel | `#141416` | `#FFFFFF` |
| Panel-2 | `#1A1A1D` | `#EBE8E2` |
| Ink / text | `#F4F4F5` | `#141416` |
| Muted | `#8B8B93` | `#6B6B73` |
| Dim | `#6B6B73` | `#8B8B93` |
| Accent | `#F5A524` | `#C47A0A` (darker for day contrast) |
| Accent dim | `rgba(245,165,36,0.12–0.14)` | `rgba(196,122,10,0.10)` |
| Line | `#242428` | `#D8D4CC` |
| Button FG | `#0A0A0B` | `#0A0A0B` |
| Max width | `1120px` | same |

**Type (unchanged):** Instrument Serif (display) · IBM Plex Sans (body / UI / indexes).  
**Accent rule:** Amber only. No cyan. No plasma blue.

**Lighting:** `lighting.js` still sets `html[data-dab-period="day"|"night"]` from Auto / Day / Night. Night mirrors Product Still dark; Day uses cooler charcoal/cream. Coarse boot in `functions.php` unchanged.

---

## Files changed (this commit package)

| Repo path | Action |
|---|---|
| `custom/theme/dabbuilds-child/assets/custom.css` | Full Product Still token + spacing update; `.dab-*` layout classes preserved |
| `docs/design-language.md` | Product Still + dark frame; lighting pointers kept |
| `docs/changes/2026-09-14-product-still-redesign.md` | This action log |
| `content/posts/product-still-redesign-2026-09.md` | Draft build-log notes (unpublished) |
| README Look / Status | See `README-snippet.md` (merge manually if needed) |

**Not changed:** `lighting.js`, `functions.php`, copy, posts live content, resume PDF, `/play/`, nav labels, URL structure, Elementor templates.

**Prototype reference (workspace only, not in repo):**  
`/workspace/dabbuilds-redesign/prototype/index.html`, `NOTES.md`, `design-plan.md` Decision section.

---

## Deploy

Theme CSS only (fast path):

```bash
./scripts/deploy-sftp.sh --yes --theme-only
```

Dry-run first if desired:

```bash
./scripts/deploy-sftp.sh --dry-run --theme-only
```

SFTP credentials remain in `.env.local` (gitignored). See `docs/deploy.md`.

---

## Verify (post-deploy)

1. **Home (Night / Auto evening):** Void `#0A0A0B` background; amber primary CTA; hero quiet with generous whitespace; signals/artifact panel reads as Product Still stage, not ops rails.
2. **Build log:** Calm list spacing; hairline rules; muted serials/dates; title hover → amber.
3. **Day mode:** Toggle Day in catalog bar (or `?dab-hour=12`); cream/charcoal surfaces; amber `#C47A0A`; no cyan flash.
4. **Night mode:** Toggle Night (or `?dab-hour=22`); full Product Still dark.
5. **Resume / Projects / singular posts:** Panels and CTAs use new tokens; Instrument Serif + IBM Plex intact.
6. **Mobile ≤820px:** Hero stacks; primary CTA full-width; lighting control still usable.
7. **Hard refresh** (Cloudflare / browser cache) if old cream palette sticks.

---

## Rollback

1. Revert `custom/theme/dabbuilds-child/assets/custom.css` to the previous cream-catalog commit (pre–Product Still).
2. Redeploy theme only:

```bash
./scripts/deploy-sftp.sh --yes --theme-only
```

3. Hard-refresh dabbuilds.com; confirm Auto/Day/Night still driven by `lighting.js`.

No database or Elementor template rollback required for this CSS-only change.

---

## Out of scope (deferred)

- Elementor section rebuild of hire strip / contact mailto from static prototype
- Replacing Instrument Serif with Inter (prototype used system Inter; live keeps Instrument Serif + IBM Plex per brand)
- WebGL / heavy motion
- Cyan or multi-accent experiments

## Deploy log (live)

- **2026-09-14 ~14:30 CT** — SFTP theme deploy to Elementor Cloud (`./scripts/deploy-sftp.sh --yes --theme-only`) as user `KaJMoEBi@sftp.elementor.cloud:32022`.
- Confirmed live CSS serves Product Still tokens (`#0A0A0B` / `#F5A524`) at `https://dabbuilds.com/wp-content/themes/dabbuilds-child/assets/custom.css` (cache-busted fetch).
- `mkdir` “Failure” lines during deploy are expected when remote directories already exist; file `put` operations completed.
- **Follow-up:** `lighting.js` hourly palettes rewritten so Auto stays Product Still dark void (cream only when Day is locked). Redeployed via SFTP.
- **Cache fix:** Cloudflare was pinning cream `custom.css` via stale `?ver=` filemtime. `functions.php` now uses `$dab_asset_ver = 20260914-product-still-2` for CSS/JS enqueue.

---

## Layout ship — Product Still full markup (2026-09-14)

**Status:** Theme PHP + CSS on disk (parent deploys; no SFTP/git push from this step).  
**Cache bust:** `$dab_asset_ver = '20260914-product-still-layout-1'` in `functions.php`.

### What changed

| Path | Change |
|---|---|
| `custom/theme/dabbuilds-child/functions.php` | Hero rebuilt as Product Still grid: `.dab-hero__copy` (eyebrow / title / lede / CTAs) + `.dab-hero__artifact` (optional `dabbuilds_child_shot_url` still, else CSS `.dab-hero__artifact-core` + meta `Nano LR · still`). Pillars `01/02/03` moved to `.dab-pillars` after inner. New `dabbuilds_child_render_hire_strip()` (Available for hire · production/IT/ops + maker · `/dabs-resume/` · mailto daniel@ + jobs@). Asset ver bumped. |
| `custom/theme/dabbuilds-child/template-parts/archive.php` | Hire strip after hero; catalog → `.dab-ledger` with heading “Build log”; rows are single-link `.dab-ledger__row` (serial · title · date); excerpts removed; thumbnails kept in markup but hidden on home via CSS. |
| `custom/theme/dabbuilds-child/assets/custom.css` | Styles for artifact stage, pillars strip, hire strip, ledger rows; responsive stack (artifact first on small screens; ledger 2-row mobile); no cyan; Instrument Serif + IBM Plex tokens kept; `lighting.js` Auto dark behavior untouched. |

### Markup sketch (home)

1. `.dab-hero` → `.dab-hero__inner` (copy \| artifact) → `.dab-pillars` → `#dab-latest`
2. `.dab-hire` (blog index only)
3. `.dab-ledger` → `.dab-ledger__row` × N

### Deploy (parent)

```bash
./scripts/deploy-sftp.sh --yes --theme-only
```

Hard-refresh after deploy so Cloudflare picks up `?ver=20260914-product-still-layout-1`.

### Verify

1. Home Night/Auto: oversized artifact stage (CSS orb or media still), quiet copy left, pillars under hero.
2. Hire strip visible before build log; resume CTA + mailto work.
3. Build log = calm list (serial · title · date), no excerpts, no dense table chrome.
4. Mobile ≤820px: artifact above copy; pillars stack; ledger serial/date then title.
5. Day/Night toggle still driven by `lighting.js`.
