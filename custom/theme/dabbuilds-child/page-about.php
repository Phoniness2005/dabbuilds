<?php
/**
 * About page (/about/). Served by the theme even without a WP page.
 *
 * DRAFT COPY: Daniel approves the voice before go-live.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="content" class="site-main dab-about-page">
	<?php dabbuilds_child_page_head( 'About', 'Daniel Bryant', 'Systems, shop floors, and a home workshop.' ); ?>

	<section class="dab-section dab-about">
		<div class="dab-section__inner dab-about__grid">
			<div class="dab-prose">
				<p>I am Daniel Bryant. I started as an Army machinist, graduated from the NTMA machinist program, and have worked in machine shops, IT support, and production leadership since.</p>
				<p>In IT I supported people and systems at Vermeer, Pella Technology, and Wells Fargo. That work covered Windows and Microsoft 365 support, SCCM application deployment, imaging and new computer setup, Citrix users, and access reviews and compliance work in every role. Today I am a Production Supervisor in machining at Emerson, where I lead a team of 14 machinists.</p>
				<p>The two sides help each other. Machining taught me to measure carefully, respect a tolerance, and document what I find. IT taught me to troubleshoot calmly and write things down so the next person can follow them. At home I work in CAD, run a 3D printer, and build things like the drone in the build log.</p>
				<p>I am completing a B.A. in General Studies with a Mathematics concentration at Southern New Hampshire University, expected June 2027.</p>
				<p><a class="dab-link-cta" href="<?php echo esc_url( home_url( '/dabs-resume/' ) ); ?>">Read the full résumé <span aria-hidden="true">&rarr;</span></a></p>
			</div>
			<aside class="dab-card dab-facts" aria-label="<?php echo esc_attr__( 'At a glance', 'dabbuilds-child' ); ?>">
				<p class="dab-eyebrow">At a glance</p>
				<dl>
					<div><dt>Now</dt><dd>Production Supervisor, Emerson</dd></div>
					<div><dt>IT roles</dt><dd>Vermeer, Pella Technology, Wells Fargo</dd></div>
					<div><dt>Studying</dt><dd>B.A., SNHU, expected June 2027</dd></div>
					<div><dt>Service</dt><dd>U.S. Army, 91E Machinist, 2009 to 2014</dd></div>
				</dl>
			</aside>
		</div>
	</section>

	<?php dabbuilds_child_render_pillars(); ?>
	<?php dabbuilds_child_render_contact_strip(); ?>
</main>
<?php
get_footer();
