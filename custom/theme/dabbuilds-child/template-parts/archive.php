<?php
/**
 * Catalog index of the build log.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;
$paged = max( 1, (int) get_query_var( 'paged' ) );
$per   = max( 1, (int) $wp_query->get( 'posts_per_page' ) );
?>
<main id="content" class="site-main">

	<?php
	if ( function_exists( 'dabbuilds_child_render_hero' ) ) {
		dabbuilds_child_render_hero();
	}
	?>

	<div class="page-content dab-catalog">
		<?php
		while ( have_posts() ) {
			the_post();
			$post_link = get_permalink();
			$index     = ( $paged - 1 ) * $per + (int) $wp_query->current_post + 1;
			$num       = str_pad( (string) $index, 3, '0', STR_PAD_LEFT );
			?>
			<article <?php post_class( 'post dab-catalog__item' ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<a class="dab-catalog__figure" href="<?php echo esc_url( $post_link ); ?>">
						<?php the_post_thumbnail( 'large' ); ?>
					</a>
				<?php endif; ?>
				<div class="dab-catalog__caption">
					<div class="dab-catalog__meta">
						<span class="dab-catalog__index"><?php echo esc_html( $num ); ?></span>
						<time class="dab-catalog__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
							<?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
						</time>
					</div>
					<h2 class="entry-title">
						<a href="<?php echo esc_url( $post_link ); ?>"><?php echo wp_kses_post( get_the_title() ); ?></a>
					</h2>
					<?php the_excerpt(); ?>
				</div>
			</article>
			<?php
		}
		?>
	</div>

	<?php
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
