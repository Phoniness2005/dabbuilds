# dabbuilds.com

Tracked customizations, content notes, and deployment docs for **[dabbuilds.com](https://dabbuilds.com)** — a WordPress site hosted on **Elementor Cloud**.

## Why this repo exists

Elementor Cloud stores the live WordPress install (core, database, media, Elementor layouts) on their platform. That live install is **not** a Git repository by default.

This repo is the source of truth for:

- Custom theme / child-theme code
- Custom plugins
- CSS / JS you want versioned
- Elementor template exports (JSON)
- Runbooks for how humans and agents change the site safely
- Change history (GitHub commits, PRs, issues)

## Live site

| Item | Value |
|------|--------|
| URL | https://dabbuilds.com |
| CMS | WordPress |
| Host | Elementor Cloud |
| CDN | Cloudflare |
| GitHub | https://github.com/Phoniness2005/dabbuilds (public) |

## Repo layout

```text
.
├── AGENTS.md                 # Instructions for AI agents (Grok, Cursor, etc.)
├── README.md                 # This file
├── docs/                     # Architecture, hosting, workflows
├── custom/
│   ├── theme/                # Child theme or theme overrides
│   ├── plugins/              # Custom WordPress plugins
│   ├── css/                  # Versioned custom CSS
│   └── js/                   # Versioned custom JS
├── content/                  # Inventories / notes about pages & posts
└── elementor/
    └── templates/            # Exported Elementor templates (JSON)
```

## Working with agents (Grok / Cursor)

1. Open this folder in Cursor: `~/Projects/dabbuilds`
2. In the project terminal: `grok`
3. Describe the change you want (layout, CSS, new feature, plugin)
4. Review the diff in Cursor, commit, open a PR if desired
5. Deploy approved changes to Elementor Cloud (see `docs/workflow.md`)

## Deploy (after you approve)

```bash
./scripts/deploy-sftp.sh --dry-run
./scripts/deploy-sftp.sh --yes
```

SFTP credentials: `.env.local` only (gitignored). Details: [`docs/deploy.md`](docs/deploy.md).

## Look and lighting

The child theme is a **Product Still on a dark void**: Instrument Serif nameplates, IBM Plex Sans UI, quiet hero with an oversized artifact stage, calm Apple-style build-log rows, and amber `#F5A524` accents only (no cyan). Illumination still follows the **viewer’s local clock** (Auto / Day / Night); Night is the stronger Product Still look, Day shifts to cooler charcoal/cream. Principles: [`docs/design-language.md`](docs/design-language.md). Lighting drop-in: [`docs/lighting.md`](docs/lighting.md). Go-live notes: [`docs/changes/2026-09-14-product-still-redesign.md`](docs/changes/2026-09-14-product-still-redesign.md).

Debug a specific hour: `https://dabbuilds.com/?dab-hour=12` (midday) or `?dab-hour=22` (evening).


## Status

**Phase 1 — established:** repo, docs, folders for custom code.  
**Phase 2 — connected:** SFTP to Elementor Cloud (`/html`), child theme scaffold, deploy scripts.  
**Phase 3 — iterate:** child theme, `/play/`, resume hosting, and the `dabbuilds-hardening` plugin are live. This repo is public.  
**Phase 4 — object lighting:** hourly Auto / Day / Night via `lighting.js`, documented for reuse.  
**Phase 5 — Product Still (2026-09-14):** dark void/panel frame, amber-only accents, quiet Product Still hero, calmed build list; theme CSS go-live via `--theme-only` deploy.
