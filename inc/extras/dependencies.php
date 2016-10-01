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
 * Requires this plugin with TGMPA:
 * - Titan Framework
 */
function bootswatch_setup_dependencies() {
	tgmpa( array(
		array(
			'name' => 'Titan Framework',
			'slug' => 'titan-framework',
			'required' => true,
		),
	), array() );
}
add_action( 'tgmpa_register', 'bootswatch_setup_dependencies' );
