<?php
/**
 * Site header with always-on nav (Home + Projects + Resume),
 * lighting control, and mobile menu.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site_name    = get_bloginfo( 'name' );
$tagline      = get_bloginfo( 'description', 'display' );
$home_url     = home_url( '/' );
$resume_url   = home_url( '/dabs-resume/' );
$projects_url = home_url( '/projects/' );
?>
<header id="site-header" class="site-header">
	<div class="site-header__inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php elseif ( $site_name ) : ?>
				<div class="site-title">
					<a href="<?php echo esc_url( $home_url ); ?>" rel="home">
						<?php echo esc_html( $site_name ); ?>
					</a>
				</div>
				<?php if ( $tagline ) : ?>
					<p class="site-description"><?php echo esc_html( $tagline ); ?></p>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="dab-header-tools">
			<div class="dab-light" role="group" aria-label="<?php echo esc_attr__( 'Site lighting', 'dabbuilds-child' ); ?>">
				<button type="button" class="dab-light__btn" data-dab-mode="auto" aria-pressed="true">
					<?php echo esc_html__( 'Auto', 'dabbuilds-child' ); ?>
				</button>
				<button type="button" class="dab-light__btn" data-dab-mode="day" aria-pressed="false">
					<?php echo esc_html__( 'Day', 'dabbuilds-child' ); ?>
				</button>
				<button type="button" class="dab-light__btn" data-dab-mode="night" aria-pressed="false">
					<?php echo esc_html__( 'Night', 'dabbuilds-child' ); ?>
				</button>
			</div>

			<button
				type="button"
				class="dab-nav-toggle"
				aria-controls="dab-primary-nav"
				aria-expanded="false"
				aria-label="<?php echo esc_attr__( 'Open menu', 'dabbuilds-child' ); ?>"
			>
				<span class="dab-nav-toggle__bar" aria-hidden="true"></span>
				<span class="dab-nav-toggle__bar" aria-hidden="true"></span>
				<span class="dab-nav-toggle__bar" aria-hidden="true"></span>
			</button>
		</div>

		<nav id="dab-primary-nav" class="dab-nav" aria-label="<?php echo esc_attr__( 'Primary', 'dabbuilds-child' ); ?>">
			<ul class="dab-nav__list">
				<li class="dab-nav__item<?php echo is_front_page() || is_home() ? ' is-active' : ''; ?>">
					<a class="dab-nav__link" href="<?php echo esc_url( $home_url ); ?>">
						<?php echo esc_html__( 'Build log', 'dabbuilds-child' ); ?>
					</a>
				</li>
				<li class="dab-nav__item<?php echo is_page( 'projects' ) ? ' is-active' : ''; ?>">
					<a class="dab-nav__link" href="<?php echo esc_url( $projects_url ); ?>">
						<?php echo esc_html__( 'Projects', 'dabbuilds-child' ); ?>
					</a>
				</li>
				<li class="dab-nav__item<?php echo is_page( 'dabs-resume' ) ? ' is-active' : ''; ?>">
					<a class="dab-nav__link" href="<?php echo esc_url( $resume_url ); ?>">
						<?php echo esc_html__( 'Resume', 'dabbuilds-child' ); ?>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</header>
