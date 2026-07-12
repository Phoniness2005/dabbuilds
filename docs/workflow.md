# Workflow — change tracking and deploy

## Goal

Every meaningful site change that *can* live in code should:

1. Happen (or be reflected) in this repo  
2. Be reviewable on GitHub (commit or PR)  
3. Then be applied to Elementor Cloud  

## Day-to-day loop (with Grok + Cursor)

```text
1. Open ~/Projects/dabbuilds in Cursor
2. Create a branch:  git checkout -b feature/short-name
3. Run:              grok
4. Describe the change
5. Review diffs in Cursor
6. Commit:           git add -A && git commit -m "..."
7. Push:             git push -u origin HEAD
8. Open PR:          gh pr create
9. Deploy approved files to Elementor Cloud (method below)
10. Verify live site
```

## What to put in git vs only in Elementor

| Do in GitHub | Do in Elementor / WP Admin |
|--------------|----------------------------|
| Custom CSS/JS | Drag-and-drop section layout |
| Child theme PHP templates | Writing a blog post |
| Custom plugins | Installing marketplace plugins |
| Template JSON exports | Quick visual tweaks |
| Docs and runbooks | Media uploads |

**Rule of thumb:** if an agent should redo or improve it later, put it in git.

## Deploy (Elementor Cloud SFTP — primary)

See **[deploy.md](./deploy.md)** for the full approve → upload flow.

```bash
./scripts/deploy-sftp.sh --dry-run   # preview
./scripts/deploy-sftp.sh --yes       # live upload (only after you approve)
```

### Other options

- **WP Admin upload:** zip a plugin/theme → Plugins / Themes → Upload  
- **Elementor UI:** layout/content still edited in Elementor; export templates to `elementor/templates/` when you want them in git  
- **Local WordPress (later):** LocalWP/Docker for offline testing — see `hosting-options.md`

## Branching

- `main` — known-good customizations  
- `feature/*` — work in progress  
- Prefer PRs once you are comfortable (`gh pr create`)

## First agent tasks (good starters)

1. Add site-wide custom CSS (typography, colors, mobile fixes) in `custom/css/`  
2. Create a minimal child theme scaffold under `custom/theme/`  
3. Inventory public pages/posts via REST API into `content/` notes  
4. Export one Elementor template and store under `elementor/templates/`  
