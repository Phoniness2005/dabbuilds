<?php
/**
 * Resume page — in-browser preview + explicit download.
 *
 * Template hierarchy: page-dabs-resume.php
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$resume_file = dabbuilds_child_get_resume_file_url();
$viewer_src  = $resume_file
	? 'https://view.officeapps.live.com/op/embed.aspx?src=' . rawurlencode( $resume_file )
	: '';
$file_name   = $resume_file ? wp_basename( $resume_file ) : 'resume';
?>
<main id="content" class="site-main dab-singular dab-resume-page">
	<article class="dab-article dab-resume">
		<header class="dab-article__header">
			<a class="dab-back" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span aria-hidden="true">←</span>
				<?php echo esc_html__( 'Build log', 'dabbuilds-child' ); ?>
			</a>
			<p class="dab-article__eyebrow"><?php echo esc_html__( 'Professional profile', 'dabbuilds-child' ); ?></p>
			<h1 class="entry-title dab-article__title"><?php echo esc_html__( "DAB's Resume", 'dabbuilds-child' ); ?></h1>
			<p class="dab-resume__lede">
				<?php echo esc_html__( 'View the latest resume below in your browser, or download a copy for offline use.', 'dabbuilds-child' ); ?>
			</p>
			<div class="dab-resume__actions">
				<?php if ( $resume_file ) : ?>
					<a class="dab-btn dab-btn--primary" href="#dab-resume-viewer">
						<?php echo esc_html__( 'View in browser', 'dabbuilds-child' ); ?>
					</a>
					<a
						class="dab-btn dab-btn--ghost"
						href="<?php echo esc_url( $resume_file ); ?>"
						download="<?php echo esc_attr( $file_name ); ?>"
					>
						<?php echo esc_html__( 'Download', 'dabbuilds-child' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</header>

		<?php if ( $resume_file && $viewer_src ) : ?>
			<section id="dab-resume-viewer" class="dab-resume__viewer-wrap" aria-label="<?php echo esc_attr__( 'Resume preview', 'dabbuilds-child' ); ?>">
				<div class="dab-resume__viewer-chrome">
					<span class="dab-resume__viewer-dot" aria-hidden="true"></span>
					<span class="dab-resume__viewer-label"><?php echo esc_html( $file_name ); ?></span>
					<a
						class="dab-resume__viewer-dl"
						href="<?php echo esc_url( $resume_file ); ?>"
						download="<?php echo esc_attr( $file_name ); ?>"
					><?php echo esc_html__( 'Download', 'dabbuilds-child' ); ?></a>
				</div>
				<iframe
					class="dab-resume__frame"
					src="<?php echo esc_url( $viewer_src ); ?>"
					title="<?php echo esc_attr__( 'Resume document preview', 'dabbuilds-child' ); ?>"
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
				></iframe>
				<p class="dab-resume__fallback">
					<?php
					echo wp_kses(
						sprintf(
							/* translators: %s: download URL */
							__( 'Preview not loading? <a href="%s" download>Download the resume</a> instead.', 'dabbuilds-child' ),
							esc_url( $resume_file )
						),
						array(
							'a' => array(
								'href'     => true,
								'download' => true,
							),
						)
					);
					?>
				</p>
			</section>
		<?php else : ?>
			<div class="dab-article__content">
				<p><?php echo esc_html__( 'Resume file not found. Please re-upload the resume in WordPress Media.', 'dabbuilds-child' ); ?></p>
				<?php
				while ( have_posts() ) {
					the_post();
					the_content();
				}
				?>
			</div>
		<?php endif; ?>
	</article>
</main>
<?php
get_footer();
