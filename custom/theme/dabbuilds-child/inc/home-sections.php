<?php
/**
 * Home page sections, in order:
 * 1) Hero  2) What I do  3) Selected work  4) Experience  5) Build log (latest 3)  6) Contact strip
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hero image. Empty URL = framed placeholder slot.
 *
 * Hook when the real photo is ready (a lit object shot or a daylight portrait):
 * add_filter( 'dabbuilds_child_hero_image', fn() => array( 'url' => '...', 'alt' => '...', 'width' => 1200, 'height' => 1500 ) );
 * or drop assets/stills/hero.jpg into the theme.
 *
 * @return array
 */
function dabbuilds_child_hero_image() {
	$img = array(
		'url'    => dabbuilds_child_theme_still_url( 'hero.jpg' ),
		'alt'    => '',
		'width'  => 1200,
		'height' => 1500,
	);
	return (array) apply_filters( 'dabbuilds_child_hero_image', $img );
}

/**
 * Selected work cards. Image is optional (slug of a theme still).
 *
 * @return array
 */
function dabbuilds_child_selected_work() {
	return array(
		array(
			'num'   => '01',
			'kind'  => 'Live site',
			'title' => 'dabbuilds.com',
			'body'  => 'This site. A WordPress child theme kept in git, with a native resume, a day and night lighting system, and a small security plugin.',
			'tags'  => array( 'WordPress', 'PHP', 'CSS' ),
			'url'   => 'https://github.com/Phoniness2005/dabbuilds',
			'cta'   => 'View source',
		),
		array(
			'num'   => '02',
			'kind'  => 'Game',
			'title' => 'Wimbledon Pong',
			'body'  => 'A Wimbledon-colored Pong game built in the browser with Grok. Both versions run right here on the site.',
			'tags'  => array( 'JavaScript', 'AI-assisted' ),
			'url'   => home_url( '/play/' ),
			'cta'   => 'Play',
		),
		array(
			'num'   => '03',
			'kind'  => 'Build',
			'title' => 'Nano Long Range V1',
			'body'  => 'A 3D-printed FPV drone I am building with my dad, combining two open Thingiverse designs and adapting them to a newer flight controller.',
			'tags'  => array( 'CAD', '3D printing', 'FPV' ),
			'url'   => home_url( '/nano-long-range-v1-update/' ),
			'cta'   => 'Read the build',
		),
	);
}

/**
 * Section heading block.
 *
 * @param string $eyebrow Eyebrow label.
 * @param string $title   Heading.
 * @param string $id      Heading id.
 */
function dabbuilds_child_section_head( $eyebrow, $title, $id ) {
	?>
	<header class="dab-section__head">
		<p class="dab-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<h2 class="dab-section__title" id="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $title ); ?></h2>
		<?php dabbuilds_child_divider(); ?>
	</header>
	<?php
}

/**
 * 1) Hero.
 */
function dabbuilds_child_render_hero() {
	static $printed = false;
	if ( $printed || ! dabbuilds_child_is_blog_index() ) {
		return;
	}
	$printed = true;
	$img     = dabbuilds_child_hero_image();
	?>
	<section class="dab-hero" aria-labelledby="dab-hero-title">
		<div class="dab-hero__inner">
			<div class="dab-hero__copy">
				<p class="dab-eyebrow">Daniel Bryant &middot; Pella, Iowa</p>
				<h1 class="dab-hero__title" id="dab-hero-title">
					<span>Systems.</span>
					<span>Security.</span>
					<span>Things that get built.</span>
				</h1>
				<p class="dab-hero__lede">
					IT and systems support, a machinist's eye for tolerances, and a home shop for CAD, 3D printing, and code.
				</p>
				<div class="dab-hero__actions">
					<a class="dab-btn dab-btn--primary" href="#dab-work"><?php echo esc_html__( 'See my work', 'dabbuilds-child' ); ?></a>
					<a class="dab-link-cta" href="<?php echo esc_url( home_url( '/dabs-resume/' ) ); ?>"><?php echo esc_html__( 'Résumé', 'dabbuilds-child' ); ?> <span aria-hidden="true">&rarr;</span></a>
				</div>
			</div>
			<figure class="dab-hero__frame<?php echo empty( $img['url'] ) ? ' is-placeholder' : ''; ?>">
				<?php if ( ! empty( $img['url'] ) ) : ?>
					<img
						class="dab-hero__img"
						src="<?php echo esc_url( $img['url'] ); ?>"
						alt="<?php echo esc_attr( $img['alt'] ); ?>"
						width="<?php echo (int) $img['width']; ?>"
						height="<?php echo (int) $img['height']; ?>"
						loading="eager"
						decoding="async"
					/>
				<?php else : ?>
					<!-- Hero photo slot: replace with a lit object shot or daylight portrait (see dabbuilds_child_hero_image). -->
					<div class="dab-hero__placeholder" aria-hidden="true">
						<img src="<?php echo esc_url( dabbuilds_child_icon_url( 'favicon-day-512.png' ) ); ?>" alt="" width="200" height="200" class="dab-hero__mark dab-hero__mark--day" />
						<img src="<?php echo esc_url( dabbuilds_child_icon_url( 'favicon-night-512.png' ) ); ?>" alt="" width="200" height="200" class="dab-hero__mark dab-hero__mark--night" />
					</div>
				<?php endif; ?>
			</figure>
		</div>
	</section>
	<?php
}

