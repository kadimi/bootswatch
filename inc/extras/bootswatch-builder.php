<?php
/**
 * Bootswatch theme builder.
 *
 * @package Bootswatch
 */

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Build a bootswatch theme (results are cached).
 *
 * @param  String  $theme      Theme name, e.g. `cerulean`.
 * @param  Array   $overrides  Associative array of variable names and values.
 * @param  Boolean $rebuild    Should the function rebuild the cache.
 * @return String              Generated CSS file path.
 */
function bootswatch_build( $theme, $overrides = [], $rebuild = WP_DEBUG ) {

	$paths = $contents = [];
	$text_direction = is_rtl() ? 'rtl' : 'ltr';

	$paths['cache.dir'] = get_template_directory() . '/cache';
	$paths['cache.css'] = sprintf( '%1$s/%2$s%3$s-%4$s.min.css', $paths['cache.dir'], $theme, $overrides ? '-' . md5( serialize( $overrides ) ) : '', $text_direction );

	$filesystem = new Filesystem();
	if ( ! file_exists( $paths['cache.dir'] ) ) {
		$filesystem->mkdir( $paths['cache.dir'], 0777 );
	}

	/**
	 * Return cached CSS if a rebuild is not requested and cache exists.
	 */
	if ( ! $rebuild && file_exists( $paths['cache.css'] ) ) {
		return $paths['cache.css'];
	}

	/**
	 * Clear old cache.
	 */
	$finder = new Finder();
	$finder->files()->in( $paths['cache.dir'] )->date( 'before now - 6 hours' );
	foreach ( $finder as $file ) {
	    $filesystem->remove( $file->getRealPath() );
	}

	$paths['bootswatch.dir'] = get_template_directory() . '/vendor/thomaspark/bootswatch';
	$paths['bootstrap.dir']  = $paths['bootswatch.dir'] . '/bower_components/bootstrap';
	$paths                   = array_merge( $paths, [
		'tmp-bootstrap.less'       => $paths['bootstrap.dir'] . '/less/tmp-bootstrap.less',
		'tmp-theme-variables.less' => $paths['bootstrap.dir'] . '/less/tmp-' . $theme . '-variables.less',
		'tmp-final.less'           => $paths['bootstrap.dir'] . '/less/tmp-final.less',
	] );

	$contents = array_merge( $contents, [
		'tmp-bootstrap.less'       => file_get_contents( $paths['bootstrap.dir'] . '/less/bootstrap.less' ),
		'bootswatch.less'          => file_get_contents( $paths['bootswatch.dir'] . '/' . $theme . '/bootswatch.less' ),
		'tmp-theme-variables.less' => file_get_contents( $paths['bootswatch.dir'] . '/' . $theme . '/variables.less' ),
		'tmp-final.less'           => '',
	] );

	/**
	 * #1 - Prepare variables.less.
	 *
	 * Apply overrides to bootswatch theme variables.less file.
	 *
	 * Value will be surrounded in quotes if:
	 * - it contains a forward slash
	 */
	foreach ( $overrides as $variable => $value ) {
		$regex                                = sprintf( '/(%1$s)\s*:\s*(.+?);/s', $variable );
		$replacement                          = strstr( $value, '/' ) ? sprintf( '$1:"%s";', $value ) : sprintf( '$1:%s;', $value );
		$contents['tmp-theme-variables.less'] = preg_replace( $regex, $replacement, $contents['tmp-theme-variables.less'] );
	}
	$filesystem->dumpFile( $paths['tmp-theme-variables.less'], $contents['tmp-theme-variables.less'] );

	/**
	 * #2 - Prepary tmp-bootstrap.less.
	 */
	$contents['tmp-bootstrap.less'] = str_replace( 'variables.less', 'tmp-' . $theme . '-variables.less', $contents['tmp-bootstrap.less'] );
	$filesystem->dumpFile( $paths['tmp-bootstrap.less'], $contents['tmp-bootstrap.less'] );

	/**
	 * #3 - Prepary tmp-final.less.
	 *
	 * Contents:
	 * - Bootstrap
	 * - Modified variables.less path
	 * - Bootswatch theme
	 */
	$contents['tmp-final.less'] = $contents['tmp-bootstrap.less'] . $contents['bootswatch.less'];
	$filesystem->dumpFile( $paths['tmp-final.less'], $contents['tmp-final.less'] );

	/**
	 * Parse and save bootswatch theme LESS code.
	 */
	$less_parser = new Less_Parser( [ 'compress' => true ] );
	$less_parser->parseFile( $paths['tmp-final.less'] );
	$css = $less_parser->getCss();
	if ( is_rtl() ) {
		$css = CSSJanus::transform( $css );
	}
	$filesystem->dumpFile( $paths['cache.css'], $css );

	/**
	 * Delete temporary files.
	 */
	array_map( function( $path ) use ( $filesystem ) {
		if ( 'tmp-' === substr( basename( $path ), 0, 4 ) ) {
			$filesystem->remove( $path );
		}
	}, $paths);

	/**
	 * Return cache file path.
	 */
	return $paths['cache.css'];
}
