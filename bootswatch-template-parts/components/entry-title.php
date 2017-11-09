<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

the_title(
	sprintf( '<%1$s class="entry-title"><a href="%2$s" rel="bookmark">'
		, is_home() ? 'h2' : 'h1'
		, esc_url( get_permalink() )
	),
	sprintf( '</a></%s>', is_home() ? 'h2' : 'h1' )
);
