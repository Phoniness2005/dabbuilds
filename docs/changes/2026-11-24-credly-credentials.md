# 2026-11-24 — Credly credentials (theme 0.6.3)

**Theme:** dabbuilds-child 0.6.3 (`style.css`). Asset query `20261124-credly-2`.

Adds a Credentials section to the home page, between Experience and Build log, and a matching text list on the résumé. Badge facts live in `inc/profile.php`. The 16 public Credly badges are self-hosted as 340px PNGs under `assets/badges/` and each card links to its Credly page. Issuer names for the Coursera-issued IBM badges are shown as IBM. The résumé list also keeps the non-Credly training already on file (Kaseya, Dell, Palantir, and NIMS).

Deploy by uploading `dabbuilds-child-0.6.3.zip` in wp-admin (Themes > Upload, replace the active theme) and clearing the hosting cache. This log does not record a live publish.

## Sign-off adjustments

After Steve's review of the first preview: home backgrounds now alternate (Experience plain, Credentials band, Build log plain, Contact strip band). The home grid shows 10 badges on desktop and 8 below 560px, with a "Show all 16" / "Show fewer" toggle. Badge names clamp to 3 lines and the full name is in the card `title`. The toggle matches the section link style and sits 18px above "View all on Credly."
