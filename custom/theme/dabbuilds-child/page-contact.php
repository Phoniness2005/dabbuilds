<?php
/**
 * Contact page (/contact/). Served by the theme even without a WP page.
 *
 * No form on purpose: nothing on this page sends mail.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
$c = dabbuilds_child_contact();
?>
<main id="content" class="site-main dab-contact-page">
	<?php dabbuilds_child_page_head( 'Contact', 'Get in touch', 'Email is the fastest way to reach me.' ); ?>

	<section class="dab-section">
		<div class="dab-section__inner">
			<div class="dab-cards dab-cards--3">
				<article class="dab-card dab-contact-card">
					<p class="dab-eyebrow">Email</p>
					<h2 class="dab-card__title"><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></h2>
					<p class="dab-card__body">For roles, projects, and questions about anything on this site.</p>
					<a class="dab-btn dab-btn--primary" href="mailto:<?php echo esc_attr( $c['email'] ); ?>">Send an email</a>
				</article>
				<article class="dab-card dab-contact-card">
					<p class="dab-eyebrow">LinkedIn</p>
					<h2 class="dab-card__title">Daniel Bryant</h2>
					<p class="dab-card__body">My professional profile and work history.</p>
					<a class="dab-link-cta" href="<?php echo esc_url( $c['linkedin'] ); ?>" rel="noopener noreferrer">View profile <span aria-hidden="true">&rarr;</span></a>
				</article>
				<article class="dab-card dab-contact-card">
					<p class="dab-eyebrow">GitHub</p>
					<h2 class="dab-card__title">Phoniness2005</h2>
					<p class="dab-card__body">Source for this site and the Pong game.</p>
					<a class="dab-link-cta" href="<?php echo esc_url( $c['github'] ); ?>" rel="noopener noreferrer">View code <span aria-hidden="true">&rarr;</span></a>
				</article>
			</div>
			<p class="dab-contact-note"><a href="<?php echo esc_url( home_url( '/dabs-resume/' ) ); ?>">Résumé</a> available on this site.</p>
		</div>
	</section>
</main>
<?php
get_footer();