/**
 * 2) What I do.
 */
function dabbuilds_child_render_pillars() {
	?>
	<section class="dab-section dab-pillars" aria-labelledby="dab-pillars-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'What I do', 'Three disciplines, one habit: do it right.', 'dab-pillars-title' ); ?>
			<div class="dab-cards dab-cards--3">
				<?php foreach ( dabbuilds_child_pillars() as $p ) : ?>
					<article class="dab-card dab-pillar">
						<p class="dab-pillar__num" aria-hidden="true"><?php echo esc_html( $p['num'] ); ?></p>
						<h3 class="dab-card__title"><?php echo esc_html( $p['title'] ); ?></h3>
						<p class="dab-card__body"><?php echo esc_html( $p['body'] ); ?></p>
						<ul class="dab-tags" aria-label="<?php echo esc_attr__( 'Skills', 'dabbuilds-child' ); ?>">
							<?php foreach ( $p['tags'] as $t ) : ?>
								<li><?php echo esc_html( $t ); ?></li>
							<?php endforeach; ?>
						</ul>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * 3) Selected work.
 */
function dabbuilds_child_render_work() {
	?>
	<section class="dab-section dab-section--band dab-work" id="dab-work" aria-labelledby="dab-work-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'Selected work', 'Things you can open and use.', 'dab-work-title' ); ?>
			<div class="dab-cards dab-cards--3">
				<?php foreach ( dabbuilds_child_selected_work() as $w ) : ?>
					<article class="dab-card dab-work-card">
						<p class="dab-work-card__meta"><span><?php echo esc_html( $w['num'] ); ?></span> <?php echo esc_html( $w['kind'] ); ?></p>
						<h3 class="dab-card__title"><?php echo esc_html( $w['title'] ); ?></h3>
						<p class="dab-card__body"><?php echo esc_html( $w['body'] ); ?></p>
						<ul class="dab-tags">
							<?php foreach ( $w['tags'] as $t ) : ?>
								<li><?php echo esc_html( $t ); ?></li>
							<?php endforeach; ?>
						</ul>
						<a class="dab-card__link" href="<?php echo esc_url( $w['url'] ); ?>"><?php echo esc_html( $w['cta'] ); ?> <span aria-hidden="true">&rarr;</span></a>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="dab-section__more"><a class="dab-link-cta" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">All work <span aria-hidden="true">&rarr;</span></a></p>
		</div>
	</section>
	<?php
}

/**
 * 4) Experience snapshot (dates only).
 */
