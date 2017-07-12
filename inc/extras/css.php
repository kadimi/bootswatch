<?php
/**
 * Bootswatch CSS.
 *
 * @package Bootswatch
 */

/**
 * Add body class `fixed-navbar` if navbar is fixed.
 */
add_action( 'body_class', function( $body_classes ) {
	if ( bootswatch_has( 'fixed_navbar' ) ) {
		return array_merge( $body_classes, [ 'fixed-navbar' ] );
	}
	return $body_classes;
} );

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
	 * The styles.
	 */
	$less .= '

		// Use fixed position for admin bar if navbar position is fixed.
		body.fixed-navbar #wpadminbar {
			position: fixed;
		}

		// Fix overlapping with Bootstrap fixed navbar.
		body.fixed-navbar {
			padding-top: (@navbar-height + @navbar-margin-bottom);
		}

		// Fix overlapping with WordPress admin bar.
		body.admin-bar .navbar-fixed-top{
			top: 32px;
			@media screen and (max-width:782px) {
				top: 46px;
			}
		}

		// Custom header defaults.
		.custom-header {

			overflow: hidden;
			padding-left: 0;
			padding-right: 0;

			position: relative;
			top: -@navbar-margin-bottom;

			height: calc(~"100vh -" @navbar-height);
			width: 100%;
			iframe,
			img {
				object-fit: cover;
				height: 100vh;
				width: 100%;
			}
		}

		// Custom header when #wpadminbar is visible.
		body.admin-bar .custom-header {
			height: calc(~"100vh - 32px" - @navbar-height);
			iframe,
			img {
				height: calc(~"100vh - 32px" );
			}
			@media screen and (max-width:782px) {
				height: calc(~"100vh - 46px" - @navbar-height);
				iframe,
				img {
					height: calc(~"100vh - 46px");
				}
			}
		}
	';

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
