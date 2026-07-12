# Hosting — Elementor Cloud

## Confirmed

- Live URL: https://dabbuilds.com
- Host header / stack signal: `x-powered-by: Elementor Cloud`
- CDN: Cloudflare in front of the origin
- WordPress REST: https://dabbuilds.com/wp-json/

## Account access (human)

1. Elementor account: https://my.elementor.com  
2. WordPress admin: https://dabbuilds.com/wp-admin  

## What to look for in Elementor Cloud

When logged into the site subscription, note whether these exist:

- [ ] SFTP / SSH credentials  
- [ ] Git deployment  
- [ ] Staging environment  
- [ ] File manager  
- [ ] Ability to install a child theme / upload plugins  

Fill in below when you have them (do **not** put real passwords in git — only hostnames/usernames if non-sensitive, or keep credentials in a password manager).

### SFTP (fill later)

```text
Host:
Port:
Username:
Password: (password manager only)
Remote path:
```

### WordPress Application Password (for REST API; optional)

Create in WP Admin → Users → Profile → Application Passwords.  
Store only in a local env file (gitignored) if agents need API access for a session.

```bash
# example local-only file: .env.local (gitignored)
WP_URL=https://dabbuilds.com
WP_USER=
WP_APP_PASSWORD=
```
