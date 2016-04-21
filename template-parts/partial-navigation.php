<?php
/**
 * Navigation.
 *
 * @package Bootswatch
 */

if ( is_home() || is_archive() || is_search() ) {
	the_posts_navigation();
}
