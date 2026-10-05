<?php
/**
 * VYRA Theme Functions and Definitions
 *
 * @package VYRA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Setup VYRA Theme features
 */
function vyra_theme_setup() {
	// Add title tag support
	add_theme_support( 'title-tag' );

	// Add featured image / post thumbnail support
	add_theme_support( 'post-thumbnails' );

	// Enable HTML5 markup support
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'vyra_theme_setup' );

/**
 * Enqueue Theme Styles and Scripts
 */
function vyra_enqueue_assets() {
	// Theme root style
	wp_enqueue_style( 'vyra-style', get_stylesheet_uri(), array(), '1.0.0' );

	// Main Custom CSS
	wp_enqueue_style(
		'vyra-main-css',
		get_template_directory_uri() . '/assets/css/vyra-main.css',
		array(),
		'1.0.0'
	);

	// Main Custom JavaScript
	wp_enqueue_script(
		'vyra-main-js',
		get_template_directory_uri() . '/assets/js/vyra-main.js',
		array(),
		'1.0.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'vyra_enqueue_assets' );

/**
 * Register 'Release' Custom Post Type
 */
function vyra_register_release_cpt() {
	$labels = array(
		'name'               => _x( 'Releases', 'post type general name', 'vyra' ),
		'singular_name'      => _x( 'Release', 'post type singular name', 'vyra' ),
		'menu_name'          => _x( 'Releases', 'admin menu', 'vyra' ),
		'name_admin_bar'     => _x( 'Release', 'add new on admin bar', 'vyra' ),
		'add_new'            => _x( 'Add New', 'release', 'vyra' ),
		'add_new_item'       => __( 'Add New Release', 'vyra' ),
		'new_item'           => __( 'New Release', 'vyra' ),
		'edit_item'          => __( 'Edit Release', 'vyra' ),
		'view_item'          => __( 'View Release', 'vyra' ),
		'all_items'          => __( 'All Releases', 'vyra' ),
		'search_items'       => __( 'Search Releases', 'vyra' ),
		'parent_item_colon'  => __( 'Parent Releases:', 'vyra' ),
		'not_found'          => __( 'No releases found.', 'vyra' ),
		'not_found_in_trash' => __( 'No releases found in Trash.', 'vyra' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'releases', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => 'releases',
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-album',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'release', $args );
}
add_action( 'init', 'vyra_register_release_cpt' );

/**
 * Register 'Artist' Custom Post Type
 */
function vyra_register_artist_cpt() {
	$labels = array(
		'name'               => _x( 'Artists', 'post type general name', 'vyra' ),
		'singular_name'      => _x( 'Artist', 'post type singular name', 'vyra' ),
		'menu_name'          => _x( 'Artists', 'admin menu', 'vyra' ),
		'name_admin_bar'     => _x( 'Artist', 'add new on admin bar', 'vyra' ),
		'add_new'            => _x( 'Add New', 'artist', 'vyra' ),
		'add_new_item'       => __( 'Add New Artist', 'vyra' ),
		'new_item'           => __( 'New Artist', 'vyra' ),
		'edit_item'          => __( 'Edit Artist', 'vyra' ),
		'view_item'          => __( 'View Artist', 'vyra' ),
		'all_items'          => __( 'All Artists', 'vyra' ),
		'search_items'       => __( 'Search Artists', 'vyra' ),
		'parent_item_colon'  => __( 'Parent Artists:', 'vyra' ),
		'not_found'          => __( 'No artists found.', 'vyra' ),
		'not_found_in_trash' => __( 'No artists found in Trash.', 'vyra' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'artists', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => 'artists',
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-admin-users',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'artist', $args );
}
add_action( 'init', 'vyra_register_artist_cpt' );

/**
 * Flush rewrite rules on CPT registration
 */
function vyra_check_flush_rules() {
	if ( get_option( 'vyra_cpt_flushed_v2' ) !== '1' ) {
		vyra_register_release_cpt();
		vyra_register_artist_cpt();
		flush_rewrite_rules();
		update_option( 'vyra_cpt_flushed_v2', '1' );
	}
}
add_action( 'init', 'vyra_check_flush_rules', 99 );

/**
 * Add Custom Metaboxes
 */
function vyra_add_theme_metaboxes() {
	// Release Metabox
	add_meta_box(
		'vyra_release_details',
		__( 'Release Details & Metadata', 'vyra' ),
		'vyra_render_release_metabox',
		'release',
		'normal',
		'high'
	);

	// Artist Metabox
	add_meta_box(
		'vyra_artist_details',
		__( 'Artist Profile & Metadata', 'vyra' ),
		'vyra_render_artist_metabox',
		'artist',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'vyra_add_theme_metaboxes' );

/**
 * Render Release Details Metabox Form
 */
function vyra_render_release_metabox( $post ) {
	wp_nonce_field( 'vyra_save_release_meta', 'vyra_release_nonce' );

	$artist_id       = get_post_meta( $post->ID, '_vyra_release_artist_id', true );
	$artist_text     = get_post_meta( $post->ID, '_vyra_release_artist', true );
	$year            = get_post_meta( $post->ID, '_vyra_release_year', true );
	$type            = get_post_meta( $post->ID, '_vyra_release_type', true );
	$catalog_num     = get_post_meta( $post->ID, '_vyra_catalog_number', true );
	$genre           = get_post_meta( $post->ID, '_vyra_release_genre', true );
	$audioigniter_id = get_post_meta( $post->ID, '_vyra_audioigniter_id', true );
	$short_desc      = get_post_meta( $post->ID, '_vyra_short_description', true );

	if ( empty( $type ) ) {
		$type = 'Single';
	}

	// Fetch Artist CPT posts for dropdown
	$artists = get_posts( array(
		'post_type'      => 'artist',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => 'any',
	) );
	?>
	<style>
		.vyra-meta-field { margin-bottom: 16px; }
		.vyra-meta-field label { display: block; font-weight: 600; margin-bottom: 6px; }
		.vyra-meta-field input[type="text"],
		.vyra-meta-field input[type="number"],
		.vyra-meta-field input[type="url"],
		.vyra-meta-field select,
		.vyra-meta-field textarea { width: 100%; max-width: 600px; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; }
		.vyra-meta-row { display: flex; gap: 20px; flex-wrap: wrap; }
		.vyra-meta-col { flex: 1; min-width: 200px; }
		.vyra-meta-desc { font-style: italic; color: #666; font-size: 12px; margin-top: 4px; }
	</style>

	<div class="vyra-meta-row">
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_release_artist_id"><?php esc_html_e( 'Select Artist (Artist CPT)', 'vyra' ); ?></label>
			<select id="vyra_release_artist_id" name="vyra_release_artist_id">
				<option value=""><?php esc_html_e( '-- Select Artist --', 'vyra' ); ?></option>
				<?php foreach ( $artists as $a ) : ?>
					<option value="<?php echo esc_attr( $a->ID ); ?>" <?php selected( $artist_id, $a->ID ); ?>>
						<?php echo esc_html( $a->post_title ); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<p class="vyra-meta-desc"><?php esc_html_e( 'Link this release to an official Artist CPT record.', 'vyra' ); ?></p>
		</div>
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_release_artist"><?php esc_html_e( 'Artist Name (Fallback / Custom)', 'vyra' ); ?></label>
			<input type="text" id="vyra_release_artist" name="vyra_release_artist" value="<?php echo esc_attr( $artist_text ); ?>" placeholder="e.g. VYRA Artist" />
		</div>
	</div>

	<div class="vyra-meta-row">
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_release_year"><?php esc_html_e( 'Release Year', 'vyra' ); ?></label>
			<input type="text" id="vyra_release_year" name="vyra_release_year" value="<?php echo esc_attr( $year ); ?>" placeholder="e.g. 2026" />
		</div>
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_release_type"><?php esc_html_e( 'Release Type', 'vyra' ); ?></label>
			<select id="vyra_release_type" name="vyra_release_type">
				<option value="Single" <?php selected( $type, 'Single' ); ?>>Single</option>
				<option value="EP" <?php selected( $type, 'EP' ); ?>>EP</option>
				<option value="LP" <?php selected( $type, 'LP' ); ?>>LP</option>
				<option value="Album" <?php selected( $type, 'Album' ); ?>>Album</option>
			</select>
		</div>
	</div>

	<div class="vyra-meta-row">
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_catalog_number"><?php esc_html_e( 'Catalog / Release Number', 'vyra' ); ?></label>
			<input type="text" id="vyra_catalog_number" name="vyra_catalog_number" value="<?php echo esc_attr( $catalog_num ); ?>" placeholder="e.g. VYRA-001" />
		</div>
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_release_genre"><?php esc_html_e( 'Genre (Optional)', 'vyra' ); ?></label>
			<input type="text" id="vyra_release_genre" name="vyra_release_genre" value="<?php echo esc_attr( $genre ); ?>" placeholder="e.g. Ambient / Techno" />
		</div>
	</div>

	<div class="vyra-meta-row">
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_audioigniter_id"><?php esc_html_e( 'AudioIgniter Playlist ID', 'vyra' ); ?></label>
			<input type="number" id="vyra_audioigniter_id" name="vyra_audioigniter_id" value="<?php echo esc_attr( $audioigniter_id ); ?>" placeholder="e.g. 5" />
			<p class="vyra-meta-desc"><?php esc_html_e( 'Numeric ID of AudioIgniter playlist. Leave blank if none.', 'vyra' ); ?></p>
		</div>
	</div>

	<div class="vyra-meta-field">
		<label for="vyra_short_description"><?php esc_html_e( 'Short Description', 'vyra' ); ?></label>
		<textarea id="vyra_short_description" name="vyra_short_description" rows="3" placeholder="Brief summary of this release..."><?php echo esc_textarea( $short_desc ); ?></textarea>
	</div>
	<?php
}

/**
 * Render Artist Details Metabox Form
 */
function vyra_render_artist_metabox( $post ) {
	wp_nonce_field( 'vyra_save_artist_meta', 'vyra_artist_nonce' );

	$genre       = get_post_meta( $post->ID, '_vyra_artist_genre', true );
	$location    = get_post_meta( $post->ID, '_vyra_artist_location', true );
	$website     = get_post_meta( $post->ID, '_vyra_artist_website', true );
	$instagram   = get_post_meta( $post->ID, '_vyra_artist_instagram', true );
	$spotify     = get_post_meta( $post->ID, '_vyra_artist_spotify', true );
	$is_featured = get_post_meta( $post->ID, '_vyra_artist_is_featured', true );
	$order       = get_post_meta( $post->ID, '_vyra_artist_order', true ) ?: '0';
	?>
	<div class="vyra-meta-row">
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_artist_genre"><?php esc_html_e( 'Genre / Style', 'vyra' ); ?></label>
			<input type="text" id="vyra_artist_genre" name="vyra_artist_genre" value="<?php echo esc_attr( $genre ); ?>" placeholder="e.g. Ambient / Techno" />
		</div>
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_artist_location"><?php esc_html_e( 'Location (Optional)', 'vyra' ); ?></label>
			<input type="text" id="vyra_artist_location" name="vyra_artist_location" value="<?php echo esc_attr( $location ); ?>" placeholder="e.g. Berlin / London" />
		</div>
	</div>

	<div class="vyra-meta-row">
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_artist_website"><?php esc_html_e( 'Website URL (Optional)', 'vyra' ); ?></label>
			<input type="url" id="vyra_artist_website" name="vyra_artist_website" value="<?php echo esc_url( $website ); ?>" placeholder="https://artistname.com" />
		</div>
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_artist_instagram"><?php esc_html_e( 'Instagram URL (Optional)', 'vyra' ); ?></label>
			<input type="url" id="vyra_artist_instagram" name="vyra_artist_instagram" value="<?php echo esc_url( $instagram ); ?>" placeholder="https://instagram.com/artistname" />
		</div>
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_artist_spotify"><?php esc_html_e( 'Spotify URL (Optional)', 'vyra' ); ?></label>
			<input type="url" id="vyra_artist_spotify" name="vyra_artist_spotify" value="<?php echo esc_url( $spotify ); ?>" placeholder="https://open.spotify.com/artist/..." />
		</div>
	</div>

	<div class="vyra-meta-row">
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_artist_is_featured">
				<input type="checkbox" id="vyra_artist_is_featured" name="vyra_artist_is_featured" value="1" <?php checked( $is_featured, '1' ); ?> />
				<?php esc_html_e( 'Featured Artist (Display in Homepage Spotlight)', 'vyra' ); ?>
			</label>
		</div>
		<div class="vyra-meta-col vyra-meta-field">
			<label for="vyra_artist_order"><?php esc_html_e( 'Display Order / Priority', 'vyra' ); ?></label>
			<input type="number" id="vyra_artist_order" name="vyra_artist_order" value="<?php echo esc_attr( $order ); ?>" style="width: 100px;" />
		</div>
	</div>
	<?php
}

/**
 * Save Release Metadata
 */
function vyra_save_release_meta( $post_id ) {
	if ( ! isset( $_POST['vyra_release_nonce'] ) || ! wp_verify_nonce( $_POST['vyra_release_nonce'], 'vyra_save_release_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['vyra_release_artist_id'] ) ) {
		update_post_meta( $post_id, '_vyra_release_artist_id', sanitize_text_field( $_POST['vyra_release_artist_id'] ) );
	}

	$fields = array(
		'vyra_release_artist'    => '_vyra_release_artist',
		'vyra_release_year'      => '_vyra_release_year',
		'vyra_release_type'      => '_vyra_release_type',
		'vyra_catalog_number'    => '_vyra_catalog_number',
		'vyra_release_genre'     => '_vyra_release_genre',
		'vyra_audioigniter_id'   => '_vyra_audioigniter_id',
		'vyra_short_description' => '_vyra_short_description',
	);

	foreach ( $fields as $input_key => $meta_key ) {
		if ( isset( $_POST[ $input_key ] ) ) {
			if ( 'vyra_short_description' === $input_key ) {
				update_post_meta( $post_id, $meta_key, sanitize_textarea_field( $_POST[ $input_key ] ) );
			} else {
				update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $input_key ] ) );
			}
		}
	}
}
add_action( 'save_post_release', 'vyra_save_release_meta' );

/**
 * Save Artist Metadata
 */
function vyra_save_artist_meta( $post_id ) {
	if ( ! isset( $_POST['vyra_artist_nonce'] ) || ! wp_verify_nonce( $_POST['vyra_artist_nonce'], 'vyra_save_artist_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_vyra_artist_genre', isset( $_POST['vyra_artist_genre'] ) ? sanitize_text_field( $_POST['vyra_artist_genre'] ) : '' );
	update_post_meta( $post_id, '_vyra_artist_location', isset( $_POST['vyra_artist_location'] ) ? sanitize_text_field( $_POST['vyra_artist_location'] ) : '' );
	update_post_meta( $post_id, '_vyra_artist_website', isset( $_POST['vyra_artist_website'] ) ? esc_url_raw( $_POST['vyra_artist_website'] ) : '' );
	update_post_meta( $post_id, '_vyra_artist_instagram', isset( $_POST['vyra_artist_instagram'] ) ? esc_url_raw( $_POST['vyra_artist_instagram'] ) : '' );
	update_post_meta( $post_id, '_vyra_artist_spotify', isset( $_POST['vyra_artist_spotify'] ) ? esc_url_raw( $_POST['vyra_artist_spotify'] ) : '' );
	update_post_meta( $post_id, '_vyra_artist_is_featured', isset( $_POST['vyra_artist_is_featured'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_vyra_artist_order', isset( $_POST['vyra_artist_order'] ) ? sanitize_text_field( $_POST['vyra_artist_order'] ) : '0' );
}
add_action( 'save_post_artist', 'vyra_save_artist_meta' );

/**
 * Helper Functions for Release & Artist
 */
function vyra_get_release_artist_name( $release_id ) {
	$artist_id = get_post_meta( $release_id, '_vyra_release_artist_id', true );
	if ( $artist_id && 'publish' === get_post_status( $artist_id ) ) {
		return get_the_title( $artist_id );
	}
	$text_name = get_post_meta( $release_id, '_vyra_release_artist', true );
	return ! empty( $text_name ) ? $text_name : 'VYRA Artist';
}

function vyra_get_release_artist_link( $release_id ) {
	$artist_id = get_post_meta( $release_id, '_vyra_release_artist_id', true );
	if ( $artist_id && 'publish' === get_post_status( $artist_id ) ) {
		return get_permalink( $artist_id );
	}
	return '';
}

/**
 * Custom Admin Columns for Release CPT
 */
function vyra_release_columns( $columns ) {
	return array(
		'cb'              => $columns['cb'],
		'title'           => __( 'Title', 'vyra' ),
		'release_artist'  => __( 'Artist', 'vyra' ),
		'release_type'    => __( 'Type', 'vyra' ),
		'release_year'    => __( 'Year', 'vyra' ),
		'audioigniter_id' => __( 'Playlist ID', 'vyra' ),
		'date'            => $columns['date'],
	);
}
add_filter( 'manage_release_posts_columns', 'vyra_release_columns' );

function vyra_release_custom_column( $column, $post_id ) {
	switch ( $column ) {
		case 'release_artist':
			echo esc_html( vyra_get_release_artist_name( $post_id ) );
			break;
		case 'release_type':
			echo esc_html( get_post_meta( $post_id, '_vyra_release_type', true ) ?: 'Single' );
			break;
		case 'release_year':
			echo esc_html( get_post_meta( $post_id, '_vyra_release_year', true ) ?: '-' );
			break;
		case 'audioigniter_id':
			$id = get_post_meta( $post_id, '_vyra_audioigniter_id', true );
			echo $id ? esc_html( '#' . $id ) : '-';
			break;
	}
}
add_action( 'manage_release_posts_custom_column', 'vyra_release_custom_column', 10, 2 );

/**
 * Custom Admin Columns for Artist CPT
 */
function vyra_artist_columns( $columns ) {
	return array(
		'cb'          => $columns['cb'],
		'title'       => __( 'Artist Name', 'vyra' ),
		'genre'       => __( 'Genre', 'vyra' ),
		'location'    => __( 'Location', 'vyra' ),
		'is_featured' => __( 'Featured', 'vyra' ),
		'order'       => __( 'Order', 'vyra' ),
		'date'        => $columns['date'],
	);
}
add_filter( 'manage_artist_posts_columns', 'vyra_artist_columns' );

function vyra_artist_custom_column( $column, $post_id ) {
	switch ( $column ) {
		case 'genre':
			echo esc_html( get_post_meta( $post_id, '_vyra_artist_genre', true ) ?: '-' );
			break;
		case 'location':
			echo esc_html( get_post_meta( $post_id, '_vyra_artist_location', true ) ?: '-' );
			break;
		case 'is_featured':
			echo '1' === get_post_meta( $post_id, '_vyra_artist_is_featured', true ) ? '<strong>Yes</strong>' : 'No';
			break;
		case 'order':
			echo esc_html( get_post_meta( $post_id, '_vyra_artist_order', true ) ?: '0' );
			break;
	}
}
add_action( 'manage_artist_posts_custom_column', 'vyra_artist_custom_column', 10, 2 );

/**
 * Auto-Seed Test Data (VYRA Artist & Midnight Echo Release Connection)
 */
function vyra_auto_seed_artist_and_release() {
	if ( get_option( 'vyra_artist_seeded_v1' ) === '1' ) {
		return;
	}

	// 1. Create or get VYRA Artist CPT post
	$artist_post = get_page_by_title( 'VYRA Artist', OBJECT, 'artist' );
	if ( ! $artist_post ) {
		$artist_id = wp_insert_post( array(
			'post_title'   => 'VYRA Artist',
			'post_content' => 'Redefining contemporary electronic texture through organic acoustics and precise digital architecture. VYRA Artist combines cinematic depth with minimalist rhythmic restraint.',
			'post_status'  => 'publish',
			'post_type'    => 'artist',
		) );
		if ( $artist_id && ! is_wp_error( $artist_id ) ) {
			update_post_meta( $artist_id, '_vyra_artist_genre', 'Electronic / Ambient' );
			update_post_meta( $artist_id, '_vyra_artist_location', 'Berlin / London' );
			update_post_meta( $artist_id, '_vyra_artist_is_featured', '1' );
			update_post_meta( $artist_id, '_vyra_artist_order', '1' );
			update_post_meta( $artist_id, '_vyra_artist_spotify', 'https://open.spotify.com' );
			update_post_meta( $artist_id, '_vyra_artist_instagram', 'https://instagram.com' );
		}
	} else {
		$artist_id = $artist_post->ID;
		update_post_meta( $artist_id, '_vyra_artist_is_featured', '1' );
	}

	// 2. Create or link Midnight Echo Release CPT post
	if ( $artist_id && ! is_wp_error( $artist_id ) ) {
		$release_post = get_page_by_title( 'Midnight Echo', OBJECT, 'release' );
		if ( ! $release_post ) {
			$release_id = wp_insert_post( array(
				'post_title'   => 'Midnight Echo',
				'post_content' => 'An enigmatic exploration of twilight synth layers, deep bass foundations, and ethereal vocal reverberations. Crafted specifically for dark-room listening and high-fidelity sound systems.',
				'post_status'  => 'publish',
				'post_type'    => 'release',
			) );
			if ( $release_id && ! is_wp_error( $release_id ) ) {
				update_post_meta( $release_id, '_vyra_release_artist_id', $artist_id );
				update_post_meta( $release_id, '_vyra_release_artist', 'VYRA Artist' );
				update_post_meta( $release_id, '_vyra_release_year', '2026' );
				update_post_meta( $release_id, '_vyra_release_type', 'LP' );
				update_post_meta( $release_id, '_vyra_catalog_number', 'VYRA-001' );
				update_post_meta( $release_id, '_vyra_release_genre', 'Ambient / Electronic' );
				update_post_meta( $release_id, '_vyra_audioigniter_id', '5' );
				update_post_meta( $release_id, '_vyra_short_description', 'An enigmatic exploration of twilight synth layers, deep bass foundations, and ethereal vocal reverberations.' );
			}
		} else {
			update_post_meta( $release_post->ID, '_vyra_release_artist_id', $artist_id );
		}
	}

	update_option( 'vyra_artist_seeded_v1', '1' );
}
add_action( 'init', 'vyra_auto_seed_artist_and_release', 98 );
/**
 * Auto-Create 'Music' Page for /music/ endpoint
 */
function vyra_auto_create_music_page() {
	if ( get_option( 'vyra_music_page_created_v1' ) === '1' ) {
		return;
	}

	$music_page = get_page_by_path( 'music' );
	if ( ! $music_page ) {
		wp_insert_post( array(
			'post_title'   => 'Music',
			'post_name'    => 'music',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		) );
	}
	update_option( 'vyra_music_page_created_v1', '1' );
}
add_action( 'init', 'vyra_auto_create_music_page', 97 );

/**
 * Auto-Create 'About' Page for /about/ endpoint
 */
function vyra_auto_create_about_page() {
	if ( get_option( 'vyra_about_page_created_v1' ) === '1' ) {
		return;
	}

	$about_page = get_page_by_path( 'about' );
	if ( ! $about_page ) {
		wp_insert_post( array(
			'post_title'   => 'About',
			'post_name'    => 'about',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		) );
	}
	update_option( 'vyra_about_page_created_v1', '1' );
}
add_action( 'init', 'vyra_auto_create_about_page', 96 );

/**
 * Auto-Create 'Contact' Page for /contact/ endpoint
 */
function vyra_auto_create_contact_page() {
	if ( get_option( 'vyra_contact_page_created_v1' ) === '1' ) {
		return;
	}

	$contact_page = get_page_by_path( 'contact' );
	if ( ! $contact_page ) {
		wp_insert_post( array(
			'post_title'   => 'Contact',
			'post_name'    => 'contact',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		) );
	}
	update_option( 'vyra_contact_page_created_v1', '1' );
}
add_action( 'init', 'vyra_auto_create_contact_page', 95 );

/**
 * Auto-Seed Monume Release & AudioIgniter Playlist
 */
function vyra_auto_seed_monume_release() {
	if ( get_option( 'vyra_monume_seeded_v1' ) === '1' ) {
		return;
	}

	// 1. Get VYRA Artist CPT post ID
	$artist_post = get_page_by_title( 'VYRA Artist', OBJECT, 'artist' );
	$artist_id   = $artist_post ? $artist_post->ID : 0;

	// 2. Create or find AudioIgniter Playlist post for Monume
	$ai_playlist_post = get_page_by_title( 'Monume Playlist', OBJECT, 'ai_playlist' );
	if ( ! $ai_playlist_post ) {
		$audio_url = content_url( '/uploads/2026/09/monume-dark-ambient-soundscape-dreamscape-570679.mp3' );
		$cover_url = get_template_directory_uri() . '/assets/images/monume.jpg';

		$tracks = array(
			array(
				'title'  => 'Monume',
				'artist' => 'VYRA Artist',
				'audio'  => $audio_url,
				'cover'  => $cover_url,
			),
		);

		$ai_playlist_id = wp_insert_post( array(
			'post_title'  => 'Monume Playlist',
			'post_status' => 'publish',
			'post_type'   => 'ai_playlist',
		) );

		if ( $ai_playlist_id && ! is_wp_error( $ai_playlist_id ) ) {
			update_post_meta( $ai_playlist_id, '_audioigniter_tracks', $tracks );
		}
	} else {
		$ai_playlist_id = $ai_playlist_post->ID;
	}

	// 3. Create or update Monume Release CPT Post
	$release_post = get_page_by_title( 'Monume', OBJECT, 'release' );
	if ( ! $release_post ) {
		$release_id = wp_insert_post( array(
			'post_title'   => 'Monume',
			'post_name'    => 'monume',
			'post_content' => 'A dark ambient soundscape shaped by slow-moving textures, atmospheric layers, and dreamlike space.',
			'post_status'  => 'publish',
			'post_type'    => 'release',
		) );

		if ( $release_id && ! is_wp_error( $release_id ) ) {
			if ( $artist_id ) {
				update_post_meta( $release_id, '_vyra_release_artist_id', $artist_id );
			}
			update_post_meta( $release_id, '_vyra_release_artist', 'VYRA Artist' );
			update_post_meta( $release_id, '_vyra_release_year', '2026' );
			update_post_meta( $release_id, '_vyra_release_type', 'Single' );
			update_post_meta( $release_id, '_vyra_catalog_number', 'VYRA-002' );
			update_post_meta( $release_id, '_vyra_release_genre', 'Ambient / Cinematic' );
			if ( $ai_playlist_id ) {
				update_post_meta( $release_id, '_vyra_audioigniter_id', (string) $ai_playlist_id );
			}
			update_post_meta( $release_id, '_vyra_short_description', 'A dark ambient soundscape shaped by slow-moving textures, atmospheric layers, and dreamlike space.' );
		}
	} else {
		if ( $ai_playlist_id ) {
			update_post_meta( $release_post->ID, '_vyra_audioigniter_id', (string) $ai_playlist_id );
		}
	}

	update_option( 'vyra_monume_seeded_v1', '1' );
}
add_action( 'init', 'vyra_auto_seed_monume_release', 99 );

/**
 * Auto-Create 'Home' Page and set show_on_front = 'page'
 */
function vyra_auto_create_home_page() {
	if ( get_option( 'vyra_home_page_created_v2' ) === '1' ) {
		return;
	}

	$home_page = get_page_by_path( 'home' );
	if ( ! $home_page ) {
		$home_id = wp_insert_post( array(
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		) );
	} else {
		$home_id = $home_page->ID;
	}

	if ( $home_id && ! is_wp_error( $home_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	update_option( 'vyra_home_page_created_v2', '1' );
}
add_action( 'init', 'vyra_auto_create_home_page', 94 );

/**
 * Register Homepage CMS Custom Meta Box in WP Admin
 */
function vyra_add_homepage_meta_box() {
	global $post;
	if ( ! $post || $post->post_type !== 'page' ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	$is_home_page  = ( $front_page_id && $post->ID === $front_page_id ) || ( $post->post_name === 'home' );

	if ( $is_home_page ) {
		add_meta_box(
			'vyra_homepage_content_meta_box',
			__( 'HOMEPAGE CONTENT', 'vyra' ),
			'vyra_render_homepage_meta_box',
			'page',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'vyra_add_homepage_meta_box' );

function vyra_render_homepage_meta_box( $post ) {
	wp_nonce_field( 'vyra_save_homepage_meta', 'vyra_homepage_meta_nonce' );

	$hero_heading       = get_post_meta( $post->ID, '_vyra_hero_heading', true );
	$hero_description   = get_post_meta( $post->ID, '_vyra_hero_description', true );
	$hero_image         = get_post_meta( $post->ID, '_vyra_hero_image', true );

	$manifesto_heading  = get_post_meta( $post->ID, '_vyra_manifesto_heading', true );
	$manifesto_text     = get_post_meta( $post->ID, '_vyra_manifesto_text', true );

	$about_sub          = get_post_meta( $post->ID, '_vyra_about_sub', true );
	$about_heading      = get_post_meta( $post->ID, '_vyra_about_heading', true );
	$about_lead         = get_post_meta( $post->ID, '_vyra_about_lead', true );
	$about_text         = get_post_meta( $post->ID, '_vyra_about_text', true );

	$newsletter_heading = get_post_meta( $post->ID, '_vyra_newsletter_heading', true );
	$newsletter_text    = get_post_meta( $post->ID, '_vyra_newsletter_text', true );
	?>
	<style>
		.vyra-cms-section { margin-bottom: 25px; padding: 15px 20px; background: #f9f9f9; border: 1px solid #e2e4e7; border-radius: 6px; }
		.vyra-cms-section h3 { margin-top: 0; margin-bottom: 12px; font-size: 15px; border-bottom: 1px solid #ddd; padding-bottom: 8px; color: #1d2327; text-transform: uppercase; letter-spacing: 0.5px; }
		.vyra-cms-field { margin-bottom: 14px; }
		.vyra-cms-field label { display: block; font-weight: 600; margin-bottom: 5px; color: #2c3338; }
		.vyra-cms-field input[type="text"], .vyra-cms-field textarea { width: 100%; max-width: 100%; border: 1px solid #8c8f94; border-radius: 4px; padding: 6px 10px; }
		.vyra-cms-field p.description { margin-top: 4px; font-size: 12px; color: #646970; }
	</style>

	<div class="vyra-cms-box">
		<!-- HERO SECTION -->
		<div class="vyra-cms-section">
			<h3>Hero</h3>
			<div class="vyra-cms-field">
				<label for="vyra_hero_heading">Hero Heading</label>
				<input type="text" id="vyra_hero_heading" name="vyra_hero_heading" value="<?php echo esc_attr( $hero_heading ); ?>" placeholder="e.g. VYRA" />
				<p class="description">Main title displayed in the hero section (Default: VYRA).</p>
			</div>

			<div class="vyra-cms-field">
				<label for="vyra_hero_description">Hero Description</label>
				<input type="text" id="vyra_hero_description" name="vyra_hero_description" value="<?php echo esc_attr( $hero_description ); ?>" placeholder="e.g. MUSIC / CULTURE / SOUND" />
				<p class="description">Subheading under the brand title (Default: MUSIC / CULTURE / SOUND).</p>
			</div>

			<div class="vyra-cms-field">
				<label for="vyra_hero_image">Hero Image</label>
				<input type="text" id="vyra_hero_image" name="vyra_hero_image" value="<?php echo esc_attr( $hero_image ); ?>" placeholder="Leave blank for theme default (assets/images/hero.jpg)" />
				<p class="description">URL for background hero image. Leave blank to use default theme artwork.</p>
			</div>
		</div>

		<!-- MANIFESTO SECTION -->
		<div class="vyra-cms-section">
			<h3>Manifesto</h3>
			<div class="vyra-cms-field">
				<label for="vyra_manifesto_heading">Manifesto Heading</label>
				<input type="text" id="vyra_manifesto_heading" name="vyra_manifesto_heading" value="<?php echo esc_attr( $manifesto_heading ); ?>" placeholder='e.g. "WHERE FREQUENCY MEETS VISION."' />
				<p class="description">Editorial quote or statement heading.</p>
			</div>

			<div class="vyra-cms-field">
				<label for="vyra_manifesto_text">Manifesto Text</label>
				<textarea id="vyra_manifesto_text" name="vyra_manifesto_text" rows="3"><?php echo esc_textarea( $manifesto_text ); ?></textarea>
				<p class="description">Body statement below the manifesto heading.</p>
			</div>
		</div>

		<!-- ABOUT SECTION -->
		<div class="vyra-cms-section">
			<h3>About</h3>
			<div class="vyra-cms-field">
				<label for="vyra_about_sub">About Subtitle</label>
				<input type="text" id="vyra_about_sub" name="vyra_about_sub" value="<?php echo esc_attr( $about_sub ); ?>" placeholder="e.g. OUR PHILOSOPHY" />
			</div>

			<div class="vyra-cms-field">
				<label for="vyra_about_heading">About Heading</label>
				<input type="text" id="vyra_about_heading" name="vyra_about_heading" value="<?php echo esc_attr( $about_heading ); ?>" placeholder="e.g. THE STORY OF VYRA" />
			</div>

			<div class="vyra-cms-field">
				<label for="vyra_about_lead">About Lead Text</label>
				<textarea id="vyra_about_lead" name="vyra_about_lead" rows="2"><?php echo esc_textarea( $about_lead ); ?></textarea>
				<p class="description">Highlighted intro paragraph in the story section.</p>
			</div>

			<div class="vyra-cms-field">
				<label for="vyra_about_text">About Text</label>
				<textarea id="vyra_about_text" name="vyra_about_text" rows="3"><?php echo esc_textarea( $about_text ); ?></textarea>
				<p class="description">Detailed brand description paragraph.</p>
			</div>
		</div>

		<!-- NEWSLETTER SECTION -->
		<div class="vyra-cms-section">
			<h3>Newsletter</h3>
			<div class="vyra-cms-field">
				<label for="vyra_newsletter_heading">Newsletter Heading</label>
				<input type="text" id="vyra_newsletter_heading" name="vyra_newsletter_heading" value="<?php echo esc_attr( $newsletter_heading ); ?>" placeholder="e.g. STAY CONNECTED." />
			</div>

			<div class="vyra-cms-field">
				<label for="vyra_newsletter_text">Newsletter Text</label>
				<input type="text" id="vyra_newsletter_text" name="vyra_newsletter_text" value="<?php echo esc_attr( $newsletter_text ); ?>" placeholder="e.g. New releases, artists, and updates from VYRA." />
			</div>
		</div>
	</div>
	<?php
}

function vyra_save_homepage_meta( $post_id ) {
	if ( ! isset( $_POST['vyra_homepage_meta_nonce'] ) || ! wp_verify_nonce( $_POST['vyra_homepage_meta_nonce'], 'vyra_save_homepage_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$fields = array(
		'vyra_hero_heading'       => '_vyra_hero_heading',
		'vyra_hero_description'   => '_vyra_hero_description',
		'vyra_hero_image'         => '_vyra_hero_image',
		'vyra_manifesto_heading'  => '_vyra_manifesto_heading',
		'vyra_manifesto_text'     => '_vyra_manifesto_text',
		'vyra_about_sub'          => '_vyra_about_sub',
		'vyra_about_heading'      => '_vyra_about_heading',
		'vyra_about_lead'         => '_vyra_about_lead',
		'vyra_about_text'         => '_vyra_about_text',
		'vyra_newsletter_heading' => '_vyra_newsletter_heading',
		'vyra_newsletter_text'    => '_vyra_newsletter_text',
	);

	foreach ( $fields as $post_key => $meta_key ) {
		if ( isset( $_POST[ $post_key ] ) ) {
			if ( in_array( $meta_key, array( '_vyra_manifesto_text', '_vyra_about_lead', '_vyra_about_text' ), true ) ) {
				update_post_meta( $post_id, $meta_key, sanitize_textarea_field( $_POST[ $post_key ] ) );
			} else {
				update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $post_key ] ) );
			}
		}
	}
}
add_action( 'save_post_page', 'vyra_save_homepage_meta' );
