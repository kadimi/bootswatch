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
function bootswatch_make_theme_file( $theme, $overrides = [], $rebuild = false ) {

	/**
	 * Fall back when missing the Less compiler.
	 */
	if ( ! class_exists( 'Less_Parser' ) ) {
		switch ( $theme ) {
		case 'bootstrap':
			return get_template_directory() . '/vendor/kadimi/bootswatch-light/light/css/bootstrap.min.css';
			break;
		case 'bootstrap-theme':
			return get_template_directory() . '/vendor/kadimi/bootswatch-light/light/css/bootstrap-theme.min.css';
			break;
		default:
			return get_template_directory() . '/vendor/kadimi/bootswatch-light/light/' . $theme . '/bootstrap.min.css';
			break;
		}
	}
	$rebuild = $rebuild || ( defined( 'BOOTSWATCH_FORCE_REBUILD' ) && BOOTSWATCH_FORCE_REBUILD );

	$cache_file_basename = sprintf( '%1$s%2$s-%3$s.min.css'
		, $theme
		, $overrides ? '-' . md5( serialize( $overrides ) ) : ''
		, is_rtl() ? 'rtl' : 'ltr'
	);

	/**
	 * Return cached CSS if abs(number) rebuild is not requested, we are not debugging and cache exists.
	 */
	if ( ! $rebuild && bootswatch_cache_file_exists( $cache_file_basename ) ) {
		return get_template_directory() . '/cache/' . $cache_file_basename;
	}

	/**
	 * Prepare CSS
	 */
	$css = bootswatch_get_bootswatch_theme_css( $theme, $overrides );

	/**
	 * RTL-ize when needed.
	 */
	if ( is_rtl() ) {
		$css = CSSJanus::transform( $css );
	}

	/**
	 * Keep cache light (only ~50 files).
	 */
	bootswatch_reduce_cache( 50 );

	/**
	 * Save file
	 */
	bootswatch_cache_file( $cache_file_basename, $css );

	/**
	 * Done, return path.
	 */
	return get_template_directory() . '/cache/' . $cache_file_basename;
}

/**
 * Parse a file with Less_Parser.
 *
 * @param  String $path Path to file.
 * @return String       CSS code.
 */
function bootswatch_parse_less_file( $path ) {
	return ( new Less_Parser( [
		'compress' => true,
	] ) )->parseFile( $path )->getCss();
}

/**
 * Parses Less code.
 *
 * @param  String $less Less code.
 * @return String       CSS code.
 */
function bootswatch_parse_less( $less ) {
	return ( new Less_Parser( [
		'compress' => true,
	] ) )->parse( $less )->getCss();
}

/**
 * Build a themes file, cache it and return the path.
 *
 * @param  String $theme     The theme name, `bootstrap` or a bootswatch theme name, e.g. `lumen`.
 * @param  Array  $overrides Overrides.
 * @return String            Path to file.
 */
