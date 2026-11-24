# 2026-11-24 — Credly credentials (theme 0.6.3)

**Theme:** dabbuilds-child 0.6.3 (`style.css`). Asset query `20261124-credly-2`.

Adds a Credentials section to the home page, between Experience and Build log, and a matching text list on the résumé. Badge facts live in `inc/profile.php`. The 16 public Credly badges are self-hosted as 340px PNGs under `assets/badges/` and each card links to its Credly page. Issuer names for the Coursera-issued IBM badges are shown as IBM. The résumé list also keeps the non-Credly training already on file (Kaseya, Dell, Palantir, and NIMS).

## Sign-off adjustments

After Steve's review of the first preview: home backgrounds now alternate (Experience plain, Credentials band, Build log plain, Contact strip band). The home grid shows 10 badges on desktop and 8 below 560px, with a "Show all 16" / "Show fewer" toggle. Badge names clamp to 3 lines and the full name is in the card `title`. The toggle matches the section link style and sits 18px above "View all on Credly."

## Deploy record

Live on dabbuilds.com as of Tuesday, November 24, 2026, 2:39 PM CT. Installed in wp-admin with **Replace currently installed with uploaded version** (`dabbuilds-child-0.6.3.zip`). Hosting cache and Redis were flushed after the upload. Steve had signed off, subject to the adjustments above, which shipped in this same 0.6.3 package. Branch: `feature/credly-credentials`. PR: [#15](https://github.com/Phoniness2005/dabbuilds/pull/15).

## Badge image check after go-live

A screenshot taken about a minute after deploy showed every badge as an empty gilt circle, even though the `<img>` tags, `src` paths, and HTTP 200 `image/png` responses were correct.

A later headless Chrome pass against https://dabbuilds.com/?dab-hour=12 (section scrolled into view, then a short wait) found no theme or asset bug:

- The 10 badges shown on desktop all reported `complete === true`, `naturalWidth === 340`, and `clientWidth === 112`, with opacity 1 and no clipping, mask, or filter hiding the art.
- Opening "Show all 16" then loaded the remaining six the same way.
- A fresh Day screenshot of the live section, `/workspace/dabbuilds-deploy/credly-preview/live-day-check.png`, shows the badge art clearly.

The empty rings in the first shot were timing. The cards use `loading="lazy"` and sit below the fold, and the gilt ring is an `outline` on the reserved 112×112 image box, so the rings paint before the PNGs (or Cloudflare Polish WebP variants) finish decoding. No 0.6.4 theme change was required.