function dabbuilds_child_render_experience() {
	?>
	<section class="dab-section dab-experience" aria-labelledby="dab-exp-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'Experience', 'Where the work happened.', 'dab-exp-title' ); ?>
			<ol class="dab-timeline">
				<?php foreach ( dabbuilds_child_experience() as $e ) : ?>
					<li class="dab-timeline__row">
						<p class="dab-timeline__dates"><?php echo esc_html( $e['dates'] ); ?></p>
						<div class="dab-timeline__body">
							<h3 class="dab-timeline__role"><?php echo esc_html( $e['role'] ); ?></h3>
							<p class="dab-timeline__org"><?php echo esc_html( $e['org'] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
			<p class="dab-timeline__edu">
				<strong>Education:</strong> B.A., General Studies, Mathematics concentration, Southern New Hampshire University (in progress, expected June 2027). NTMA Machinist Training Graduate, 2014.
			</p>
			<p class="dab-section__more"><a class="dab-link-cta" href="<?php echo esc_url( home_url( '/dabs-resume/' ) ); ?>">Full résumé <span aria-hidden="true">&rarr;</span></a></p>
		</div>
	</section>
	<?php
}

/**
 * Build log rows.
 *
 * @param WP_Query|null $query Query (null = main loop).
 * @param int           $limit Max rows (0 = all).
 */
function dabbuilds_child_render_log_rows( $query = null, $limit = 0 ) {
	global $wp_query;
	$q     = $query ? $query : $wp_query;
	$count = 0;
	echo '<ol class="dab-ledger__list">';
	while ( $q->have_posts() ) {
		$q->the_post();
		++$count;
		?>
		<li class="dab-ledger__item">
			<a class="dab-ledger__row" href="<?php echo esc_url( get_permalink() ); ?>">
				<time class="dab-ledger__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></time>
				<span class="dab-ledger__title"><?php echo wp_kses_post( get_the_title() ); ?></span>
				<span class="dab-ledger__arrow" aria-hidden="true">&rarr;</span>
			</a>
		</li>
		<?php
		if ( $limit && $count >= $limit ) {
			break;
		}
	}
	echo '</ol>';
	if ( $query ) {
		wp_reset_postdata();
	}
}

/**
 * 5) Build log, latest 3.
 */
function dabbuilds_child_render_log_teaser() {
	$q = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	if ( ! $q->have_posts() ) {
		return;
	}
	?>
	<section class="dab-section dab-section--band dab-ledger" aria-labelledby="dab-log-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'Build log', 'Latest from the shop.', 'dab-log-title' ); ?>
			<?php dabbuilds_child_render_log_rows( $q, 3 ); ?>
			<p class="dab-section__more"><a class="dab-link-cta" href="<?php echo esc_url( home_url( '/build-log/' ) ); ?>">Full build log <span aria-hidden="true">&rarr;</span></a></p>
		</div>
	</section>
	<?php
}

/**
 * 6) Contact strip (also used at the foot of inner pages).
 */
function dabbuilds_child_render_contact_strip() {
	$c = dabbuilds_child_contact();
	?>
	<section class="dab-section dab-contact-strip" aria-labelledby="dab-contact-title">
		<div class="dab-section__inner dab-contact-strip__inner">
			<div>
				<p class="dab-eyebrow">Contact</p>
				<h2 class="dab-section__title" id="dab-contact-title">Get in touch.</h2>
				<p class="dab-contact-strip__lede">Email is the fastest way to reach me.</p>
			</div>
			<div class="dab-contact-strip__actions">
				<a class="dab-btn dab-btn--primary" href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a>
				<a class="dab-link-cta" href="<?php echo esc_url( $c['linkedin'] ); ?>" rel="noopener noreferrer">LinkedIn <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Inner page heading.
 *
 * @param string $eyebrow Eyebrow.
 * @param string $title   H1.
 * @param string $lede    Optional lede.
 */
function dabbuilds_child_page_head( $eyebrow, $title, $lede = '' ) {
	?>
	<section class="dab-page-head">
		<div class="dab-section__inner">
			<p class="dab-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h1 class="dab-page-title entry-title"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $lede ) : ?>
				<p class="dab-page-lede"><?php echo esc_html( $lede ); ?></p>
			<?php endif; ?>
			<?php dabbuilds_child_divider(); ?>
		</div>
	</section>
	<?php
}

/**
 * Full home page body.
 */
function dabbuilds_child_render_home() {
	dabbuilds_child_render_hero();
	dabbuilds_child_render_pillars();
	dabbuilds_child_render_work();
	dabbuilds_child_render_experience();
	dabbuilds_child_render_log_teaser();
	dabbuilds_child_render_contact_strip();
}
