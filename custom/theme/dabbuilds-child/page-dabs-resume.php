<?php
/**
 * Résumé page (/dabs-resume/): native HTML, printable to PDF.
 *
 * Content comes from inc/profile.php. The old Office Online embed of
 * Resume-2026-V2.doc is gone: that file still has the old Vermeer dates and
 * SNHU line. A corrected download appears when
 * dabbuilds_child_resume_download_url() returns a URL.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$c        = dabbuilds_child_contact();
$download = dabbuilds_child_resume_download_url();
?>
<main id="content" class="site-main dab-resume-page">
	<?php dabbuilds_child_page_head( 'Daniel A. Bryant', 'Résumé', 'Production supervision, IT and systems support, and machining.' ); ?>

	<section class="dab-section dab-resume">
		<div class="dab-section__inner">
			<div class="dab-resume__actions">
				<button type="button" class="dab-btn dab-btn--primary" data-dab-print><?php echo esc_html__( 'Print or save as PDF', 'dabbuilds-child' ); ?></button>
				<?php if ( $download ) : ?>
					<a class="dab-link-cta" href="<?php echo esc_url( $download ); ?>" download><?php echo esc_html__( 'Download', 'dabbuilds-child' ); ?> <span aria-hidden="true">&darr;</span></a>
				<?php endif; ?>
			</div>

			<article class="dab-card dab-resume__sheet" aria-label="<?php echo esc_attr__( 'Résumé', 'dabbuilds-child' ); ?>">
				<header class="dab-resume__header">
					<h2 class="dab-resume__name">Daniel A. Bryant</h2>
					<p class="dab-resume__contact">
						<?php echo esc_html( $c['location'] ); ?>
						<span aria-hidden="true">&middot;</span>
						<a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a>
						<span aria-hidden="true">&middot;</span>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">dabbuilds.com</a>
					</p>
				</header>

				<section class="dab-resume__block" aria-labelledby="dab-r-exp">
					<h3 class="dab-resume__h" id="dab-r-exp">Experience</h3>
					<?php foreach ( dabbuilds_child_experience() as $e ) : ?>
						<div class="dab-resume__job">
							<div class="dab-resume__jobhead">
								<p class="dab-resume__role"><?php echo esc_html( $e['role'] ); ?></p>
								<p class="dab-resume__dates"><?php echo esc_html( $e['dates'] ); ?></p>
							</div>
							<p class="dab-resume__org"><?php echo esc_html( $e['org'] ); ?>, <?php echo esc_html( $e['place'] ); ?></p>
							<ul>
								<?php foreach ( $e['bullets'] as $b ) : ?>
									<li><?php echo esc_html( $b ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
					<div class="dab-resume__job">
						<p class="dab-resume__role">Earlier</p>
						<ul>
							<?php foreach ( dabbuilds_child_earlier_roles() as $r ) : ?>
								<li><?php echo esc_html( $r ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</section>

				<section class="dab-resume__block" aria-labelledby="dab-r-edu">
					<h3 class="dab-resume__h" id="dab-r-edu">Education</h3>
					<?php foreach ( dabbuilds_child_education() as $ed ) : ?>
						<div class="dab-resume__jobhead">
							<p class="dab-resume__role"><?php echo esc_html( $ed['detail'] ); ?></p>
							<p class="dab-resume__dates"><?php echo esc_html( $ed['dates'] ); ?></p>
						</div>
						<p class="dab-resume__org"><?php echo esc_html( $ed['school'] ); ?></p>
					<?php endforeach; ?>
				</section>

				<section class="dab-resume__block dab-resume__two" aria-labelledby="dab-r-skills">
					<div>
						<h3 class="dab-resume__h" id="dab-r-skills">Skills</h3>
						<?php foreach ( dabbuilds_child_skills() as $group => $items ) : ?>
							<p><strong><?php echo esc_html( $group ); ?>:</strong> <?php echo esc_html( implode( ', ', $items ) ); ?></p>
						<?php endforeach; ?>
					</div>
					<div>
						<h3 class="dab-resume__h">Certifications and training</h3>
						<ul>
							<?php foreach ( dabbuilds_child_certifications() as $cert ) : ?>
								<li><?php echo esc_html( $cert ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</section>
			</article>
		</div>
	</section>
</main>
<?php
get_footer();
