<?php
/**
 * PHP version compatibility.
 *
 * @package Bootswatch
 */

add_action( 'init', function() {

	/**
	 * Exit function if PHP version is compatible.
	 */
	if ( PHP_VERSION_ID > 54000 ) {
		return;
	}

	/**
	 * Find newest available WordPress theme.
	 */
	$newest_available_wp_theme = false;
	$wp_themes = [
		'twentyninteen',
		'twentyeighteen',
		'twentyseventeen',
		'twentysixteen',
		'twentyfifteen',
		'twentyfourteen',
		'twentythirteen',
		'twentytwelve',
		'twentyeleven',
		'twentyten',
	];
	array_walk( $wp_themes, function( $wp_theme ) use ( &$newest_available_wp_theme ) {
		if ( ! $newest_available_wp_theme ) {
			if ( file_exists( WP_CONTENT_DIR . "/themes/$wp_theme/style.css" ) ) {
				$newest_available_wp_theme = $wp_theme;
			}
		}
	} );
	if ( ! $newest_available_wp_theme ) {
		return;
	}

	/**
	 * Switch theme.
	 */
	switch_theme( $newest_available_wp_theme );

	/**
	 * Let the admin now we switched the theme and explain why.
	 */
	add_action( 'admin_notices', function() use ( $newest_available_wp_theme ) {
		// Translators: %1$s is the current PHP version and %2$s is a WordPress default theme name.
		$message = sprintf( __( 'Bootswatch requires <code>PHP 5.4</code> or higher, you are using <code>PHP %1$s</code>. We will revert to the theme %2$s but we hope that you will uprade PHP very soon.', 'bootswatch' ), PHP_VERSION, wp_get_theme( $newest_available_wp_theme ) );
		bootswatch_admin_notice( $message, 'php-compatibility-error', 'error' );
	} );
}, PHP_INT_MIN );
