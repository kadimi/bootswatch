<?php
/**
 * Bootswatch CSS.
 *
 * @package Bootswatch
 */

/**
 * Add inline CSS in header.
 */
add_action( 'wp_head', function() {

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
	if ( has_custom_header() ) {
		$less .= '
			.custom-header {
				overflow: hidden;
				height: calc(~"100vh -" @navbar-height);
				body.adminbar & {
					height: calc(~"100vh - 32px" - @navbar-height );
					@media screen and (max-width:782px) {
						height: calc(~"100vh - 46px" - @navbar-height );
					}
				}
				width: 100%;
				padding-left: 0;
				padding-right: 0;
				position: relative;
				top: -@navbar-margin-bottom;
				img {
					object-fit: cover;
					height: 95vh;
					width: 100%;
				}
				@media screen and (min-width: 48em) {
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
} );
