<?php
/**
 * Product-page layout for a single post or page.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	?>
	<main id="content" <?php post_class( 'site-main dab-singular' ); ?>>
		<article class="dab-article">
			<header class="dab-article__header">
				<a class="dab-back" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo esc_html__( 'Build log', 'dabbuilds-child' ); ?>
				</a>

				<p class="dab-article__eyebrow">
					<?php
					if ( is_singular( 'post' ) ) {
						echo esc_html( get_the_date( 'Y.m.d' ) );
					} else {
						echo esc_html__( 'Page', 'dabbuilds-child' );
					}
					?>
				</p>

				<?php the_title( '<h1 class="entry-title dab-article__title">', '</h1>' ); ?>

				<?php if ( is_singular( 'post' ) && has_tag() ) : ?>
					<div class="dab-article__tags">
						<?php the_tags( '<span class="dab-tag">', '</span><span class="dab-tag">', '</span>' ); ?>
					</div>
				<?php endif; ?>
			</header>

			<?php if ( has_post_thumbnail() && ! is_page() ) : ?>
				<figure class="dab-article__hero-media">
					<?php the_post_thumbnail( 'large' ); ?>
				</figure>
			<?php endif; ?>

			<div class="page-content dab-article__content entry-content">
				<?php
				the_content();
				wp_link_pages(
					array(
						'before' => '<nav class="dab-page-links"><span class="dab-page-links__label">' . esc_html__( 'Pages:', 'dabbuilds-child' ) . '</span>',
						'after'  => '</nav>',
					)
				);
				?>
			</div>
		</article>

		<?php if ( is_singular( 'post' ) ) : ?>
			<nav class="dab-post-nav" aria-label="<?php echo esc_attr__( 'Post navigation', 'dabbuilds-child' ); ?>">
				<div class="dab-post-nav__prev">
					<?php previous_post_link( '%link', '<span class="dab-post-nav__label">Previous</span><span class="dab-post-nav__title">%title</span>' ); ?>
				</div>
				<div class="dab-post-nav__next">
					<?php next_post_link( '%link', '<span class="dab-post-nav__label">Next</span><span class="dab-post-nav__title">%title</span>' ); ?>
				</div>
			</nav>
		<?php endif; ?>

		<?php comments_template(); ?>
	</main>
	<?php
endwhile;
