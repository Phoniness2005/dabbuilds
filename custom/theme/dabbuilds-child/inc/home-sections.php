<?php
/**
 * Home page sections, in order:
 * 1) Hero  2) What I do  3) Selected work  4) Experience  5) Credentials  6) Build log (latest 3)  7) Contact strip
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
 * @return array<string, mixed>
 */
function dabbuilds_child_hero_image(): array {
	$img      = array(
		'url'    => dabbuilds_child_theme_still_url( 'hero.jpg' ),
		'alt'    => '',
		'width'  => 1200,
		'height' => 1500,
	);
	$filtered = apply_filters( 'dabbuilds_child_hero_image', $img );
	if ( ! is_array( $filtered ) ) {
		return $img;
	}
	return array(
		'url'    => ( isset( $filtered['url'] ) && is_string( $filtered['url'] ) ) ? $filtered['url'] : '',
		'alt'    => ( isset( $filtered['alt'] ) && is_string( $filtered['alt'] ) ) ? $filtered['alt'] : '',
		'width'  => ( isset( $filtered['width'] ) && is_numeric( $filtered['width'] ) ) ? (int) $filtered['width'] : 1200,
		'height' => ( isset( $filtered['height'] ) && is_numeric( $filtered['height'] ) ) ? (int) $filtered['height'] : 1500,
	);
}

/**
 * Selected work cards. Image is optional (slug of a theme still).
 *
 * @return list<array<string, mixed>>
 */
