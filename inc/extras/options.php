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
], 'bootswatch', function() {
	?>
	<script>
		jQuery( document ).ready( function( $ ) {
			wp.customize( 'bootswatch[theme]', function( value ) {
				value.bind( function( newval ) {

					$('link[id^=bootswatch]').remove();

					var theme_uri_format = "<?php echo bootswatch_get_theme_uri( '{{theme}}' );?>"
					var theme_uri        = theme_uri_format.replace('{{theme}}', newval);

					$('body').append( `<link rel='stylesheet' id='bootswatch-preview-css'  href='${theme_uri}' type='text/css' media='all' />` );

				} );
			} );
		} );
	</script>
	<?
} );

/**
 * Add fixed navbar option.
 */
bootswatch_create_select( 'fixed_navbar', __( 'Fixed Navigation Bar', 'bootswatch' ), 'noyes', 'bootswatch', function() {
	?>
	<script>
		jQuery( document ).ready( function( $ ) {
			wp.customize( 'bootswatch[fixed_navbar]', function( value ) {
				value.bind( function( newval ) {
					$navbar = $( 'header nav');
					if ( 'yes' === newval ) {
						$( 'body' ).addClass( 'fixed-navbar' );
						$navbar.addClass( 'navbar-fixed-top' );
						$navbar.removeClass( 'navbar-satitc-top' );
					} else {
						$( 'body' ).removeClass( 'fixed-navbar' );
						$navbar.addClass( 'navbar-static-top' );
						$navbar.removeClass( 'navbar-fixed-top' );
					}
				} );
			} );
		} );
	</script>
	<?
} );

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
function bootswatch_create_select( $id, $label, $choices = 'noyes', $section = 'bootswatch', $preview_cb = false ) {

	add_action( 'customize_register', function( $wp_customize ) use ( $id, $label, $choices, $section, $preview_cb ) {
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
			'transport' => $preview_cb ? 'postMessage' : 'refresh',
		] );
		if ( $preview_cb ) {
			add_action( 'wp_footer', $preview_cb );
		}
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

function bootswatch_get_theme_uri( $theme ) {
	return get_template_directory_uri() . '/vendor/thomaspark/bootswatch/' . $theme . '/bootstrap.min.css';
}
