<?php
/**
 * Content.
 *
 * @package Bootswatch
 */

while ( have_posts() ) {
	the_post();

	if ( is_single() ) {
		get_template_part( 'template-parts/content', 'single' );
	} else if ( is_page() ) {
		get_template_part( 'template-parts/content', 'page' );
	} else if ( is_search() ) {
		get_template_part( 'template-parts/content', 'search' );
	} else {
		get_template_part( 'template-parts/content' );
	}

	if ( is_single() ) {
		bootswatch_post_navigation();
	}

	if ( is_single() || is_page() ) {
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}
}
