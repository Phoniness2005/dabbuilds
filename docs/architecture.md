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
