<?php
/**
 * Bootswatch depedencies manager.
 *
 * @package Bootswatch
 */

require_once get_template_directory() . '/vendor/TGM-Plugin-Activation/class-tgm-plugin-activation.php';

/**
 * We require this plugin:
 * - Titan Framework
 */
function bootswatch_setup_dependencies () {
	tgmpa( array(
		array(
			'name' => 'Titan Framework',
			'slug' => 'titan-framework',
			'required' => true,
		),
	), array() );
}
add_action( 'tgmpa_register', 'bootswatch_setup_dependencies' );
