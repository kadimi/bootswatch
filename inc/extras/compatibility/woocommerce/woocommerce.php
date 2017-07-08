<?php
/**
 * Bootswatch WooCommerce/Sensei compatibility.
 *
 * @package Bootswatch
 */

if ( function_exists( 'WC' ) ) :

	add_action( 'after_setup_theme', function () {
		add_theme_support( 'woocommerce' );
	} );

	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

	add_action( 'woocommerce_before_main_content', 'bootswatch_content_wrapper' );
	add_action( 'woocommerce_after_main_content', 'bootswatch_content_wrapper_end' );

endif;
