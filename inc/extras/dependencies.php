<?php
/**
 * Bootswatch depedencies manager.
 *
 * @package Bootswatch
 */

/**
 * TGMPA.
 */
require_once get_template_directory() . '/vendor/TGM-Plugin-Activation/class-tgm-plugin-activation.php';

/**
 * Less.php.
 */
require_once get_template_directory() . '/vendor/less.php/lib/Less/Autoloader.php';
Less_Autoloader::register();

/**
 * We require this plugin with TGMPA:
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
