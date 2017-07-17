<?php
/**
 * Bootswatch WooCommerce/Sensei compatibility.
 *
 * @package Bootswatch
 */

if ( function_exists( 'Sensei' ) ) :

	add_action( 'after_setup_theme', function () {
		add_theme_support( 'sensei' );
	} );

	remove_action( 'sensei_before_main_content', [ Sensei()->frontend, 'sensei_output_content_wrapper' ] );
	remove_action( 'sensei_after_main_content', [ Sensei()->frontend, 'sensei_output_content_wrapper_end' ] );

	add_action( 'sensei_before_main_content', 'bootswatch_content_wrapper' );
	add_action( 'sensei_after_main_content', 'bootswatch_content_wrapper_end' );

endif;
