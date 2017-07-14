<?php
/**
 * Bootswatch Options (with Titan Framework).
 *
 * @package Bootswatch
 */

/**
 * Registers options with the Theme Customizer
 *
 * @param      object    $wp_customize    The WordPress Theme Customizer
 * @package    tcx
 * @since      0.2.0
 * @version    1.0.0
 */


function tcx_register_theme_customizer( $wp_customize ) {

	$wp_customize->add_section(
		'bootswatch',
		array(
			'title'     => 'Bootswatch',
			'priority'  => 0
		)
	);
	$wp_customize->add_setting(
		'bootswatch[theme]',
		array(
			'transport'   	    => 'postMessage'
		)
	);
		$wp_customize->add_control(
		'bootswatch[theme]',
		array(
		    'label'      => 'Theme',
		    'section'    => 'bootswatch',
		)
	);
} // end tcx_register_theme_customizer
add_action( 'customize_register', 'tcx_register_theme_customizer' );
/**
 * Sanitizes the incoming input and returns it prior to serialization.
 *
 * @param      string    $input    The string to sanitize
 * @return     string              The sanitized string
 * @package    tcx
 * @since      0.5.0
 * @version    1.0.2
 */
function tcx_sanitize_input( $input ) {
	return strip_tags( stripslashes( $input ) );
} // end tcx_sanitize_input

/**
 * Registers the Theme Customizer Preview with WordPress.
 *
 * @package    tcx
 * @since      0.3.0
 * @version    1.0.0
 */
function tcx_customizer_live_preview() {
	wp_enqueue_script(
		'tcx-theme-customizer',
		get_template_directory_uri() . '/js/theme-customizer.js',
		array( 'customize-preview' ),
		'1.0.0',
		true
	);
} // end tcx_customizer_live_preview
add_action( 'customize_preview_init', 'tcx_customizer_live_preview' );


add_filter( 'theme_mod_bootswatch', function( $mod ) {
	$mod['theme'] = 'united';
	$mod['fixed_navbar'] = 'yes';
	return $mod;
} );