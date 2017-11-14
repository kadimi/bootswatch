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
		'before_widget' => '<aside id="%1$s" class="widget well clearfix %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer', 'bootswatch' ),
		'id' => 'footer',
		'before_widget' => '<aside id="%1$s" class="widget col-md-3 clearfix %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'bootswatch_widgets_init' );
