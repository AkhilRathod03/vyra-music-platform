<?php
/**
 * Template Name: About Page
 * Template for /about/ endpoint
 *
 * @package VYRA
 */

get_header(); ?>

<main class="vyra-main-content">

	<!-- 1. INTRO SECTION -->
	<section class="vyra-section vyra-about-hero-section">
		<div class="vyra-container">
			<div class="vyra-about-hero-content">
				<span class="vyra-section-sub">ABOUT VYRA</span>
				<h1 class="vyra-about-main-title">
					MUSIC.<br>
					CULTURE.<br>
					SOUND.
				</h1>
				<p class="vyra-about-lead-text">
					VYRA is an independent space for music, artists, and sound-driven creative work.
				</p>
			</div>
		</div>
	</section>

	<!-- 2. MANIFESTO / APPROACH SECTION -->
	<section class="vyra-section vyra-approach-section vyra-reveal">
		<div class="vyra-container">
			<div class="vyra-approach-header">
				<span class="vyra-section-sub">OUR APPROACH</span>
				<h2 class="vyra-section-title">SOUND COMES FIRST.</h2>
				<p class="vyra-approach-body">
					VYRA brings together music, visual culture, and carefully considered digital experiences. The focus is on atmosphere, identity, and the details that make a sound feel memorable.
				</p>
			</div>

			<div class="vyra-principles-grid">
				<div class="vyra-principle-card">
					<span class="vyra-principle-num">01 &mdash; SOUND</span>
					<h3 class="vyra-principle-title">Music remains at the center.</h3>
				</div>
				<div class="vyra-principle-card">
					<span class="vyra-principle-num">02 &mdash; IDENTITY</span>
					<h3 class="vyra-principle-title">Every artist and release has its own visual language.</h3>
				</div>
				<div class="vyra-principle-card">
					<span class="vyra-principle-num">03 &mdash; EXPERIENCE</span>
					<h3 class="vyra-principle-title">The digital experience should feel as considered as the music itself.</h3>
				</div>
			</div>
		</div>
	</section>

	<!-- 3. LARGE VISUAL SECTION (EDITORIAL SPLIT LAYOUT) -->
	<section class="vyra-section vyra-visual-split-section vyra-reveal">
		<div class="vyra-container">
			<div class="vyra-split-grid">
				<div class="vyra-split-media">
					<div class="vyra-split-artwork-frame">
						<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero.jpg" alt="VYRA Studio Atmosphere" class="vyra-split-img">
						<div class="vyra-artwork-light-sheen"></div>
					</div>
				</div>
				<div class="vyra-split-content">
					<span class="vyra-section-sub">THE VYRA WORLD</span>
					<h2 class="vyra-section-title">A SPACE BUILT AROUND SOUND.</h2>
					<p class="vyra-body-text">
						Every texture, visual element, and acoustic detail is designed to create a singular, immersive environment for music to resonate.
					</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 4. WHAT WE DO SECTION -->
	<section class="vyra-section vyra-what-we-do-section vyra-reveal">
		<div class="vyra-container">
			<div class="vyra-section-header">
				<span class="vyra-section-sub">OUR SPECTRUM</span>
				<h2 class="vyra-section-title">WHAT WE DO</h2>
			</div>

			<div class="vyra-spectrum-grid">
				<div class="vyra-spectrum-card">
					<h3 class="vyra-spectrum-title">RELEASES</h3>
					<p class="vyra-spectrum-desc">Original music and curated releases.</p>
				</div>
				<div class="vyra-spectrum-card">
					<h3 class="vyra-spectrum-title">ARTISTS</h3>
					<p class="vyra-spectrum-desc">A growing roster of distinctive voices.</p>
				</div>
				<div class="vyra-spectrum-card">
					<h3 class="vyra-spectrum-title">SOUND</h3>
					<p class="vyra-spectrum-desc">Electronic, cinematic and experimental textures.</p>
				</div>
				<div class="vyra-spectrum-card">
					<h3 class="vyra-spectrum-title">VISUALS</h3>
					<p class="vyra-spectrum-desc">Photography, film and visual identity around the music.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 5. CTA SECTION -->
	<section class="vyra-section vyra-about-cta-section vyra-reveal">
		<div class="vyra-container">
			<div class="vyra-about-cta-box">
				<h2 class="vyra-cta-heading">EXPLORE VYRA.</h2>
				<div class="vyra-about-cta-buttons">
					<a href="<?php echo esc_url( home_url( '/music/' ) ); ?>" class="vyra-btn vyra-btn-primary">
						<span>EXPLORE MUSIC &rarr;</span>
					</a>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'artist' ) ); ?>" class="vyra-btn vyra-btn-outline">
						<span>MEET THE ARTISTS &rarr;</span>
					</a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>