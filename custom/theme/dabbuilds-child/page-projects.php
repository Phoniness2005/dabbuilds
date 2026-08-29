<?php
/**
 * Projects page — live demos and public source for employers.
 *
 * Template hierarchy: page-projects.php
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$shots = array(
	'homepage'          => __( 'Site home', 'dabbuilds-child' ),
	'play'              => __( 'Wimbledon Pong', 'dabbuilds-child' ),
	'resume'            => __( 'Resume 2026', 'dabbuilds-child' ),
	'github-dabbuilds'  => __( 'Site source on GitHub', 'dabbuilds-child' ),
);
?>
<main id="content" class="site-main dab-singular dab-projects-page">
	<article class="dab-article dab-projects">
		<header class="dab-article__header">
			<a class="dab-back" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span aria-hidden="true">←</span>
				<?php echo esc_html__( 'Build log', 'dabbuilds-child' ); ?>
			</a>
			<p class="dab-article__eyebrow"><?php echo esc_html__( 'For hiring managers', 'dabbuilds-child' ); ?></p>
			<h1 class="entry-title dab-article__title"><?php echo esc_html__( 'Projects', 'dabbuilds-child' ); ?></h1>
			<p class="dab-projects__lede">
				<?php echo esc_html__( 'Live work, public source, and a current resume. Everything here is running on dabbuilds.com or GitHub — not a mockup.', 'dabbuilds-child' ); ?>
			</p>
			<div class="dab-resume__actions">
				<a class="dab-btn dab-btn--primary" href="<?php echo esc_url( home_url( '/dabs-resume/' ) ); ?>">
					<?php echo esc_html__( 'Resume', 'dabbuilds-child' ); ?>
				</a>
				<a class="dab-btn dab-btn--ghost" href="https://github.com/Phoniness2005" rel="noopener noreferrer">
					<?php echo esc_html__( 'GitHub', 'dabbuilds-child' ); ?>
				</a>
			</div>
		</header>

		<section class="dab-project-grid" aria-label="<?php echo esc_attr__( 'Featured projects', 'dabbuilds-child' ); ?>">
			<article class="dab-project-card">
				<p class="dab-project-card__eyebrow">Live</p>
				<h2 class="dab-project-card__title">dabbuilds.com</h2>
				<p class="dab-project-card__body">
					<?php echo esc_html__( 'Personal site: WordPress child theme, security headers, resume viewer, and this build log. Source is public.', 'dabbuilds-child' ); ?>
				</p>
				<p class="dab-project-card__links">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Open site', 'dabbuilds-child' ); ?></a>
					<a href="https://github.com/Phoniness2005/dabbuilds" rel="noopener noreferrer"><?php echo esc_html__( 'Source', 'dabbuilds-child' ); ?></a>
				</p>
			</article>
			<article class="dab-project-card">
				<p class="dab-project-card__eyebrow">Game</p>
				<h2 class="dab-project-card__title">Wimbledon Pong</h2>
				<p class="dab-project-card__body">
					<?php echo esc_html__( 'Browser Pong from Grok/Replit Open 2025. Hosted on this site at /play/ and on GitHub Pages.', 'dabbuilds-child' ); ?>
				</p>
				<p class="dab-project-card__links">
					<a href="<?php echo esc_url( home_url( '/play/' ) ); ?>"><?php echo esc_html__( 'Play', 'dabbuilds-child' ); ?></a>
					<a href="https://github.com/Phoniness2005/grok-replit-open-2025" rel="noopener noreferrer"><?php echo esc_html__( 'Source', 'dabbuilds-child' ); ?></a>
				</p>
			</article>
			<article class="dab-project-card">
				<p class="dab-project-card__eyebrow">Profile</p>
				<h2 class="dab-project-card__title">Resume 2026</h2>
				<p class="dab-project-card__body">
					<?php echo esc_html__( 'Current resume, viewable in the browser or downloaded as a Word document.', 'dabbuilds-child' ); ?>
				</p>
				<p class="dab-project-card__links">
					<a href="<?php echo esc_url( home_url( '/dabs-resume/' ) ); ?>"><?php echo esc_html__( 'View resume', 'dabbuilds-child' ); ?></a>
				</p>
			</article>
		</section>

		<?php
		$any_shot = false;
		foreach ( $shots as $slug => $label ) {
			if ( dabbuilds_child_shot_url( $slug ) ) {
				$any_shot = true;
				break;
			}
		}
		if ( $any_shot ) :
			?>
			<section class="dab-project-shots" aria-label="<?php echo esc_attr__( 'Recent captures', 'dabbuilds-child' ); ?>">
				<h2 class="dab-projects__sub"><?php echo esc_html__( 'Recent captures', 'dabbuilds-child' ); ?></h2>
				<div class="dab-shot-grid">
					<?php foreach ( $shots as $slug => $label ) : ?>
						<?php $url = dabbuilds_child_shot_url( $slug ); ?>
						<?php if ( $url ) : ?>
							<figure class="dab-shot">
								<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $label ); ?>" loading="lazy" width="1440" height="900">
								<figcaption><?php echo esc_html( $label ); ?></figcaption>
							</figure>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>
	</article>
</main>
<?php
get_footer();
