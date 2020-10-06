<?php
/**
 * Bootswatch scripts.
 *
 * @package Bootswatch
 */

/**
 * Enqueue scripts and styles.
 */
add_action(
	'wp_enqueue_scripts',
	function() {

		/**
		 * Current Bootswatch theme with fallback to Bootstrap
		 */
		$theme = bootswatch_get_option( 'theme', 'bootstrap' );

		/**
		 * Bootswatch or bootstrap theme.
		 */
		$variables  = apply_filters( 'bootswatch_variables_overrides', bootswatch_get_default_overrides(), $theme );
		$theme_path = bootswatch_make_theme_file( $theme, $variables );
		$theme_url  = content_url( substr( $theme_path, strlen( WP_CONTENT_DIR ) ) );
		wp_enqueue_style( 'bootswatch', $theme_url, array(), bootswatch_version() );

		/**
		 * Style.css.
		 */
		wp_enqueue_style( 'bootswatch-style', get_template_directory_uri() . '/style.css', array(), bootswatch_version() );

		/**
		 * Scripts.
		 */
		wp_enqueue_script( 'bootswatch-bootstrap', bootswatch_get_bootstrap_part_uri( 'script' ), array( 'jquery' ), bootswatch_version(), true );

		/**
		 * Comment reply script.
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	} 
);
