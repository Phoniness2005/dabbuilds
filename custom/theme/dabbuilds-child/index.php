<?php
/**
 * Site entry point — DAB Builds child.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_singular() ) {
	get_template_part( 'template-parts/single' );
} elseif ( is_archive() || is_home() || is_search() ) {
	get_template_part( 'template-parts/archive' );
} else {
	get_template_part( 'template-parts/404' );
}

get_footer();
