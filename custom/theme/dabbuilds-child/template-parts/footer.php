<?php
/**
 * Site footer with lighting hint.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer id="site-footer" class="site-footer">
	<div class="site-footer__inner">
		<p class="dab-light-hint" data-dab-light-hint>
			<?php echo esc_html__( 'Light follows your local clock, one hour at a time.', 'dabbuilds-child' ); ?>
		</p>
		<p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
			·
			<a href="https://github.com/Phoniness2005/dabbuilds"><?php echo esc_html__( 'Source', 'dabbuilds-child' ); ?></a>
		</p>
	</div>
</footer>
