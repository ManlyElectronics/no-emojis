<?php
/**
 * Plugin Name: Manly No Emojis
 * Description: Disables the emoji functionality in WordPress to improve performance.
 * Version: 1.1.0
 * Author: Manly Electronics
 * Author URI: https://manlyelectronics.com.au
 * License: GPL2
 * Requires PHP: 7.4
 *
 * @category  Plugin
 * @package   Manly_No_Emojis
 * @license   GPL2 https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/ManlyElectronics/no-emojis
 * @since     1.0.0
 * PHP Version 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Disable the emoji detection script in the head.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'embed_head', 'print_emoji_detection_script' );

// Disable the emoji styles in the front-end.
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Admin hooks are registered after plugins are loaded.
add_action(
	'admin_init',
	function () {
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
	}
);

// Remove the TinyMCE emoji plugin.
add_filter(
	'tiny_mce_plugins',
	function ( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		}
		return array();
	}
);

// Remove emoji from RSS feeds.
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

// Remove emoji from email.
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

// Prevent DNS prefetching for emoji.
add_filter( 'emoji_svg_url', '__return_false' );

/**
 * Register the optional content conversion setting.
 *
 * @since 1.1.0
 * @return void
 */
function manly_no_emojis_register_settings() {
	register_setting(
		'manly_no_emojis',
		'manly_no_emojis_convert_content',
		array(
			'sanitize_callback' => 'manly_no_emojis_sanitize_setting',
			'default'           => '0',
		)
	);
}
add_action( 'admin_init', 'manly_no_emojis_register_settings' );

/**
 * Validate the content conversion setting.
 *
 * @since 1.1.0
 * @param mixed $value Submitted setting value.
 * @return string The validated setting.
 */
function manly_no_emojis_sanitize_setting( $value ) {
	if ( in_array( $value, array( '0', '1', 'remove' ), true ) ) {
		return $value;
	}

	add_settings_error(
		'manly_no_emojis_convert_content',
		'manly_no_emojis_invalid_mode',
		__( 'Please select a valid emoji content option.', 'manly-no-emojis' )
	);
	return get_option( 'manly_no_emojis_convert_content', '0' );
}

/**
 * Add the plugin settings page.
 *
 * @since 1.1.0
 * @return void
 */
function manly_no_emojis_add_settings_page() {
	add_options_page(
		__( 'Manly No Emojis', 'manly-no-emojis' ),
		__( 'Manly No Emojis', 'manly-no-emojis' ),
		'manage_options',
		'manly-no-emojis',
		'manly_no_emojis_render_settings_page'
	);
}
add_action( 'admin_menu', 'manly_no_emojis_add_settings_page' );

/**
 * Render the plugin settings page.
 *
 * @since 1.1.0
 * @return void
 */
