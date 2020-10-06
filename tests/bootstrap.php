<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Bootswatch
 */

$bootswatch_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $bootswatch_tests_dir ) {
	$bootswatch_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $bootswatch_tests_dir . '/includes/functions.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Undocumented.
 */
function bootswatch_register_theme() {

	$theme_dir     = dirname( dirname( __FILE__ ) );
	$current_theme = basename( $theme_dir );

	register_theme_directory( dirname( $theme_dir ) );

	add_filter(
		'pre_option_template',
		function() use ( $current_theme ) {
			return $current_theme;
		}
	);
	add_filter(
		'pre_option_stylesheet',
		function() use ( $current_theme ) {
			return $current_theme;
		}
	);
}
tests_add_filter( 'muplugins_loaded', 'bootswatch_register_theme' );

// Start up the WP testing environment.
require $bootswatch_tests_dir . '/includes/bootstrap.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Load MonkeyTestCase class file.
require 'tests/class-monkey-test-case.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

// Load dependencies.
require 'vendor/autoload.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
