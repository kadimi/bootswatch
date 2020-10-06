<?php
/**
 * Bootswatch functions and definitions.
 *
 * @package Bootswatch
 */

define( 'BOOTSWATCH_DIR', get_template_directory() );
define( 'BOOTSWATCH_MINIMAL_PHP_VERSION', '7.3.0' );
define( 'BOOTSWATCH_MINIMAL_PHP_VERSION_ID', 70300 );

/**
 * Loads Bootswatch translated strings.
 */
function bootswatch_load_textdomain() {
	load_theme_textdomain( 'bootswatch', BOOTSWATCH_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'bootswatch_load_textdomain' );

/**
 * Load all extras from ./inc/ using `get_template_part()` to allow overriding.
 */
if ( PHP_VERSION_ID > BOOTSWATCH_MINIMAL_PHP_VERSION_ID ) {
	$bootswatch_extras = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( BOOTSWATCH_DIR . '/inc' ), RecursiveIteratorIterator::SELF_FIRST );
	( function() use ( $bootswatch_extras ) {
		foreach ( $bootswatch_extras as $extra => $unused ) {
			$extra = str_replace( '\\', '/', $extra );
			if ( preg_match( '/\/[\w-]+\.php$/', $extra ) ) {
				get_template_part( substr( $extra, strlen( BOOTSWATCH_DIR ), -4 ) );
			}
		}
	} )();
} else {
	get_template_part( 'inc/compatibility/php-version' );
}
