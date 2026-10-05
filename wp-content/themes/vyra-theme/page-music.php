<?php
/**
 * Template Name: Music Library Page
 * Template for /music/ endpoint
 *
 * @package VYRA
 */

get_header(); ?>

<main class="vyra-main-content">
	<!-- MUSIC LIBRARY HERO / HEADER -->
	<section class="vyra-archive-hero vyra-section">
		<div class="vyra-container">
			<div class="vyra-archive-header-content">
				<span class="vyra-section-sub">MUSIC</span>
				<h1 class="vyra-section-title">ALL MUSIC</h1>
				<p class="vyra-archive-description">
					Explore the VYRA catalogue &mdash; releases, artists, and sounds.
				</p>
			</div>
		</div>
	</section>

	<!-- MUSIC TRACK LISTING SECTION -->
	<section class="vyra-section vyra-music-library-section">
		<div class="vyra-container">

			<?php
			$music_releases_query = new WP_Query( array(
				'post_type'      => 'release',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );

			if ( $music_releases_query->have_posts() ) :
				?>
				<div class="vyra-music-table-wrapper">

					<!-- DESKTOP TABLE HEADER -->
					<div class="vyra-music-table-header" aria-hidden="true">
						<span class="vyra-col-num">#</span>
						<span class="vyra-col-title">TRACK TITLE</span>
						<span class="vyra-col-artist">ARTIST</span>
						<span class="vyra-col-release">RELEASE</span>
						<span class="vyra-col-audio">AUDIO</span>
					</div>

					<!-- TRACK ROWS -->
					<div class="vyra-music-table-body">
						<?php
						$row_count = 0;
						while ( $music_releases_query->have_posts() ) :
							$music_releases_query->the_post();
							$row_count++;
							$formatted_num   = sprintf( '%02d', $row_count );
							$artist_name     = vyra_get_release_artist_name( get_the_ID() );
							$artist_link     = vyra_get_release_artist_link( get_the_ID() );
							$release_type    = get_post_meta( get_the_ID(), '_vyra_release_type', true ) ?: 'Single';
							$release_year    = get_post_meta( get_the_ID(), '_vyra_release_year', true ) ?: get_the_date( 'Y' );
							$catalog_num     = get_post_meta( get_the_ID(), '_vyra_catalog_number', true );
							$audioigniter_id = get_post_meta( get_the_ID(), '_vyra_audioigniter_id', true );
							$img_url         = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );

							$slug = get_post_field( 'post_name', get_the_ID() );
							if ( ! $img_url && file_exists( get_template_directory() . '/assets/images/' . $slug . '.jpg' ) ) {
								$img_url = get_template_directory_uri() . '/assets/images/' . $slug . '.jpg';
							}
							if ( ! $img_url ) {
								$img_url = get_template_directory_uri() . '/assets/images/midnight-echo.jpg';
							}
							?>
							<div class="vyra-music-row <?php echo ! empty( $audioigniter_id ) ? 'has-audio' : 'no-audio'; ?>">

								<!-- COL 1: NUMBER -->
								<div class="vyra-col-num">
									<span class="vyra-row-number"><?php echo esc_html( $formatted_num ); ?></span>
								</div>

								<!-- COL 2: TRACK TITLE -->
								<div class="vyra-col-title">
									<div class="vyra-track-title-block">
										<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> Thumb" class="vyra-row-thumb">
										<div class="vyra-track-name-wrapper">
											<h3 class="vyra-row-track-name">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3>
											<?php if ( $catalog_num ) : ?>
												<span class="vyra-row-catalog"><?php echo esc_html( $catalog_num ); ?></span>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- COL 3: ARTIST -->
								<div class="vyra-col-artist">
									<span class="vyra-mobile-label">ARTIST</span>
									<?php if ( $artist_link ) : ?>
										<a href="<?php echo esc_url( $artist_link ); ?>" class="vyra-artist-link"><?php echo esc_html( $artist_name ); ?></a>
									<?php else : ?>
										<span class="vyra-artist-text"><?php echo esc_html( $artist_name ); ?></span>
									<?php endif; ?>
								</div>

								<!-- COL 4: RELEASE -->
								<div class="vyra-col-release">
									<span class="vyra-mobile-label">RELEASE</span>
									<span class="vyra-release-text">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										<span class="vyra-release-meta-tag">&bull; <?php echo esc_html( strtoupper( $release_type ) ); ?> (<?php echo esc_html( $release_year ); ?>)</span>
									</span>
								</div>

								<!-- COL 5: AUDIO PLAY ENGINE -->
								<div class="vyra-col-audio">
									<?php if ( ! empty( $audioigniter_id ) ) : ?>
										<div class="vyra-featured-player vyra-music-row-player">
											<?php echo do_shortcode( '[ai_playlist id="' . esc_attr( $audioigniter_id ) . '"]' ); ?>
										</div>
									<?php else : ?>
										<div class="vyra-no-audio-tag">
											<span>CATALOGUE ENTRY</span>
										</div>
									<?php endif; ?>
								</div>

							</div>
						<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>

			<?php else : ?>
				<div class="vyra-empty-state">
					<p class="vyra-empty-title">NO TRACKS FOUND</p>
					<p class="vyra-empty-sub">Check back soon as new recordings are added to the music library.</p>
				</div>
			<?php endif; ?>

		</div>
	</section>
</main>

<?php get_footer(); ?>