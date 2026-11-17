<?php
/**
 * Site header: wordmark, primary nav, lighting switch.
 *
 * Nav: HOME · WORK · ABOUT · RÉSUMÉ · CONTACT (hard-coded, not a WP menu).
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$dab_nav = array(
	'home'        => array( __( 'Home', 'dabbuilds-child' ), home_url( '/' ) ),
	'projects'    => array( __( 'Work', 'dabbuilds-child' ), home_url( '/projects/' ) ),
	'about'       => array( __( 'About', 'dabbuilds-child' ), home_url( '/about/' ) ),
	'dabs-resume' => array( __( 'Résumé', 'dabbuilds-child' ), home_url( '/dabs-resume/' ) ),
	'contact'     => array( __( 'Contact', 'dabbuilds-child' ), home_url( '/contact/' ) ),
);
?>
<a class="dab-skip" href="#content"><?php echo esc_html__( 'Skip to content', 'dabbuilds-child' ); ?></a>
<header id="site-header" class="site-header">
	<div class="site-header__inner">
		<a class="dab-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr__( 'DAB Builds, home', 'dabbuilds-child' ); ?>">
			<span class="dab-wordmark__mark" aria-hidden="true">
				<svg viewBox="0 0 32 32" width="28" height="28" focusable="false"><path d="M10 2h12l8 8v12l-8 8H10l-8-8V10z" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M12 4.5h8l7.5 7.5v8L20 27.5h-8L4.5 20v-8z" fill="none" stroke="currentColor" stroke-width=".75" opacity=".6"/></svg>
			</span>
			<span class="dab-wordmark__text">DAB Builds</span>
		</a>

		<nav id="dab-primary-nav" class="dab-nav" aria-label="<?php echo esc_attr__( 'Primary', 'dabbuilds-child' ); ?>">
			<ul class="dab-nav__list">
				<?php foreach ( $dab_nav as $slug => $item ) : ?>
					<?php $active = dabbuilds_child_is_section( $slug ); ?>
					<li class="dab-nav__item<?php echo $active ? ' is-active' : ''; ?>">
						<a class="dab-nav__link" href="<?php echo esc_url( $item[1] ); ?>"<?php echo $active ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $item[0] ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<div class="dab-light" role="group" aria-label="<?php echo esc_attr__( 'Site lighting', 'dabbuilds-child' ); ?>">
			<button type="button" class="dab-light__btn" data-dab-mode="auto" aria-pressed="true"><?php echo esc_html__( 'Auto', 'dabbuilds-child' ); ?></button>
			<button type="button" class="dab-light__btn" data-dab-mode="day" aria-pressed="false"><?php echo esc_html__( 'Day', 'dabbuilds-child' ); ?></button>
			<button type="button" class="dab-light__btn" data-dab-mode="night" aria-pressed="false"><?php echo esc_html__( 'Night', 'dabbuilds-child' ); ?></button>
		</div>
	</div>
</header>
