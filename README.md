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
| GitHub | https://github.com/Phoniness2005/dabbuilds |

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

## Status

**Phase 1 — established:** repo, docs, folders for custom code.  
**Phase 2 — connect:** export/connect SFTP or theme files from Elementor Cloud when available.  
**Phase 3 — iterate:** implement tracked changes with agent assistance.
