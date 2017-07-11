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

	$less = '';

	/**
	 * Prepare LESS parser.
	 */
	$variables_path = bootswatch_get_option( 'theme' )
		? get_template_directory() . '/vendor/thomaspark/bootswatch/' . bootswatch_get_option( 'theme' ) . '/variables.less'
		: get_template_directory() . '/vendor/thomaspark/bootswatch/bower_components/bootstrap/less/variables.less'
	;
	$less_parser = new Less_Parser();
	$less_parser->parseFile( $variables_path, home_url() );

	/**
	 * Fix overlapping with WordPress admin bar.
	 */
	$less .= '
		body.admin-bar .navbar-fixed-top{
			top: 32px;
			@media screen and (max-width:782px) {
				top: 46px;
			}
		}
	';

	/**
	 * Fix overlapping with Bootstrap's fixed navbar.
	 */
	if ( bootswatch_has( 'fixed_navbar' ) ) {
		$less .= 'body { padding-top: (@navbar-height + @navbar-margin-bottom); }';
	}

	/**
	 * Position header image.
	 */
	if ( bootswatch_has( 'header_image' ) ) {
		$less .= '
			.header_image {
				padding-left: 0;
				padding-right: 0;
				position: relative;
				top: -@navbar-margin-bottom;
				img {
					min-width:100%;
				}
			}
		';
	}

	/**
	 * Parse LESS code.
	 */
	$less_parser->parse( $less );
	$css .= $less_parser->getCss();

	/**
	 * Print to page.
	 */
	printf( '<style>%s</style>', $css ); // WPCS: xss ok.
}

add_action( 'wp_head', 'bootswatch_css' );
