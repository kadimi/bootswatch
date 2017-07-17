<?php
/**
 * Custom nav walker.
 *
 * @package Bootswatch
 */

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
			$indent  = str_repeat( "\t", $depth );
			$output .= sprintf( '%2$s<ul class="dropdown-menu">%3$s', "\n", $indent, "\n" );
		}
	}
}
