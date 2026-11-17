<?php
/**
 * DAB Builds child theme (Hello Elementor). "Capitol Daylight" design system.
 *
 * Source of truth: https://github.com/Phoniness2005/dabbuilds
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_stylesheet_directory() . '/inc/class-dabbuilds-child-bounds.php';
require_once get_stylesheet_directory() . '/inc/profile.php';
require_once get_stylesheet_directory() . '/inc/routes.php';
require_once get_stylesheet_directory() . '/inc/head-meta.php';
require_once get_stylesheet_directory() . '/inc/home-sections.php';

/**
 * Request path source. Non-strings recover to an empty path.
 *
 * @return string
 */
function dabbuilds_child_request_uri(): string {
	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	$raw = wp_unslash( $_SERVER['REQUEST_URI'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized on the next line when it is a string.
	if ( ! is_string( $raw ) ) {
		return '';
	}
	return sanitize_text_field( $raw );
}

/**
 * Integer query var. Non-numeric values recover to 0.
 *
 * @param string $key Query var.
 * @return int
 */
function dabbuilds_child_query_int( $key ): int {
	if ( '' === $key ) {
		return 0;
	}
	$value = get_query_var( $key );
	if ( is_int( $value ) ) {
		return $value;
	}
	if ( is_string( $value ) && is_numeric( $value ) ) {
		return (int) $value;
	}
	return 0;
}

/**
 * Cache-bust string for theme CSS/JS (Cloudflare caches by ?ver=).
 */
function dabbuilds_child_asset_ver(): string {
	$ver = '20261117-power-of-10-1';
	if ( 1 !== preg_match( '/^[a-z0-9.-]{1,64}$/', $ver ) ) {
		return '0';
	}
	return $ver;
}

/**
 * Enqueue fonts, parent/child styles, and custom assets.
 */
function dabbuilds_child_enqueue_assets(): void {
	$ver = dabbuilds_child_asset_ver();

	// Josefin Sans (deco display caps) + Inter (body).
	wp_enqueue_style(
		'dabbuilds-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Josefin+Sans:wght@600;700&display=swap',
		array(),
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Google Fonts CSS must not gain a ver query.
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
		array( 'dabbuilds-fonts' ),
		wp_get_theme()->get( 'Version' )
	);

	$custom_css = get_stylesheet_directory() . '/assets/custom.css';
	if ( file_exists( $custom_css ) ) {
		wp_enqueue_style(
			'dabbuilds-custom',
			get_stylesheet_directory_uri() . '/assets/custom.css',
			array( 'dabbuilds-child' ),
			$ver
		);
	}

	$custom_js = get_stylesheet_directory() . '/assets/custom.js';
	if ( file_exists( $custom_js ) ) {
		wp_enqueue_script(
			'dabbuilds-custom',
			get_stylesheet_directory_uri() . '/assets/custom.js',
			array(),
			$ver,
			true
		);
	}

	$lighting_js = get_stylesheet_directory() . '/assets/lighting.js';
	if ( file_exists( $lighting_js ) ) {
		wp_enqueue_script(
			'dabbuilds-lighting',
			get_stylesheet_directory_uri() . '/assets/lighting.js',
			array(),
			$ver,
			false
		);
	}
}
add_action( 'wp_enqueue_scripts', 'dabbuilds_child_enqueue_assets', 20 );

/**
 * Set Day or Night before first paint.
 *
 * Auto = Day from 06:00 to 17:59 local time, Night otherwise. Day and Night
 * buttons lock the choice. Reads the local clock and localStorage only;
 * nothing is sent to the server. ?dab-hour=0..23 forces an hour for screenshots.
 */
function dabbuilds_child_lighting_boot(): void {
	?>
	<script>
	(function () {
		try {
			var mode = 'auto';
			try { mode = localStorage.getItem('dab-light-mode') || 'auto'; } catch (e) {}
			if (mode !== 'day' && mode !== 'night') mode = 'auto';
			var hour = new Date().getHours();
			try {
				var q = new URLSearchParams(location.search).get('dab-hour');
				if (q !== null && q !== '' && !isNaN(parseInt(q, 10))) hour = ((parseInt(q, 10) % 24) + 24) % 24;
			} catch (e) {}
			var period = mode === 'day' ? 'day' : mode === 'night' ? 'night' : ((hour >= 6 && hour < 18) ? 'day' : 'night');
			var el = document.documentElement;
			el.dataset.dabMode = mode;
			el.dataset.dabHour = String(hour);
			el.dataset.dabPeriod = period;
			el.style.colorScheme = period === 'night' ? 'dark' : 'light';
		} catch (e) {}
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'dabbuilds_child_lighting_boot', 0 );

/**
 * Preconnect to Google Fonts.
 *
 * @param array<int, mixed> $urls         URLs to print for resource hints.
 * @param string            $relation_type The relation type the URLs are printed for.
 * @return array<int, mixed>
 */
function dabbuilds_child_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' !== $relation_type ) {
		return $urls;
	}
	if ( count( $urls ) + 2 > Dabbuilds_Child_Bounds::HINTS ) {
		return $urls;
	}
	$urls[] = array(
		'href' => 'https://fonts.googleapis.com',
	);
	$urls[] = array(
		'href'        => 'https://fonts.gstatic.com',
		'crossorigin' => 'anonymous',
	);
	return $urls;
}
add_filter( 'wp_resource_hints', 'dabbuilds_child_resource_hints', 10, 2 );

/**
 * Whether the current request is the main blog index (not a single post/page).
 */
function dabbuilds_child_is_blog_index(): bool {
	return ( is_home() || is_front_page() ) && ! is_singular() && ! dabbuilds_child_virtual_route();
}

/**
 * Public URL of the resume attachment (.doc). Kept for the legacy download.
 *
 * NOTE: Resume-2026-V2.doc still has the old Vermeer dates and the old SNHU
 * line. The HTML resume does not link to it until a corrected file is
 * uploaded and this filter (or the pin below) is updated.
 *
 * @return string Empty if not found.
 */
function dabbuilds_child_get_resume_file_url() {
	return home_url( '/wp-content/uploads/2026/08/Resume-2026-V2.doc' );
}

/**
 * URL of a corrected resume download (PDF preferred). Empty = hide the link.
 *
 * Hook: add_filter( 'dabbuilds_child_resume_download_url', fn() => 'https://.../Resume.pdf' );
 *
 * @return string
 */
function dabbuilds_child_resume_download_url(): string {
	$filtered = apply_filters( 'dabbuilds_child_resume_download_url', '' );
	return is_string( $filtered ) ? $filtered : '';
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
 * Force child templates so Elementor Theme Builder cannot skip our layouts.
 *
 * @param string $template Path to template.
 * @return string
 */
function dabbuilds_child_force_templates( $template ) {
	$dir = get_stylesheet_directory();

	$route = dabbuilds_child_virtual_route();
	if ( $route ) {
		$custom = $dir . '/page-' . $route . '.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}

	foreach ( array( 'dabs-resume', 'projects', 'about', 'contact', 'build-log' ) as $slug ) {
		if ( is_page( $slug ) ) {
			$custom = $dir . '/page-' . $slug . '.php';
			if ( file_exists( $custom ) ) {
				return $custom;
			}
		}
	}

	if ( dabbuilds_child_is_blog_index() ) {
		$custom = $dir . '/index.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}

	if ( is_singular() ) {
		$custom = $dir . '/singular.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}

	return $template;
}
add_filter( 'template_include', 'dabbuilds_child_force_templates', 99 );

/**
 * Gilt stepped "ziggurat" divider (the one deco motif).
 *
 * @param string $extra Extra class.
 */
function dabbuilds_child_divider( $extra = '' ): void {
	echo '<div class="dab-divider ' . esc_attr( $extra ) . '" aria-hidden="true"><svg viewBox="0 0 120 14" width="120" height="14" focusable="false"><path d="M0 13h40v-4h8v-4h8V1h8v4h8v4h8v4h40" fill="none" stroke="currentColor" stroke-width="1.25"/></svg></div>';
}

/**
 * Theme-bundled still URL (ships with the child theme; no media-library dependency).
 *
 * @param string $file Filename under assets/stills/.
 * @return string Empty if missing.
 */
function dabbuilds_child_theme_still_url( $file = 'nano-lr-still.jpg' ) {
	$file = basename( (string) $file );
	if ( '' === $file || false !== strpos( $file, '..' ) ) {
		return '';
	}
	$path = get_stylesheet_directory() . '/assets/stills/' . $file;
	if ( ! is_readable( $path ) ) {
		return '';
	}
	return get_stylesheet_directory_uri() . '/assets/stills/' . rawurlencode( $file );
}

/**
 * Public URL of an uploaded screenshot by attachment slug.
 *
 * @param string $slug Attachment slug (filename without extension).
 * @return string Empty if not found.
 */
function dabbuilds_child_shot_url( $slug ) {
	$att = get_posts(
		array(
			'name'           => sanitize_title( $slug ),
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
		)
	);
	if ( empty( $att ) ) {
		return '';
	}
	$url = wp_get_attachment_url( $att[0]->ID );
	return $url ? $url : '';
}

/**
 * Public URL of the hosted Wimbledon Pong game.
 *
 * @return string
 */
function dabbuilds_child_play_url() {
	return home_url( '/play/' );
}

/**
 * Serve the Pong hub and versioned game files at /play/ without WordPress chrome.
 */
function dabbuilds_child_serve_play_game(): void {
	$request_uri = dabbuilds_child_request_uri();
	$path        = (string) wp_parse_url( $request_uri, PHP_URL_PATH );
	$path        = untrailingslashit( $path );

	$rel = '';
	if ( '/play' === $path || '/play/index.html' === $path ) {
		$rel = 'index.html';
	} elseif ( preg_match( '#^/play/(v[12])$#', $path, $m ) ) {
		$rel = $m[1] . '/index.html';
	} elseif ( preg_match( '#^/play/(v[12]/(?:index\.html|assets/[a-z0-9._-]+\.(?:jpg|jpeg|png|gif)))$#i', $path, $m ) ) {
		$rel = $m[1];
	} else {
		return;
	}

	$file      = get_stylesheet_directory() . '/play/' . $rel;
	$real_play = realpath( get_stylesheet_directory() . '/play' );
	$real_file = realpath( $file );
	if ( ! $real_play || ! $real_file || strpos( $real_file, $real_play ) !== 0 || ! is_readable( $real_file ) ) {
		return;
	}

	$ext  = strtolower( pathinfo( $real_file, PATHINFO_EXTENSION ) );
	$mime = 'text/html; charset=utf-8';
	if ( 'jpg' === $ext || 'jpeg' === $ext ) {
		$mime = 'image/jpeg';
	} elseif ( 'png' === $ext ) {
		$mime = 'image/png';
	} elseif ( 'gif' === $ext ) {
		$mime = 'image/gif';
	}

	status_header( 200 );
	header( 'Content-Type: ' . $mime );
	header( 'X-Robots-Tag: noindex, follow' );
	header( 'Cache-Control: public, max-age=60, must-revalidate' );
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_readfile -- stream one theme file; WP_Filesystem would buffer it.
	$bytes = readfile( $real_file );
	if ( false === $bytes ) {
		exit;
	}
	exit;
}
add_action( 'template_redirect', 'dabbuilds_child_serve_play_game', 0 );

/**
 * Point leftover Replit game links at the on-site copy.
 *
 * @param string $content Post content.
 * @return string
 */
function dabbuilds_child_rewrite_game_url( $content ) {
	if ( '' === $content ) {
		return $content;
	}

	$old = array(
		'https://grokreplitopen2025.replit.app/',
		'https://grokreplitopen2025.replit.app',
		'http://grokreplitopen2025.replit.app/',
		'http://grokreplitopen2025.replit.app',
	);

	return str_replace( $old, dabbuilds_child_play_url(), $content );
}
add_filter( 'the_content', 'dabbuilds_child_rewrite_game_url', 20 );

/**
 * Extra Elementor hooks - print hero if archive location still runs.
 */
function dabbuilds_child_elementor_archive_hero(): void {
	dabbuilds_child_render_hero();
}
add_action( 'elementor/theme/before_do_archive', 'dabbuilds_child_elementor_archive_hero' );

/**
 * Serve resume downloads with Content-Disposition: attachment when ?download=1.
 * Keeps normal URL for Office Online preview (inline).
 */
function dabbuilds_child_resume_download_headers(): void {
	if ( empty( $_GET['dab_download'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	$file = dabbuilds_child_get_resume_file_url();
	if ( ! $file ) {
		return;
	}

	// Only force download for our known resume URL path.
	$path = wp_parse_url( $file, PHP_URL_PATH );
	$req  = wp_parse_url( home_url( add_query_arg( array() ) ), PHP_URL_PATH );
	// Handled via dedicated endpoint below - this early check is unused for remote files.
	unset( $path, $req );
}
// Attachment files are static on CDN; download attr on <a> is enough for modern browsers.
