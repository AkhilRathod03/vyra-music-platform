<?php
/**
 * Front Page Template for VYRA Theme
 *
 * @package VYRA
 */

get_header();

$front_page_id = (int) get_option( 'page_on_front' ) ?: get_the_ID();

// CMS Editable Content with Fallbacks
$hero_heading       = get_post_meta( $front_page_id, '_vyra_hero_heading', true ) ?: 'VYRA';
$hero_description   = get_post_meta( $front_page_id, '_vyra_hero_description', true ) ?: 'MUSIC / CULTURE / SOUND';
$hero_image         = get_post_meta( $front_page_id, '_vyra_hero_image', true ) ?: ( get_template_directory_uri() . '/assets/images/hero.jpg' );

$manifesto_heading  = get_post_meta( $front_page_id, '_vyra_manifesto_heading', true ) ?: '"WHERE FREQUENCY MEETS VISION."';
$manifesto_text     = get_post_meta( $front_page_id, '_vyra_manifesto_text', true ) ?: 'Pure sound without boundaries. Experience audio in its purest editorial form.';

$about_sub          = get_post_meta( $front_page_id, '_vyra_about_sub', true ) ?: 'OUR PHILOSOPHY';
$about_heading      = get_post_meta( $front_page_id, '_vyra_about_heading', true ) ?: 'THE STORY OF VYRA';
$about_lead         = get_post_meta( $front_page_id, '_vyra_about_lead', true ) ?: 'VYRA was founded on a singular premise: music should be experienced with absolute visual and acoustic clarity.';
$about_text         = get_post_meta( $front_page_id, '_vyra_about_text', true ) ?: 'We bridge the space between underground electronic innovation and refined editorial presentation. Every release, visual element, and performance is curated to deliver an uncompromised artistic journey.';

$newsletter_heading = get_post_meta( $front_page_id, '_vyra_newsletter_heading', true ) ?: 'STAY CONNECTED.';
$newsletter_text    = get_post_meta( $front_page_id, '_vyra_newsletter_text', true ) ?: 'New releases, artists, and updates from VYRA.';
?>

