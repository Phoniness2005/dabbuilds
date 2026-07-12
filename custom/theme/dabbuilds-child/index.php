<?php
/**
 * Site entry point — mirrors Hello Elementor, injects DAB hero on blog index.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$is_elementor_theme_exist = function_exists( 'elementor_theme_do_location' );

if ( is_singular() ) {
	if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'single' ) ) {
		get_template_part( 'template-parts/single' );
	}
} elseif ( is_archive() || is_home() ) {
	// Prefer our archive part so hero always renders (even if Elementor owns archive).
	if ( dabbuilds_child_is_blog_index() ) {
		get_template_part( 'template-parts/archive' );
	} elseif ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'archive' ) ) {
		get_template_part( 'template-parts/archive' );
	}
} elseif ( is_search() ) {
	if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'archive' ) ) {
		get_template_part( 'template-parts/search' );
	}
} else {
	if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'single' ) ) {
		get_template_part( 'template-parts/404' );
	}
}

get_footer();
