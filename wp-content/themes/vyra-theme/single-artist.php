<?php
/**
 * Single Template for 'Artist' Custom Post Type
 * URL: /artists/[artist-slug]/
 *
 * @package VYRA
 */

get_header();

while ( have_posts() ) :
	the_post();

	$artist_id = get_the_ID();
	$genre     = get_post_meta( $artist_id, '_vyra_artist_genre', true ) ?: 'Electronic / Ambient';
	$location  = get_post_meta( $artist_id, '_vyra_artist_location', true );
	$website   = get_post_meta( $artist_id, '_vyra_artist_website', true );
	$instagram = get_post_meta( $artist_id, '_vyra_artist_instagram', true );
	$spotify   = get_post_meta( $artist_id, '_vyra_artist_spotify', true );

	$img_url = get_the_post_thumbnail_url( $artist_id, 'full' );
	if ( ! $img_url ) {
		$img_url = get_template_directory_uri() . '/assets/images/artist.jpg';
	}

	// Query releases connected to this artist
	$artist_releases_query = new WP_Query( array(
		'post_type'      => 'release',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => '_vyra_release_artist_id',
				'value'   => $artist_id,
				'compare' => '=',
			),
			array(
				'key'     => '_vyra_release_artist',
				'value'   => get_the_title(),
				'compare' => '=',
			),
		),
	) );
	?>

	<main class="vyra-main-content">
		<section class="vyra-section vyra-single-artist-section">
			<div class="vyra-container">

				<!-- BACK LINK -->
				<div class="vyra-back-wrapper">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'artist' ) ); ?>" class="vyra-back-link">
						&larr; BACK TO ARTISTS
					</a>
				</div>

				<!-- MAIN ARTIST GRID -->
				<div class="vyra-single-artist-grid">

					<!-- LEFT COLUMN: LARGE ARTIST PORTRAIT -->
					<div class="vyra-single-artwork-col">
						<div class="vyra-single-artwork-frame vyra-artist-portrait-frame">
							<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> Portrait" class="vyra-single-artwork-img vyra-artist-portrait-img">
							<div class="vyra-artist-vignette"></div>
							<div class="vyra-artist-badge-overlay">RESIDENT ARTIST</div>
						</div>
					</div>

					<!-- RIGHT COLUMN: ARTIST DETAILS & BIO -->
					<div class="vyra-single-info-col">
						<div class="vyra-single-header-meta">
							<span class="vyra-release-type-year">ARTIST &bull; <?php echo esc_html( strtoupper( $genre ) ); ?></span>
							<h1 class="vyra-single-title"><?php the_title(); ?></h1>
							<?php if ( $location ) : ?>
								<p class="vyra-single-artist-location"><?php echo esc_html( $location ); ?></p>
							<?php endif; ?>
						</div>

						<!-- BIO -->
						<div class="vyra-single-description vyra-body-content">
							<?php the_content(); ?>
						</div>

						<!-- SOCIAL & EXTERNAL LINKS -->
						<?php if ( $website || $instagram || $spotify ) : ?>
							<div class="vyra-artist-socials-box">
								<h3 class="vyra-meta-box-heading">CONNECT & FOLLOW</h3>
								<div class="vyra-artist-social-links">
									<?php if ( $spotify ) : ?>
										<a href="<?php echo esc_url( $spotify ); ?>" target="_blank" rel="noopener noreferrer" class="vyra-btn vyra-btn-outline vyra-btn-sm">
											<span>Spotify</span>
										</a>
									<?php endif; ?>
									<?php if ( $instagram ) : ?>
										<a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" class="vyra-btn vyra-btn-outline vyra-btn-sm">
											<span>Instagram</span>
										</a>
									<?php endif; ?>
									<?php if ( $website ) : ?>
										<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer" class="vyra-btn vyra-btn-outline vyra-btn-sm">
											<span>Official Website</span>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

					</div>
				</div>

				<!-- RELEASES BY THIS ARTIST SECTION -->
				<div class="vyra-artist-releases-section">
					<div class="vyra-section-header vyra-flex-between">
						<div>
							<span class="vyra-section-sub">DISCOGRAPHY</span>
							<h2 class="vyra-section-title">RELEASES BY <?php echo esc_html( strtoupper( get_the_title() ) ); ?></h2>
						</div>
					</div>

					<?php if ( $artist_releases_query->have_posts() ) : ?>
						<div class="vyra-releases-grid vyra-archive-grid">
							<?php
							$rel_count = 0;
							while ( $artist_releases_query->have_posts() ) :
								$artist_releases_query->the_post();
								$rel_count++;
								$formatted_num = sprintf( '%02d', $rel_count );
								$rel_year      = get_post_meta( get_the_ID(), '_vyra_release_year', true ) ?: get_the_date( 'Y' );
								$rel_type      = get_post_meta( get_the_ID(), '_vyra_release_type', true ) ?: 'Single';
								$rel_img_url   = get_the_post_thumbnail_url( get_the_ID(), 'large' );

								if ( ! $rel_img_url ) {
									$rel_img_url = get_template_directory_uri() . '/assets/images/midnight-echo.jpg';
								}
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'vyra-release-card vyra-archive-card' ); ?>>
									<a href="<?php the_permalink(); ?>" class="vyra-card-link-wrapper" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
										<div class="vyra-card-media">
											<img src="<?php echo esc_url( $rel_img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> Release Artwork" class="vyra-card-img" loading="lazy">
											<div class="vyra-artwork-light-sheen"></div>
											<div class="vyra-card-hover-overlay">
												<span class="vyra-view-btn">VIEW RELEASE &rarr;</span>
											</div>
											<span class="vyra-artwork-number"><?php echo esc_html( $formatted_num ); ?></span>
										</div>
										<div class="vyra-release-meta">
											<div class="vyra-release-top-line">
												<span class="vyra-release-year"><?php echo esc_html( $rel_year ); ?></span>
												<span class="vyra-release-type-badge"><?php echo esc_html( strtoupper( $rel_type ) ); ?></span>
											</div>
											<h3 class="vyra-release-title"><?php the_title(); ?></h3>
											<p class="vyra-release-artist"><?php echo esc_html( get_the_title( $artist_id ) ); ?></p>
										</div>
									</a>
								</article>
							<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					<?php else : ?>
						<div class="vyra-empty-state">
							<p class="vyra-empty-title">NO RELEASES FOUND</p>
							<p class="vyra-empty-sub">There are no releases linked to this artist yet.</p>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</section>
	</main>

<?php
endwhile;

get_footer();
?>