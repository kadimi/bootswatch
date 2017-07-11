<?php
/**
 * Navigation.
 *
 * @package Bootswatch
 */

if ( is_home() || is_archive() || is_search() ) {
	if ( apply_filters( 'bootswatch_show_posts_navigation', true ) ) {
		bootswatch_posts_navigation();
	}
}