<main class="vyra-main-content">

	<!-- 1. CINEMATIC HERO SECTION -->
	<section class="vyra-hero-section" id="hero">
		<div class="vyra-hero-visual-container">
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( $hero_heading ); ?> Autonomous Sound Cover" class="vyra-hero-img">
			<div class="vyra-hero-overlay"></div>
		</div>

		<div class="vyra-hero-content vyra-container">
			<h1 class="vyra-hero-brand-title"><?php echo esc_html( $hero_heading ); ?></h1>
			<p class="vyra-hero-subtitle"><?php echo esc_html( $hero_description ); ?></p>
			
			<div class="vyra-hero-ctas">
				<a href="<?php echo esc_url( home_url( '/music/' ) ); ?>" class="vyra-btn vyra-btn-primary">
					<span>Explore Music</span>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
				</a>
				<a href="#featured" class="vyra-btn vyra-btn-secondary">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
					<span>Listen Now</span>
				</a>
			</div>
		</div>

		<!-- SCROLL INDICATOR -->
		<a href="#featured" class="vyra-scroll-indicator" aria-label="Scroll to featured music">
			<span class="vyra-scroll-text">SCROLL</span>
			<span class="vyra-scroll-line"></span>
		</a>
	</section>

	<!-- 3. FEATURED MUSIC RELEASE SECTION -->
	<section class="vyra-section vyra-featured-section vyra-reveal" id="featured">
		<div class="vyra-container">
			<div class="vyra-section-header">
				<span class="vyra-section-sub">FEATURED SPOTLIGHT</span>
				<h2 class="vyra-section-title">RELEASE OF THE MONTH</h2>
			</div>

			<div class="vyra-featured-layout">
				<!-- LARGE ALBUM ARTWORK CONTAINER -->
				<div class="vyra-featured-artwork-wrapper">
					<div class="vyra-artwork-container vyra-artwork-featured">
						<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/midnight-echo.jpg" alt="Midnight Echo Album Artwork" class="vyra-artwork-img">
						<div class="vyra-artwork-light-sheen"></div>
						<span class="vyra-artwork-number">01</span>
						<span class="vyra-artwork-brand">VYRA RECORDS</span>
						<button class="vyra-play-overlay-btn" aria-label="Play Midnight Echo">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
						</button>
					</div>
				</div>

				<!-- TRACK METADATA & PLAYER CONTAINER -->
				<div class="vyra-featured-info">
					<div class="vyra-meta-badge">LP &bull; 2026</div>
					<h3 class="vyra-track-title">Midnight Echo</h3>
					<p class="vyra-track-artist">By VYRA Artist</p>
					
					<p class="vyra-track-description">
						An enigmatic exploration of twilight synth layers, deep bass foundations, and ethereal vocal reverberations. Crafted specifically for dark-room listening and high-fidelity sound systems.
					</p>

					<!-- AUDIOIGNITER FEATURED PLAYER CONTAINER -->
					<div class="vyra-featured-player-box" id="vyra-player-container">
						<div class="vyra-player-label">
							<span class="vyra-live-dot"></span>
							<span>OFFICIAL RELEASE AUDIO</span>
						</div>
						<div class="vyra-featured-player">
							<?php echo do_shortcode( '[ai_playlist id="5"]' ); ?>
						</div>
					</div>


				</div>
			</div>
		</div>
	</section>

	<!-- 4. LATEST RELEASES SECTION -->
	<section class="vyra-section vyra-releases-section vyra-reveal" id="releases">
		<div class="vyra-container">
			<div class="vyra-section-header vyra-flex-between">
				<div>
					<span class="vyra-section-sub">DISCOGRAPHY</span>
					<h2 class="vyra-section-title">LATEST RELEASES</h2>
				</div>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'release' ) ); ?>" class="vyra-link-arrow">View All Discography &rarr;</a>
			</div>

			<?php
			$vyra_homepage_releases = new WP_Query( array(
				'post_type'      => 'release',
				'posts_per_page' => 4,
				'post_status'    => 'publish',
			) );

			$vyra_has_query_releases = $vyra_homepage_releases->have_posts();
			$vyra_release_count      = $vyra_has_query_releases ? $vyra_homepage_releases->post_count : 1;
			$grid_class              = ( $vyra_release_count === 1 ) ? 'vyra-releases-grid vyra-releases-single-card' : 'vyra-releases-grid';
			?>

			<div class="<?php echo esc_attr( $grid_class ); ?>">
				<?php
				if ( $vyra_has_query_releases ) :
					$vyra_card_count = 0;
					while ( $vyra_homepage_releases->have_posts() ) :
						$vyra_homepage_releases->the_post();
						$vyra_card_count++;
						$formatted_num = sprintf( '%02d', $vyra_card_count );
						$year          = get_post_meta( get_the_ID(), '_vyra_release_year', true ) ?: get_the_date( 'Y' );
						$artist        = vyra_get_release_artist_name( get_the_ID() );
						$img_url       = get_the_post_thumbnail_url( get_the_ID(), 'large' );

						if ( ! $img_url ) {
							$img_url = get_template_directory_uri() . '/assets/images/midnight-echo.jpg';
						}
						?>
						<div class="vyra-release-card">
							<a href="<?php the_permalink(); ?>" class="vyra-card-link-wrapper">
								<div class="vyra-card-media">
									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> Release Artwork" class="vyra-card-img">
									<div class="vyra-artwork-light-sheen"></div>
									<div class="vyra-card-hover-overlay">
										<span class="vyra-view-btn">VIEW RELEASE &rarr;</span>
									</div>
									<span class="vyra-artwork-number"><?php echo esc_html( $formatted_num ); ?></span>
								</div>
								<div class="vyra-release-meta">
									<span class="vyra-release-year"><?php echo esc_html( $year ); ?></span>
									<h4 class="vyra-release-title"><?php the_title(); ?></h4>
									<p class="vyra-release-artist"><?php echo esc_html( $artist ); ?></p>
								</div>
							</a>
						</div>
					<?php
					endwhile;
					wp_reset_postdata();
				else :
					// Real fallback single release card: Midnight Echo
					?>
					<div class="vyra-release-card">
						<a href="<?php echo esc_url( home_url( '/releases/midnight-echo/' ) ); ?>" class="vyra-card-link-wrapper">
							<div class="vyra-card-media">
								<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/midnight-echo.jpg" alt="Midnight Echo Release Artwork" class="vyra-card-img">
								<div class="vyra-artwork-light-sheen"></div>
								<div class="vyra-card-hover-overlay">
									<span class="vyra-view-btn">VIEW RELEASE &rarr;</span>
								</div>
								<span class="vyra-artwork-number">01</span>
							</div>
							<div class="vyra-release-meta">
								<span class="vyra-release-year">2026</span>
								<h4 class="vyra-release-title">Midnight Echo</h4>
								<p class="vyra-release-artist">VYRA Artist</p>
							</div>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- 5. ARTIST SPOTLIGHT SECTION -->
	<section class="vyra-section vyra-artist-section vyra-reveal" id="artists">
		<div class="vyra-container">
			<?php
			$featured_artist_query = new WP_Query( array(
				'post_type'      => 'artist',
				'posts_per_page' => 1,
				'post_status'    => 'publish',
				'meta_query'     => array(
					array(
						'key'     => '_vyra_artist_is_featured',
						'value'   => '1',
						'compare' => '=',
					),
				),
			) );

			if ( $featured_artist_query->have_posts() ) :
				while ( $featured_artist_query->have_posts() ) :
					$featured_artist_query->the_post();
					$f_artist_id = get_the_ID();
					$f_bio       = get_the_content() ?: 'Redefining contemporary electronic texture through organic acoustics and precise digital architecture. VYRA Artist combines cinematic depth with minimalist rhythmic restraint.';
					$f_img_url   = get_the_post_thumbnail_url( $f_artist_id, 'full' );
					if ( ! $f_img_url ) {
						$f_img_url = get_template_directory_uri() . '/assets/images/artist.jpg';
					}
					?>
					<div class="vyra-artist-grid">
						<!-- CINEMATIC ARTIST PORTRAIT CONTAINER -->
						<div class="vyra-artist-media">
							<div class="vyra-artist-photo">
								<img src="<?php echo esc_url( $f_img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> Resident Artist" class="vyra-artist-img">
								<div class="vyra-artist-vignette"></div>
								<div class="vyra-artist-badge-overlay">RESIDENT ARTIST</div>
							</div>
						</div>

						<div class="vyra-artist-content">
							<span class="vyra-section-sub">ARTIST SPOTLIGHT</span>
							<h2 class="vyra-artist-name"><?php the_title(); ?></h2>
							<div class="vyra-artist-bio">
								<p><?php echo esc_html( wp_strip_all_tags( $f_bio ) ); ?></p>
							</div>
							<div>
								<a href="<?php echo esc_url( get_post_type_archive_link( 'artist' ) ); ?>" class="vyra-btn vyra-btn-outline">
									<span>Explore Artist Roster</span>
								</a>
							</div>
						</div>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<div class="vyra-artist-grid">
					<!-- CINEMATIC ARTIST PORTRAIT CONTAINER -->
					<div class="vyra-artist-media">
						<div class="vyra-artist-photo">
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/artist.jpg" alt="VYRA Resident Artist" class="vyra-artist-img">
							<div class="vyra-artist-vignette"></div>
							<div class="vyra-artist-badge-overlay">RESIDENT ARTIST</div>
						</div>
					</div>

					<div class="vyra-artist-content">
						<span class="vyra-section-sub">ARTIST SPOTLIGHT</span>
						<h2 class="vyra-artist-name">VYRA ARTIST</h2>
						<p class="vyra-artist-bio">
							Redefining contemporary electronic texture through organic acoustics and precise digital architecture. VYRA Artist combines cinematic depth with minimalist rhythmic restraint.
						</p>
						<div>
							<a href="<?php echo esc_url( get_post_type_archive_link( 'artist' ) ); ?>" class="vyra-btn vyra-btn-outline">
								<span>Explore Artist Roster</span>
							</a>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<!-- 6. FULL-WIDTH VISUAL SECTION (MANIFESTO) -->
	<section class="vyra-fullwidth-section vyra-reveal" id="fullwidth-visual">
		<div class="vyra-fullwidth-visual-container">
			<div class="vyra-fullwidth-overlay"></div>
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="VYRA Manifesto Background" class="vyra-fullwidth-img">
		</div>
		<div class="vyra-fullwidth-content vyra-container">
			<span class="vyra-fullwidth-caption">MANIFESTO</span>
			<h2 class="vyra-fullwidth-heading"><?php echo esc_html( $manifesto_heading ); ?></h2>
			<p class="vyra-fullwidth-subtext"><?php echo esc_html( $manifesto_text ); ?></p>
		</div>
	</section>

	<!-- 7. ABOUT VYRA SECTION (EDITORIAL TWO-COLUMN LAYOUT) -->
	<section class="vyra-section vyra-about-section vyra-reveal" id="about">
		<div class="vyra-container">
			<div class="vyra-about-grid">
				<div class="vyra-about-left">
					<span class="vyra-section-sub"><?php echo esc_html( $about_sub ); ?></span>
					<h2 class="vyra-section-title"><?php echo esc_html( $about_heading ); ?></h2>
				</div>
				<div class="vyra-about-right">
					<p class="vyra-lead-text">
						<?php echo esc_html( $about_lead ); ?>
					</p>
					<p class="vyra-body-text">
						<?php echo esc_html( $about_text ); ?>
					</p>
					<div class="vyra-pillars">
						<div class="vyra-pillar-item">
							<h4 class="vyra-pillar-title">01. Precision Curation</h4>
							<p>Selecting only soundscapes that push artistic boundaries.</p>
						</div>
						<div class="vyra-pillar-item">
							<h4 class="vyra-pillar-title">02. High Fidelity</h4>
							<p>Uncompressed sonic depth optimized for audiophile environments.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 8. NEWSLETTER SECTION -->
	<section class="vyra-section vyra-newsletter-section vyra-reveal" id="newsletter">
		<div class="vyra-container">
			<div class="vyra-newsletter-box">
				<div class="vyra-newsletter-content">
					<span class="vyra-section-sub">NEWSLETTER</span>
					<h2 class="vyra-newsletter-heading"><?php echo esc_html( $newsletter_heading ); ?></h2>
					<p class="vyra-newsletter-desc">
						<?php echo esc_html( $newsletter_text ); ?>
					</p>

					<form class="vyra-newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to VYRA updates.');">
						<div class="vyra-input-wrapper">
							<input type="email" class="vyra-input-email" placeholder="Enter your email address" required aria-label="Email Address">
							<button type="submit" class="vyra-btn vyra-btn-primary">
								<span>Subscribe</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
