<?php
/**
 * Catalog index of the build log — Apple-style ledger rows.
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

	if ( function_exists( 'dabbuilds_child_render_hire_strip' ) ) {
		dabbuilds_child_render_hire_strip();
	}
	?>

	<section class="dab-ledger page-content dab-catalog" aria-label="<?php echo esc_attr__( 'Build log', 'dabbuilds-child' ); ?>">
		<h2 class="dab-ledger__heading"><?php echo esc_html__( 'Build log', 'dabbuilds-child' ); ?></h2>

		<div class="dab-ledger__list" role="list">
			<?php
			while ( have_posts() ) {
				the_post();
				$post_link = get_permalink();
				$index     = ( $paged - 1 ) * $per + (int) $wp_query->current_post + 1;
				$num       = str_pad( (string) $index, 3, '0', STR_PAD_LEFT );
				?>
				<a
					class="dab-ledger__row dab-catalog__item"
					role="listitem"
					href="<?php echo esc_url( $post_link ); ?>"
				>
					<?php if ( has_post_thumbnail() ) : ?>
						<span class="dab-ledger__figure dab-catalog__figure" aria-hidden="true">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
						</span>
					<?php endif; ?>
					<span class="dab-ledger__serial dab-catalog__index"><?php echo esc_html( $num ); ?></span>
					<span class="dab-ledger__title"><?php echo wp_kses_post( get_the_title() ); ?></span>
					<time class="dab-ledger__date dab-catalog__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
						<?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
					</time>
				</a>
				<?php
			}
			?>
		</div>
	</section>

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
