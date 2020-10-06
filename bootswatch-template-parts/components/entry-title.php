<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

/**
 * Prepare classes.
 */
$classes = array( 'entry-title' );

if ( is_singular() ) {
	the_title(
		sprintf(
			'<h1 class="%s">',
			implode( ' ', $classes )
		),
		'</h1>' 
	);
} else {
	the_title(
		sprintf(
			'<h2 class="%1$s"><a href="%2$s" rel="bookmark">',
			implode( ' ', $classes ),
			esc_url( get_permalink() )
		),
		'</a></h2>' 
	);
}
