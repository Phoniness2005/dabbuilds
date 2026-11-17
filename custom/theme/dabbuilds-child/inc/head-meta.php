<?php
/**
 * Head tags: meta description, canonical, Open Graph, Twitter card, favicons.
 *
 * Assets ship with the theme in assets/icons/ (no media library dependency):
 * - og-image-1200x630.png        Open Graph / Twitter image
 * - favicon-day-{32,180,512}.png Ink on Ivory (light browser UI)
 * - favicon-night-{32,180,512}.png Gilt on night (dark browser UI)
 * - favicon.ico                   16/32/48 fallback, also served at /favicon.ico
 *
 * Hooks for overrides:
 * - dabbuilds_child_meta_description (string, context)
 * - dabbuilds_child_og_image          (absolute URL)
 * - dabbuilds_child_canonical_url     (absolute URL)
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * True if an SEO plugin is already printing description/canonical/OG tags.
 *
 * @return bool
 */
function dabbuilds_child_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

/**
 * Theme icon URL.
 *
 * @param string $file File in assets/icons/.
 * @return string
 */
function dabbuilds_child_icon_url( $file ) {
	return get_stylesheet_directory_uri() . '/assets/icons/' . rawurlencode( basename( $file ) );
}

/**
 * Default site description.
 *
 * @return string
 */
function dabbuilds_child_default_description() {
	return 'Daniel Bryant. IT and systems support, machining and CNC, CAD, and 3D printing. Resume, selected work, and build log.';
}

/**
 * Meta description for the current request.
 *
 * @return string
 */
function dabbuilds_child_meta_description() {
	$desc  = dabbuilds_child_default_description();
	$route = dabbuilds_child_virtual_route();

	if ( $route ) {
		$desc = dabbuilds_child_routes()[ $route ]['description'];
	} elseif ( is_page( 'dabs-resume' ) ) {
		$desc = 'Resume of Daniel Bryant: production supervision at Emerson, IT roles at Wells Fargo, Pella Technology, and Vermeer, and Army machinist training.';
	} elseif ( is_page( 'projects' ) ) {
		$desc = 'Selected work by Daniel Bryant: this site, a browser Pong game, and the builds behind the build log.';
	} elseif ( is_page( 'about' ) || is_page( 'contact' ) ) {
		$routes = dabbuilds_child_routes();
		$desc   = $routes[ get_post_field( 'post_name', get_queried_object_id() ) ]['description'];
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$text      = has_excerpt( $post ) ? $post->post_excerpt : $post->post_content;
			$stripped  = wp_strip_all_tags( strip_shortcodes( $text ) );
			$collapsed = preg_replace( '/\s+/', ' ', $stripped );
			$text      = is_string( $collapsed ) ? trim( $collapsed ) : '';
			if ( '' !== $text ) {
				$desc = wp_trim_words( $text, 28, '...' );
			}
		}
	} elseif ( is_tag() || is_category() ) {
		$desc = sprintf( 'Build log entries tagged %s, from DAB Builds.', single_term_title( '', false ) );
	}

	$filtered = apply_filters( 'dabbuilds_child_meta_description', $desc );
	return is_string( $filtered ) ? $filtered : $desc;
}

/**
 * Canonical URL for the current request.
 *
 * @return string
 */
function dabbuilds_child_canonical_url() {
	$url   = '';
	$route = dabbuilds_child_virtual_route();
	if ( $route ) {
		$url = home_url( '/' . $route . '/' );
	} elseif ( is_singular() ) {
		$url = wp_get_canonical_url();
	} elseif ( is_front_page() || is_home() ) {
		$paged = dabbuilds_child_query_int( 'paged' );
		$url   = $paged > 1 ? get_pagenum_link( $paged ) : home_url( '/' );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		$url  = $term instanceof WP_Term ? get_term_link( $term ) : '';
	} elseif ( is_author() ) {
		$url = get_author_posts_url( get_queried_object_id() );
	}
	if ( is_wp_error( $url ) || ! is_string( $url ) ) {
		$url = '';
	}
	$filtered = apply_filters( 'dabbuilds_child_canonical_url', $url );
	return is_string( $filtered ) ? $filtered : $url;
}

/**
 * Open Graph image URL.
 *
 * @return string
 */
