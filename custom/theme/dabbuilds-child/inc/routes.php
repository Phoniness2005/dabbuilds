<?php
/**
 * Theme-served pages: /about/, /contact/, /build-log/.
 *
 * These render from theme templates without needing a WordPress page in
 * wp-admin. If a real page with the same slug is created later, WordPress
 * serves that page and the same theme template is still used.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme-served routes and their titles and meta descriptions.
 *
 * @return array<string, array{title: string, description: string}>
 */
function dabbuilds_child_routes(): array {
	return array(
		'about'     => array(
			'title'       => 'About',
			'description' => 'About Daniel Bryant: IT and systems support, machining supervision, and a home shop for CAD and 3D printing.',
		),
		'contact'   => array(
			'title'       => 'Contact',
			'description' => 'Contact Daniel Bryant by email at jobs@dabbuilds.com, or find him on LinkedIn and GitHub.',
		),
		'build-log' => array(
			'title'       => 'Build log',
			'description' => 'Every entry in the DAB Builds build log, newest first.',
		),
	);
}

/**
 * Slug of the theme-served route for this request, or ''.
 *
 * Only matches when WordPress itself found nothing (404) at that path.
 *
 * @return string
 */
function dabbuilds_child_virtual_route() {
	static $route = null;
	if ( is_string( $route ) ) {
		return $route;
	}
	$route = '';
	if ( ! did_action( 'wp' ) ) {
		$route = null;
		return '';
	}
	$raw  = dabbuilds_child_request_uri();
	$path = (string) wp_parse_url( $raw, PHP_URL_PATH );
	$home = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	if ( $home && '/' !== $home && 0 === strpos( $path, rtrim( $home, '/' ) ) ) {
		$path = substr( $path, strlen( rtrim( $home, '/' ) ) );
	}
	$slug = trim( $path, '/' );
	if ( isset( dabbuilds_child_routes()[ $slug ] ) && ! get_page_by_path( $slug ) ) {
		$route = $slug;
	}
	return $route;
}

/**
 * Turn the 404 into a 200 for theme-served routes.
 */
function dabbuilds_child_route_status(): void {
	if ( ! dabbuilds_child_virtual_route() ) {
		return;
	}
	global $wp_query;
	if ( ! $wp_query instanceof WP_Query ) {
		return;
	}
	$wp_query->is_404 = false;
	status_header( 200 );
}
add_action( 'template_redirect', 'dabbuilds_child_route_status', 1 );

/**
 * Document title for theme-served routes.
 *
 * @param string $title Title.
 * @return string
 */
function dabbuilds_child_route_title( $title ) {
	$route = dabbuilds_child_virtual_route();
	if ( $route ) {
		return dabbuilds_child_routes()[ $route ]['title'] . ' &#8211; ' . get_bloginfo( 'name' );
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'dabbuilds_child_route_title', 20 );

/**
 * Body classes for theme-served routes.
 *
 * @param array<int, string> $classes Classes.
 * @return array<int, string>
 */
function dabbuilds_child_route_body_class( $classes ): array {
	$route = dabbuilds_child_virtual_route();
	if ( $route ) {
		$classes   = array_diff( $classes, array( 'error404' ) );
		$classes[] = 'page';
		$classes[] = 'dab-route-' . $route;
	}
	return $classes;
}
add_filter( 'body_class', 'dabbuilds_child_route_body_class' );

/**
 * Whether the current request is a given site section (real page or route).
 *
 * @param string $slug Section slug.
 * @return bool
 */
function dabbuilds_child_is_section( $slug ) {
	if ( 'home' === $slug ) {
		return dabbuilds_child_is_blog_index();
	}
	return is_page( $slug ) || dabbuilds_child_virtual_route() === $slug;
}

/**
 * Home title: add a plain descriptor when the site has no tagline.
 *
 * @param array<string, string> $parts Title parts.
 * @return array<string, string>
 */
function dabbuilds_child_home_title_parts( $parts ): array {
	if ( ( is_home() || is_front_page() ) && empty( $parts['tagline'] ) && ! dabbuilds_child_virtual_route() ) {
		$parts['tagline'] = 'Daniel Bryant, IT, Systems, and Making';
	}
	return $parts;
}
add_filter( 'document_title_parts', 'dabbuilds_child_home_title_parts' );

/**
 * /resume/ resolves to an old media attachment (resume.png from Aug 2026).
 * Send it to the HTML résumé instead. Remove once the attachment slug is fixed in wp-admin.
 */
function dabbuilds_child_redirect_resume_attachment(): void {
	if ( is_attachment() && 'resume' === get_post_field( 'post_name', get_queried_object_id() ) ) {
		wp_safe_redirect( home_url( '/dabs-resume/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'dabbuilds_child_redirect_resume_attachment', 2 );
