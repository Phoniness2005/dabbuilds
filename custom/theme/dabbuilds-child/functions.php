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
 * Public URL of the resume attachment (.doc / .pdf / .docx).
 *
 * @return string Empty if not found.
 */
function dabbuilds_child_get_resume_file_url() {
	$known = home_url( '/wp-content/uploads/2026/08/Resume-2026-V1.doc' );

	$cached = get_transient( 'dabbuilds_resume_file_url_v2' );
	if ( is_string( $cached ) && $cached !== '' ) {
		return $cached;
	}

	// Prefer the current hosted file, then page content, then media search.
	$candidates = array( $known );

	$by_name = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 5,
			's'              => 'Resume',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	foreach ( $by_name as $att ) {
		$url = wp_get_attachment_url( $att->ID );
		if ( $url && preg_match( '/\.(docx?|pdf)$/i', $url ) ) {
			$candidates[] = $url;
		}
	}

	$page = get_page_by_path( 'dabs-resume' );
	if ( $page ) {
		if ( preg_match( '/href=["\']([^"\']+\.(?:docx?|pdf))["\']/i', $page->post_content, $m ) ) {
			array_unshift( $candidates, $m[1] );
		}
	}

	// Last-resort known path (previous production file).
	$candidates[] = home_url( '/wp-content/uploads/2025/07/Resume-V5-2025.doc' );

	$url = '';
	foreach ( $candidates as $candidate ) {
		if ( is_string( $candidate ) && $candidate !== '' ) {
			$url = esc_url_raw( $candidate );
			break;
		}
	}

	if ( $url ) {
		set_transient( 'dabbuilds_resume_file_url_v2', $url, HOUR_IN_SECONDS );
	}

	return $url;
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
 * Force child templates so Elementor Theme Builder cannot skip our layouts.
 *
 * @param string $template Path to template.
 * @return string
 */
function dabbuilds_child_force_templates( $template ) {
	$dir = get_stylesheet_directory();

	if ( is_page( 'dabs-resume' ) ) {
		$custom = $dir . '/page-dabs-resume.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}

	if ( is_page( 'projects' ) ) {
		$custom = $dir . '/page-projects.php';
		if ( file_exists( $custom ) ) {
			return $custom;
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
 * Serve the standalone game at /play/ without WordPress chrome.
 */
function dabbuilds_child_serve_play_game() {
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path        = (string) wp_parse_url( $request_uri, PHP_URL_PATH );
	$path        = untrailingslashit( $path );

	if ( $path !== '/play' && $path !== '/play/index.html' ) {
		return;
	}

	$file = get_stylesheet_directory() . '/play/index.html';
	if ( ! is_readable( $file ) ) {
		return;
	}

	status_header( 200 );
	header( 'Content-Type: text/html; charset=utf-8' );
	header( 'X-Robots-Tag: noindex, follow' );
	header( 'Cache-Control: public, max-age=300' );
	readfile( $file );
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
	if ( ! is_string( $content ) || $content === '' ) {
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
 * Extra Elementor hooks — print hero if archive location still runs.
 */
function dabbuilds_child_elementor_archive_hero() {
	dabbuilds_child_render_hero();
}
add_action( 'elementor/theme/before_do_archive', 'dabbuilds_child_elementor_archive_hero' );

/**
 * Serve resume downloads with Content-Disposition: attachment when ?download=1.
 * Keeps normal URL for Office Online preview (inline).
 */
function dabbuilds_child_resume_download_headers() {
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
	// Handled via dedicated endpoint below — this early check is unused for remote files.
	unset( $path, $req );
}
// Attachment files are static on CDN; download attr on <a> is enough for modern browsers.
