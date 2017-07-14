<?php
/**
 * Bootswatch Options (with Titan Framework).
 *
 * @package Bootswatch
 */

/**
 * Add main section.
 */
add_action( 'customize_register', function( $wp_customize ) {
	$wp_customize->add_section( 'bootswatch', [
			'title'     => 'Bootswatch',
			'priority'  => 0,
	] );
} );

/**
 * Add theme option.
 */
bootswatch_create_select( 'theme', __( 'Theme', 'bootswatch' ), [
	''          => __( 'Just Bootstrap', 'bootswatch' ),
	'cerulean'  => 'Cerulean',
	'cosmo'     => 'Cosmo',
	'cyborg'    => 'Cyborg',
	'darkly'    => 'Darkly',
	'flatly'    => 'Flatly',
	'journal'   => 'Journal',
	'lumen'     => 'Lumen',
	'paper'     => 'Paper',
	'readable'  => 'Readable',
	'sandstone' => 'Sandstone',
	'simplex'   => 'Simplex',
	'slate'     => 'Slate',
	'spacelab'  => 'Spacelab',
	'superhero' => 'Superhero',
	'united'    => 'United',
	'yeti'      => 'Yeti',
] );

/**
 * Add fixed navbar option.
 */
bootswatch_create_select( 'fixed_navbar', __( 'Fixed Navigation Bar', 'bootswatch' ) );

/**
 * Add header search form option.
 */
bootswatch_create_select( 'search_form_in_header', __( 'Search Form in Header', 'bootswatch' ) );

/**
 * Registers a new option which is a dropdown.
 *
 * @param  String       $id      ID.
 * @param  String       $label   Label.
 * @param  String|Array $choices Choices array, accepts also `noyes` and 'yesno'.
 * @param  String       $section Section ID.
 */
function bootswatch_create_select( $id, $label, $choices = 'noyes', $section = 'bootswatch' ) {

	add_action( 'customize_register', function( $wp_customize ) use ( $id, $label, $choices, $section ) {
		switch ( $choices ) {
		case 'noyes':
				$choices = [
					'no' => __( 'No', 'bootswatch' ),
					'yes' => __( 'Yes', 'bootswatch' ),
				];
			break;
		case 'yesno':
				$choices = [
					'yes' => __( 'Yes', 'bootswatch' ),
					'no' => __( 'No', 'bootswatch' ),
				];
			break;
		default:
			break;
		}

		$id = sprintf( 'bootswatch[%s]', $id );
		$wp_customize->add_setting( $id, [
			'sanitize_callback' => function( $value ) {
				return  ( preg_match( '/^[a-z]+$/', $value ) )
					? $value
					: ''
				;
			},
		] );
		$wp_customize->add_control(
			new WP_Customize_Control( $wp_customize, $id, [
				'settings' => $id,
				'label'    => $label,
				'type'     => 'select',
				'choices'  => $choices,
				'section'  => $section,
			] )
		);
	} );
}

/**
 * Gets an option.
 *
 * @param  string $option_id The option id.
 * @return mixed             The option value.
 */
function bootswatch_get_option( $option_id ) {
	if ( class_exists( 'TitanFramework' ) ) {
		return TitanFramework::getInstance( 'bootswatch' )->getOption( $option_id );
	} else {
		$mods = get_theme_mod( 'bootswatch', [] );
		return array_key_exists( $option_id, $mods )
			? $mods[ $option_id ]
			: false
		;
	}
}

/**
 * Checks if an option is being used.
 *
 * @param  string $option_id The Option id.
 * @return boolean           Weither or not that option is being used
 */
function bootswatch_has( $option_id ) {
	switch ( $option_id ) {
	default:
		return 'yes' === bootswatch_get_option( $option_id );
		break;
	}
}
