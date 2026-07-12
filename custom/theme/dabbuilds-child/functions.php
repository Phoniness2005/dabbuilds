<?php
/**
 * DAB Builds child theme (Hello Elementor).
 *
 * Source of truth: https://github.com/Phoniness2005/dabbuilds
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue fonts, parent/child styles, and custom assets.
 */
function dabbuilds_child_enqueue_assets() {
	wp_enqueue_style(
		'dabbuilds-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'hello-elementor',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'hello-elementor' )->get( 'Version' )
	);

	wp_enqueue_style(
		'dabbuilds-child',
		get_stylesheet_uri(),
		array( 'hello-elementor', 'dabbuilds-fonts' ),
		wp_get_theme()->get( 'Version' )
	);

	$custom_css = get_stylesheet_directory() . '/assets/custom.css';
	if ( file_exists( $custom_css ) ) {
		wp_enqueue_style(
			'dabbuilds-custom',
			get_stylesheet_directory_uri() . '/assets/custom.css',
			array( 'dabbuilds-child' ),
			(string) filemtime( $custom_css )
		);
	}

	$custom_js = get_stylesheet_directory() . '/assets/custom.js';
	if ( file_exists( $custom_js ) ) {
		wp_enqueue_script(
			'dabbuilds-custom',
			get_stylesheet_directory_uri() . '/assets/custom.js',
			array(),
			(string) filemtime( $custom_js ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'dabbuilds_child_enqueue_assets', 20 );

/**
 * Preconnect to Google Fonts.
 */
function dabbuilds_child_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'dabbuilds_child_resource_hints', 10, 2 );

/**
 * Whether the current request is the main blog index (not a single post/page).
 */
function dabbuilds_child_is_blog_index() {
	return ( is_home() || is_front_page() ) && ! is_singular();
}

/**
 * Home hero markup.
 */
function dabbuilds_child_render_hero() {
	static $printed = false;
	if ( $printed || ! dabbuilds_child_is_blog_index() ) {
		return;
	}
	$printed = true;
	?>
	<section class="dab-hero" aria-label="Introduction">
		<div class="dab-hero__grid" aria-hidden="true"></div>
		<div class="dab-hero__glow" aria-hidden="true"></div>
		<div class="dab-hero__inner">
			<p class="dab-hero__eyebrow">Build · Iterate · Launch</p>
			<h1 class="dab-hero__title">
				What can I help you<br>
				<span class="dab-hero__accent">build?</span>
			</h1>
			<p class="dab-hero__lede">
				Hardware, software, and the space between — a log of experiments,
				vehicles, and code from someone who believes the future is still
				worth shipping.
			</p>
			<div class="dab-hero__actions">
				<a class="dab-btn dab-btn--primary" href="#dab-latest">Read the build log</a>
				<a class="dab-btn dab-btn--ghost" href="<?php echo esc_url( home_url( '/dabs-resume/' ) ); ?>">Resume</a>
			</div>
			<ul class="dab-hero__signals" aria-label="Focus areas">
				<li>FPV &amp; flight systems</li>
				<li>AI-assisted building</li>
				<li>Open experiments</li>
			</ul>
		</div>
	</section>
	<div id="dab-latest" class="dab-latest-anchor"></div>
	<?php
}

/**
 * Print hero once at the start of the main loop on the blog index.
 */
function dabbuilds_child_loop_start_hero() {
	if ( ! dabbuilds_child_is_blog_index() ) {
		return;
	}
	// Only for the main query.
	if ( ! in_the_loop() && ! did_action( 'loop_start' ) ) {
		// still allow first loop_start
	}
	dabbuilds_child_render_hero();
}
add_action( 'loop_start', 'dabbuilds_child_loop_start_hero', 1 );

/**
 * Fallback if loop_start never fires (some Elementor canvas templates).
 */
function dabbuilds_child_wp_body_open_flag() {
	// no-op placeholder for future canvas support
}
add_action( 'wp_body_open', 'dabbuilds_child_wp_body_open_flag' );
