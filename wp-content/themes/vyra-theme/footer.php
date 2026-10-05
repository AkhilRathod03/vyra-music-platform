<?php
/**
 * Footer Template for VYRA Theme
 *
 * @package VYRA
 */

?>
<footer class="vyra-footer" id="contact">
	<div class="vyra-container">
		<div class="vyra-footer-grid">
			<!-- BRAND COLUMN -->
			<div class="vyra-footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vyra-logo" aria-label="VYRA Home">
					<span class="vyra-logo-text">VYRA</span>
					<span class="vyra-logo-dot">.</span>
				</a>
				<p class="vyra-footer-tagline">
					Autonomous Sound & Editorial Music Collective. Crafting raw, modern audio experiences.
				</p>
			</div>

			<!-- QUICK NAVIGATION -->
			<div class="vyra-footer-links">
				<h4 class="vyra-footer-title">Navigation</h4>
				<ul class="vyra-footer-nav-list">
					<li><a href="<?php echo esc_url( home_url( '/music/' ) ); ?>">Music</a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'artist' ) ); ?>">Artists</a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'release' ) ); ?>">Releases</a></li>
					<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
				</ul>
			</div>

			<!-- SOCIAL MEDIA PLACEHOLDERS -->
			<div class="vyra-footer-social">
				<h4 class="vyra-footer-title">Connect</h4>
				<ul class="vyra-social-links">
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="Spotify">Spotify</a></li>
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="Apple Music">Apple Music</a></li>
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="SoundCloud">SoundCloud</a></li>
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="Instagram">Instagram</a></li>
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="YouTube">YouTube</a></li>
				</ul>
			</div>
		</div>

		<!-- BOTTOM COPYRIGHT BAR -->
		<div class="vyra-footer-bottom">
			<p class="vyra-copyright">&copy; <?php echo esc_html( date( 'Y' ) ); ?> VYRA. All rights reserved.</p>
			<div class="vyra-footer-legal">
				<a href="#">Privacy Policy</a>
				<span class="vyra-divider">&bull;</span>
				<a href="#">Terms of Sound</a>
			</div>
		</div>
	</div>
</footer>

<!-- VYRA PERSISTENT GLOBAL MUSIC PLAYER -->
<div class="vyra-global-player" id="vyra-global-player" aria-label="Global Music Player" role="region" aria-hidden="true">
	<div class="vyra-global-player-inner">
		<!-- LEFT: TRACK COVER & METADATA -->
		<div class="vyra-global-track-info">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/midnight-echo.jpg" alt="Now Playing Artwork" class="vyra-global-cover" id="vyra-global-cover">
			<div class="vyra-global-meta">
				<h4 class="vyra-global-title" id="vyra-global-title">Midnight Echo</h4>
				<p class="vyra-global-artist" id="vyra-global-artist">VYRA Artist</p>
			</div>
		</div>

		<!-- CENTER: PROGRESS BAR & TIMERS -->
		<div class="vyra-global-progress-container">
			<div class="vyra-global-progress-bar" id="vyra-global-progress-bar" role="slider" aria-label="Seek progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" tabindex="0">
				<div class="vyra-global-progress-fill" id="vyra-global-progress-fill"></div>
			</div>
			<div class="vyra-global-timers">
				<span id="vyra-global-time-current">00:00</span>
				<span id="vyra-global-time-duration">--:--</span>
			</div>
		</div>

		<!-- RIGHT: CONTROLS & CLOSE -->
		<div class="vyra-global-controls">
			<button class="vyra-global-play-btn" id="vyra-global-play-btn" aria-label="Play track">
				<svg class="vyra-icon-play" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
				<svg class="vyra-icon-pause" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: none;"><rect x="6" y="4" width="4" height="16"></rect><rect x="14" y="4" width="4" height="16"></rect></svg>
			</button>

			<button class="vyra-global-close-btn" id="vyra-global-close-btn" aria-label="Close Global Music Player">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
			</button>
		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>