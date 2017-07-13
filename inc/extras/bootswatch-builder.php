<?php
/**
 * Bootswatch theme builder.
 *
 * @package Bootswatch
 */

/**
 * Build a bootswatch theme (results are cached).
 *
 * @param  String  $theme      Theme name, e.g. `cerulean`.
 * @param  Array   $overrides  Associative array of variable names and values.
 * @param  Boolean $rebuild    Should the function rebuild the cache.
 * @return String              Generated CSS file path.
 */
function bootswatch_build( $theme, $overrides = [], $rebuild = WP_DEBUG ) {

	if ( ! class_exists( 'Less_Parser' ) ) {
		return;
	}

	$paths          = [];
	$contents       = [];
	$text_direction = is_rtl() ? 'rtl' : 'ltr';

	$paths['cache.dir'] = get_template_directory() . '/cache';
	$paths['cache.css'] = sprintf( '%1$s/%2$s%3$s-%4$s.min.css', $paths['cache.dir'], $theme, $overrides ? '-' . md5( serialize( $overrides ) ) : '', $text_direction );

	/**
	 * Return cached CSS if a rebuild is not requested and cache exists.
	 */
	if ( ! $rebuild && file_exists( $paths['cache.css'] ) ) {
		return $paths['cache.css'];
	}


	/**
	 * Create file system instance.
	 */
	require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
	$fs = new WP_Filesystem_Direct( 'bootswatch' );

	/**
	 * Clear old cache.
	 */
	$fs->delete( $paths['cache.dir'] );
	$fs->mkdir( $paths['cache.dir'] );

	$paths['bootswatch.dir'] = get_template_directory() . '/vendor/thomaspark/bootswatch';
	$paths['bootstrap.dir']  = $paths['bootswatch.dir'] . '/bower_components/bootstrap';
	$paths                   = array_merge( $paths, [
		'tmp-bootstrap.less'       => $paths['bootstrap.dir'] . '/less/tmp-bootstrap.less',
		'tmp-theme-variables.less' => $paths['bootstrap.dir'] . '/less/tmp-' . $theme . '-variables.less',
		'tmp-final.less'           => $paths['bootstrap.dir'] . '/less/tmp-final.less',
	] );

	$contents = array_merge( $contents, [
		'tmp-bootstrap.less'       => $fs->get_contents( $paths['bootstrap.dir'] . '/less/bootstrap.less' ),
		'bootswatch.less'          => $fs->get_contents( $paths['bootswatch.dir'] . '/' . $theme . '/bootswatch.less' ),
		'tmp-theme-variables.less' => $fs->get_contents( $paths['bootswatch.dir'] . '/' . $theme . '/variables.less' ),
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
	$fs->put_contents( $paths['tmp-theme-variables.less'], $contents['tmp-theme-variables.less'] );

	/**
	 * #2 - Prepare tmp-bootstrap.less.
	 */
	$contents['tmp-bootstrap.less'] = str_replace( 'variables.less', 'tmp-' . $theme . '-variables.less', $contents['tmp-bootstrap.less'] );
	$fs->put_contents( $paths['tmp-bootstrap.less'], $contents['tmp-bootstrap.less'] );

	/**
	 * #3 - Prepare tmp-final.less.
	 *
	 * Contains: Bootstrap, modified variables.less path and Bootswatch theme.
	 */
	$contents['tmp-final.less'] = $contents['tmp-bootstrap.less'] . $contents['bootswatch.less'];
	$fs->put_contents( $paths['tmp-final.less'], $contents['tmp-final.less'] );

	/**
	 * Parse and save bootswatch theme LESS code.
	 */
	$less_parser = new Less_Parser( [
		'compress' => true,
	] );
	$less_parser->parseFile( $paths['tmp-final.less'] );
	$css = $less_parser->getCss();
	if ( is_rtl() ) {
		$css = CSSJanus::transform( $css );
	}
	$fs->put_contents( $paths['cache.css'], $css );

	/**
	 * Delete temporary files.
	 */
	array_map( function( $path ) use ( $fs ) {
		if ( 'tmp-' === substr( basename( $path ), 0, 4 ) ) {
			$fs->delete( $path );
		}
	}, $paths);

	return $paths['cache.css'];
}
