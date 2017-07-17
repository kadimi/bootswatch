<?php
/**
 * Bootswatch menus enhancements.
 *
 * @package Bootswatch
 */

/**
 * Adds relevant classes to menu items.
 *
 * - Adds active class to active menu item.
 * - Adds dropdown class to first level primary menu elements with children.
 *
 * @link https://developer.wordpress.org/reference/hooks/nav_menu_css_class/
 *
 * @param  Array  $classes See link.
 * @param  Object $item    See link.
 * @param  Array  $args    See link.
 * @param  Int    $depth   See link.
 * @return Array           See link.
 */
function bootswatch_nav_menu_css_class( $classes, $item, $args, $depth ) {

	// Add active class to active menu item.
	if ( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'active';
	}

	// Add dropdown class to first level primary menu elements with children.
	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if ( in_array( 'menu-item-has-children', $item->classes ) ) {
			$classes[] = 'dropdown';
		}
	}
	return $classes;
}
add_filter( 'nav_menu_css_class' , 'bootswatch_nav_menu_css_class' , 10 , 4 );

/**
 * Adds relevant classes to menu items.
 *
 * - Adds data-toggle="dropdown" to first level primary menu elements with children.
 * - Add "dropdown-toggle" class to first level primary menu elements with children.
 *
 * @link https://developer.wordpress.org/reference/hooks/nav_menu_link_attributes/
 *
 * @param  Array  $atts  See link.
 * @param  Object $item  See link.
 * @param  Array  $args  See link.
 * @param  Int    $depth See link.
 * @return Array         See link.
 */
function bootswatch_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if ( in_array( 'menu-item-has-children', $item->classes ) ) {

			// Add data-toggle="dropdown" to first level primary menu elements with children.
			$atts['data-toggle'] = 'dropdown';

			// Add "dropdown-toggle" class to first level primary menu elements with children.
			$classes         = isset( $atts['classes'] ) ? explode( ' ', $atts['classes'] ) : [];
			$classes[]       = 'dropdown-toggle';
			$atts['classes'] = implode( ' ', $classes );
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'bootswatch_nav_menu_link_attributes', 10, 4 );
