<?php
/**
 * Singular entry (posts & pages) — bypass Elementor single location when needed.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/single' );
get_footer();
