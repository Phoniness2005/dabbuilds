# Agent instructions — dabbuilds.com

## Project

- **Site:** https://dabbuilds.com
- **Stack:** WordPress + Elementor (Elementor Cloud hosting)
- **Owner GitHub:** Phoniness2005
- **This repo:** versioned customizations only — not a full WordPress core checkout

## Critical constraints

1. **Do not invent WordPress core or plugin files that are not in this repo.** Live core lives on Elementor Cloud.
2. **Prefer changes that land in this repo** (`custom/`, `elementor/templates/`, `docs/`) so they are reviewable in GitHub.
3. **Never commit secrets:** Application Passwords, SFTP passwords, API keys, `.env` values. Use env vars or local-only files listed in `.gitignore`.
4. **Elementor layouts** are often edited in the Elementor UI. When the user wants visual page changes, clarify whether they want:
   - CSS/JS overrides in this repo, or
   - steps to perform in Elementor, or
   - exported template JSON checked into `elementor/templates/`
5. **Database content** (posts, pages body text, menus) is not in git unless explicitly exported. Prefer documenting content changes or using WP admin / REST API when credentials are provided for the session only.

## Preferred change types

| Change | Where to put it |
|--------|------------------|
| Global styles | `custom/css/` |
| Behavior / scripts | `custom/js/` |
| Child theme | `custom/theme/` |
| Custom plugin | `custom/plugins/<name>/` |
| Elementor template export | `elementor/templates/` |
| Process / deploy notes | `docs/` |

## Safety

- Ask before destructive ops (delete pages, reset theme, mass rewrite content).
- Prefer small, reviewable commits with clear messages.
- If deploy path to Elementor Cloud is unknown, implement + document; do not assume SFTP/Git deploy exists.

## When starting a task

1. Read `README.md` and relevant files under `docs/`.
2. Inspect existing `custom/` code before adding new files.
3. Summarize the plan for non-trivial work; use plan mode for ambiguous redesigns.
