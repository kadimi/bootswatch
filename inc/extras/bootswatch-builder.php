<?php
/**
 * Bootswatch theme builder.
 *
 * @package Bootswatch
 */

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Build a bootswatch theme.
 *
 * The function builds CSS code for a theme and stores it in cache.
 * If the cache already exists, the function skips the build process,
 * unless `$rebuild` is set to true.
 *
 * @param  String  $theme      Theme name, e.g. `cerulean`.
 * @param  Array   $overrides  Associative array of variable names and values.
 * @param  Boolean $rebuild    Should the function rebuild the cache.
 * @return String              Generated CSS file path.
 */
function bootswatch_build( $theme, $overrides = [], $rebuild = WP_DEBUG ) {

	$filesystem = new Filesystem();
	$finder = new Finder();

	$cache_dir = get_template_directory() . '/cache';
	$cached_file_path = sprintf( '%1$s/%2$s%3$s.min.css'
		, $cache_dir
		, $theme
		, $overrides ? '-' . md5( serialize( $overrides ) ) : ''
	);

	/**
	 * Return cached CSS if a rebuild is not requested and cache exists.
	 */
	if ( ! $rebuild ) {
		if ( file_exists( $cached_file_path ) ) {
			return $cached_file_path;
		}
	}

	/**
	 * Clear old cache.
	 */
	$finder->files()->in( $cache_dir )->date( 'before now - 6 hours' );
	foreach ( $finder as $file ) {
	    $filesystem->remove( $file->getRealPath() );
	}

	$bootstrap_dir = get_template_directory() . '/vendor/thomaspark/bootswatch/bower_components/bootstrap';
	$bootstrap_less = file_get_contents( $bootstrap_dir . '/less/bootstrap.less' );
	$bootswatch_theme_variables_less = file_get_contents( get_template_directory() . '/vendor/thomaspark/bootswatch/' . $theme . '/variables.less' );
	$bootswatch_theme_less_file_path = $bootstrap_dir . '/less/bootswatch-' . $theme . '.less';
	$variables_less_file_path = $bootstrap_dir . '/less/variables-' . $theme . '.less';

	/**
	 * Apply overrides to bootswatch theme variables.less file.
	 */
	foreach ( $overrides as $variable => $value ) {
		$regex = sprintf( '/(%1$s)\s*:\s*(.+?);/s', $variable );
		$replacement = sprintf( '$1:%s;', $value );
		$bootswatch_theme_variables_less = preg_replace( $regex, $replacement, $bootswatch_theme_variables_less );
	}

	/**
	 * Create temporary bootswatch variable less file.
	 */
	$filesystem->dumpFile( $variables_less_file_path, $bootswatch_theme_variables_less );

	$bootswatch_less = str_replace( 'variables.less', 'variables-' . $theme . '.less', $bootstrap_less );
	$filesystem->dumpFile( $bootswatch_theme_less_file_path, $bootswatch_less );

	/**
	 * Parse bootswatch theme LESS code.
	 */
	$less_parser = new Less_Parser( [ 'compress' => true ] );
	$less_parser->parseFile( $bootswatch_theme_less_file_path );
	$css = $less_parser->getCss();
	$filesystem->remove( $bootswatch_theme_less_file_path );
	$filesystem->remove( $variables_less_file_path );

	/**
	 * Save generated CSS code to cache.
	 */
	if ( ! file_exists( $cache_dir ) ) {
		$filesystem->mkdir( $cache_dir, 0777 );
	}
	$filesystem->dumpFile( $cached_file_path, $css );

	return $cached_file_path;
}
