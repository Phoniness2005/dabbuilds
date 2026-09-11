# The site as an object: hourly light, and why the cyan had to go

It has been a while since the last site-tinkering post, and this time the work was the look itself. I used Grok to help me move faster, then I spent more time than I expected making the lighting actually follow a clock instead of just flipping a dark-mode switch.

The posts, the resume, Pong, and the nav did not move. The object around them did.

## I looked at Body Shop, not a template pack

There is a small industrial design studio in San Francisco called [Body Shop](https://www.body-shop.co/). They are not the cosmetics company. They design things that are supposed to live in a house without becoming a spectacle: the 1X NEO home robot, a bedside Dream Recorder, Quiet Hours tools, Walden timers that mark time with sand and candles instead of a notification.

I am not them, and this site is not one of their products. What I stole was the attitude. Restraint. Warm materials. The object is the hero and the chrome recedes. Time as something you feel, not something that pings you.

The old dabbuilds look was a void-black page with electric cyan I had borrowed from SpaceX / xAI energy. Fine for a launch trailer. Wrong for a build log that also has a drone on a table and a Pong clone in Wimbledon colors. Cyan had to go.

## What you are looking at

Bone paper and brass by day. Charcoal and a low nightstand wash after dusk. Hairline seams instead of glow grids. The header still has Build log, Projects, and Resume. Auto / Day / Night sits next to them so you are not stuck if the clock is wrong for your eyes.

The light follows *your* local clock, not mine, and it steps once an hour. Morning is not the same as 3 p.m., and 3 p.m. is not dusk. There is no location permission. The browser already knows what hour it is.

If you want to see a specific hour without waiting, add `?dab-hour=12` or `?dab-hour=22` to the URL. That is also how I took the screenshots.

## How to put this on your own site

The source is public: [github.com/Phoniness2005/dabbuilds](https://github.com/Phoniness2005/dabbuilds).

The file that matters for lighting is [`custom/theme/dabbuilds-child/assets/lighting.js`](https://github.com/Phoniness2005/dabbuilds/blob/main/custom/theme/dabbuilds-child/assets/lighting.js). The write-up for copying it onto another WordPress child theme is [`docs/lighting.md`](https://github.com/Phoniness2005/dabbuilds/blob/main/docs/lighting.md). Design notes, without anybody else’s photos, are in [`docs/design-language.md`](https://github.com/Phoniness2005/dabbuilds/blob/main/docs/design-language.md).

You need the 24 palettes, a tiny boot script so the first paint is not the wrong period, the Auto / Day / Night buttons, and CSS that actually reads the variables. That is the whole trick.

## Still iterating

Pong is still Wimbledon green on purpose. The Nano Long Range is still in progress with my dad. I am sure I will notice a contrast bug at some odd hour the first time I open this on a phone in a dark room, the same way I found the Pong menu bugs by handing it to my wife.

As usual I will keep iterating.
