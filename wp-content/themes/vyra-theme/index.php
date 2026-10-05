<?php
/**
 * Main Index Template
 *
 * @package VYRA
 */

get_header(); ?>

<main class="vyra-main-content">
	<section class="vyra-section vyra-container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'vyra-article' ); ?>>
					<h1 class="vyra-page-title"><?php the_title(); ?></h1>
					<div class="vyra-entry-content">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			endwhile;
		else :
			?>
			<p><?php esc_html_e( 'No content found.', 'vyra' ); ?></p>
			<?php
		endif;
		?>
	</section>
</main>

<?php get_footer(); ?>
