<?php
/**
 * Home page (sectioned) and build log archives (tags, categories, author, search).
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;
$paged = max( 1, (int) get_query_var( 'paged' ) );
?>
<main id="content" class="site-main">
	<?php if ( dabbuilds_child_is_blog_index() && 1 === $paged ) : ?>

		<?php dabbuilds_child_render_home(); ?>

	<?php else : ?>
		<?php
		if ( is_tag() || is_category() ) {
			$eyebrow = is_tag() ? __( 'Tag', 'dabbuilds-child' ) : __( 'Category', 'dabbuilds-child' );
			$heading = single_term_title( '', false );
		} elseif ( is_author() ) {
			$eyebrow = __( 'Author', 'dabbuilds-child' );
			$heading = get_the_author_meta( 'display_name', (int) get_query_var( 'author' ) );
		} elseif ( is_search() ) {
			$eyebrow = __( 'Search', 'dabbuilds-child' );
			$heading = get_search_query();
		} else {
			$eyebrow = __( 'Build log', 'dabbuilds-child' );
			/* translators: %d: page number */
			$heading = sprintf( __( 'Page %d', 'dabbuilds-child' ), $paged );
		}
		?>
		<section class="dab-page-head">
			<div class="dab-section__inner">
				<a class="dab-back" href="<?php echo esc_url( home_url( '/build-log/' ) ); ?>"><span aria-hidden="true">&larr;</span> <?php echo esc_html__( 'Build log', 'dabbuilds-child' ); ?></a>
				<p class="dab-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<h1 class="dab-page-title"><?php echo esc_html( $heading ); ?></h1>
				<?php dabbuilds_child_divider(); ?>
			</div>
		</section>
		<section class="dab-section dab-ledger dab-ledger--page" aria-label="<?php echo esc_attr__( 'Entries', 'dabbuilds-child' ); ?>">
			<div class="dab-section__inner">
				<?php if ( have_posts() ) : ?>
					<?php dabbuilds_child_render_log_rows(); ?>
				<?php else : ?>
					<p><?php echo esc_html__( 'Nothing here yet.', 'dabbuilds-child' ); ?></p>
				<?php endif; ?>

				<?php if ( $wp_query->max_num_pages > 1 ) : ?>
					<nav class="pagination" aria-label="<?php echo esc_attr__( 'Posts', 'dabbuilds-child' ); ?>">
						<div class="nav-previous"><?php previous_posts_link( esc_html__( 'Newer', 'dabbuilds-child' ) ); ?></div>
						<div class="nav-next"><?php next_posts_link( esc_html__( 'Older', 'dabbuilds-child' ) ); ?></div>
					</nav>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>
</main>
