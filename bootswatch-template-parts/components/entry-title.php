<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

/**
 * Prepare classes.
 */
$bootswatch_classes = array( 'entry-title' );

if ( is_singular() ) {
	the_title(
		sprintf(
			'<h1 class="%s">',
			implode( ' ', $bootswatch_classes )
		),
		'</h1>' 
	);
} else {
	the_title(
		sprintf(
			'<h2 class="%1$s"><a href="%2$s" rel="bookmark">',
			implode( ' ', $bootswatch_classes ),
			esc_url( get_permalink() )
		),
		'</a></h2>' 
	);
}