function dabbuilds_child_selected_work(): array {
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
function dabbuilds_child_section_head( $eyebrow, $title, $id ): void {
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
function dabbuilds_child_render_hero(): void {
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
				<p class="dab-eyebrow">Daniel Bryant</p>
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
			<?php
			$hero_url = ( isset( $img['url'] ) && is_string( $img['url'] ) ) ? $img['url'] : '';
			$hero_alt = ( isset( $img['alt'] ) && is_string( $img['alt'] ) ) ? $img['alt'] : '';
			$hero_w   = ( isset( $img['width'] ) && is_numeric( $img['width'] ) ) ? (int) $img['width'] : 0;
			$hero_h   = ( isset( $img['height'] ) && is_numeric( $img['height'] ) ) ? (int) $img['height'] : 0;
			?>
			<figure class="dab-hero__frame<?php echo '' === $hero_url ? ' is-placeholder' : ''; ?>">
				<?php if ( '' !== $hero_url ) : ?>
					<img
						class="dab-hero__img"
						src="<?php echo esc_url( $hero_url ); ?>"
						alt="<?php echo esc_attr( $hero_alt ); ?>"
						width="<?php echo (int) $hero_w; ?>"
						height="<?php echo (int) $hero_h; ?>"
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
function dabbuilds_child_render_pillars(): void {
	?>
	<section class="dab-section dab-pillars" aria-labelledby="dab-pillars-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'What I do', 'Three disciplines, one habit: do it right.', 'dab-pillars-title' ); ?>
			<div class="dab-cards dab-cards--3">
				<?php
				$dab_n = 0;
				foreach ( dabbuilds_child_pillars() as $p ) :
					if ( $dab_n >= Dabbuilds_Child_Bounds::PILLARS ) {
						break;
					}
					++$dab_n;
					if ( ! isset( $p['num'], $p['title'], $p['body'] ) || ! is_string( $p['num'] ) || ! is_string( $p['title'] ) ) {
						continue;
					}
					if ( ! is_string( $p['body'] ) || ! isset( $p['tags'] ) || ! is_array( $p['tags'] ) ) {
						continue;
					}
					?>
					<article class="dab-card dab-pillar">
						<p class="dab-pillar__num" aria-hidden="true"><?php echo esc_html( $p['num'] ); ?></p>
						<h3 class="dab-card__title"><?php echo esc_html( $p['title'] ); ?></h3>
						<p class="dab-card__body"><?php echo esc_html( $p['body'] ); ?></p>
						<ul class="dab-tags" aria-label="<?php echo esc_attr__( 'Skills', 'dabbuilds-child' ); ?>">
							<?php
							$dab_t = 0;
							foreach ( $p['tags'] as $t ) :
								if ( $dab_t >= Dabbuilds_Child_Bounds::TAGS ) {
									break;
								}
								++$dab_t;
								if ( ! is_string( $t ) ) {
									continue;
								}
								?>
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
function dabbuilds_child_render_work(): void {
	?>
	<section class="dab-section dab-section--band dab-work" id="dab-work" aria-labelledby="dab-work-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'Selected work', 'Things you can open and use.', 'dab-work-title' ); ?>
			<div class="dab-cards dab-cards--3">
				<?php
				$dab_n = 0;
				foreach ( dabbuilds_child_selected_work() as $w ) :
					if ( $dab_n >= Dabbuilds_Child_Bounds::WORK ) {
						break;
					}
					++$dab_n;
					if ( ! isset( $w['num'], $w['kind'], $w['title'], $w['body'], $w['url'], $w['cta'], $w['tags'] ) ) {
						continue;
					}
					if ( ! is_string( $w['num'] ) || ! is_string( $w['kind'] ) || ! is_string( $w['title'] ) || ! is_string( $w['body'] ) || ! is_string( $w['url'] ) || ! is_string( $w['cta'] ) || ! is_array( $w['tags'] ) ) {
						continue;
					}
					?>
					<article class="dab-card dab-work-card">
						<p class="dab-work-card__meta"><span><?php echo esc_html( $w['num'] ); ?></span> <?php echo esc_html( $w['kind'] ); ?></p>
						<h3 class="dab-card__title"><?php echo esc_html( $w['title'] ); ?></h3>
						<p class="dab-card__body"><?php echo esc_html( $w['body'] ); ?></p>
						<ul class="dab-tags">
							<?php
							$dab_t = 0;
							foreach ( $w['tags'] as $t ) :
								if ( $dab_t >= Dabbuilds_Child_Bounds::TAGS ) {
									break;
								}
								++$dab_t;
								if ( ! is_string( $t ) ) {
									continue;
								}
								?>
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
function dabbuilds_child_render_experience(): void {
	?>
	<section class="dab-section dab-experience" aria-labelledby="dab-exp-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'Experience', 'Where the work happened.', 'dab-exp-title' ); ?>
			<ol class="dab-timeline">
				<?php
				$dab_n = 0;
				foreach ( dabbuilds_child_experience() as $e ) :
					if ( $dab_n >= Dabbuilds_Child_Bounds::JOBS ) {
						break;
					}
					++$dab_n;
					if ( ! isset( $e['dates'], $e['role'], $e['org'] ) ) {
						continue;
					}
					if ( ! is_string( $e['dates'] ) || ! is_string( $e['role'] ) || ! is_string( $e['org'] ) ) {
						continue;
					}
					?>
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
function dabbuilds_child_render_log_rows( $query = null, $limit = 0 ): void {
	global $wp_query;
	$q = $query instanceof WP_Query ? $query : $wp_query;
	if ( ! $q instanceof WP_Query ) {
		echo '<ol class="dab-ledger__list"></ol>';
		return;
	}
	$count = 0;
	$cap   = Dabbuilds_Child_Bounds::LOG_ROWS;
	if ( $limit > 0 && $limit < $cap ) {
		$cap = $limit;
	}
	echo '<ol class="dab-ledger__list">';
	while ( $q->have_posts() && $count < $cap ) {
		$q->the_post();
		++$count;
		$permalink = get_permalink();
		$datetime  = get_the_date( DATE_W3C );
		$display   = get_the_date( 'M j, Y' );
		if ( ! is_string( $permalink ) ) {
			$permalink = '';
		}
		if ( ! is_string( $datetime ) ) {
			$datetime = '';
		}
		if ( ! is_string( $display ) ) {
			$display = '';
		}
		?>
		<li class="dab-ledger__item">
			<a class="dab-ledger__row" href="<?php echo esc_url( $permalink ); ?>">
				<time class="dab-ledger__date" datetime="<?php echo esc_attr( $datetime ); ?>"><?php echo esc_html( $display ); ?></time>
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
 * 6) Build log, latest 3.
 */
function dabbuilds_child_render_log_teaser(): void {
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
	<section class="dab-section dab-ledger" aria-labelledby="dab-log-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'Build log', 'Latest from the shop.', 'dab-log-title' ); ?>
			<?php dabbuilds_child_render_log_rows( $q, 3 ); ?>
			<p class="dab-section__more"><a class="dab-link-cta" href="<?php echo esc_url( home_url( '/build-log/' ) ); ?>">Full build log <span aria-hidden="true">&rarr;</span></a></p>
		</div>
	</section>
	<?php
}

/**
 * 7) Contact strip (also used at the foot of inner pages).
 */
function dabbuilds_child_render_contact_strip(): void {
	$c = dabbuilds_child_contact();
	?>
	<section class="dab-section dab-section--band dab-contact-strip" aria-labelledby="dab-contact-title">
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
function dabbuilds_child_page_head( $eyebrow, $title, $lede = '' ): void {
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
 * One Credly badge card. The whole card is the public badge link.
 *
 * @param array<string, string> $badge Frozen credential.
 */
function dabbuilds_child_render_credential_card( $badge ): void {
	if ( ! isset( $badge['name'], $badge['issuer'], $badge['year'], $badge['url'], $badge['image'] ) ) {
		return;
	}
	$src = dabbuilds_child_credential_image_url( $badge['image'] );
	if ( '' === $src ) {
		return;
	}
	$alt = $badge['name'] . ' badge';
	?>
	<a class="dab-cred-card" href="<?php echo esc_url( $badge['url'] ); ?>" target="_blank" rel="noopener" title="<?php echo esc_attr( $badge['name'] ); ?>">
		<span class="dab-cred-card__medallion">
			<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="112" height="112" loading="lazy" />
		</span>
		<span class="dab-cred-card__name"><?php echo esc_html( $badge['name'] ); ?></span>
		<span class="dab-cred-card__issuer"><?php echo esc_html( $badge['issuer'] ); ?></span>
		<span class="dab-cred-card__year"><?php echo esc_html( $badge['year'] ); ?></span>
	</a>
	<?php
}

/**
 * Grid of badge cards. Bounded by CREDENTIALS.
 *
 * @param list<array<string, string>> $badges Frozen credentials.
 */
function dabbuilds_child_render_credential_grid( $badges ): void {
	$class = 'dab-cred-grid';
	if ( count( $badges ) <= 4 ) {
		$class .= ' dab-cred-grid--few';
	}
	echo '<ul class="' . esc_attr( $class ) . '">';
	$n = 0;
	foreach ( $badges as $badge ) {
		if ( $n >= Dabbuilds_Child_Bounds::CREDENTIALS ) {
			break;
		}
		++$n;
		$item = 'dab-cred-grid__item';
		if ( $n > Dabbuilds_Child_Bounds::CREDENTIALS_MOBILE ) {
			$item .= ' dab-cred-grid__item--from-9';
		}
		if ( $n > Dabbuilds_Child_Bounds::CREDENTIALS_HOME ) {
			$item .= ' dab-cred-grid__item--from-11';
		}
		echo '<li class="' . esc_attr( $item ) . '">';
		dabbuilds_child_render_credential_card( $badge );
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * 5) Credentials. Banded, between plain Experience and plain Build log.
 */
function dabbuilds_child_render_credentials(): void {
	$all   = dabbuilds_child_credentials();
	$total = count( $all );
	if ( $total < 1 ) {
		return;
	}
	?>
	<section class="dab-section dab-section--band dab-credentials" aria-labelledby="dab-cred-title">
		<div class="dab-section__inner">
			<?php dabbuilds_child_section_head( 'Verified on Credly', 'Credentials', 'dab-cred-title' ); ?>
			<?php dabbuilds_child_render_credential_grid( $all ); ?>
			<?php if ( $total > Dabbuilds_Child_Bounds::CREDENTIALS_MOBILE ) : ?>
				<details class="dab-cred-more">
					<summary class="dab-cred-more__toggle">
						<span class="dab-cred-more__show">
							<?php
							/* translators: %d: total credential count. */
							echo esc_html( sprintf( __( 'Show all %d', 'dabbuilds-child' ), $total ) );
							?>
						</span>
						<span class="dab-cred-more__fewer"><?php echo esc_html__( 'Show fewer', 'dabbuilds-child' ); ?></span>
					</summary>
				</details>
			<?php endif; ?>
			<p class="dab-section__more"><a class="dab-link-cta" href="<?php echo esc_url( dabbuilds_child_credly_url() ); ?>" target="_blank" rel="noopener"><?php echo esc_html__( 'View all on Credly', 'dabbuilds-child' ); ?> <span aria-hidden="true">&rarr;</span></a></p>
		</div>
	</section>
	<?php
}

/**
 * Full home page body.
 */
function dabbuilds_child_render_home(): void {
	dabbuilds_child_render_hero();
	dabbuilds_child_render_pillars();
	dabbuilds_child_render_work();
	dabbuilds_child_render_experience();
	dabbuilds_child_render_credentials();
	dabbuilds_child_render_log_teaser();
	dabbuilds_child_render_contact_strip();
}
