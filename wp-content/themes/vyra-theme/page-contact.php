<?php
/**
 * Template Name: Contact Page
 * Template for /contact/ endpoint
 *
 * @package VYRA
 */

get_header(); ?>

<main class="vyra-main-content">

	<!-- 1. INTRO SECTION -->
	<section class="vyra-section vyra-contact-hero-section">
		<div class="vyra-container">
			<div class="vyra-contact-hero-content">
				<span class="vyra-section-sub">CONTACT VYRA</span>
				<h1 class="vyra-contact-main-title">
					LET'S MAKE<br>
					SOMETHING<br>
					SOUND.
				</h1>
				<p class="vyra-contact-lead-text">
					For artists, collaborations, press, and general enquiries.
				</p>
			</div>
		</div>
	</section>

	<!-- 2. CONTACT INFORMATION & FORM SECTION -->
	<section class="vyra-section vyra-contact-main-section vyra-reveal">
		<div class="vyra-container">
			<div class="vyra-contact-grid">

				<!-- LEFT COLUMN: CONTACT DEPARTMENTS & EMAILS -->
				<div class="vyra-contact-info-col">
					<div class="vyra-contact-dept-list">

						<div class="vyra-dept-item">
							<span class="vyra-dept-label">ARTISTS</span>
							<a href="mailto:artists@example.com" class="vyra-dept-email">artists@example.com</a>
							<p class="vyra-dept-desc">Music submissions, artist enquiries and collaborations.</p>
						</div>

						<div class="vyra-dept-item">
							<span class="vyra-dept-label">PRESS</span>
							<a href="mailto:press@example.com" class="vyra-dept-email">press@example.com</a>
							<p class="vyra-dept-desc">Press, media and editorial enquiries.</p>
						</div>

						<div class="vyra-dept-item">
							<span class="vyra-dept-label">GENERAL</span>
							<a href="mailto:hello@example.com" class="vyra-dept-email">hello@example.com</a>
							<p class="vyra-dept-desc">Partnerships and general questions.</p>
						</div>

					</div>
				</div>

				<!-- RIGHT COLUMN: EDITORIAL CONTACT FORM -->
				<div class="vyra-contact-form-col">
					<div class="vyra-contact-form-box">
						<form class="vyra-contact-form" id="vyra-contact-form" onsubmit="event.preventDefault(); const msg = document.getElementById('vyra-form-status'); if(msg){ msg.style.display = 'block'; }">
							<div class="vyra-form-group">
								<label for="vyra-contact-name" class="vyra-form-label">NAME</label>
								<input type="text" id="vyra-contact-name" name="name" class="vyra-form-input" required placeholder="Your full name" autocomplete="name">
							</div>

							<div class="vyra-form-group">
								<label for="vyra-contact-email" class="vyra-form-label">EMAIL</label>
								<input type="email" id="vyra-contact-email" name="email" class="vyra-form-input" required placeholder="your.email@example.com" autocomplete="email">
							</div>

							<div class="vyra-form-group">
								<label for="vyra-contact-subject" class="vyra-form-label">SUBJECT</label>
								<input type="text" id="vyra-contact-subject" name="subject" class="vyra-form-input" required placeholder="Enquiry subject">
							</div>

							<div class="vyra-form-group">
								<label for="vyra-contact-message" class="vyra-form-label">MESSAGE</label>
								<textarea id="vyra-contact-message" name="message" class="vyra-form-textarea" rows="5" required placeholder="Write your message here..."></textarea>
							</div>

							<div class="vyra-form-actions">
								<button type="submit" class="vyra-btn vyra-btn-primary">
									<span>SEND ENQUIRY &rarr;</span>
								</button>
							</div>

							<!-- FORM STATUS NOTIFICATION -->
							<div class="vyra-form-status-notice" id="vyra-form-status" style="display: none;" role="status">
								<span>Contact form coming soon.</span>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- 3. FOLLOW / SOCIAL SECTION -->
	<section class="vyra-section vyra-follow-section vyra-reveal">
		<div class="vyra-container">
			<div class="vyra-follow-box">
				<span class="vyra-section-sub">CONNECT</span>
				<h2 class="vyra-follow-heading">FOLLOW VYRA</h2>
				<ul class="vyra-social-links vyra-follow-socials">
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="Spotify">Spotify</a></li>
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="Apple Music">Apple Music</a></li>
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="SoundCloud">SoundCloud</a></li>
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="Instagram">Instagram</a></li>
					<li><a href="#" target="_blank" rel="noopener noreferrer" aria-label="YouTube">YouTube</a></li>
				</ul>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>