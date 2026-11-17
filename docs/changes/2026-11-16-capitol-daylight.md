# 2026-11-16 Capitol Daylight redesign (branch `redesign/capitol-daylight`)

Status: **live** as of Nov 17, about 12:30 to 12:37 PM CT. dabbuilds.com is serving dabbuilds-child v0.6.0 (Capitol Daylight). See `docs/changes/2026-11-17-linkedin-and-deploy-status.md` for the deploy log, LinkedIn update, and remaining work.

Do not merge PR #6 until Daniel decides to. The eight binary icon and OG files are still only in the box checkout and the theme zip, not on GitHub.

Spec: Steve's change list "Capitol Daylight" (bright deco, Apple-smooth). Ivory/Paper/Marble grounds,
Ink/Stone text, Deep Brass links, Brass buttons, Gilt decoration only. Josefin Sans 600/700 caps for display,
nav, and buttons (14px minimum); Inter body at 17-18px.

## What changed (child theme)

- `assets/custom.css` rewritten: new tokens (Day default, Night via `html[data-dab-period="night"]`), retired
  `#0A0A0B`, `#F5A524`, `#C47A0A`, IBM Plex Sans, and Instrument Serif. One deco motif: the Gilt stepped divider.
- `assets/lighting.js` simplified: Auto = Day 06:00-17:59 local, Night otherwise; Day/Night locks still work.
  `?dab-hour=` still forces an hour. Colors live in CSS; JS only flips `data-dab-period`.
- Home order: Hero, What I do, Selected work, Experience, Build log (latest 3), Contact strip (`inc/home-sections.php`).
- Hero: deco caps headline, Brass "See my work" button, "Résumé" text link, framed image slot
  (placeholder monogram until a real photo lands; hook `dabbuilds_child_hero_image` or drop `assets/stills/hero.jpg`).
- Nav: Home, Work, About, Résumé, Contact.
- `/about/`, `/contact/`, `/build-log/` are served by the theme (`inc/routes.php`) when no WP page exists. If a WP page
  with the same slug is created later, it uses the same template.
- Contact page has no form (nothing sends mail). Email daniel@dabbuilds.com, LinkedIn, GitHub.
- Résumé page is native HTML (`page-dabs-resume.php`) from `inc/profile.php`, with print-to-PDF styles. The Office embed
  of `Resume-2026-V2.doc` is gone because that file still has the old Vermeer dates and SNHU line. A corrected
  download appears when the `dabbuilds_child_resume_download_url` filter returns a URL.
- Work page (`page-projects.php`): new cards, stale cyan screenshot grid removed.
- Head tags (`inc/head-meta.php`): meta description, canonical, Open Graph, Twitter card, favicons (Day and Night PNG,
  apple-touch-icon, `favicon.ico`, also served at `/favicon.ico`). The WP Site Icon (Iron Man crop) is no longer printed.
  Skips description/canonical/OG if Yoast, Rank Math, AIOSEO, or SEOPress is active.
- Career facts live in one place: `inc/profile.php`. Truth rules are in its header comment.

## Still needs wp-admin (not in this branch)

- Upload a corrected résumé file (PDF preferred) and hook it via `dabbuilds_child_resume_download_url`.
- Remove or replace the old WP Site Icon in Customizer (theme already stops printing it).
- Author slug `/author/ozvceopeps/` to `/author/daniel-bryant/` (user nicename).
- `/resume/` attachment slug collision (old `resume.png`).
- Sep 10 lighting post copy (describes hourly light) and the Aug 29 post's "Resume 2026 V1" wording.
- Empty image alts in the Nano LR post; new-look screenshots for Work cards.
- Optional: create real About/Contact pages only if Daniel wants to edit them in WP (the theme serves them already).

## Preview

Local WordPress Playground with sample posts; screenshots in
`/workspace/design-review/2026-11-16/preview/` on the ops box (not in git).

## Binary assets note

`custom/theme/dabbuilds-child/assets/icons/` (OG image, Day/Night favicons, `favicon.ico`) is committed in the
box checkout (`/workspace/dabbuilds-repo`). The GitHub copy of this branch was pushed through a text-only API, so
those 8 files may be missing on GitHub until they are pushed with git. Sources:
`/workspace/design-review/2026-11-16/assets/` (Steve's renders; `favicon.ico` is built from `favicon-day-512.png`).
