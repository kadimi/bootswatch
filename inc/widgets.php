<?php
/**
 * Bootswatch widgets.
 *
 * @package Bootswatch
 */

/**
 * Register widget area.
 */
function bootswatch_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'bootswatch' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget card %2$s p-3 my-3">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle card-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'bootswatch_widgets_init' );
