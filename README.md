# Manly No Emojis
Published at https://wordpress.org/plugins/manly-no-emojis/

A lightweight WordPress plugin that disables emoji functionality to improve performance and reduce HTTP requests.

## Features

- **Performance Optimization**: Removes unnecessary emoji detection scripts and styles
- **Lightweight**: Minimal code footprint with no dependencies
- **Zero Configuration**: Works out of the box - just activate and go
- **Comprehensive Coverage**: Disables WordPress emoji processing across frontend, admin, RSS feeds, and emails

## What It Removes

- Emoji detection script from page head
- Emoji styles from frontend and admin
- TinyMCE wpemoji plugin
- Emoji conversion in RSS feeds
- Emoji handling in emails
- DNS prefetch for emoji CDN

Optionally, the plugin can replace common emojis with English descriptions and remove other recognized emojis, or remove all emojis recognized by the installed WordPress version without descriptions. This applies to displayed post and page content and comments, is off by default, and does not change saved content. HTML attributes and text in code, preformatted, script, style, and textarea elements are left unchanged.

## Requirements

- **WordPress**: 5.0 or higher (tested up to 7.2)
- **PHP**: 7.4 or higher

## Installation

1. Upload the `manly-no-emojis` folder to `/wp-content/plugins/`
2. Activate the plugin through the **Plugins** menu in WordPress
3. Done! No configuration needed.

To change how emojis appear in content, go to **Settings > Manly No Emojis** and select an option.

## FAQ

### Will this break my site?

The plugin disables WordPress emoji processing. If you enable content conversion, recognized emojis in displayed post and page content and comments are replaced or removed. Saved content is not changed.

### Can I still use emojis?

Yes. The plugin does not remove emoji characters from your content. Browsers can display them using their own or the operating system's emoji fonts.

WordPress normally checks emoji support and may replace unsupported characters with images. This plugin disables that processing, so unsupported emojis may not display correctly.

If content conversion is enabled, recognized emojis in post and page content and comments are replaced or removed instead. Other site text, such as titles, is not converted.

## Performance Impact

By removing WordPress's emoji functionality, you'll reduce:
- HTTP requests to emoji CDN services
- CSS and JavaScript processing in the browser
- Overall page load time

## License

GPL-2.0+

Licensed under the GNU General Public License v2 or later. See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for details.


## Author

Manly Electronics  
https://manlyelectronics.com.au

## Changelog

### 1.1.0
- Added optional emoji descriptions or removal in post and page content and comments.
- Fixed emoji scripts and styles in admin and emoji scripts in embeds.
- Tested up to WordPress 7.2.

### 1.0.1
- Bug fixes and improvements

### 1.0
- Initial release
