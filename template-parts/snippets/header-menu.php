<?php
/**
 * The primary menu.
 *
 * @package Bootswatch
 */

if ( ! function_exists( 'bootswatch_header_menu_title_cb' ) ) {
	/**
	 * Adds caret to top level element with children in the primary menu location.
	 *
	 * @param  string   $title The menu item's title.
	 * @param  WP_Post  $item  The current menu item.
	 * @param  stdClass $args  An object of wp_nav_menu() arguments.
	 * @param  int      $depth Depth of menu item. Used for padding.
	 * @return String   The filtered menu item title.
	 */
	function bootswatch_header_menu_title_cb( $title, $item, $args, $depth ) {
		return 0 === $depth && in_array( 'menu-item-has-children', $item->classes )
			? $title . ' <span class="caret"></span>'
			: $title
		;
	}
}

/**
 * Hook callback.
 */
add_filter( 'nav_menu_item_title', 'bootswatch_header_menu_title_cb', 10, 4 );

/**
 * Display primary menu.
 */
wp_nav_menu( array(
	'theme_location' => 'primary',
	'container' => false,
	'menu_class' => 'nav navbar-nav' . ( ! bootswatch_has( 'search_form_in_header' ) ? ' navbar-right' : '' ),
	'walker' => new Bootswatch_Nav_Walker,
	'fallback_cb' => false,
	'depth' => 2,
) );

/**
 * Hook callback so it doesn't run for other elements in the page.
 */
remove_filter( 'nav_menu_item_title', 'bootswatch_header_menu_title_cb' );
