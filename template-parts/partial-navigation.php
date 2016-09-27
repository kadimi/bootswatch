<?php
/**
 * Navigation.
 *
 * @package Bootswatch
 */

if ( is_home() || is_archive() || is_search() ) {
	bootswatch_posts_navigation();
}
