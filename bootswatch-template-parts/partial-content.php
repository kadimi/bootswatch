<?php
/**
 * Content.
 *
 * @package Bootswatch
 */

while ( have_posts() ) {
	the_post();

	bootswatch_get_template_part( 'template-parts/content' );

	if ( is_singular( [ 'post' ] ) ) {
		bootswatch_post_navigation();
	}

	if ( is_single() || is_page() ) {
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}
}
