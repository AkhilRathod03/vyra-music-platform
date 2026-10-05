<?php
/**
 * Archive Template for 'Artist' Custom Post Type
 * URL: /artists/
 *
 * @package VYRA
 */

get_header(); ?>

<main class="vyra-main-content">
	<!-- ARTISTS ARCHIVE HERO / HEADER -->
	<section class="vyra-archive-hero vyra-section">
		<div class="vyra-container">
			<div class="vyra-archive-header-content">
				<span class="vyra-section-sub">ROSTER</span>
				<h1 class="vyra-section-title">VYRA ARTISTS</h1>
				<p class="vyra-archive-description">
					The visionary composers, sound designers, and visual architects defining the VYRA aesthetic.
				</p>
			</div>
		</div>
	</section>

	<!-- ARTISTS GRID SECTION -->
	<section class="vyra-section vyra-archive-grid-section">
		<div class="vyra-container">
			<?php if ( have_posts() ) : ?>
				<div class="vyra-artists-grid vyra-archive-grid">
					<?php
					$count = 0;
					while ( have_posts() ) :
						the_post();
						$count++;
						$formatted_num = sprintf( '%02d', $count );
						$genre         = get_post_meta( get_the_ID(), '_vyra_artist_genre', true ) ?: 'Electronic / Ambient';
						$location      = get_post_meta( get_the_ID(), '_vyra_artist_location', true );
						$img_url       = get_the_post_thumbnail_url( get_the_ID(), 'large' );

						if ( ! $img_url ) {
							$img_url = get_template_directory_uri() . '/assets/images/artist.jpg';
						}
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'vyra-artist-card vyra-archive-card' ); ?>>
							<a href="<?php the_permalink(); ?>" class="vyra-card-link-wrapper" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
								<div class="vyra-card-media vyra-artist-card-media">
									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> Portrait" class="vyra-card-img vyra-artist-card-img" loading="lazy">
									<div class="vyra-artwork-light-sheen"></div>
									<div class="vyra-card-hover-overlay">
										<span class="vyra-view-btn">VIEW ARTIST &rarr;</span>
									</div>
									<span class="vyra-artwork-number"><?php echo esc_html( $formatted_num ); ?></span>
								</div>
								<div class="vyra-release-meta vyra-artist-meta">
									<span class="vyra-artist-genre-badge"><?php echo esc_html( strtoupper( $genre ) ); ?></span>
									<h3 class="vyra-artist-card-title"><?php the_title(); ?></h3>
									<?php if ( $location ) : ?>
										<p class="vyra-artist-card-location"><?php echo esc_html( $location ); ?></p>
									<?php endif; ?>
								</div>
							</a>
						</article>
					<?php endwhile; ?>
				</div>

				<!-- PAGINATION -->
				<div class="vyra-pagination-wrapper">
					<?php
					the_posts_pagination(
						array(
							'mid_size'  => 2,
							'prev_text' => __( '&larr; Previous', 'vyra' ),
							'next_text' => __( 'Next &rarr;', 'vyra' ),
						)
					);
					?>
				</div>

			<?php else : ?>
				<div class="vyra-empty-state">
					<p class="vyra-empty-title">NO ARTISTS FOUND</p>
					<p class="vyra-empty-sub">Check back soon for upcoming artist additions to the roster.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>