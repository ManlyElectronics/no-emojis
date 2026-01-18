<?php
/**
 * Plugin Name: Manly No Emojis
 * Description: Disables the emoji functionality in WordPress to improve performance.
 * Version: 1.0.1
 * Author: Manly Electronics
 * Author URI: https://manlyelectronics.com.au
 * License: GPL2
 * Requires PHP: 7.4
 *
 * @category Plugin
 * @package  Manly_No_Emojis
 * @author   Manly Electronics <info@manlyelectronics.com.au>
 * @license  GPL2 https://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://manlyelectronics.com.au
 *
 * @since 1.0.0
 */

if (! defined('ABSPATH') ) {
    exit;
}

// Disable the emoji detection script in the head.
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');

// Disable the emoji styles in the front-end and admin.
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove the TinyMCE emoji plugin.
add_filter(
    'tiny_mce_plugins',
    function ( $plugins ) {
        if (is_array($plugins)) {
            return array_diff($plugins, array( 'wpemoji' ));
        }
        return array();
    }
);

// Remove emoji from RSS feeds.
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');

// Remove emoji from email.
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

// Prevent DNS prefetching for emoji.
add_filter('emoji_svg_url', '__return_false');
