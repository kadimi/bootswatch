<?php
/**
 * Bootswatch CSS.
 *
 * @package Bootswatch
 */

/**
 * Adds inline CSS in header.
 */
function bootswatch_css() {

	$css = '';

	/**
	 * Fix overlapping with WordPress admin bar.
	 */
	$css .= 'body.admin-bar .navbar-fixed-top{ top: 32px; }';

	/**
	 * Fix overlapping with Bootstrap's fixed navbar.
	 */
	if ( bootswatch_has( 'fixed_navbar' ) ) {

		$variables_path = bootswatch_get_option( 'theme' )
			? get_template_directory() . '/vendor/thomaspark/bootswatch/' . bootswatch_get_option( 'theme' ) . '/variables.less'
			: get_template_directory() . '/vendor/thomaspark/bootswatch/bower_components/bootstrap/less/variables.less'
		;

		$less_parser = new Less_Parser();
		$less_parser->parseFile( $variables_path, home_url() );
		$less_parser->parse( 'body { padding-top: (@navbar-height + @navbar-margin-bottom); }' );
		$css .= $less_parser->getCss();

	}
	printf( '<style>%s</style>', $css ); // WPCS: xss ok.
}

add_action( 'wp_head', 'bootswatch_css' );
