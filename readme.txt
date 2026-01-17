=== Manly No Emojis ===
Contributors: DimitriAus
Tags: emoji, performance, speed, disable, optimization
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Disables the emoji functionality in WordPress to improve performance.

== Description ==

This lightweight plugin removes WordPress emoji functionality to reduce HTTP requests and improve page load times.

**What it removes:**

* Emoji detection script from page head
* Emoji styles from frontend and admin
* TinyMCE wpemoji plugin
* Emoji conversion in RSS feeds
* Emoji handling in emails
* DNS prefetch for emoji CDN

== Installation ==

1. Upload the `manly-no-emojis` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Done! No configuration needed.

== Frequently Asked Questions ==

= Will this break my site? =

No. This plugin only removes emoji-related scripts and styles. Regular text and images are unaffected.

= Can I still use emojis? =

Yes, but they will display as plain text characters or native OS emojis instead of WordPress's Twitter-style images.

== Changelog ==

= 1.0 =
* Initial release
