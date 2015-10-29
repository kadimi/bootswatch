<?php

add_filter( 'nav_menu_css_class' , 'bootswatch_nav_menu_css_class' , 10 , 4 );
function bootswatch_nav_menu_css_class( $classes, $item, $args, $depth ){

	// Add active class to active menu item.
	if( in_array('current-menu-item', $classes) ){
		$classes[] = 'active';
	}

	// Add dropdown class to first level primary meny elements with children.
	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if( in_array('menu-item-has-children', $item->classes) ){
			$classes[] = 'dropdown';
		}
	}
	return $classes;
}

add_filter( 'nav_menu_link_attributes', 'bootswatch_nav_menu_link_attributes', 10, 4 );
function bootswatch_nav_menu_link_attributes( $atts, $item, $args, $depth) {

	// Add data-toggle="dropdown" to first level primary meny elements with children.
	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if( in_array('menu-item-has-children', $item->classes) ){
			$atts['data-toggle'] = 'dropdown';
		}
	}

	// Add "dropdown-toggle" class to first level primary meny elements with children.
	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if( in_array('menu-item-has-children', $item->classes) ){
			$classes = isset( $atts[ 'classes' ] )
				? explode( ' ', $atts[ 'classes' ] )
				: array()
			;
			$classes[] = 'dropdown-toggle';
			$atts['classes'] = implode( ' ', $classes );
		}
	}

	return $atts;
}

add_filter( 'walker_nav_menu_start_el', 'bootswatch_nav_menu_start_el', 10, 4 );
function bootswatch_nav_menu_start_el( $item_output, $item, $depth, $args) {
	return $item_output;
}

add_filter( 'nav_menu_item_title', 'bootswatch_nav_menu_item_title', 10, 4 );
function bootswatch_nav_menu_item_title( $title, $item, $args, $depth ) {
	// Add caret to first level primary meny elements with children.
	if ( 'primary' === $args->theme_location && 0 == $depth ) {
		if( in_array('menu-item-has-children', $item->classes) ){
			$title .= ' <b class="caret"></b>';
		}
	}

	return $title;
}

/**
 * Bootswatch menu walker class
 */
class Bootswatch_Nav_Walker extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'primary' === $args->theme_location ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
		}
	}
}

