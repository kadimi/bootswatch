<?php
/**
 * The index.
 *
 * @package Bootswatch
 */

do_action( 'bootswatch_init' );
if ( function_exists( 'bootswatch_get_template_part' ) ) {
	bootswatch_get_template_part( 'template-parts/index' );
} else {
	wp_die(
		// Translators: %1$s is the required PHP version, %2$s in the one available.
		esc_html( sprintf( __( 'Bootswatch requires PHP %1$s or newer, you are using PHP %2$s.', 'bootswatch' ), BOOTSWATCH_MINIMAL_PHP_VERSION, phpversion() ) ),
		null,
		array(
			'back_link' => true,
		) 
	);
}
do_action( 'bootswatch_shutdown' );
