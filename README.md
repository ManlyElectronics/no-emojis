# Manly No Emojis

A lightweight WordPress plugin that disables emoji functionality to improve performance and reduce HTTP requests.

## Features

- **Performance Optimization**: Removes unnecessary emoji detection scripts and styles
- **Lightweight**: Minimal code footprint with no dependencies
- **Zero Configuration**: Works out of the box - just activate and go
- **Comprehensive Coverage**: Disables emojis across frontend, admin, RSS feeds, and emails

## What It Removes

- Emoji detection script from page head
- Emoji styles from frontend and admin
- TinyMCE wpemoji plugin
- Emoji conversion in RSS feeds
- Emoji handling in emails
- DNS prefetch for emoji CDN

## Requirements

- **WordPress**: 5.0 or higher (tested up to 6.9)
- **PHP**: 7.4 or higher

## Installation

1. Upload the `manly-no-emojis` folder to `/wp-content/plugins/`
2. Activate the plugin through the **Plugins** menu in WordPress
3. Done! No configuration needed.

## FAQ

### Will this break my site?

No. This plugin only removes emoji-related scripts and styles. Regular text and images are completely unaffected.

### Can I still use emojis?

Yes! Emojis will display as plain text characters or native OS emojis instead of WordPress's Twitter-style images. This actually provides better compatibility across different platforms.

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

### 1.0.1
- Bug fixes and improvements

### 1.0
- Initial release
