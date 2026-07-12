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

	// Parent structural CSS (Hello Elementor 3.x uses assets/, not only style.css).
	wp_enqueue_style(
		'hello-elementor',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'hello-elementor' )->get( 'Version' )
	);

	wp_enqueue_style(
		'dabbuilds-child',
		get_stylesheet_uri(),
		array( 'dabbuilds-fonts' ),
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
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
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
 * Home hero markup (safe to call once per request).
 */
function dabbuilds_child_render_hero() {
	static $printed = false;
	if ( $printed || ! dabbuilds_child_is_blog_index() ) {
		return;
	}
	$printed = true;
	?>
	<section class="dab-hero" aria-label="<?php echo esc_attr__( 'Introduction', 'dabbuilds-child' ); ?>">
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
			<ul class="dab-hero__signals" aria-label="<?php echo esc_attr__( 'Focus areas', 'dabbuilds-child' ); ?>">
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
 * Hide default Hello archive title on the blog home (hero replaces it).
 *
 * @param bool $show Whether to show the page title.
 * @return bool
 */
function dabbuilds_child_hide_home_archive_title( $show ) {
	if ( dabbuilds_child_is_blog_index() ) {
		return false;
	}
	return $show;
}
add_filter( 'hello_elementor_page_title', 'dabbuilds_child_hide_home_archive_title' );

/**
 * Force child index.php on the blog home so Elementor Theme Builder
 * cannot swallow the hero (template_include override).
 *
 * @param string $template Path to template.
 * @return string
 */
function dabbuilds_child_force_blog_template( $template ) {
	if ( dabbuilds_child_is_blog_index() ) {
		$custom = get_stylesheet_directory() . '/index.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}
	return $template;
}
add_filter( 'template_include', 'dabbuilds_child_force_blog_template', 99 );

/**
 * Extra Elementor hooks — print hero if archive location still runs.
 */
function dabbuilds_child_elementor_archive_hero() {
	dabbuilds_child_render_hero();
}
add_action( 'elementor/theme/before_do_archive', 'dabbuilds_child_elementor_archive_hero' );
