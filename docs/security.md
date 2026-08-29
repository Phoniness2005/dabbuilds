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

Code Snippets is a stopgap because Elementor Cloud SFTP credentials in `.env.local` no longer authenticate. After a successful SFTP plugin deploy, deactivate that snippet and uninstall Code Snippets.

## Still blocked without SFTP (or Elementor file manager)

- Copy `custom/plugins/dabbuilds-hardening/` onto the server and activate it as a real plugin
- Copy the child-theme `/play/` files and `functions.php` so `/play/` is not a 404
- Delete public core files `readme.html` and `license.txt` (static; PHP cannot hide them)
- `X-Powered-By: Elementor Cloud` is host-controlled

Rotate the SFTP password in Elementor Cloud and put the new value only in `.env.local` (never git).

## Intentionally unchanged

- Public resume download (by design)
- Inactive **Elementor** 4.1.4 (left installed for Elementor Cloud)
- XML-RPC already returns HTTP 422 at the host
- Registration remains off
