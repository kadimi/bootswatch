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
bootswatch_create_option_select( 'theme', __( 'Theme', 'bootswatch' ), bootswatch_themes_list(), 'bootswatch', function () {
	?>
	<script>
		jQuery( document ).ready( function( $ ) {
			wp.customize( 'bootswatch[theme]', function( value ) {
				value.bind( function( newval ) {

					$('link[id^=bootswatch]').remove();

					if ( ! newval ) {
						$( '<link/>', {
							rel   : 'stylesheet',
							id    : 'bootswatch-bootstrap',
							href  : '<?php bootswatch_bootstrap_part_uri( 'style' ); ?>',
							type  : 'text/css',
							media : 'all'
						} ).appendTo( $( 'body' ) );
						$( '<link/>', {
							rel   : 'stylesheet',
							id    : 'bootswatch-bootstrap-theme',
							href  : '<?php bootswatch_bootstrap_part_uri( 'theme' ); ?>',
							type  : 'text/css',
							media : 'all'
						} ).appendTo( $( 'body' ) );
					} else {
						$( '<link/>', {
							rel   : 'stylesheet',
							id    : `bootswatch-${newval}-css`,
							href  : '<?php echo bootswatch_get_theme_uri( '{{theme}}' ); // XSS OK. ?>'.replace('{{theme}}', newval),
							type  : 'text/css',
							media : 'all'
						} ).appendTo( $( 'body' ) );
					}
				} );
			} );
		} );
	</script>
	<?php
} );

/**
 * Add fixed navbar option.
 */
bootswatch_create_option_radio( 'fixed_navbar', __( 'Fixed Navigation Bar', 'bootswatch' ), 'noyes', 'bootswatch', function () {
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
	<?php
} );

/**
	* Add header search form option.
	*/
bootswatch_create_option_radio( 'search_form_in_header', __( 'Search Form in Header', 'bootswatch' ), 'noyes', 'bootswatch', function () {
	?>
	<script>
		jQuery( document ).ready( function( $ ) {
			wp.customize( 'bootswatch[search_form_in_header]', function( value ) {
				value.bind( function( newval ) {

					$container = $( '.navbar .navbar-collapse' );
					$menu      = $( '.nav', $container );
					$form_new  = $( '<?php echo str_replace( [ "'", "\n" ], [ "\'", ' ' ], bootswatch_get_search_form( 'navbar-form pull-right' ) ); // XSS OK. ?>' );
					$form_old  = $( '.navbar-form', $container );

					if ( 'yes' === newval ) {
						$form_new.appendTo( $container );
						$menu.removeClass( 'navbar-right' );
					} else {
						$form_old.remove();
						$menu.addClass( 'navbar-right' );
					}
				} );
			} );
		} );
	</script>
	<?php
} );

/**
 * Registers a new option which is a dropdown or a radio.
 *
 * @param  String          $type   `select` or `radio`.
 * @param  String          $id      ID.
 * @param  String          $label   Label.
 * @param  String|Array    $choices Choices array, accepts also `noyes` and 'yesno'.
 * @param  String          $section Section ID.
 * @param  String|Function $preview_cb Function.
 */
function bootswatch_create_option_choice( $type, $id, $label, $choices = 'noyes', $section = 'bootswatch', $preview_cb = false ) {

	if ( ! in_array( $type, [ 'select', 'radio' ] ) ) {
		return;
	}

	add_action( 'customize_register', function( $wp_customize ) use ( $type, $id, $label, $choices, $section, $preview_cb ) {
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
				'type'     => $type,
				'choices'  => $choices,
				'section'  => $section,
			] )
		);
	} );
}

/**
 * Registers a new option which is a dropdown.
 *
 * @param  String          $id      ID.
 * @param  String          $label   Label.
 * @param  String|Array    $choices Choices array, accepts also `noyes` and 'yesno'.
 * @param  String          $section Section ID.
 * @param  String|Function $preview_cb Function.
 */
function bootswatch_create_option_select( $id, $label, $choices = 'noyes', $section = 'bootswatch', $preview_cb = false ) {
	bootswatch_create_option_choice( 'select', $id, $label, $choices, $section, $preview_cb );
}

/**
 * Registers a new option which is a radio.
 *
 * @param  String          $id      ID.
 * @param  String          $label   Label.
 * @param  String|Array    $choices Choices array, accepts also `noyes` and 'yesno'.
 * @param  String          $section Section ID.
 * @param  String|Function $preview_cb Function.
 */
function bootswatch_create_option_radio( $id, $label, $choices = 'noyes', $section = 'bootswatch', $preview_cb = false ) {
	bootswatch_create_option_choice( 'radio', $id, $label, $choices, $section, $preview_cb );
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

/**
 * Return bootswatch theme CSS file URI.
 *
 * @param  String $theme The theme.
 * @return String|Bolean The theme URI or false.
 */
function bootswatch_get_theme_uri( $theme ) {

	if ( ! $theme ) {
		return bootswatch_get_bootstrap_part_uri( 'style' );
	}

	return array_key_exists( $theme, array_merge( bootswatch_themes_list(), [
		'{{theme}}' => '',
	] ) )
		? get_template_directory_uri() . '/vendor/thomaspark/bootswatch/' . $theme . '/bootstrap.min.css'
		: false
	;
}

/**
 * Print Bootstrap Part URI.
 *
 * @param  String $part `style`, `theme` or `script`.
 */
function bootswatch_bootstrap_part_uri( $part ) {
	echo (string) bootswatch_get_bootstrap_part_uri( $part ); // XSS OK.
}

/**
 * Get bootstrap part URI.
 *
 * @param  String $part `style`, `theme` or `script`.
 * @return String|null  The URI.
 */
function bootswatch_get_bootstrap_part_uri( $part ) {

	$d = get_template_directory_uri() . '/vendor/thomaspark/bootswatch/bower_components/bootstrap/dist/';
	switch ( $part ) {
	case 'style':
		return $d . 'css/bootstrap.min.css';
	case 'theme':
		return $d . 'css/bootstrap-theme.min.css';
	case 'script':
		return $d . 'js/bootstrap.min.js';
	}
}

/**
 * Returns a list of available themes.
 *
 * @return Array The list.
 */
function bootswatch_themes_list() {
	return [
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
	];
}
