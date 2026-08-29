# Wimbledon Pong

Hosted at `/play/` from the child theme. Source of the game itself is also in [Phoniness2005/grok-replit-open-2025](https://github.com/Phoniness2005/grok-replit-open-2025).

## Versions

| Path | What it is |
|---|---|
| `/play/` | Hub. Version 2 on top, version 1 underneath. |
| `/play/v2/` | August 2026 rebuild. |
| `/play/v1/` | Original 2025 Grok/Replit build, unchanged. |

`functions.php` serves the HTML without WordPress chrome. Do not place a real `/html/play/` directory on the web root: Elementor/nginx treats it as a static folder, directory URLs 403, and `/play/` never reaches PHP. Version 2 loads textures from the theme URL on dabbuilds.com (`/wp-content/themes/dabbuilds-child/play/v2/assets/`) and from relative `assets/` on GitHub Pages.

## Version 1 analysis (what was wrong)

The original game was a 1200×900 canvas with CSS `border: 8px purple` and `box-shadow: 0 0 0 4px white`. Collision used the canvas edge, not the grass. That led to:

- Score and stats positioned `absolute` against the *page*, so they drifted off the court inside an iframe.
- Menus rebuilt with `innerHTML` every frame. Holding an arrow key skipped options.
- Menus looked clickable (`cursor: pointer`) and were not.
- Instructions sat at the bottom of the window, not the court.
- Amateur / Tour / Pro shared one AI. Pro used `error: 0` and tracked the ball every frame. Amateur was the same tracker with jitter.
- Crowd bands were 75px of purple. The ball and paddles could travel through them.
- Paddles were flat rectangles. Grass was a solid fill. The net was dashed squares that ran through the crowd.

## Version 2 (what changed)

**UI.** HTML overlay instead of canvas text. Click or keyboard. No key-repeat on menus. Overlay is rebuilt only when the state changes. HUD is in a grid above the court, so it stays lined up in an iframe. Mouse and touch move the left paddle while the ball is in play; WASD is ignored for a moment after the pointer moves so they do not fight. Pause is `P`. Esc goes to the menu (and back one step on the difficulty screen).

**Opponent.** Three distinct AIs:

- Amateur: slow, late reaction (~38 frames), large aim error, occasional full miss, drifts back to centre when the ball is going away.
- Tour: club-match pace, modest bounce prediction, still beatable.
- Pro: reads wall bounces, faster acceleration, small persistent error (never zero), chases when the ball is leaving.

**Graphics.** The white and purple frame is *drawn on the canvas*, not added as a CSS border fighting the collision box. Playable grass is `PLAY_TOP`…`PLAY_BOTTOM`. Ball and paddles cannot enter the stands. Surfaces are tiled photographs (grass, seat cloth, light oak, dark walnut). Mowing stripes, tramlines, a centre net with mesh, a tennis-ball seam, and a short “Ready / Play” hold after each point.

## Files

```
custom/theme/dabbuilds-child/play/
  index.html          hub
  v1/index.html       original game
  v2/index.html       rebuild
  v2/assets/
    grass.jpg
    seats.jpg
    wood-light.jpg
    wood-dark.jpg
```
