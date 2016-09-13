<?php
/**
 * Bootswatch classes.
 *
 * @package Bootswatch
 */

/**
 * Return classes to be used for the primary container.
 * @return Array The classes.
 */
function bootswatch_primary_classes() {
	$classes = arrary();
	$classes[] = is_active_sidebar( 'sidebar' )
		? 'col-md-8'
		: 'col-md-12'
	;

	$classes = array_unique( apply_filters( 'bootswatch_primary_classes', $classes ) );
	return $classes;
}
