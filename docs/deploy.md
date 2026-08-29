# Deploy to Elementor Cloud (approve → SFTP)

## Model

```text
  Grok edits files in ~/Projects/dabbuilds
            │
            ▼
  You review in Cursor / GitHub (diff, commit, PR)
            │
            ▼
  You explicitly approve deploy
            │
            ▼
  ./scripts/deploy-sftp.sh --yes
            │
            ▼
  Live site: https://dabbuilds.com
```

Grok **will not** upload to the live site unless you clearly approve (e.g. “deploy this” or run the script with `--yes`). The script also refuses to run without `--yes`.

## Credentials

Stored only in **`.env.local`** (gitignored):

```bash
SFTP_HOST=sftp.elementor.cloud
SFTP_PORT=32022
SFTP_USER=...
SFTP_PASSWORD=...
SFTP_REMOTE_ROOT=/html
```

Never commit `.env.local`. If credentials were pasted in chat, rotate them in Elementor Cloud when convenient.

## Commands

```bash
cd ~/Projects/dabbuilds

# List remote WordPress content
./scripts/sftp-ls.sh
./scripts/sftp-ls.sh /html/wp-content/themes

# Preview what would upload (no changes)
./scripts/deploy-sftp.sh --dry-run

# After you approve
./scripts/deploy-sftp.sh --yes
./scripts/deploy-sftp.sh --yes --theme-only
./scripts/deploy-sftp.sh --yes --plugins-only
```

## What gets deployed

| Local path | Remote path |
|------------|-------------|
| `custom/theme/dabbuilds-child/` | `/html/wp-content/themes/dabbuilds-child/` |
| `custom/theme/dabbuilds-child/play/` | `/html/play/` (static copy; Elementor only serves `.jpg` from the web root) |
| `custom/plugins/<name>/` | `/html/wp-content/plugins/<name>/` |

## First-time theme activation

After the first successful theme deploy:

1. Log in: https://dabbuilds.com/wp-admin  
2. **Appearance → Themes**  
3. Activate **DAB Builds Child**  
4. Confirm the site still looks correct (Hello Elementor parent must remain installed)

Custom security plugin: `custom/plugins/dabbuilds-hardening/` (see [`security.md`](./security.md)).

## What this does *not* deploy

- Blog posts / pages in the database  
- Elementor layout widgets (edit those in Elementor, or export JSON into `elementor/templates/`)  
- Media library uploads  
- WordPress core / Elementor plugin updates  

## Agent rules (summary)

1. Edit only under this repo (`custom/`, `docs/`, etc.).  
2. Commit to GitHub for history.  
3. Deploy only after human approval.  
4. Prefer child-theme CSS/JS for visual tweaks that should be versioned.
