<?php
/**
 * Blog / archive listing with techno-optimistic hero on the main blog index.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<main id="content" class="site-main">

	<?php
	if ( function_exists( 'dabbuilds_child_render_hero' ) ) {
		dabbuilds_child_render_hero();
	}
	?>

	<div class="page-content">
		<?php
		while ( have_posts() ) {
			the_post();
			$post_link = get_permalink();
			?>
			<article <?php post_class( 'post' ); ?>>
				<?php
				printf(
					'<h2 class="%s"><a href="%s">%s</a></h2>',
					'entry-title',
					esc_url( $post_link ),
					wp_kses_post( get_the_title() )
				);
				if ( has_post_thumbnail() ) {
					printf(
						'<a class="dab-post-thumb" href="%s">%s</a>',
						esc_url( $post_link ),
						get_the_post_thumbnail( get_the_ID(), 'large' )
					);
				}
				the_excerpt();
				?>
			</article>
			<?php
		}
		?>
	</div>

	<?php
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) :
		$prev_arrow = is_rtl() ? '&rarr;' : '&larr;';
		$next_arrow = is_rtl() ? '&larr;' : '&rarr;';
		?>
		<nav class="pagination" aria-label="<?php echo esc_attr__( 'Posts', 'dabbuilds-child' ); ?>">
			<div class="nav-previous">
				<?php
				previous_posts_link(
					sprintf(
						/* translators: %s: arrow */
						esc_html__( '%s Previous', 'dabbuilds-child' ),
						sprintf( '<span class="meta-nav">%s</span>', $prev_arrow )
					)
				);
				?>
			</div>
			<div class="nav-next">
				<?php
				next_posts_link(
					sprintf(
						/* translators: %s: arrow */
						esc_html__( 'Next %s', 'dabbuilds-child' ),
						sprintf( '<span class="meta-nav">%s</span>', $next_arrow )
					)
				);
				?>
			</div>
		</nav>
	<?php endif; ?>

</main>
