/**
 * Main JavaScript File for VYRA Theme
 * Dynamic Multi-Track AudioIgniter & Persistent Global Music Player Synchronization
 * Fully Scalable for N-Releases with Zero Hardcoded Track/Playlist IDs
 */

document.addEventListener('DOMContentLoaded', () => {
	// --------------------------------------------------------------------------
	// 1. MOBILE NAVIGATION TOGGLE
	// --------------------------------------------------------------------------
	const mobileToggle = document.getElementById('vyra-mobile-toggle');
	const mobileMenu = document.getElementById('vyra-mobile-menu');

	if (mobileToggle && mobileMenu) {
		mobileToggle.addEventListener('click', () => {
			const isExpanded = mobileToggle.getAttribute('aria-expanded') === 'true';
			mobileToggle.setAttribute('aria-expanded', !isExpanded);
			mobileMenu.setAttribute('aria-hidden', isExpanded);
			mobileMenu.classList.toggle('vyra-active');
			document.body.classList.toggle('vyra-mobile-menu-open');
		});

		const mobileNavLinks = mobileMenu.querySelectorAll('.vyra-mobile-nav-link');
		mobileNavLinks.forEach((link) => {
			link.addEventListener('click', () => {
				mobileToggle.setAttribute('aria-expanded', 'false');
				mobileMenu.setAttribute('aria-hidden', 'true');
				mobileMenu.classList.remove('vyra-active');
				document.body.classList.remove('vyra-mobile-menu-open');
			});
		});
	}

	// --------------------------------------------------------------------------
	// 2. HEADER SCROLL EFFECT
	// --------------------------------------------------------------------------
	const header = document.getElementById('vyra-site-header');
	if (header) {
		const handleScroll = () => {
			if (window.scrollY > 40) {
				header.classList.add('vyra-header-scrolled');
			} else {
				header.classList.remove('vyra-header-scrolled');
			}
		};

		window.addEventListener('scroll', handleScroll, { passive: true });
		handleScroll();
	}

	// --------------------------------------------------------------------------
	// 3. REVEAL ANIMATIONS (INTERSECTION OBSERVER)
	// --------------------------------------------------------------------------
	const revealElements = document.querySelectorAll('.vyra-reveal');
	if (revealElements.length > 0 && 'IntersectionObserver' in window) {
		const revealObserver = new IntersectionObserver(
			(entries, observer) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						entry.target.classList.add('vyra-revealed');
						observer.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
		);

		revealElements.forEach((el) => revealObserver.observe(el));
	} else {
		revealElements.forEach((el) => el.classList.add('vyra-revealed'));
	}

	// --------------------------------------------------------------------------
	// 4. PERSISTENT GLOBAL MUSIC PLAYER & DYNAMIC MULTI-TRACK AUDIOIGNITER SYNC
	// --------------------------------------------------------------------------
	const globalPlayer = document.getElementById('vyra-global-player');
	const globalCover = document.getElementById('vyra-global-cover');
	const globalTitle = document.getElementById('vyra-global-title');
	const globalArtist = document.getElementById('vyra-global-artist');
	const globalPlayBtn = document.getElementById('vyra-global-play-btn');
	const globalCloseBtn = document.getElementById('vyra-global-close-btn');
	const globalProgressBar = document.getElementById('vyra-global-progress-bar');
	const globalProgressFill = document.getElementById('vyra-global-progress-fill');
	const globalTimeCurrent = document.getElementById('vyra-global-time-current');
	const globalTimeDuration = document.getElementById('vyra-global-time-duration');

	if (!globalPlayer) return;

	let isClosedByUser = false;
	let currentTrackKey = null;
	let currentPlaybackTarget = null;
	let lastLoggedActiveKey = null;
	let isEnforcingSingleTrack = false;
	let autoplayConfirmed = false;
	const boundAudioElements = new WeakSet();
	const observedContainers = new WeakSet();

	// Helper to format seconds -> MM:SS
	const formatTime = (seconds) => {
		if (isNaN(seconds) || seconds === null || seconds < 0 || !isFinite(seconds)) {
			return '00:00';
		}
		const m = Math.floor(seconds / 60);
		const s = Math.floor(seconds % 60);
		return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
	};

	// Helper to collect all SoundManager2 sound instances
	const getAllSoundManagerSounds = () => {
		if (window.soundManager && window.soundManager.sounds) {
			return Object.values(window.soundManager.sounds).filter(Boolean);
		}
		return [];
	};

	// Helper to collect all HTML5 audio elements (DOM tags + SoundManager2 memory instances)
	const getAllAudioElements = () => {
		const audios = new Set(Array.from(document.querySelectorAll('audio')));
		const smSounds = getAllSoundManagerSounds();
		smSounds.forEach((sound) => {
			if (sound && sound._a && sound._a instanceof HTMLAudioElement) {
				audios.add(sound._a);
			}
		});
		return Array.from(audios);
	};

	// Helper to dynamically find SoundManager2 sound object for an HTMLAudioElement at event time
	const findSoundManagerForAudio = (audioEl) => {
		if (!window.soundManager || !window.soundManager.sounds) {
			return null;
		}
		return Object.values(window.soundManager.sounds)
			.filter(Boolean)
			.find((sound) => sound && sound._a === audioEl) || null;
	};

	// Observer binder for SoundManager2 sound instances (Chained to preserve AudioIgniter's internal React callbacks)
	const attachSM2Observers = (soundObj) => {
		if (!soundObj || soundObj._vyraObserved) return;
		soundObj._vyraObserved = true;

		const origOnPlay = soundObj.options.onplay;
		soundObj.options.onplay = function () {
			if (typeof origOnPlay === 'function') {
				origOnPlay.apply(this, arguments);
			}
			enforceSingleActiveTrackExcept(soundObj);
			syncGlobalPlayerState();
			syncMusicPageTrackButtons();
		};

		const origOnResume = soundObj.options.onresume;
		soundObj.options.onresume = function () {
			if (typeof origOnResume === 'function') {
				origOnResume.apply(this, arguments);
			}
			enforceSingleActiveTrackExcept(soundObj);
			syncGlobalPlayerState();
			syncMusicPageTrackButtons();
		};

		const origOnPause = soundObj.options.onpause;
		soundObj.options.onpause = function () {
			if (typeof origOnPause === 'function') {
				origOnPause.apply(this, arguments);
			}
			syncGlobalPlayerState();
			syncMusicPageTrackButtons();
		};

		const origOnStop = soundObj.options.onstop;
		soundObj.options.onstop = function () {
			if (typeof origOnStop === 'function') {
				origOnStop.apply(this, arguments);
			}
			syncGlobalPlayerState();
			syncMusicPageTrackButtons();
		};

		const origOnFinish = soundObj.options.onfinish;
		soundObj.options.onfinish = function () {
			if (typeof origOnFinish === 'function') {
				origOnFinish.apply(this, arguments);
			}
			syncGlobalPlayerState();
			syncMusicPageTrackButtons();
		};

		const origWhilePlaying = soundObj.options.whileplaying;
		soundObj.options.whileplaying = function () {
			if (typeof origWhilePlaying === 'function') {
				origWhilePlaying.apply(this, arguments);
			}
			syncGlobalPlayerState();
			syncMusicPageTrackButtons();
		};
	};

	const observeAllSoundManagerSounds = () => {
		const smSounds = getAllSoundManagerSounds();
		smSounds.forEach((s) => attachSM2Observers(s));
	};

	// Extract AudioIgniter Playlist ID dynamically from runtime sound object
	const getAudioIgniterPlaylistId = (soundObj) => {
		if (!soundObj) return null;

		const url = soundObj.url || '';
		const id = soundObj.id || '';

		const match = url.match(/playlist_id=(\d+)/i) || id.match(/ai-(\d+)/i);
		if (match && match[1]) {
			return match[1];
		}

		if (soundObj._a && soundObj._a instanceof HTMLAudioElement) {
			const aiRoot = soundObj._a.closest('.audioigniter-root');
			if (aiRoot) {
				const rId = aiRoot.id || '';
				const plIdMatch = rId.match(/audioigniter-(\d+)/i) || (aiRoot.getAttribute('data-tracks-url') || '').match(/playlist_id=(\d+)/i);
				if (plIdMatch && plIdMatch[1]) {
					return plIdMatch[1];
				}
			}
		}

		return null;
	};

	// Find container DOM element for a SoundManager2 sound instance dynamically (Scalable for any N releases)
	const findContainerForSound = (soundObj) => {
		if (!soundObj) return null;

		const rows = Array.from(document.querySelectorAll('.vyra-music-row'));
		const containers = Array.from(document.querySelectorAll('.vyra-music-row, .vyra-featured-layout, .vyra-single-release-grid, .audioigniter-root, #vyra-player-container'));

		// Priority A & C: Match AudioIgniter Playlist ID
		const playlistId = getAudioIgniterPlaylistId(soundObj);
		if (playlistId) {
			for (const container of containers) {
				const cId = container.id || '';
				const dataUrl = container.getAttribute('data-tracks-url') || '';
				const dataPl = container.getAttribute('data-playlist-id') || '';
				const hasChildAi = container.querySelector(`#audioigniter-${playlistId}, .audioigniter-root[data-tracks-url*="playlist_id=${playlistId}"], .audioigniter-root[data-playlist-id="${playlistId}"]`);

				if (cId === `audioigniter-${playlistId}` || cId.includes(`audioigniter-${playlistId}`) || dataUrl.includes(`playlist_id=${playlistId}`) || dataPl === String(playlistId) || hasChildAi) {
					return container;
				}
			}
		}

		// Priority B: Audio URL / MP3 Filename matching
		if (soundObj.url) {
			const urlClean = soundObj.url.split('?')[0];
			const filename = urlClean.substring(urlClean.lastIndexOf('/') + 1).toLowerCase();

			if (filename && filename.length > 3) {
				for (const container of containers) {
					const tracksUrl = (container.getAttribute('data-tracks-url') || '').toLowerCase();
					if (tracksUrl && tracksUrl.includes(filename)) return container;

					const containerAudios = container.querySelectorAll('audio, source, a');
					for (const a of containerAudios) {
						const src = (a.src || a.href || '').toLowerCase();
						if (src && src.includes(filename)) return container;
					}

					const rowText = (container.textContent || '').toLowerCase();
					const stem = filename.replace(/\.(mp3|wav|ogg|m4a)$/i, '').replace(/[-_]/g, ' ');
					if (stem && stem.length >= 4 && rowText.includes(stem)) {
						return container;
					}
				}
			}
		}

		// Priority DOM containment check if soundObj._a is present
		if (soundObj._a && soundObj._a instanceof HTMLAudioElement) {
			const parent = containers.find((c) => c.contains(soundObj._a));
			if (parent) return parent;
		}

		// Priority D: Fallback to sound index matching row index
		if (soundObj.id) {
			const match = soundObj.id.match(/sound(\d+)/i);
			if (match && rows.length > 0) {
				const idx = parseInt(match[1], 10);
				if (rows[idx]) return rows[idx];
			}
		}

		// Homepage Featured Layout Fallback
		const isHome = document.body.classList.contains('home') || window.location.pathname === '/' || window.location.pathname === '';
		if (isHome) {
			const feat = document.querySelector('.vyra-featured-layout, #audioigniter-5');
			if (feat) return feat;
		}

		return null;
	};

	// Single-Track Playback Enforcer (Uses Direct SM2 pause ONLY on OTHER active sounds)
	const enforceSingleActiveTrackExcept = (currentSoundObj) => {
		if (isEnforcingSingleTrack || !currentSoundObj) return;
		isEnforcingSingleTrack = true;

		try {
			if (window.soundManager && window.soundManager.sounds) {
				const smSounds = Object.values(window.soundManager.sounds).filter(Boolean);
				smSounds.forEach((otherSound) => {
					if (otherSound !== currentSoundObj && otherSound.playState === 1 && !otherSound.paused) {
						if (typeof otherSound.pause === 'function') {
							otherSound.pause();
						}
					}
				});
			}
		} finally {
			isEnforcingSingleTrack = false;
		}
	};

	// Returns the ONE track that is genuinely playing
	const getCurrentlyPlayingTrack = () => {
		// 1. Check SoundManager2 sounds for genuinely playing sound (playState === 1 && paused === false)
		if (window.soundManager && window.soundManager.sounds) {
			const smSounds = Object.values(window.soundManager.sounds).filter(Boolean);
			const activeSm = smSounds.find(
				(s) => s.playState === 1 && s.paused === false
			);
			if (activeSm) {
				return { type: 'sm', soundObj: activeSm, audioEl: activeSm._a || null };
			}
		}

		// 2. Check HTML5 audio elements for genuinely playing audio
		const allAudios = Array.from(document.querySelectorAll('audio'));
		const playingAudio = allAudios.find((a) => !a.paused && !a.ended);
		if (playingAudio) {
			return { type: 'html5', soundObj: null, audioEl: playingAudio };
		}

		return null;
	};

	// Music page track row button visual synchronizer (UI ONLY, Atomic Update, Responsive & Unlimited Tracks)
	const syncMusicPageTrackButtons = () => {
		const isMusicPage = document.body.classList.contains('page-template-page-music') ||
			window.location.pathname.includes('/music');

		if (!isMusicPage) return;

		const activeTrack = getCurrentlyPlayingTrack();
		const activeSM = activeTrack?.soundObj || null;
		const activeAudio = activeTrack?.audioEl || null;

		const activeContainer = activeSM ? findContainerForSound(activeSM) : null;

		const rows = document.querySelectorAll('.vyra-music-row');
		rows.forEach((row) => {
			let isRowPlaying = false;

			if (activeSM && activeContainer) {
				if (row === activeContainer || row.contains(activeContainer) || activeContainer.contains(row)) {
					isRowPlaying = true;
				}
			}

			if (!isRowPlaying && activeAudio) {
				const rowAudios = row.querySelectorAll('audio');
				if (rowAudios.length > 0 && Array.from(rowAudios).includes(activeAudio)) {
					isRowPlaying = true;
				}
			}

			const playBtns = row.querySelectorAll('.ai-audio-control, .ai-btn-play, .ai-btn-pause, button.ai-btn');
			const aiRoots = row.querySelectorAll('.audioigniter-root');

			if (isRowPlaying) {
				playBtns.forEach((btn) => btn.classList.add('ai-audio-playing', 'ai-playing'));
				aiRoots.forEach((root) => root.classList.add('ai-playing', 'ai-audio-playing'));
				row.classList.add('vyra-row-playing');
			} else {
				playBtns.forEach((btn) => btn.classList.remove('ai-audio-playing', 'ai-playing'));
				aiRoots.forEach((root) => root.classList.remove('ai-playing', 'ai-audio-playing'));
				row.classList.remove('vyra-row-playing');
			}
		});
	};

	// Find active container for metadata extraction
	const getActiveContainer = (activeTarget) => {
		const soundObj = activeTarget ? (activeTarget.soundObj || null) : null;
		if (soundObj) {
			const matchedContainer = findContainerForSound(soundObj);
			if (matchedContainer) return matchedContainer;
		}

		const targetObj = activeTarget ? (activeTarget.audioEl || activeTarget.soundObj || activeTarget) : null;

		if (targetObj && targetObj.closest) {
			const row = targetObj.closest('.vyra-music-row, .vyra-single-info-col, .vyra-featured-info, .audioigniter-root, .vyra-single-release-grid');
			if (row) return row;
		}

		return null;
	};

	const showGlobalPlayer = () => {
		if (globalPlayer && !globalPlayer.classList.contains('vyra-active')) {
			globalPlayer.classList.add('vyra-active');
			globalPlayer.setAttribute('aria-hidden', 'false');
			document.body.classList.add('vyra-global-player-active');
		}
	};

	const hideGlobalPlayer = () => {
		if (globalPlayer) {
			globalPlayer.classList.remove('vyra-active');
			globalPlayer.setAttribute('aria-hidden', 'true');
			document.body.classList.remove('vyra-global-player-active');
		}
	};

	// Bind event listeners to audio elements for purely event-driven sync
	const bindAudioElements = () => {
		observeAllSoundManagerSounds();
		const allAudios = getAllAudioElements();
		allAudios.forEach((audioEl) => {
			if (!boundAudioElements.has(audioEl)) {
				boundAudioElements.add(audioEl);

				const events = ['timeupdate', 'loadedmetadata', 'durationchange', 'play', 'playing', 'pause', 'ended'];
				events.forEach((evt) => {
					audioEl.addEventListener(evt, () => {
						const matchingSM = findSoundManagerForAudio(audioEl);
						if (matchingSM) {
							attachSM2Observers(matchingSM);
						}

						if (evt === 'play' || evt === 'playing' || evt === 'timeupdate') {
							currentPlaybackTarget = {
								type: matchingSM ? 'sm' : 'html5',
								soundObj: matchingSM || null,
								audioEl: audioEl
							};
						}

						syncGlobalPlayerState();
						syncMusicPageTrackButtons();
					});
				});
			}
		});

		// Observe ONLY specific AudioIgniter root containers for child tree changes
		const aiRoots = document.querySelectorAll('.audioigniter-root');
		aiRoots.forEach((aiRoot) => {
			if (!observedContainers.has(aiRoot) && 'MutationObserver' in window) {
				observedContainers.add(aiRoot);
				const aiObserver = new MutationObserver(() => {
					observeAllSoundManagerSounds();
					bindAudioElements();
					syncGlobalPlayerState();
					syncMusicPageTrackButtons();
				});
				aiObserver.observe(aiRoot, {
					childList: true,
					subtree: true
				});
			}
		});
	};

	// Main Synchronizer Function (Fully Dynamic Metadata Extraction)
	const syncGlobalPlayerState = () => {
		observeAllSoundManagerSounds();
		const activeTrack = getCurrentlyPlayingTrack();
		const isPlaying = activeTrack !== null;

		if (isPlaying) {
			currentPlaybackTarget = activeTrack;
			const targetId = activeTrack.soundObj ? activeTrack.soundObj.id : (activeTrack.audioEl ? 'HTML5 Audio' : 'Track');
			if (lastLoggedActiveKey !== targetId) {
				lastLoggedActiveKey = targetId;
				console.log('[VYRA Global] ACTIVE:', targetId);
			}
			if (!isClosedByUser) {
				showGlobalPlayer();
			}
		}

		// Use active playing track, or fallback to stored currentPlaybackTarget if paused
		const activeTarget = activeTrack || currentPlaybackTarget;

		if (!activeTarget) return;

		const activeAudio = activeTarget?.audioEl || null;
		const activeSound = activeTarget?.soundObj || null;
		const activeContainer = getActiveContainer(activeTarget);

		// 1. Fully Dynamic Metadata Extraction & Track Switching (Supports Any N Tracks)
		let trackTitle = '';
		let artistName = '';
		let coverSrc = '';

		if (activeContainer) {
			const titleEl = activeContainer.querySelector('.vyra-row-track-name, .ai-track-title, .vyra-music-row-title, .vyra-single-title, .vyra-featured-title, .vyra-track-title');
			const artistEl = activeContainer.querySelector('.vyra-artist-link, .vyra-artist-text, .ai-track-artist, .vyra-music-row-subtitle, .vyra-featured-subtitle, .vyra-track-artist');
			const imgEl = activeContainer.querySelector('img.vyra-row-thumb, .ai-track-cover img, .vyra-music-cover-img, .vyra-single-cover img, .vyra-featured-cover img, .vyra-artwork-img');

			if (titleEl) trackTitle = titleEl.textContent.trim();
			if (artistEl) artistName = artistEl.textContent.trim();
			if (imgEl && imgEl.src) coverSrc = imgEl.src;
		}

		// Fully Dynamic URL/Filename Stem Fallback if container text is empty
		if (!trackTitle && activeSound && activeSound.url) {
			const urlClean = activeSound.url.split('?')[0];
			const filename = urlClean.substring(urlClean.lastIndexOf('/') + 1);
			const stem = filename.replace(/\.(mp3|wav|ogg|m4a)$/i, '').replace(/[-_]/g, ' ');
			if (stem) {
				trackTitle = stem.replace(/\b\w/g, (l) => l.toUpperCase());
			}
		}

		if (!trackTitle) trackTitle = 'VYRA Track';
		if (!artistName) artistName = 'VYRA Artist';

		const newTrackKey = `${trackTitle}-${artistName}`;

		if (currentTrackKey !== newTrackKey) {
			currentTrackKey = newTrackKey;
			if (globalTitle) globalTitle.textContent = trackTitle;
			if (globalArtist) globalArtist.textContent = artistName;
			if (globalCover && coverSrc) {
				globalCover.src = coverSrc;
				globalCover.alt = `${trackTitle} cover`;
			}
		}

		// 2. Time & Progress Bar Synchronization
		if (activeSound && activeSound.duration && activeSound.duration > 0) {
			const currentSec = (activeSound.position || 0) / 1000;
			const totalSec = activeSound.duration / 1000;
			const pct = Math.max(0, Math.min(100, (currentSec / totalSec) * 100));

			if (globalTimeCurrent) globalTimeCurrent.textContent = formatTime(currentSec);
			if (globalTimeDuration) globalTimeDuration.textContent = formatTime(totalSec);
			if (globalProgressFill) globalProgressFill.style.width = `${pct}%`;
		} else if (activeAudio && !isNaN(activeAudio.duration) && activeAudio.duration > 0 && isFinite(activeAudio.duration)) {
			const currentSec = activeAudio.currentTime || 0;
			const totalSec = activeAudio.duration;
			const pct = (currentSec / totalSec) * 100;

			if (globalTimeCurrent) globalTimeCurrent.textContent = formatTime(currentSec);
			if (globalTimeDuration) globalTimeDuration.textContent = formatTime(totalSec);
			if (globalProgressFill) globalProgressFill.style.width = `${pct}%`;
		}

		// 3. Update Play/Pause Button Icon (ONLY isPlaying decides if Pause icon is shown)
		if (globalPlayBtn) {
			const playIcon = globalPlayBtn.querySelector('.vyra-icon-play');
			const pauseIcon = globalPlayBtn.querySelector('.vyra-icon-pause');
			if (playIcon && pauseIcon) {
				if (isPlaying) {
					playIcon.style.display = 'none';
					pauseIcon.style.display = 'block';
					globalPlayBtn.setAttribute('aria-label', 'Pause');
				} else {
					playIcon.style.display = 'block';
					pauseIcon.style.display = 'none';
					globalPlayBtn.setAttribute('aria-label', 'Play');
				}
			}
		}
	};

	// Event Listeners for Global Player Play/Pause Button
	if (globalPlayBtn) {
		globalPlayBtn.addEventListener('click', (e) => {
			e.preventDefault();
			const activeTrack = getCurrentlyPlayingTrack();

			if (activeTrack && activeTrack.soundObj) {
				if (typeof activeTrack.soundObj.pause === 'function') {
					activeTrack.soundObj.pause();
				}
				return;
			}

			if (currentPlaybackTarget && currentPlaybackTarget.soundObj) {
				const sound = currentPlaybackTarget.soundObj;
				console.log('[VYRA Global] RESUME/PLAY TRIGGERED FOR:', sound.id);

				if (sound.paused && typeof sound.resume === 'function' && sound.position > 0) {
					sound.resume();
				} else if (typeof sound.play === 'function') {
					sound.play();
				}
				return;
			}
		});
	}

	if (globalCloseBtn) {
		globalCloseBtn.addEventListener('click', (e) => {
			e.preventDefault();
			isClosedByUser = true;
			hideGlobalPlayer();
		});
	}

	// Global Progress Bar Seeking Handler
	if (globalProgressBar) {
		const handleSeek = (e) => {
			const rect = globalProgressBar.getBoundingClientRect();
			if (rect.width <= 0) return;
			const clickX = e.clientX - rect.left;
			const percentage = Math.max(0, Math.min(1, clickX / rect.width));

			const activeTrack = getCurrentlyPlayingTrack() || currentPlaybackTarget;
			if (activeTrack && activeTrack.soundObj && activeTrack.soundObj.duration > 0) {
				const targetMs = percentage * activeTrack.soundObj.duration;
				if (typeof activeTrack.soundObj.setPosition === 'function') {
					activeTrack.soundObj.setPosition(targetMs);
				}
				syncGlobalPlayerState();
				return;
			}
		};

		globalProgressBar.addEventListener('click', handleSeek);
	}

	// Click delegation listener for play buttons across the site
	document.addEventListener('click', (e) => {
		const target = e.target.closest('.ai-audio-control, .vyra-play-trigger, .vyra-play-overlay-btn, .vyra-card-play-btn, .ai-btn-play, .ai-btn-pause, .ai-btn');
		if (target) {
			isClosedByUser = false;
			setTimeout(() => {
				observeAllSoundManagerSounds();
				bindAudioElements();
				syncGlobalPlayerState();
				syncMusicPageTrackButtons();
			}, 100);
		}
	});

	// Initial bind and sync
	bindAudioElements();
	setTimeout(() => {
		observeAllSoundManagerSounds();
		bindAudioElements();
		syncGlobalPlayerState();
		syncMusicPageTrackButtons();
	}, 400);

	// --------------------------------------------------------------------------
	// 5. HOMEPAGE SILENT AUTOPLAY & SYNCHRONOUS USER GESTURE TRIGGER
	// --------------------------------------------------------------------------
	const initHomepageAutoplay = () => {
		// Strict check: Run ONLY on the homepage
		const isHomepage = document.body.classList.contains('home') ||
			window.location.pathname === '/' ||
			window.location.pathname === '' ||
			window.location.pathname.endsWith('/index.php');

		if (!isHomepage) return;

		let gestureAttempted = false;

		// Identify existing AudioIgniter play control button specifically for sound0 / Playlist ID 5
		const findAudioIgniterPlayButtonForSound0 = () => {
			const featuredContainer = document.querySelector(
				'#audioigniter-5, .audioigniter-root[data-tracks-url*="audioigniter_playlist_id=5"], .audioigniter-root[id*="audioigniter-5"], .audioigniter-root[data-playlist-id="5"], #vyra-player-container'
			);

			let button = null;

			if (featuredContainer) {
				button = featuredContainer.querySelector('.ai-audio-control, .ai-btn-play, .ai-btn-pause, button.ai-btn, .ai-btn');
				if (!button) {
					button = featuredContainer.querySelector('.vyra-play-trigger, .vyra-play-overlay-btn, .vyra-card-play-btn');
				}
			}

			if (!button) {
				button = document.querySelector(
					'#audioigniter-5 .ai-audio-control, #audioigniter-5 .ai-btn-play, #audioigniter-5 button, .vyra-featured-player .ai-audio-control, .vyra-featured-player .ai-btn-play, .vyra-featured-player button, .vyra-featured-layout .vyra-play-trigger'
				);
			}

			return button;
		};

		// Synchronous first user gesture handler (Direct Pointer Event Triggering AudioIgniter Play Control)
		const handleFirstNaturalGesture = () => {
			if (autoplayConfirmed || gestureAttempted) return;

			gestureAttempted = true;

			const targetButton = findAudioIgniterPlayButtonForSound0();

			if (!targetButton) {
				console.log('[VYRA Autoplay] AUDIOIGNITER TARGET NOT FOUND');
				return;
			}

			console.log('[VYRA Autoplay] FIRST GESTURE PLAY TRIGGERED');

			targetButton.click();
		};

		const gestureEvent = 'PointerEvent' in window ? 'pointerup' : 'click';
		document.addEventListener(gestureEvent, handleFirstNaturalGesture, {
			once: true,
			passive: true
		});

		// Silent page-load play call removed to prevent SoundManager2 internal auto-stop on unhandled NotAllowedError
	};

	initHomepageAutoplay();
});
