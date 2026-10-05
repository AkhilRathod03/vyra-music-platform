# VYRA — Music & Culture Platform

A premium music and culture platform built with WordPress, featuring a custom responsive theme, dynamic music releases, artist profiles, AudioIgniter-based audio playback, a persistent global music player, CMS-managed homepage content, and optimized media delivery.

---

## Overview

**VYRA** is an editorial-style music platform engineered as a custom, high-performance WordPress theme (`vyra-theme`). The site provides an immersive audio streaming and culture catalog experience for independent record labels, artists, and music enthusiasts. It blends dynamic WordPress Custom Post Types with a persistent bottom audio bar and multi-track audio synchronization powered by AudioIgniter and SoundManager2.

---

## Features

- **Premium Editorial Aesthetic**: Modern dark-mode visual design with smooth typography, glassmorphism overlays, and dynamic hover effects.
- **Custom WordPress Theme**: Built from scratch (`vyra-theme`) with modular component templates and zero bloat.
- **Dynamic Releases Catalog**: Custom Post Type (`release`) supporting catalog numbers, release types, release years, cover artwork, and embedded audio.
- **Artist Profiles System**: Custom Post Type (`artist`) linking spotlight artists with biographic information and catalog discography.
- **Music Library Page**: Responsive track listing page (`/music/`) showcasing full catalog releases with instant audio playback controls.
- **AudioIgniter Integration**: Dynamic shortcode embedding (`[ai_playlist id="..."]`) powering individual release audio engines.
- **Persistent Global Music Player**: Sticky bottom audio control bar preserving playback continuity, track title, artist name, artwork, interactive seekable progress bar, and duration across page navigation.
- **Single-Track Audio Synchronization**: Direct SoundManager2 sound object control preventing multi-track audio overlapping while preserving native React UI component states.
- **Atomic Play/Pause State Sync**: Real-time state reflection across row controls, global bottom player, and mobile layouts.
- **Homepage CMS Integration**: Full WordPress Admin editability (`WP Admin → Pages → Home → Edit`) managing Hero text, featured releases, manifesto copy, and section headers without code changes.
- **Responsive Layout**: Tailored UI layouts optimized for desktop, tablet, and mobile browsers.
- **Optimized Media Delivery**: Performant asset loading for images and audio streams.

---

## Tech Stack

- **WordPress 6.x**: Core Content Management System & Custom Theme Framework
- **PHP 8.2+**: Server-side templating, WP_Query execution, custom metadata, and shortcode handling
- **JavaScript (ES6+)**: Event-driven architecture, DOM manipulation, mutation observers, and state synchronizers
- **HTML5 & CSS3**: Custom responsive styling utilizing CSS custom properties (variables) and Flexbox/Grid layouts
- **AudioIgniter**: Custom WordPress audio player plugin integration
- **SoundManager2**: Underlying HTML5/Audio API engine managing sound instances, position tracking, and events
- **LocalWP**: Local development and server environment orchestration

---

## Project Structure

```
vyra-music-platform/
├── wp-content/themes/vyra-theme/
│   ├── style.css             # Main theme stylesheet & CSS design tokens
│   ├── functions.php         # Theme setup, CPT registration, meta boxes, & asset enqueuing
│   ├── header.php            # Global site header & navigation bar
│   ├── footer.php            # Global site footer & persistent audio player container
│   ├── front-page.php        # CMS-driven homepage template
│   ├── index.php             # Fallback index template
│   ├── archive-release.php   # Music catalog archive template
│   ├── single-release.php    # Individual release details template
│   ├── archive-artist.php    # Artist directory template
│   ├── single-artist.php     # Individual artist profile template
│   ├── page-music.php        # Music library template (/music/)
│   ├── page-about.php        # About page template (/about/)
│   ├── page-contact.php      # Contact page template (/contact/)
│   └── assets/
│       ├── css/
│       │   └── vyra-main.css # Theme structural & responsive styles
│       ├── js/
│       │   └── vyra-main.js  # Multi-track AudioIgniter & global player synchronizer
│       └── images/           # Release artwork and brand graphics
├── README.md                 # Project documentation
├── .gitignore                # Git exclusion rules
└── LICENSE                   # MIT Open Source License
```

---

## Music System & Audio Architecture

1. **Release Post Type (`release`)**: Represents singles, EPs, and albums. Each release links to an AudioIgniter playlist ID stored in post metadata (`_vyra_audioigniter_id`).
2. **Artist Post Type (`artist`)**: Tracks recording artists and spotlights.
3. **AudioIgniter Integration**: Embeds AudioIgniter's player engine into music rows via `[ai_playlist id="..."]`.
4. **Global Player Synchronizer**: `vyra-main.js` observes active SoundManager2 sound objects, extracting track titles, artist names, cover images, and playback position to populate `#vyra-global-player`.
5. **Chained Callback Event System**: Custom SoundManager2 event listeners wrap AudioIgniter's native React callbacks (`onplay`, `onpause`, `onresume`, `onfinish`), guaranteeing that pausing a track through single-track enforcement cleanly resets AudioIgniter's internal React button state without synthetic `.click()` side effects.

---

## Homepage CMS

The VYRA homepage (`/`) is fully editable via WordPress Admin:

1. Navigate to **WP Admin → Pages → Home → Edit**.
2. Update the Hero headline, subtext, featured release selection, and manifesto content.
3. Save changes. The `front-page.php` template dynamically renders updated fields while preserving layout styling and audio playback.

---

## Local Development

To run this project locally using LocalWP:

1. Clone or copy the repository into your LocalWP site path:
   `wp-content/themes/vyra-theme/`
2. Ensure WordPress is running on LocalWP (`http://vyra.local`).
3. Activate the **VYRA Theme** under **WP Admin → Appearance → Themes**.
4. Install and activate the **AudioIgniter** plugin.
5. Create Releases and Artists in WP Admin, assigning AudioIgniter playlist IDs to releases.

---

## Deployment

VYRA is engineered for deployment on live WordPress production environments (such as Kinsta, WP Engine, or custom VPS hosts).

*Note: All local database credentials, server configuration files (`wp-config.php`), and environment variables are excluded from version control for security.*

---

## Author

**Akhil Kumar**  
Software Engineer  
GitHub: [AkhilRathod03](https://github.com/AkhilRathod03)

---

## License

This project is licensed under the [MIT License](LICENSE).
