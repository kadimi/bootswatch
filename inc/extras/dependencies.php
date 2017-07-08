<?php
/**
 * Bootswatch depedencies manager.
 *
 * @package Bootswatch
 */

/**
 * Require composer stuff.
 */
require get_template_directory() . '/vendor/autoload.php';

/**
 * Requires plugins with TGMPA.
 *
 * Example:
 *
 * tgmpa( array(
 * 	array(
 * 		'name' => 'Titan Framework',
 * 		'slug' => 'titan-framework',
 * 		'required' => true,
 * 	),
 * ), array() );
 */
function bootswatch_setup_dependencies() {
}
add_action( 'tgmpa_register', 'bootswatch_setup_dependencies' );
