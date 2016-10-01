<?php
/**
 * Bootswatch theme builder.
 *
 * @package Bootswatch
 */

use Symfony\Component\Filesystem\Filesystem;

/**
 * Build a bootswatch theme.
 *
 * The function builds CSS code for a theme and stores it in cache.
 * If the cache already exists, the function skips the build process,
 * unless `$rebuild` is set to true.
 *
 * @param  String  $theme      Theme name, e.g. Cerulean.
 * @param  Array   $overrides  Associative array of variable names and values.
 * @param  Boolean $rebuild    Should the function rebuild the cache.
 * @return String              Generated CSS code.
 */
function bootswatch_build( $theme, $overrides = [], $rebuild = WP_DEBUG ) {

	/**
	 * Filesystem.
	 *
	 * @var Filesystem
	 */
	$fs = new Filesystem();

	/**
	 * Cache directory path.
	 *
	 * @var String
	 */
	$cache_dir = get_template_directory() . '/cache';

	/**
	 * Cache file path.
	 *
	 * @var String
	 */
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
			return file_get_contents( $cached_file_path );
		}
	}

	/**
	 * The folder of bootstrap.
	 *
	 * @var String
	 */
	$bootstrap_dir = get_template_directory() . '/vendor/thomaspark/bootswatch/bower_components/bootstrap';

	/**
	 * The bootstrap main less file contents.
	 *
	 * @var String
	 */
	$bootstrap_less = file_get_contents( $bootstrap_dir . '/less/bootstrap.less' );

	/**
	 * Bootswatch theme variables.less
	 *
	 * @var String
	 */
	$bootswatch_theme_variables_less = file_get_contents( get_template_directory() . '/vendor/thomaspark/bootswatch/' . $theme . '/variables.less' );

	/**
	 * The path of the temporary bootswatch file.
	 *
	 * @var String
	 */
	$bootswatch_theme_less_file_path = $bootstrap_dir . '/less/bootswatch-' . $theme . '.less';

	/**
	 * The path of the temporary variables file
	 *
	 * @var String
	 */
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
	$fs->dumpFile( $variables_less_file_path, $bootswatch_theme_variables_less );

	/**
	 * The bootswatch less code.
	 *
	 * It's bootstrap's less file contents with @variables pointing to bootswatch theme variables.less.
	 *
	 * @var String
	 */
	$bootswatch_less = str_replace( 'variables.less', 'variables-' . $theme . '.less', $bootstrap_less );

	/**
	 * Create temporary bootswatch less file.
	 */
	$fs->dumpFile( $bootswatch_theme_less_file_path, $bootswatch_less );

	/**
	 * Parse bootswatch theme LESS code.
	 */
	$css = ( new Less_Parser( [ 'compress' => true ] ) )->parseFile( $bootswatch_theme_less_file_path )->getCss();

	/**
	 * Delete temporary files.
	 */
	$fs->remove( $bootswatch_theme_less_file_path );
	$fs->remove( $variables_less_file_path );

	/**
	 * Maybe create cache directory.
	 */
	if ( ! file_exists( $cache_dir ) ) {
		$fs->mkdir( $cache_dir, 0777 );
	}

	/**
	 * Save generated CSS code to cache.
	 */
	$fs->dumpFile( $cached_file_path, $css );

	/**
	 * Return generated CSS code.
	 */
	return $css;
}
