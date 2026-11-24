# Power of 10 for dabbuilds.com

Adapted from Gerard Holzmann, “The Power of 10: Rules for Developing Safety-Critical Code” (NASA/JPL, 2006), for the languages in this repo. New theme, plugin, and script code should follow this. The live WordPress core, Hello Elementor, and Elementor are not in git and are out of scope.

## What this applies to

First-party code:

- `custom/theme/dabbuilds-child/` PHP and the theme JS in `assets/custom.js` and `assets/lighting.js`
- `custom/plugins/dabbuilds-hardening/`
- `scripts/*.sh` and `scripts/*.exp`

Exempt, and left unchanged except where a rule is called out below:

- `custom/theme/dabbuilds-child/play/` — the Wimbledon Pong pages and their images. Static game content, not the theme control plane.
- Binary theme assets: `assets/icons/`, `assets/stills/`, `assets/badges/`, and the play textures.
- `assets/custom.css` is declarative. The rules about recursion, allocation, and assertions do not map onto stylesheet rules. The one CSS change in the Power of 10 pass is the mobile divider alignment.
- `vendor/` and `node_modules/` are analyzer installs. They are gitignored and are not deployed.

## The rules here

1. **Simple control flow.** No `goto`, `eval`, `setjmp`, or recursion. The lighting refresh used to schedule itself. It is now `onLightTick` → `armLightTimer` → `setTimeout(onLightTick)`, with a fixed tick cap, so the call stack does not grow and the chain can be shown to stop.

2. **Fixed loop bounds.** Caps live in `Dabbuilds_Child_Bounds`. Render loops, the REST route scan (4096), deploy file walks (5000 files, 32 path parts, 32 plugins, 10000 SFTP commands), and the JS DOM walks stop at a literal ceiling. A `foreach` over a fixed list written in the function is already bounded by that list. Caps PHPStan can prove are unreachable are not added, because level `max` rejects that dead code.

3. **Nothing grows without a ceiling.** This is PHP, JS, and shell, so allocation is not banned outright. Arrays, query results, and SFTP command lists stop at the caps above. Queries that load posts set `posts_per_page`. The deploy script refuses to append past 10000 commands.

4. **Functions stay at or under 60 lines.** Each named PHP function is under that line count. JS uses the same ESLint rule. The outer IIFE in `custom.js` and `lighting.js` is the script scope (rule 6), not a routine, and ESLint is set with `IIFEs: false`. Shell helpers in `scripts/deploy-sftp.sh` are under 60 lines. The inline lighting boot in `functions.php` stays in `wp_head` so the first paint does not flash; it is not a separate module.

5. **Guards, not side-effecting asserts.** Use an early return, a skipped row, or `[[ ]] || { echo … >&2; exit 1; }`. Guards check types and bounds that can actually fail (request input, hook return values, filesystem paths, mixed arrays). They do not change output when the value is already valid. PHP `assert()` is not used. Constant arrays are not wrapped in checks PHPStan can prove never fire.

6. **Smallest scope.** PHP keeps WordPress’s `$wp_query` touch inside the one function that needs it, and only after an `instanceof WP_Query` check. JS uses `const` / `let` inside an IIFE. The one intentional global is `window.DABLighting`. Shell keeps the SFTP command list in the script, capped, and does not export it.

7. **Check returns, validate parameters, escape output.** Theme output goes through `esc_html`, `esc_url`, `esc_attr`, or `wp_kses_post`. Request paths are sanitized when they are strings. `WP_Error` and non-strings from hooks recover to a safe default (`''` or the unfiltered value when that value is already a string). Filter callbacks that replace `__return_false` and `__return_empty_string` are named functions in the plugin.

8. **No metaprogramming.** No `eval`, `create_function`, or variable functions. Deploy modes (`--yes`, `--dry-run`, `--theme-only`, `--plugins-only`) are command-line switches, not build flags. The Expect scripts send a fixed SFTP program; the batch file is data.

9. **One level of indirection, named framework callbacks.** Do not call a function through a variable name (`call_user_func` on a request string, `obj[name]()`). WordPress `add_action` / `add_filter` and DOM listeners are allowed when the callback has a name. Named exceptions:
   - Theme: `dabbuilds_child_enqueue_assets`, `dabbuilds_child_lighting_boot`, `dabbuilds_child_resource_hints`, `dabbuilds_child_hide_home_archive_title`, `dabbuilds_child_force_templates`, `dabbuilds_child_serve_play_game`, `dabbuilds_child_rewrite_game_url`, `dabbuilds_child_elementor_archive_hero`, `dabbuilds_child_route_status`, `dabbuilds_child_route_title`, `dabbuilds_child_route_body_class`, `dabbuilds_child_home_title_parts`, `dabbuilds_child_redirect_resume_attachment`, and the head-meta printers.
   - Plugin: `dabbuilds_hardening_send_headers`, `dabbuilds_hardening_hide_versions`, `dabbuilds_hardening_strip_ver`, `dabbuilds_hardening_return_empty_string`, `dabbuilds_hardening_return_false`, `dabbuilds_hardening_no_xmlrpc_methods`, `dabbuilds_hardening_comments_closed`, `dabbuilds_hardening_lock_user_rest`, `dabbuilds_hardening_cors`, `dabbuilds_hardening_replace_cors`, `dabbuilds_hardening_block_author_enum`, `dabbuilds_hardening_login_error`, `dabbuilds_hardening_disallow_file_edit`.
   - JS: `onScroll`, `onPrintClick`, `onModeClick`, `onLightTick` (`setTimeout`), `bindControls` (`DOMContentLoaded`).

10. **Analyzers at the strictest practical setting.** See below. CI is `.github/workflows/power-of-10.yml`.

## Analyzers

| Check | Setting |
| --- | --- |
| `php -l` | Every first-party PHP file |
| PHPStan | `phpstan.neon`, level `max`, with `szepeviktor/phpstan-wordpress` |
| PHPCS | `phpcs.xml`, WordPress standard |
| ESLint | `eslint.config.js`, recommended plus the strict ruleset, `max-lines-per-function` 60 |
| ShellCheck | `shellcheck -S style` on `scripts/*.sh` |
| Shell scripts | `set -euo pipefail` |
| Expect | `scripts/*.exp` is Tcl. ShellCheck does not parse it. The command loops are capped in the script. |

Python, mypy, Ruff, Swift, and SwiftLint do not apply. There is no Python or Swift in this repo.

`composer.json` and `package.json` are dev-only. Do not deploy `vendor/` or `node_modules/`.

## Deploy

The owner deploys the theme. Do not run `./scripts/deploy-sftp.sh --yes` unless Daniel asks.
