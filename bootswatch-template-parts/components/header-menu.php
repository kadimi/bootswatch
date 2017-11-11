<?php
/**
 * The primary menu.
 *
 * @package Bootswatch
 */

/**
 * Add caret to top level element with children in the primary menu location.
 */
add_filter( 'nav_menu_item_title', function( $title, $item, $args, $depth ) {
	if ( 'primary' === $args->theme_location && ! $depth && in_array( 'menu-item-has-children', $item->classes ) ) {
		$title .= ' <span class="caret"></span>';
	}
	return $title;
}, 10, 4 );

/**
 * Add `nav-item` class to `<li>`.
 */
add_filter( 'nav_menu_css_class', function( $classes, $item, $args, $depth ) {
	if ( 'primary' === $args->theme_location ) {
		$classes[] = 'nav-item';
	}
	return $classes;
}, 10, 4 );

/**
 * Add `nav-link` class to `<a>`.
 */
add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args, $depth ) {
	if ( 'primary' === $args->theme_location ) {
		$atts['class'] = 'nav-link';
	}
	return $atts;
}, 10, 4 );

/**
 * Display primary menu.
 */
wp_nav_menu( array(
	'theme_location' => 'primary',
	'container' => false,
	'menu_class' => 'navbar-nav mr-auto' . ( ! bootswatch_has( 'search_form_in_header' ) ? ' navbar-right' : '' ),
	'walker' => new Bootswatch_Nav_Walker,
	'fallback_cb' => false,
	'depth' => 2,
) );
