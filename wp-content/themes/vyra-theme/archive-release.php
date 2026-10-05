<?php
/**
 * Archive Template for 'Release' Custom Post Type
 * URL: /releases/
 *
 * @package VYRA
 */

get_header(); ?>

<main class="vyra-main-content">
	<!-- RELEASES ARCHIVE HERO / HEADER -->
	<section class="vyra-archive-hero vyra-section">
		<div class="vyra-container">
			<div class="vyra-archive-header-content">
				<span class="vyra-section-sub">DISCOGRAPHY</span>
				<h1 class="vyra-section-title">ALL RELEASES</h1>
				<p class="vyra-archive-description">
					Explore the official catalogue of VYRA recordings, sonic architectures, and editorial releases.
				</p>
			</div>
		</div>
	</section>

	<!-- RELEASES GRID SECTION -->
	<section class="vyra-section vyra-archive-grid-section">
		<div class="vyra-container">
			<?php if ( have_posts() ) : ?>
				<div class="vyra-releases-grid vyra-archive-grid">
					<?php
					$count = 0;
					while ( have_posts() ) :
						the_post();
						$count++;
						$formatted_num = sprintf( '%02d', $count );
						$year          = get_post_meta( get_the_ID(), '_vyra_release_year', true ) ?: get_the_date( 'Y' );
						$artist        = get_post_meta( get_the_ID(), '_vyra_release_artist', true ) ?: 'VYRA Artist';
						$type          = get_post_meta( get_the_ID(), '_vyra_release_type', true ) ?: 'Single';
						$img_url       = get_the_post_thumbnail_url( get_the_ID(), 'large' );

						if ( ! $img_url ) {
							$img_url = get_template_directory_uri() . '/assets/images/midnight-echo.jpg';
						}
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'vyra-release-card vyra-archive-card' ); ?>>
							<a href="<?php the_permalink(); ?>" class="vyra-card-link-wrapper" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
								<div class="vyra-card-media">
									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> Release Artwork" class="vyra-card-img" loading="lazy">
									<div class="vyra-artwork-light-sheen"></div>
									<div class="vyra-card-hover-overlay">
										<span class="vyra-view-btn">VIEW RELEASE &rarr;</span>
									</div>
									<span class="vyra-artwork-number"><?php echo esc_html( $formatted_num ); ?></span>
								</div>
								<div class="vyra-release-meta">
									<div class="vyra-release-top-line">
										<span class="vyra-release-year"><?php echo esc_html( $year ); ?></span>
										<span class="vyra-release-type-badge"><?php echo esc_html( strtoupper( $type ) ); ?></span>
									</div>
									<h3 class="vyra-release-title"><?php the_title(); ?></h3>
									<p class="vyra-release-artist"><?php echo esc_html( $artist ); ?></p>
								</div>
							</a>
						</article>
					<?php endwhile; ?>
				</div>

				<!-- ARCHIVE PAGINATION -->
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
					<p class="vyra-empty-title">NO RELEASES FOUND</p>
					<p class="vyra-empty-sub">Check back soon for upcoming catalogue entries.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>