function bootswatch_get_bootswatch_theme_css( $theme = 'bootstrap', $overrides = [] ) {

	/**
	 * Prevent muliple using the same file.
	 */
	$salt = rand( 10, 99 );

	/**
	 * Path of original files, bare, theme and variables.
	 */
	if ( 'bootstrap' === $theme ) {
		$variables_path = bootswatch_light_directory() . 'less/variables.less';
		$bare_path      = bootswatch_light_directory() . 'less/bootstrap.less';
		$theme_path     = bootswatch_light_directory() . 'less/theme.less';
	} else {
		$variables_path = bootswatch_light_directory() . "$theme/variables.less";
		$bare_path      = bootswatch_light_directory() . 'less/bootstrap.less';
		$theme_path     = bootswatch_light_directory() . "$theme/bootswatch.less";
	}

	/**
	 * Path of temporary files, bare, theme, variables and final.
	 */
	$tmp_variables_path = bootswatch_light_directory() . "less/_tmp-variables-$salt.less";
	$tmp_bare_path      = bootswatch_light_directory() . "less/_tmp-bare-$salt.less";
	$tmp_theme_path     = bootswatch_light_directory() . "less/_tmp-theme-$salt.less";
	$tmp_final_path     = bootswatch_light_directory() . "less/_tmp-final-$salt.less";

	/**
	 * Get a file system isntance.
	 */
	$filesystem = bootswatch_get_filesystem();

	/**
	 * Create modified variables.less as tmp-variables.less
	 */
	$variables_contents = $filesystem->get_contents( $variables_path );
	foreach ( $overrides as $variable => $value ) {
		$regex       = sprintf( '/(%1$s)\s*:\s*(.+?);/s', $variable );
		$replacement = strstr( $value, '/' )
			? sprintf( '$1:"%s";', $value )
			: sprintf( '$1:%s;', $value );
		$variables_contents = preg_replace( $regex, $replacement, $variables_contents );
	}
	$filesystem->delete( $tmp_variables_path );
	$filesystem->put_contents( $tmp_variables_path, $variables_contents, 0644 );

	/**
	 * Replace variables in bare file.
	 */
	$bare_contents = $filesystem->get_contents( $bare_path );
		$bare_contents = str_replace( 'variables.less', "_tmp-variables-$salt.less", $bare_contents );

	/**
	 * Replace variables in theme file.
	 */
	$theme_contents = $filesystem->get_contents( $theme_path );
	$theme_contents = str_replace( 'variables.less', "_tmp-variables-$salt.less", $theme_contents );

	/**
	 * Combine bare and theme files to produce final file.
	 */
	$final_contents = $bare_contents . $theme_contents;
	$filesystem->delete( $tmp_final_path );
	$filesystem->put_contents( $tmp_final_path, $final_contents, 0644 );

	/**
	 * Parse final file.
	 */
	$css = bootswatch_parse_less_file( $tmp_final_path );

	/**
	 * Delete temporary files.
	 */
	$filesystem->delete( $tmp_final_path );
	$filesystem->delete( $tmp_variables_path );

	/**
	 * Return CSS code.
	 */
	return $css;
}

/**
 * Get the WP_Filesystem_Direct instance.
 *
 * @return WP_Filesystem_Direct	The instance.
 */
function bootswatch_get_filesystem() {

	static $filesystem = false;

	if ( $filesystem ) {
		return $filesystem;
	}

	require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
	if ( ! defined( 'FS_CHMOD_DIR' ) ) {
		define( 'FS_CHMOD_DIR', false );
	}
	if ( ! defined( 'FS_CHMOD_FILE' ) ) {
		define( 'FS_CHMOD_FILE', false );
	}
	$filesystem = new WP_Filesystem_Direct( 'bootswatch' );

	return $filesystem;
}

/**
 * Recude cache.
 *
 * @param  Int $keep Number of files to keep.
 * @return Boolean   True.
 */
function bootswatch_reduce_cache( $keep ) {

	$filesystem = bootswatch_get_filesystem();
	$cache_dir  = get_template_directory() . '/cache/';
	$files      = $filesystem->dirlist( $cache_dir );

	/**
	 * Cache directory not found.
	 */
	if ( ! $files ) {
		return;
	}

	if ( count( $files ) > $keep ) {
		shuffle( $files );
		$counter_0 = 0;
		/**
		 * Delete 10 files per batch.
		 */
		while ( $counter_0++ < 10 ) {
			$filesystem->delete( $cache_dir . '/' . $files[ $counter_0 ]['name'] );
		}
	}
	return true;
}

/**
 * Saves file to cache.
 *
 * @param  String $basename Basename.
 * @param  String $contents Content.
 */
function bootswatch_cache_file( $basename, $contents ) {
	$filesystem = bootswatch_get_filesystem();
	$cache_dir  = get_template_directory() . '/cache/';

	/**
	 * Make sure the cache folder exists.
	 */
	$filesystem->mkdir( $cache_dir, 0755 );

	/**
	 * Save file
	 */
	$filesystem->delete( $cache_dir . $basename );
	$filesystem->put_contents( $cache_dir . $basename, $contents, 0644 );
}

/**
 * Check if cache exists for file.
 *
 * @param  String $basename Basename.
 * @return Boolean          True if the file exists, false otherwise.
 */
function bootswatch_cache_file_exists( $basename ) {
	$cache_dir  = get_template_directory() . '/cache/';
	return file_exists( $cache_dir . $basename );
}

/**
 * Get bootswatch-light assets directory.
 *
 * @return String The directory path.
 */
function bootswatch_light_directory() {
	return get_template_directory() . '/vendor/kadimi/bootswatch-light/light/';
}
