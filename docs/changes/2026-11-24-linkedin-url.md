# 2026-11-24 — Custom LinkedIn URL (theme 0.6.2)

**Theme:** dabbuilds-child 0.6.2 (`style.css`). Asset query `20261124-linkedin-url-1`.

Public LinkedIn links now use https://www.linkedin.com/in/daniel-a-bryant. The old `/in/daniel-bryant-34749943b` URL no longer resolves.

The only code change is `dabbuilds_child_contact()` in `inc/profile.php`. Footer, home, and contact pages already read that value. Historical notes under `docs/changes/` were left as written on those dates.

Deploy by uploading `dabbuilds-child-0.6.2.zip` in wp-admin (Themes > Upload, replace the active theme) and clearing the hosting cache. This log does not record a live publish.
