<?php
/**
 * Calendar classes.
 *
 * @package Bootswatch
 */

add_action( 'get_calendar', function( $output ) {
	return str_replace( '<table id="wp-calendar">', '<table id="wp-calendar" class="table table-striped table-bordered">', $output );
} );