function dabbuilds_child_og_image() {
	$image    = dabbuilds_child_icon_url( 'og-image-1200x630.png' );
	$filtered = apply_filters( 'dabbuilds_child_og_image', $image );
	return is_string( $filtered ) ? $filtered : $image;
}

/**
 * Print description, canonical, OG, and Twitter tags.
 */
function dabbuilds_child_print_meta(): void {
	if ( is_404() && ! dabbuilds_child_virtual_route() ) {
		return;
	}
	if ( dabbuilds_child_seo_plugin_active() ) {
		return;
	}

	$desc      = dabbuilds_child_meta_description();
	$canonical = dabbuilds_child_canonical_url();
	$title     = wp_get_document_title();
	$image     = dabbuilds_child_og_image();
	$type      = is_singular( 'post' ) ? 'article' : 'website';

	echo "\n<!-- DAB Builds head meta -->\n";
	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	if ( $canonical ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
	}
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $type ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	if ( $canonical ) {
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $canonical ) );
	}
	if ( $image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
		echo '<meta property="og:image:width" content="1200">' . "\n";
		echo '<meta property="og:image:height" content="630">' . "\n";
		echo '<meta property="og:image:alt" content="DAB BUILDS wordmark with a gilt sunburst on ivory">' . "\n";
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	if ( $image ) {
		printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image ) );
	}
}
add_action( 'wp_head', 'dabbuilds_child_print_meta', 2 );

/**
 * Core prints its own canonical on singular views; ours replaces it.
 */
function dabbuilds_child_swap_core_canonical(): void {
	if ( ! dabbuilds_child_seo_plugin_active() ) {
		remove_action( 'wp_head', 'rel_canonical' );
	}
}
add_action( 'wp', 'dabbuilds_child_swap_core_canonical' );

/**
 * Theme favicons. Replaces the WordPress Site Icon (the old Iron Man crop),
 * so the icon is versioned in git instead of the media library.
 */
function dabbuilds_child_print_icons(): void {
	$v = dabbuilds_child_asset_ver();
	printf( '<link rel="icon" href="%s?v=%s" sizes="any">' . "\n", esc_url( dabbuilds_child_icon_url( 'favicon.ico' ) ), esc_attr( $v ) );
	printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s?v=%s" media="(prefers-color-scheme: light)">' . "\n", esc_url( dabbuilds_child_icon_url( 'favicon-day-32.png' ) ), esc_attr( $v ) );
	printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s?v=%s" media="(prefers-color-scheme: dark)">' . "\n", esc_url( dabbuilds_child_icon_url( 'favicon-night-32.png' ) ), esc_attr( $v ) );
	printf( '<link rel="icon" type="image/png" sizes="512x512" href="%s?v=%s">' . "\n", esc_url( dabbuilds_child_icon_url( 'favicon-day-512.png' ) ), esc_attr( $v ) );
	printf( '<link rel="apple-touch-icon" sizes="180x180" href="%s?v=%s">' . "\n", esc_url( dabbuilds_child_icon_url( 'favicon-day-180.png' ) ), esc_attr( $v ) );
	echo '<meta name="theme-color" content="#F6F1E7" media="(prefers-color-scheme: light)">' . "\n";
	echo '<meta name="theme-color" content="#14120F" media="(prefers-color-scheme: dark)">' . "\n";
}
add_action( 'wp_head', 'dabbuilds_child_print_icons', 3 );
remove_action( 'wp_head', 'wp_site_icon', 99 );

/**
 * Serve the theme favicon.ico at /favicon.ico when the request reaches WordPress.
 * (WordPress fires do_faviconico for that path; a static file on the host wins if present.)
 */
function dabbuilds_child_favicon_ico(): void {
	$file = get_stylesheet_directory() . '/assets/icons/favicon.ico';
	if ( ! is_readable( $file ) ) {
		return;
	}
	header( 'Content-Type: image/x-icon' );
	header( 'Cache-Control: public, max-age=86400' );
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_readfile -- stream the theme favicon; WP_Filesystem would buffer it.
	$bytes = readfile( $file );
	if ( false === $bytes ) {
		exit;
	}
	exit;
}
add_action( 'do_faviconico', 'dabbuilds_child_favicon_ico', 1 );
