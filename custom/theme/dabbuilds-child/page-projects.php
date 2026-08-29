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
			<p class="dab-article__eyebrow"><?php echo esc_html__( 'Things you can actually click', 'dabbuilds-child' ); ?></p>
			<h1 class="entry-title dab-article__title"><?php echo esc_html__( 'Projects', 'dabbuilds-child' ); ?></h1>
			<p class="dab-projects__lede">
				<?php echo esc_html__( 'I would rather send you to something that is running than to a slide deck. This is the site, the Pong game, the current resume, and the GitHub repos behind them.', 'dabbuilds-child' ); ?>
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
					<?php echo esc_html__( 'This site. Child theme, resume viewer, build log, and a little security plugin I added after poking at it. The source is public on GitHub.', 'dabbuilds-child' ); ?>
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
					<?php echo esc_html__( 'The Wimbledon-colored Pong clone I vibe-coded with Grok. Replit free hosting expired, so it lives at /play/ now. Version 2 and the original both open in their own windows. Source is on GitHub.', 'dabbuilds-child' ); ?>
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
					<?php echo esc_html__( 'Resume 2026 V1. You can read it in the browser or download the Word file. This one actually matches what I have been doing lately.', 'dabbuilds-child' ); ?>
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
				<h2 class="dab-projects__sub"><?php echo esc_html__( 'What it looks like right now', 'dabbuilds-child' ); ?></h2>
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
