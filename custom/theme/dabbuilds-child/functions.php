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
 * Enqueue parent + child styles and optional custom JS.
 */
function dabbuilds_child_enqueue_assets() {
	// Parent theme stylesheet.
	wp_enqueue_style(
		'hello-elementor',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'hello-elementor' )->get( 'Version' )
	);

	// Child theme style.css (theme metadata + optional rules).
	wp_enqueue_style(
		'dabbuilds-child',
		get_stylesheet_uri(),
		array( 'hello-elementor' ),
		wp_get_theme()->get( 'Version' )
	);

	// Versioned custom CSS from this repo.
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