function manly_no_emojis_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to manage these settings.', 'manly-no-emojis' ) );
	}
	$mode = get_option( 'manly_no_emojis_convert_content', '0' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Manly No Emojis', 'manly-no-emojis' ); ?></h1>
		<form action="options.php" method="post">
			<?php settings_fields( 'manly_no_emojis' ); ?>
			<fieldset>
				<legend><?php esc_html_e( 'Emojis in post and page content and comments', 'manly-no-emojis' ); ?></legend>
				<p>
					<label>
						<input type="radio" name="manly_no_emojis_convert_content" value="0" <?php checked( '0', $mode ); ?>>
						<?php esc_html_e( 'Leave emojis unchanged', 'manly-no-emojis' ); ?>
					</label>
					<br>
					<span class="description"><?php esc_html_e( 'Example:', 'manly-no-emojis' ); ?> Hello &#x1f600;! <?php esc_html_e( 'stays', 'manly-no-emojis' ); ?> Hello &#x1f600;!</span>
					<br>
					<span class="description"><?php esc_html_e( 'WordPress emoji scripts and styles remain disabled in all modes.', 'manly-no-emojis' ); ?></span>
				</p>
				<p>
					<label>
						<input type="radio" name="manly_no_emojis_convert_content" value="1" <?php checked( '1', $mode ); ?>>
						<?php esc_html_e( 'Replace common emojis with descriptions', 'manly-no-emojis' ); ?>
					</label>
					<br>
					<span class="description"><?php esc_html_e( 'Example:', 'manly-no-emojis' ); ?> Hello &#x1f600;! <?php esc_html_e( 'becomes', 'manly-no-emojis' ); ?> Hello [grinning face]!</span>
				</p>
				<p>
					<label>
						<input type="radio" name="manly_no_emojis_convert_content" value="remove" <?php checked( 'remove', $mode ); ?>>
						<?php esc_html_e( 'Remove emojis without descriptions', 'manly-no-emojis' ); ?>
					</label>
					<br>
					<span class="description"><?php esc_html_e( 'Example:', 'manly-no-emojis' ); ?> Hello&#x1f600;! <?php esc_html_e( 'becomes', 'manly-no-emojis' ); ?> Hello!</span>
				</p>
			</fieldset>
			<p class="description">
				<?php esc_html_e( 'Descriptions are in English. In either conversion mode, other emojis recognized by WordPress are removed. Saved content is not changed.', 'manly-no-emojis' ); ?>
			</p>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Return the emoji sequences recognized by WordPress and their replacements.
 *
 * @since 1.1.0
 * @return array<string, string> Emoji sequences and replacement text.
 */
function manly_no_emojis_replacements() {
	static $replacements = null;
	if ( null !== $replacements ) {
		return $replacements;
	}

	$replacements       = array();
	$emoji_presentation = html_entity_decode( '&#xfe0f;', ENT_QUOTES, 'UTF-8' );
	foreach ( _wp_emoji_list( 'entities' ) as $entity ) {
		$emoji                  = html_entity_decode( $entity, ENT_QUOTES, 'UTF-8' );
		$replacements[ $emoji ] = '';
		if ( 1 === preg_match( '/^.$/us', $emoji ) ) {
			$replacements[ $emoji . $emoji_presentation ] = '';
		}
	}

	// Preserve legal symbols unless explicitly presented as emoji.
	foreach ( array( '&#169;', '&#174;', '&#8482;' ) as $entity ) {
		unset( $replacements[ html_entity_decode( $entity, ENT_QUOTES, 'UTF-8' ) ] );
	}

	$keycap = html_entity_decode( '&#x20e3;', ENT_QUOTES, 'UTF-8' );
	foreach ( str_split( '#*0123456789' ) as $digit ) {
		$replacements[ $digit . $keycap ]                       = '';
		$replacements[ $digit . $emoji_presentation . $keycap ] = '';
	}

	$descriptions = array(
		'&#x1f600;'        => 'grinning face',
		'&#x1f603;'        => 'smiling face',
		'&#x1f604;'        => 'smiling face',
		'&#x1f60a;'        => 'smiling face',
		'&#x1f642;'        => 'slightly smiling face',
		'&#x1f602;'        => 'face with tears of joy',
		'&#x1f923;'        => 'rolling on the floor laughing',
		'&#x1f609;'        => 'winking face',
		'&#x1f60d;'        => 'smiling face with heart eyes',
		'&#x1f622;'        => 'crying face',
		'&#x1f62d;'        => 'loudly crying face',
		'&#x1f44d;'        => 'thumbs up',
		'&#x1f44e;'        => 'thumbs down',
		'&#x1f44f;'        => 'clapping hands',
		'&#x1f64f;'        => 'folded hands',
		'&#x1f389;'        => 'celebration',
		'&#x1f525;'        => 'fire',
		'&#x1f680;'        => 'rocket',
		'&#x1f4a1;'        => 'light bulb',
		'&#x2764;'         => 'heart',
		'&#x2764;&#xfe0f;' => 'red heart',
	);

	foreach ( $descriptions as $entity => $description ) {
		$emoji                  = html_entity_decode( $entity, ENT_QUOTES, 'UTF-8' );
		$replacements[ $emoji ] = '[' . $description . ']';
		if ( isset( $replacements[ $emoji . $emoji_presentation ] ) ) {
			$replacements[ $emoji . $emoji_presentation ] = '[' . $description . ']';
		}
		for ( $tone = 0x1f3fb; $tone <= 0x1f3ff; ++$tone ) {
			$modifier = html_entity_decode( '&#' . $tone . ';', ENT_QUOTES, 'UTF-8' );
			if ( isset( $replacements[ $emoji . $modifier ] ) ) {
				$replacements[ $emoji . $modifier ] = '[' . $description . ']';
			}
		}
	}
	return $replacements;
}

/**
 * Convert recognized emoji in one HTML text segment.
 *
 * @since 1.1.0
 * @param string $text HTML text without tags.
 * @param bool   $replace_with_words Whether to use descriptions for common emojis.
 * @return string Converted text.
 */
function manly_no_emojis_convert_text( $text, $replace_with_words = true ) {
	if ( ! preg_match( '/[^\x00-\x7f]|&#(?:x[0-9a-f]+|[0-9]+);/i', $text ) ) {
		return $text;
	}
	$matched = preg_match_all( '/&#(?:x[0-9a-f]+|[0-9]+);|./isu', $text, $matches );
	if ( false === $matched ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Report a runtime conversion failure, not debug output.
		error_log( 'Manly No Emojis: Could not parse text for emoji conversion: ' . preg_last_error() );
		return $text;
	}
	$tokens  = array();
	$decoded = array();
	foreach ( $matches[0] as $token ) {
		$value = '&' === $token[0] ? html_entity_decode( $token, ENT_QUOTES, 'UTF-8' ) : $token;
		if ( $value === $token && strlen( $token ) > 1 && '&' === $token[0] ) {
			foreach ( str_split( $token ) as $character ) {
				$tokens[]  = $character;
				$decoded[] = $character;
			}
		} else {
			$tokens[]  = $token;
			$decoded[] = $value;
		}
	}
	$matched = preg_match_all( '/\X/u', implode( '', $decoded ), $clusters );
	if ( false === $matched ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Report a runtime conversion failure, not debug output.
		error_log( 'Manly No Emojis: Could not parse emoji sequences: ' . preg_last_error() );
		return $text;
	}

	$replacements = manly_no_emojis_replacements();
	$output       = '';
	$index        = 0;
	foreach ( $clusters[0] as $cluster ) {
		$original       = '';
		$length         = 0;
		$cluster_length = strlen( $cluster );
		while ( $length < $cluster_length && isset( $tokens[ $index ] ) ) {
			$original .= $tokens[ $index ];
			$length   += strlen( $decoded[ $index ] );
			++$index;
		}
		if ( array_key_exists( $cluster, $replacements ) ) {
			$output .= $replace_with_words ? $replacements[ $cluster ] : '';
		} else {
			$output .= $original;
		}
	}
	return $output;
}

/**
 * Convert emoji in displayed content without modifying HTML tags or code.
 *
 * @since 1.1.0
 * @param string $content The rendered content or comment.
 * @return string The converted content.
 */
function manly_no_emojis_convert_content( $content ) {
	$parts              = wp_html_split( $content );
	$ignored            = '';
	$replace_with_words = 'remove' !== get_option( 'manly_no_emojis_convert_content', '0' );
	foreach ( $parts as &$part ) {
		if ( '' !== $part && '<' === $part[0] ) {
			if ( '' === $ignored && preg_match( '/^<\s*(code|pre|script|style|textarea)(?:\s|>)/i', $part, $match ) ) {
				$ignored = strtolower( $match[1] );
			} elseif ( '' !== $ignored && preg_match( '/^<\s*\/\s*' . $ignored . '\s*>/i', $part ) ) {
				$ignored = '';
			}
		} elseif ( '' === $ignored && '' !== $part ) {
			$part = manly_no_emojis_convert_text( $part, $replace_with_words );
		}
	}
	unset( $part );
	return implode( '', $parts );
}

if ( in_array( get_option( 'manly_no_emojis_convert_content', '0' ), array( '1', 'remove' ), true ) ) {
	add_filter( 'the_content', 'manly_no_emojis_convert_content', 99 );
	add_filter( 'comment_text', 'manly_no_emojis_convert_content', 99 );
}
