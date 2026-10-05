<?php
/**
 * Single Template for 'Release' Custom Post Type
 * URL: /releases/[release-slug]/
 *
 * @package VYRA
 */

get_header();

while ( have_posts() ) :
	the_post();

	$artist          = vyra_get_release_artist_name( get_the_ID() );
	$artist_link     = vyra_get_release_artist_link( get_the_ID() );
	$year            = get_post_meta( get_the_ID(), '_vyra_release_year', true ) ?: get_the_date( 'Y' );
	$type            = get_post_meta( get_the_ID(), '_vyra_release_type', true ) ?: 'Single';
	$catalog_num     = get_post_meta( get_the_ID(), '_vyra_catalog_number', true );
	$genre           = get_post_meta( get_the_ID(), '_vyra_release_genre', true );
	$audioigniter_id = get_post_meta( get_the_ID(), '_vyra_audioigniter_id', true );
	$short_desc      = get_post_meta( get_the_ID(), '_vyra_short_description', true );

	$slug    = get_post_field( 'post_name', get_the_ID() );
	$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	if ( ! $img_url && file_exists( get_template_directory() . '/assets/images/' . $slug . '.jpg' ) ) {
		$img_url = get_template_directory_uri() . '/assets/images/' . $slug . '.jpg';
	}
	if ( ! $img_url ) {
		$img_url = get_template_directory_uri() . '/assets/images/midnight-echo.jpg';
	}
	?>

	<main class="vyra-main-content">
		<section class="vyra-section vyra-single-release-section">
			<div class="vyra-container">

				<!-- BACK LINK -->
				<div class="vyra-back-wrapper">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'release' ) ); ?>" class="vyra-back-link">
						&larr; BACK TO RELEASES
					</a>
				</div>

				<!-- SINGLE RELEASE MAIN GRID -->
				<div class="vyra-single-release-grid">

					<!-- LEFT COLUMN: LARGE ARTWORK -->
					<div class="vyra-single-artwork-col">
						<div class="vyra-single-artwork-frame">
							<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?> Cover Artwork" class="vyra-single-artwork-img">
							<div class="vyra-artwork-light-sheen"></div>
							<?php if ( $catalog_num ) : ?>
								<span class="vyra-catalog-badge"><?php echo esc_html( $catalog_num ); ?></span>
							<?php endif; ?>
						</div>
					</div>

					<!-- RIGHT COLUMN: RELEASE DETAILS & AUDIO PLAYER -->
					<div class="vyra-single-info-col">
						<div class="vyra-single-header-meta">
							<span class="vyra-release-type-year">
								<?php echo esc_html( strtoupper( $type ) ); ?> &bull; <?php echo esc_html( $year ); ?>
							</span>
							<h1 class="vyra-single-title"><?php the_title(); ?></h1>
							<p class="vyra-single-artist">
								<?php if ( $artist_link ) : ?>
									<a href="<?php echo esc_url( $artist_link ); ?>" class="vyra-artist-link"><?php echo esc_html( $artist ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $artist ); ?>
								<?php endif; ?>
							</p>
						</div>

						<!-- DESCRIPTION -->
						<?php if ( ! empty( $short_desc ) ) : ?>
							<div class="vyra-single-description">
								<p><?php echo nl2br( esc_html( $short_desc ) ); ?></p>
							</div>
						<?php elseif ( get_the_content() ) : ?>
							<div class="vyra-single-description vyra-body-content">
								<?php the_content(); ?>
							</div>
						<?php endif; ?>

						<!-- AUDIO PLAYER AREA (Only render if playlist ID exists) -->
						<?php if ( ! empty( $audioigniter_id ) ) : ?>
							<div class="vyra-single-player-area">
								<div class="vyra-player-label">
									<span class="vyra-live-dot"></span>
									<span>OFFICIAL RELEASE AUDIO</span>
								</div>
								<div class="vyra-featured-player vyra-single-player">
									<?php echo do_shortcode( '[ai_playlist id="' . esc_attr( $audioigniter_id ) . '"]' ); ?>
								</div>
							</div>
						<?php endif; ?>

						<!-- RELEASE METADATA BREAKDOWN -->
						<div class="vyra-single-meta-box">
							<h3 class="vyra-meta-box-heading">RELEASE INFORMATION</h3>
							<dl class="vyra-meta-dl">
								<div class="vyra-meta-item">
									<dt>ARTIST</dt>
									<dd>
										<?php if ( $artist_link ) : ?>
											<a href="<?php echo esc_url( $artist_link ); ?>" class="vyra-artist-link"><?php echo esc_html( $artist ); ?></a>
										<?php else : ?>
											<?php echo esc_html( $artist ); ?>
										<?php endif; ?>
									</dd>
								</div>
								<div class="vyra-meta-item">
									<dt>FORMAT</dt>
									<dd><?php echo esc_html( $type ); ?></dd>
								</div>
								<div class="vyra-meta-item">
									<dt>YEAR</dt>
									<dd><?php echo esc_html( $year ); ?></dd>
								</div>
								<?php if ( $catalog_num ) : ?>
									<div class="vyra-meta-item">
										<dt>CATALOG #</dt>
										<dd><?php echo esc_html( $catalog_num ); ?></dd>
									</div>
								<?php endif; ?>
								<?php if ( $genre ) : ?>
									<div class="vyra-meta-item">
										<dt>GENRE</dt>
										<dd><?php echo esc_html( $genre ); ?></dd>
									</div>
								<?php endif; ?>
								<div class="vyra-meta-item">
									<dt>PUBLISHED</dt>
									<dd><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></dd>
								</div>
							</dl>
						</div>

					</div>
				</div>

				<?php if ( get_the_content() && ! empty( $short_desc ) ) : ?>
					<div class="vyra-single-full-content vyra-section-subtle">
						<h3 class="vyra-subtle-heading">EDITORIAL NOTES</h3>
						<div class="vyra-body-text">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</section>
	</main>

<?php
endwhile;

get_footer();
?>