<?php
/**
 * Work page (/projects/).
 *
 * The old "What it looks like right now" screenshot grid showed the
 * pre-redesign cyan site and has been removed. New screenshots can be added
 * per card later (media library or theme stills).
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$work   = dabbuilds_child_selected_work();
$work[] = array(
	'num'   => '04',
	'kind'  => 'Profile',
	'title' => 'Résumé',
	'body'  => 'The full résumé as a web page, ready to print or save as a PDF.',
	'tags'  => array( 'HTML', 'Print' ),
	'url'   => home_url( '/dabs-resume/' ),
	'cta'   => 'Read the résumé',
);
?>
<main id="content" class="site-main dab-projects-page">
	<?php dabbuilds_child_page_head( 'Work', 'Selected work', 'I would rather send you to something that runs than to a slide deck.' ); ?>

	<section class="dab-section">
		<div class="dab-section__inner">
			<div class="dab-cards dab-cards--2">
				<?php foreach ( $work as $w ) : ?>
					<article class="dab-card dab-work-card">
						<p class="dab-work-card__meta"><span><?php echo esc_html( $w['num'] ); ?></span> <?php echo esc_html( $w['kind'] ); ?></p>
						<h2 class="dab-card__title"><?php echo esc_html( $w['title'] ); ?></h2>
						<p class="dab-card__body"><?php echo esc_html( $w['body'] ); ?></p>
						<ul class="dab-tags">
							<?php foreach ( $w['tags'] as $t ) : ?>
								<li><?php echo esc_html( $t ); ?></li>
							<?php endforeach; ?>
						</ul>
						<a class="dab-card__link" href="<?php echo esc_url( $w['url'] ); ?>"><?php echo esc_html( $w['cta'] ); ?> <span aria-hidden="true">&rarr;</span></a>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="dab-section__more"><a class="dab-link-cta" href="https://github.com/Phoniness2005" rel="noopener noreferrer">More on GitHub <span aria-hidden="true">&rarr;</span></a></p>
		</div>
	</section>
</main>
<?php
get_footer();
