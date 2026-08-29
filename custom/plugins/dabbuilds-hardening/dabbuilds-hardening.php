<?php
/**
 * Plugin Name: DAB Builds Hardening
 * Description: Security headers, REST user lockdown, XML-RPC off, and version hiding for dabbuilds.com.
 * Version: 1.0.0
 * Author: DAB Builds
 * Requires at least: 6.0
 * Requires PHP: 8.0
 *
 * @package dabbuilds-hardening
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Send browser security headers on WordPress-served responses.
 */
function dabbuilds_hardening_send_headers() {
	if ( headers_sent() ) {
		return;
	}

	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=()' );
	header( 'Cross-Origin-Opener-Policy: same-origin-allow-popups' );

	// Intentionally allows Google Fonts, the Office Online resume preview,
	// Gravatar, and inline scripts used by WordPress + /play/.
	$csp = implode(
		'; ',
		array(
			"default-src 'self'",
			"base-uri 'self'",
			"form-action 'self'",
			"frame-ancestors 'self'",
			"object-src 'none'",
			"script-src 'self' 'unsafe-inline'",
			"style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
			"font-src 'self' https://fonts.gstatic.com data:",
			"img-src 'self' data: https:",
			"connect-src 'self'",
			"frame-src 'self' https://view.officeapps.live.com https://*.officeapps.live.com",
		)
	);
	header( 'Content-Security-Policy: ' . $csp );
}
add_action( 'send_headers', 'dabbuilds_hardening_send_headers' );

/**
 * Hide WordPress version tokens from markup and feeds.
 */
function dabbuilds_hardening_hide_versions() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	add_filter( 'the_generator', '__return_empty_string' );
	add_filter(
		'style_loader_src',
		'dabbuilds_hardening_strip_ver',
		999
	);
	add_filter(
		'script_loader_src',
		'dabbuilds_hardening_strip_ver',
		999
	);
}
add_action( 'init', 'dabbuilds_hardening_hide_versions' );

/**
 * Strip only the WordPress core version query arg from enqueued assets.
 * Leaves theme/plugin filemtime cache-busters intact.
 *
 * @param string $src Asset URL.
 * @return string
 */
function dabbuilds_hardening_strip_ver( $src ) {
	if ( ! is_string( $src ) || $src === '' ) {
		return $src;
	}

	$wp_ver = get_bloginfo( 'version' );
	if ( $wp_ver === '' || strpos( $src, 'ver=' . $wp_ver ) === false ) {
		return $src;
	}

	return remove_query_arg( 'ver', $src );
}

/**
 * Disable XML-RPC (host already returns 422; keep it off in WordPress too).
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );

/**
 * Do not advertise XML-RPC pingback on posts.
 */
add_filter( 'pings_open', '__return_false' );
add_filter( 'comments_open', 'dabbuilds_hardening_comments_closed', 20, 2 );

/**
 * Keep comments closed on the public site.
 *
 * @param bool $open    Whether comments are open.
 * @param int  $post_id Post ID.
 * @return bool
 */
function dabbuilds_hardening_comments_closed( $open, $post_id ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	return false;
}

/**
 * Remove anonymous access to the users REST collection (username enumeration).
 *
 * @param array $endpoints Registered REST routes.
 * @return array
 */
function dabbuilds_hardening_lock_user_rest( $endpoints ) {
	if ( is_user_logged_in() ) {
		return $endpoints;
	}

	foreach ( array_keys( $endpoints ) as $route ) {
		if ( strpos( $route, '/wp/v2/users' ) === 0 ) {
			unset( $endpoints[ $route ] );
		}
	}

	return $endpoints;
}
add_filter( 'rest_endpoints', 'dabbuilds_hardening_lock_user_rest' );

/**
 * Restrict REST CORS to this site. Core reflects any Origin with credentials.
 *
 * @param mixed $served Whether the request has already been served.
 * @return mixed
 */
function dabbuilds_hardening_cors( $served ) {
	$origin  = get_http_origin();
	$allowed = untrailingslashit( home_url() );

	if ( $origin && untrailingslashit( $origin ) === $allowed ) {
		header( 'Access-Control-Allow-Origin: ' . esc_url_raw( $origin ) );
		header( 'Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE' );
		header( 'Access-Control-Allow-Credentials: true' );
		header( 'Access-Control-Allow-Headers: Authorization, X-WP-Nonce, Content-Disposition, Content-MD5, Content-Type' );
		header( 'Vary: Origin' );
	}

	return $served;
}

/**
 * Replace core REST CORS headers.
 */
function dabbuilds_hardening_replace_cors() {
	remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
	add_filter( 'rest_pre_serve_request', 'dabbuilds_hardening_cors' );
}
add_action( 'rest_api_init', 'dabbuilds_hardening_replace_cors', 15 );

/**
 * Do not expose author archives or ?author=N (login-name enumeration).
 */
function dabbuilds_hardening_block_author_enum() {
	if ( is_admin() ) {
		return;
	}

	$author_q = isset( $_GET['author'] ) ? wp_unslash( $_GET['author'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( is_author() || $author_q !== '' ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'dabbuilds_hardening_block_author_enum', 0 );

/**
 * Generic login failure text so usernames are not confirmed.
 *
 * @return string
 */
function dabbuilds_hardening_login_error() {
	return __( 'Invalid login credentials.', 'dabbuilds-hardening' );
}
add_filter( 'login_errors', 'dabbuilds_hardening_login_error' );

/**
 * Disable the theme/plugin file editor when wp-config has not already done so.
 */
function dabbuilds_hardening_disallow_file_edit() {
	if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
		define( 'DISALLOW_FILE_EDIT', true );
	}
}
add_action( 'admin_init', 'dabbuilds_hardening_disallow_file_edit', 0 );
