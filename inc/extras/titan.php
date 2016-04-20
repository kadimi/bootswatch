<?php
/**
 * Bootswatch Options (with Titan Framework).
 *
 * @package Bootswatch
 */

/**
 * Register Bootswatch theme options.
 */
function bootswatch_create_options() {
	$titan = TitanFramework::getInstance( 'bootswatch' );

	$section = $titan->createThemeCustomizerSection( array(
		'name' => __( 'Theme Options', 'bootswatch' ),
		'panel' => __( 'Bootswatch', 'bootswatch' ),
	) );

	$section->createOption( array(
		'name' => __( 'Theme', 'bootswatch' ),
		'id' => 'theme',
		'type' => 'select',
		'default' => 'cerulean',
		'options' => array(
			'' => 'Just Bootstrap',
			'cerulean' => 'Cerulean',
			'cosmo' => 'Cosmo',
			'cyborg' => 'Cyborg',
			'darkly' => 'Darkly',
			'flatly' => 'Flatly',
			'journal' => 'Journal',
			'lumen' => 'Lumen',
			'paper' => 'Paper',
			'readable' => 'Readable',
			'sandstone' => 'Sandstone',
			'simplex' => 'Simplex',
			'slate' => 'Slate',
			'spacelab' => 'Spacelab',
			'superhero' => 'Superhero',
			'united' => 'United',
			'yeti' => 'Yeti',
		),
	) );

	$section->createOption( array(
		'name' => __( 'Fixed Navbar', 'bootswatch' ),
		'id' => 'fixed_navbar',
		'type' => 'select',
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes' ),
			'no' => __( 'No' ),
		),
	) );
}
add_action( 'tf_create_options', 'bootswatch_create_options' );

/**
 * Gets an option.
 *
 * @param  string $option_id The option id.
 * @return miwed             The option value.
 */
function bootswatch_get_option( $option_id ) {
	return TitanFramework::getInstance( 'bootswatch' )->getOption( $option_id );
}

/**
 * Checks if an option is being used.
 *
 * @param  [string] $option_id The Option id.
 * @return [boolean]           Weither or not that option is being used
 */
function bootswatch_use( $option_id ) {
	return 'yes' === bootswatch_get_option( $option_id );
}
