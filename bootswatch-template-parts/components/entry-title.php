<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

the_title(
	sprintf( '<%1$s class="entry-title"><a href="%2$s" rel="bookmark">'
		, is_singular() ? 'h1' : 'h2'
		, esc_url( get_permalink() )
	),
	sprintf( '</a></%s>', is_singular() ? 'h1' : 'h2' )
);
