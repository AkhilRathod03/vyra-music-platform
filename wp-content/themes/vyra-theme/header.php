<?php
/**
 * Header Template for VYRA Theme
 *
 * @package VYRA
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'vyra-body' ); ?>>
<?php wp_body_open(); ?>

<!-- NAVIGATION HEADER -->
<header class="vyra-header" id="vyra-site-header">
	<div class="vyra-header-container">
		<!-- LOGO -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vyra-logo" aria-label="VYRA Home">
			<span class="vyra-logo-text">VYRA</span>
			<span class="vyra-logo-dot">.</span>
		</a>

		<!-- DESKTOP NAVIGATION -->
		<nav class="vyra-nav-desktop" aria-label="Main Navigation">
			<ul class="vyra-nav-list">
				<li><a href="<?php echo esc_url( home_url( '/music/' ) ); ?>" class="vyra-nav-link">Music</a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'artist' ) ); ?>" class="vyra-nav-link">Artists</a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'release' ) ); ?>" class="vyra-nav-link">Releases</a></li>
				<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="vyra-nav-link">About</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vyra-nav-link">Contact</a></li>
			</ul>
		</nav>

		<!-- MOBILE MENU BUTTON -->
		<button class="vyra-mobile-toggle" id="vyra-mobile-toggle" aria-label="Toggle Navigation Menu" aria-expanded="false" aria-controls="vyra-mobile-menu">
			<span class="vyra-toggle-bar"></span>
			<span class="vyra-toggle-bar"></span>
		</button>
	</div>

	<!-- MOBILE NAVIGATION DRAWER -->
	<div class="vyra-mobile-menu" id="vyra-mobile-menu" aria-hidden="true">
		<div class="vyra-mobile-menu-inner">
			<ul class="vyra-mobile-nav-list">
				<li><a href="<?php echo esc_url( home_url( '/music/' ) ); ?>" class="vyra-mobile-nav-link">Music</a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'artist' ) ); ?>" class="vyra-mobile-nav-link">Artists</a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'release' ) ); ?>" class="vyra-mobile-nav-link">Releases</a></li>
				<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="vyra-mobile-nav-link">About</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="vyra-mobile-nav-link">Contact</a></li>
			</ul>
		</div>
	</div>
</header>