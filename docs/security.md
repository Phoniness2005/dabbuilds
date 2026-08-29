# Security — dabbuilds.com

Notes from the 2026-08-29 review. Code that can live in git is in this repo. WordPress database / media / host files are called out separately.

## What is in git

| Path | Role |
|------|------|
| `custom/plugins/dabbuilds-hardening/` | Security headers, REST user lockdown, XML-RPC off, version hiding, author-archive block, login-error genericization, CORS limited to this origin |
| `custom/theme/dabbuilds-child/` | Resume URL helper, `/play/` game host (not a security control) |

Deploy the plugin with:

```bash
./scripts/deploy-sftp.sh --yes --plugins-only
```

Then activate **DAB Builds Hardening** in WP Admin → Plugins.

## Live WordPress changes already applied (REST API, 2026-08-29)

These are **not** represented as files in git:

- Uploaded `Resume-2026-V1.doc` as media id `179` and pointed the DAB's Resume page at it
- Closed comments and pingbacks sitewide (`default_comment_status` / `default_ping_status`) and on existing posts
- Deleted unused **Envato Elements** 2.0.16 (plugin closed on WordPress.org)
- Installed **Code Snippets** 3.10.1 and activated snippet **“DAB Builds Hardening”** (id `5`) — same PHP as the plugin above

SFTP deploy on 2026-08-29 copied the plugin and child theme (including `/play/`) to Elementor Cloud, activated **DAB Builds Hardening**, and removed the Code Snippets stopgap. Public `readme.html` and `license.txt` were deleted over SFTP.

## Host-controlled leftovers

- `X-Powered-By: Elementor Cloud` is set by Elementor Host
- Keep SFTP credentials only in `.env.local` (never git). Create the SFTP user with expiry **Never** so deploys keep working.

## Intentionally unchanged

- Public resume download (by design)
- Inactive **Elementor** 4.1.4 (left installed for Elementor Cloud)
- XML-RPC already returns HTTP 422 at the host
- Registration remains off
