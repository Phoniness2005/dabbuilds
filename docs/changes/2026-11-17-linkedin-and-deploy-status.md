# 2026-11-17 — LinkedIn update and Capitol Daylight deploy status

**Owner:** Daniel Bryant / DAB Builds
**Branch:** `redesign/capitol-daylight` (draft PR #6)
**Status:** **live.** Capitol Daylight (dabbuilds-child v0.6.0) was published to dabbuilds.com on Nov 17, about 12:30 to 12:37 PM CT. LinkedIn updates from earlier in the day are live, including the résumé in Featured.

Companion to `docs/changes/2026-11-16-capitol-daylight.md`. Design source: Steve's change list "Capitol Daylight" at `/workspace/design-review/2026-11-16/steve-change-list.md`, the site audit at `/workspace/design-review/2026-11-16/site-audit.md`, and the commits on this branch.

---

## Design (now live)

Capitol Daylight is a bright deco, Apple-smooth redesign of the `dabbuilds-child` theme, version 0.6.0 in `style.css`.

- Palette: Ivory `#F6F1E7`, Paper `#FFFDF8`, Marble `#EDE6D8`, Ink `#1C1A17`, Stone `#5E5A52`. Deep Brass `#8A5A12` for links, Brass `#7A4E0E` for buttons, Gilt `#C9A24A` for decoration only. Night: `#14120F` / `#EDE6D8` / `#D4AF5A`. Retired `#0A0A0B`, `#F5A524`, and `#C47A0A`.
- Type: Josefin Sans 600/700 caps for display, nav, and buttons (14px minimum). Inter for body at 17-18px. Retired Instrument Serif and IBM Plex Sans.
- Lighting: Auto shows Day from 6 AM to 6 PM local (`06:00` to `17:59`); Night otherwise. Day/Night locks and `?dab-hour=` still work. Colors live in CSS; JS only flips `data-dab-period`.
- Home order: Hero, What I do, Selected work, Experience, Build log (latest 3), Contact strip.
- Nav: Home, Work, About, Résumé, Contact. Theme-served `/about/`, `/contact/`, and `/build-log/` when no WordPress page exists. Contact has no form (email jobs@dabbuilds.com, LinkedIn, GitHub).
- Native HTML résumé from `inc/profile.php` (Vermeer split, SNHU expected June 2027). Work cards replace the old cyan screenshot grid. Head tags add meta description, canonical, Open Graph, Twitter card, and theme favicons. The WordPress Site Icon is no longer printed.

GitHub commits on this branch (text-only push, split for the connector): `6db0848`, `7b6da17`, `6845197`, `3fcd7b2`, `611e23a`, `dcade51`, and `f86d2ac` (`fix(theme): redirect stale /resume/ attachment to /dabs-resume/`). The packaged zip on the ops box was built from the box checkout at `16b14c1`, which carries the same theme changes.

Full file-level notes remain in `docs/changes/2026-11-16-capitol-daylight.md`.

---

## Approval

Daniel approved the publish at 7:31 AM CT on Nov 17: "Looks good, publish the site and update LinkedIn."

The LinkedIn pass and the theme publish are both done. This PR stays a draft. Do not merge it until Daniel decides to merge it to `main`.

---

## Deploy log (live)

**2026-11-17, about 12:30 to 12:37 PM CT**

- Signed in to wp-admin through "Log in with Elementor". The old WordPress-only password does not work.
- Uploaded `dabbuilds-child-capitol-daylight-16b14c1.zip` through Themes > Upload, using "Replace active with uploaded". The active theme went from 0.5.0 to 0.6.0.
- Ran "Clear Hosting Cache" once; it succeeded.
- Removed the old Customizer Site Icon and published. The theme favicons are now served.

### Live checks

- These pages return 200: `/`, `/about/`, `/contact/`, `/projects/`, `/build-log/`, `/dabs-resume/`.
- `/resume/` returns 301 to `/dabs-resume/`.
- The OG image `og-image-1200x630.png` returns 200.
- `style.css?ver=0.6.0`.
- The root `/favicon.ico` returns 404. That's minor, because the link tags point at the theme icons.

### Packages and earlier SFTP attempt

- The rollback zip is still at `/workspace/design-review/2026-11-16/deploy-packages/dabbuilds-child-ROLLBACK-main-549b473.zip`.
- The earlier `./scripts/deploy-sftp.sh --yes --theme-only` path still fails: the box network now allows only HTTP, so SSH/SFTP to `sftp.elementor.cloud:32022` returns `HTTP/1.1 400 Bad Request`. Today's publish used the WordPress theme upload instead. Persistent access (SFTP egress or a WordPress Application Password) is still open.

No credentials are recorded in this log.

### Screenshots (box only, not committed)

- `/workspace/design-review/2026-11-16/live/wp-themes-after.png`
- `/workspace/design-review/2026-11-16/live/home-desktop.png`
- `/workspace/design-review/2026-11-16/live/linkedin-featured-resume.png`

---

## Binary icon and OG files

The eight files under `custom/theme/dabbuilds-child/assets/icons/` are **not on GitHub**. The GitHub connector pushes text only. The files exist in the box checkout (`/workspace/dabbuilds-repo`) and inside the v0.6.0 theme zip (now installed on the live site):

- `favicon-day-32.png`, `favicon-day-180.png`, `favicon-day-512.png`
- `favicon-night-32.png`, `favicon-night-180.png`, `favicon-night-512.png`
- `favicon.ico`
- `og-image-1200x630.png`

Sources: `/workspace/design-review/2026-11-16/assets/`. They must be added with git before this PR is merged, or they will be missing from the GitHub tree even though the live theme has them.

---

## LinkedIn changes (Nov 17, CT)

Profile: https://www.linkedin.com/in/daniel-bryant-34749943b

Copy source: `/workspace/design-review/2026-11-16/linkedin-copy.md`.

### Done

- Steve's banner uploaded.
- Headline set to: IT Systems and Support | Production Supervisor, Machining | CNC, CAD and 3D Printing | dabbuilds.com
- About rewritten as three paragraphs:

  I work where technology meets the shop floor. I spent about three years in IT support at Vermeer, Pella Technology, and Wells Fargo. That work covered Windows and Microsoft 365 support, SCCM application deployment, imaging and new computer setup, Citrix users, Okta and SharePoint access, and access reviews and compliance work in every role. At Wells Fargo I held Entra ID and Intune admin access.

  I started as an Army machinist (91E) and graduated from the NTMA machinist program with a 4.0 and Honor Graduate recognition. I have set up and edited programs on CNC lathes and mills, led the plate side of a machine shop, and today I am a Production Supervisor in machining at Emerson, leading a team of 14 machinists. Machining taught me to measure carefully, respect a tolerance, and document what I find. That habit makes me a better troubleshooter, and IT taught me to write things down so the next person can follow them.

  I am completing a B.A. in General Studies with a Mathematics concentration at Southern New Hampshire University, expected June 2027. At home I work in CAD, run a 3D printer, and write about what I build at dabbuilds.com. The best way to reach me is jobs@dabbuilds.com.

- Experience:
  - Emerson Production Supervisor, Machining, Nov 2025 to Present.
  - Vermeer split into IT Support Specialist I (Feb 2022 to Apr 2024) and Machining Specialist, then Plant 2 Plate Side Machine Shop Group Leader (Feb 2020 to Feb 2022).
  - Wells Fargo and Pella Technology dates verified.
- 18 skills added. Top five:
  1. Technical Support
  2. Microsoft Endpoint Configuration Manager
  3. Troubleshooting
  4. CNC Manufacturing
  5. Geometric Dimensioning & Tolerancing

  The intended remaining skills were Microsoft 365, Windows, Disk Imaging, Citrix (user support), Microsoft Entra ID, Microsoft Intune, Okta, Microsoft SharePoint, Jamf, Production Supervision, Training and Development, Computer-Aided Design (CAD), and 3D Printing. LinkedIn's standard labels replaced a few of the names we asked for (for example, CNC Machining became CNC Manufacturing).

- Featured: dabbuilds.com, the Nano Long Range V1 update, Wimbledon Pong, and (after the theme went live) "DAB's Resume" at https://dabbuilds.com/dabs-resume/.

### Held on purpose

- The custom URL (the current URL is on submitted applications).
- The profile photo (must be a real photo of Daniel, never generated).

### Screenshots (box only, not committed)

`/workspace/design-review/2026-11-16/live/linkedin-after-1.png` through `linkedin-after-4.png`, plus `/workspace/design-review/2026-11-16/live/linkedin-featured-resume.png`.

---

## Remaining work

1. wp-admin follow-ups from `site-audit.md` and the Nov 16 change log:
   - Upload a corrected résumé PDF and hook it via `dabbuilds_child_resume_download_url`.
   - Change the author slug `/author/ozvceopeps/` to `/author/daniel-bryant/`.
   - Fix the Sep 10 lighting post copy (it still describes hourly light) and the Aug 29 post's "Resume 2026 V1" wording.
   - Add alt text on empty images in the Nano LR post.
   - Replace Work card screenshots with new-look shots.
2. A mobile live check.
3. Persistent access: SFTP egress (the box network still allows only HTTP) or a WordPress Application Password.
4. Deciding whether to merge PR #6 to `main`. Do not merge it yet. The eight binary icon and OG files are still not on GitHub and should be added with git before a merge.
