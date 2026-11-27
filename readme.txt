=== Manly No Emojis ===
Contributors: DimitriAus
Tags: emoji, performance, speed, disable, optimization
Requires at least: 5.0
Tested up to: 7.2
Requires PHP: 7.4
Stable tag: 1.1.0
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

Optionally, the plugin can replace common emojis with English descriptions and remove other recognized emojis, or remove all emojis recognized by the installed WordPress version without descriptions. This applies to displayed post and page content and comments, is off by default, and does not change saved content. HTML attributes and text in code, preformatted, script, style, and textarea elements are left unchanged.

== Installation ==

1. Upload the `manly-no-emojis` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Done! No configuration needed.

To change how emojis appear in content, go to Settings > Manly No Emojis and select an option.

== Frequently Asked Questions ==

= Will this break my site? =

The plugin disables WordPress emoji processing. If you enable content conversion, recognized emojis in displayed post and page content and comments are replaced or removed. Saved content is not changed.

= Can I still use emojis? =

Yes. The plugin does not remove emoji characters from your content. Browsers can display them using their own or the operating system's emoji fonts.

WordPress normally checks emoji support and may replace unsupported characters with images. This plugin disables that processing, so unsupported emojis may not display correctly.

If content conversion is enabled, recognized emojis in post and page content and comments are replaced or removed instead. Other site text, such as titles, is not converted.

== Changelog ==

= 1.1.0 =
* Added: Optional emoji descriptions or removal in post and page content and comments.
* Fixed: Emoji scripts and styles in admin and emoji scripts in embeds.
* Updated: Tested up to WordPress 7.2.

= 1.0.4 =
* Updated: Tested up to WordPress 7.1.

= 1.0.3 =
* Updated: Requires PHP bumped to 7.4 (WordPress 7.0 minimum); Tested up to 7.1.

= 1.0.2 =
* Fixed: Coding standards compliance (WordPress PHPCS).
* Fixed: Minimum PHP requirement corrected to 7.2.

= 1.0 =
* Initial release.
