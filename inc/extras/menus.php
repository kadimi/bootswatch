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

	// Add data-toggle="dropdown" to first level primary menu elements with children.
	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if ( in_array( 'menu-item-has-children', $item->classes ) ) {
			$atts['data-toggle'] = 'dropdown';
		}
	}

	// Add "dropdown-toggle" class to first level primary menu elements with children.
	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if ( in_array( 'menu-item-has-children', $item->classes ) ) {
			$classes = isset( $atts['classes'] )
				? explode( ' ', $atts['classes'] )
				: array()
			;
			$classes[] = 'dropdown-toggle';
			$atts['classes'] = implode( ' ', $classes );
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'bootswatch_nav_menu_link_attributes', 10, 4 );

/**
 * Does nothing... Yet.
 *
 * @link https://developer.wordpress.org/reference/hooks/walker_nav_menu_start_el/
 *
 * @param  string $item_output See link.
 * @param  Object $item        See link.
 * @param  Int    $depth       See link.
 * @param  Array  $args        See link.
 * @return String              See link.
 */
function bootswatch_nav_menu_start_el( $item_output, $item, $depth, $args ) {
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'bootswatch_nav_menu_start_el', 10, 4 );

/**
 * Adds caret to first level primary menu elements with children.
 *
 * @link https://developer.wordpress.org/reference/hooks/nav_menu_item_title/
 *
 * @param  String $title See link.
 * @param  Object $item  See link.
 * @param  Array  $args  See link.
 * @param  Int    $depth See link.
 * @return String        See link.
 */
function bootswatch_nav_menu_item_title( $title, $item, $args, $depth ) {
	// Add caret to first level primary menu elements with children.
	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if ( in_array( 'menu-item-has-children', $item->classes ) ) {
			$title .= ' <b class="caret"></b>';
		}
	}

	return $title;
}
/* add_filter( 'nav_menu_item_title', 'bootswatch_nav_menu_item_title', 10, 4 ); */

/**
 * Bootswatch menu walker class
 *
 * @link https://developer.wordpress.org/reference/classes/walker_nav_menu/
 */
class Bootswatch_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Indent <ul> and add `dropdown-menu` class.
	 *
	 * @param  String $output See link.
	 * @param  Int    $depth  See link.
	 * @param  Array  $args   See link.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'primary' === $args->theme_location ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
		}
	}
}
