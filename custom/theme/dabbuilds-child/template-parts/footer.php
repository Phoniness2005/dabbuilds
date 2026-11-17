<?php
/**
 * Site footer.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$c = dabbuilds_child_contact();
?>
<footer id="site-footer" class="site-footer">
	<div class="site-footer__inner">
		<div class="site-footer__brand">
			<p class="dab-wordmark__text">DAB Builds</p>
			<p class="site-footer__line">Daniel Bryant &middot; <?php echo esc_html( $c['location'] ); ?></p>
		</div>
		<ul class="site-footer__links">
			<li><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></li>
			<li><a href="<?php echo esc_url( $c['linkedin'] ); ?>" rel="noopener noreferrer">LinkedIn</a></li>
			<li><a href="https://github.com/Phoniness2005/dabbuilds" rel="noopener noreferrer"><?php echo esc_html__( 'Site source', 'dabbuilds-child' ); ?></a></li>
		</ul>
		<p class="dab-light-hint" data-dab-light-hint><?php echo esc_html__( 'Auto lighting: day from 6 AM to 6 PM on your clock, night after that.', 'dabbuilds-child' ); ?></p>
	</div>
</footer>
