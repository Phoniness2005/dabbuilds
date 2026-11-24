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
						<a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a>
						<span aria-hidden="true">&middot;</span>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">dabbuilds.com</a>
					</p>
				</header>

				<section class="dab-resume__block" aria-labelledby="dab-r-exp">
					<h3 class="dab-resume__h" id="dab-r-exp">Experience</h3>
					<?php
					$dab_n = 0;
					foreach ( dabbuilds_child_experience() as $e ) :
						if ( $dab_n >= Dabbuilds_Child_Bounds::JOBS ) {
							break;
						}
						++$dab_n;
						if ( ! isset( $e['role'], $e['dates'], $e['org'], $e['bullets'] ) ) {
							continue;
						}
						if ( ! is_string( $e['role'] ) || ! is_string( $e['dates'] ) || ! is_string( $e['org'] ) || ! is_array( $e['bullets'] ) ) {
							continue;
						}
						?>
						<div class="dab-resume__job">
							<div class="dab-resume__jobhead">
								<p class="dab-resume__role"><?php echo esc_html( $e['role'] ); ?></p>
								<p class="dab-resume__dates"><?php echo esc_html( $e['dates'] ); ?></p>
							</div>
							<p class="dab-resume__org"><?php echo esc_html( $e['org'] ); ?><?php echo ( isset( $e['place'] ) && is_string( $e['place'] ) && '' !== $e['place'] ) ? ', ' . esc_html( $e['place'] ) : ''; ?></p>
							<ul>
								<?php
								$dab_b = 0;
								foreach ( $e['bullets'] as $b ) :
									if ( $dab_b >= Dabbuilds_Child_Bounds::BULLETS ) {
										break;
									}
									++$dab_b;
									if ( ! is_string( $b ) ) {
										continue;
									}
									?>
									<li><?php echo esc_html( $b ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
					<div class="dab-resume__job">
						<p class="dab-resume__role">Earlier</p>
						<ul>
							<?php
							$dab_r = 0;
							foreach ( dabbuilds_child_earlier_roles() as $r ) :
								if ( $dab_r >= Dabbuilds_Child_Bounds::EARLIER ) {
									break;
								}
								++$dab_r;
								?>
								<li><?php echo esc_html( $r ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</section>

				<section class="dab-resume__block" aria-labelledby="dab-r-edu">
					<h3 class="dab-resume__h" id="dab-r-edu">Education</h3>
					<?php
					$dab_ed = 0;
					foreach ( dabbuilds_child_education() as $ed ) :
						if ( $dab_ed >= Dabbuilds_Child_Bounds::EDUCATION ) {
							break;
						}
						++$dab_ed;
						if ( ! isset( $ed['detail'], $ed['dates'], $ed['school'] ) ) {
							continue;
						}
						if ( ! is_string( $ed['detail'] ) || ! is_string( $ed['dates'] ) || ! is_string( $ed['school'] ) ) {
							continue;
						}
						?>
						<div class="dab-resume__jobhead">
							<p class="dab-resume__role"><?php echo esc_html( $ed['detail'] ); ?></p>
							<p class="dab-resume__dates"><?php echo esc_html( $ed['dates'] ); ?></p>
						</div>
						<p class="dab-resume__org"><?php echo esc_html( $ed['school'] ); ?></p>
					<?php endforeach; ?>
				</section>

				<section class="dab-resume__block" aria-labelledby="dab-r-skills">
					<h3 class="dab-resume__h" id="dab-r-skills">Skills</h3>
					<?php
					$dab_g = 0;
					foreach ( dabbuilds_child_skills() as $group => $items ) :
						if ( $dab_g >= Dabbuilds_Child_Bounds::SKILL_GROUPS ) {
							break;
						}
						++$dab_g;
						$clean = array();
						$dab_s = 0;
						foreach ( $items as $item ) {
							if ( $dab_s >= Dabbuilds_Child_Bounds::SKILLS ) {
								break;
							}
							++$dab_s;
							$clean[] = $item;
						}
						?>
						<p><strong><?php echo esc_html( $group ); ?>:</strong> <?php echo esc_html( implode( ', ', $clean ) ); ?></p>
					<?php endforeach; ?>
				</section>

				<section class="dab-resume__block" aria-labelledby="dab-r-certs">
					<h3 class="dab-resume__h" id="dab-r-certs">Certifications</h3>
					<ul>
						<?php
						$dab_c = 0;
						foreach ( dabbuilds_child_certifications() as $cert ) :
							if ( $dab_c >= Dabbuilds_Child_Bounds::CERTS ) {
								break;
							}
							++$dab_c;
							?>
							<li><?php echo esc_html( $cert ); ?></li>
						<?php endforeach; ?>
					</ul>
				</section>
			</article>
		</div>
	</section>
</main>
<?php
get_footer();
