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
 * Requires plugins with TGMPA:
 */
function bootswatch_setup_dependencies() {
    /**
     * Example
     *
	tgmpa( array(
		array(
			'name' => 'Titan Framework',
			'slug' => 'titan-framework',
			'required' => true,
		),
	), array() );
     */
}
add_action( 'tgmpa_register', 'bootswatch_setup_dependencies' );
