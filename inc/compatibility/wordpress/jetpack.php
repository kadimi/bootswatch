<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Bootswatch
 */

if ( class_exists( 'Jetpack' ) ) {

	/**
	 * Add theme support for Infinite Scroll.
	 */
	add_action( 'after_setup_theme', function() {

		add_theme_support( 'infinite-scroll', [
			'container' => 'primary',
			'footer'    => false,
			'render'    => function () {
				while ( have_posts() ) {
					the_post();
					bootswatch_get_template_part( 'template-parts/content', get_post_format() );
				}
			},
		] );
	} );

	/**
	 * Hide main pagination if using infinite scroll
	 */
	add_filter( 'bootswatch_show_posts_navigation', function( $show ) {
		$using_infinite_scroll = in_array( 'infinite-scroll', get_option( 'jetpack_active_modules', [] ) );
		return $using_infinite_scroll ? false : $show;
	} );
}
