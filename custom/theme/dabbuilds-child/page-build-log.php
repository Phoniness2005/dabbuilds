<?php
/**
 * Full build log (/build-log/). Served by the theme even without a WP page.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
$q = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 100,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
?>
<main id="content" class="site-main dab-build-log-page">
	<?php dabbuilds_child_page_head( 'Build log', 'Build log', 'Newest first. Builds, code, and notes on this site.' ); ?>
	<section class="dab-section dab-ledger dab-ledger--page">
		<div class="dab-section__inner">
			<?php if ( $q->have_posts() ) : ?>
				<?php dabbuilds_child_render_log_rows( $q ); ?>
			<?php else : ?>
				<p><?php echo esc_html__( 'Nothing here yet.', 'dabbuilds-child' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
