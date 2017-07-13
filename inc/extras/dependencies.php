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
 * Require TGMPA
 */
// require get_template_directory() . '/managed/tgmpa/class-tgm-plugin-activation.php';

/**
 * Requires plugins with TGMPA.
 */
function bootswatch_setup_dependencies() {
	tgmpa( [
		[
			'name' => 'Titan Framework',
			'slug' => 'titan-framework',
		],
		[
			'name' => 'Less PHP Compiter',
			'slug' => 'lessphp',
		],
	] );
}
add_action( 'tgmpa_register', 'bootswatch_setup_dependencies' );
