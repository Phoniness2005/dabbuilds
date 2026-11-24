# Architecture

## High-level

```text
Visitors
   │
   ▼
Cloudflare (CDN / TLS)
   │
   ▼
Elementor Cloud (WordPress + Elementor)
   │
   ├── Theme + Elementor templates (hosted)
   ├── Plugins (hosted)
   ├── Media library (hosted)
   └── MySQL content (hosted)
   │
   ▼ (optional, versioned here)
GitHub: Phoniness2005/dabbuilds
   custom theme / plugins / CSS / JS / template exports
```

## What lives where

| Asset | Primary location | In this GitHub repo? |
|-------|------------------|----------------------|
| WordPress core | Elementor Cloud | No |
| Database (posts, options) | Elementor Cloud | No (unless exported) |
| Media uploads | Elementor Cloud | No |
| Elementor page designs | Elementor Cloud | Optional JSON exports |
| Custom CSS/JS you own | This repo → deploy to host | Yes |
| Child theme / custom plugin | This repo → deploy to host | Yes |
| Process docs | This repo | Yes |

## Public site facts (as of repo creation)

- Front page shows posts (`show_on_front`: posts)
- REST API available at `/wp-json/`
- Elementor-related namespaces present (Elementor hosting / Elementor One)
- Recent content themes: builds, FPV / Nano Long Range, Grok + Replit experiments

## Lighting (client-only)

Hourly palettes live in the child theme (`assets/lighting.js`). The browser reads local time and `localStorage`; the server never sees the hour. See [`lighting.md`](./lighting.md).

## Home page structure (current)

The child theme (`dabbuilds-child` 0.6.3, Capitol Daylight) renders the home page in `inc/home-sections.php`. Order:

1. Hero
2. What I do
3. Selected work
4. Experience (plain background)
5. Credentials (banded, `.dab-section--band`)
6. Build log (plain; latest 3 posts)
7. Contact strip (banded)

Neighboring sections alternate plain and banded backgrounds so no two adjacent sections share the same ground. The résumé page (`page-dabs-resume.php`) includes a text-only Certifications list from the same data in `inc/profile.php`. Credly badge images are self-hosted under `assets/badges/`. Change log: [`changes/2026-11-24-credly-credentials.md`](./changes/2026-11-24-credly-credentials.md).

