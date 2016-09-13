<?php
/**
 * Bootswatch hooks.
 *
 * @package Bootswatch
 */

/**
 * Hooks defined so far.
 */
$hooks = array(
	'after_nav',
);


foreach ( $hooks as $hook ) {
	add_action( 'bootswatch_' . $hook, 'bootswatch_hook_callback' );
}

/**
 * [bootswatch_hook_callback description]
 */
function bootswatch_hook_callback() {
	$hook = preg_replace( '/^bootswatch_/', '', current_filter() );
	$content = TitanFramework::getInstance( 'bootswatch' )->getOption( $hook );
	echo apply_filters( 'the_content', $content );
}
