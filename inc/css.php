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
	echo '<style>' . bootswatch_generate_inline_css( bootswatch_get_option( 'theme', 'bootstrap' ) ) . '</style>'; // WPCS: xss ok.
} );

/**
 * Generates inline CSS that corrects display, see comments with LESS code.
 *
 * If `$theme` is empty, the function will use bootstrap.
 *
 * @param  String $theme The bootswatch theme.
 * @return String        The CSS code.
 */
function bootswatch_generate_inline_css( $theme = 'bootstrap' ) {

	if ( ! class_exists( 'Less_Parser' ) ) {
		return bootswatch_bootstrap_inline_css();
	}

	/**
	 * Prepare replaceemts.
	 */
	$options = get_theme_mod( 'bootswatch' );
	$replacements = [
		'{{custom_header_percentage_size}}' => '100vh',
	];
	if ( isset( $options['custom_header_percentage_size'] ) ) {
		$size = intval( $options['custom_header_percentage_size'] );
		if ( $size > 0 ) {
			$replacements['{{custom_header_percentage_size}}'] = $size . 'vh';
		}
	}

	/**
	 * Prepare LESS parser.
	 */
	switch ( $theme ) {
	case 'bootstrap':
			$variables_path = bootswatch_get_bootstrap_part_path( 'variables' );
		break;
	default:
			$variables_path = bootswatch_get_theme_part_path( $theme, 'variables' );
		break;
	}

	$less_parser = new Less_Parser( [
		'compress' => true,
	] );
	$less_parser->parseFile( $variables_path );
	/**
	 * The styles.
	 */
	$less = '

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

			width: 100%;
			iframe,
			img,
			video {
				object-fit: cover;
				width: 100%;
			}
			&,
			iframe,
			img,
			video {
				height: calc(~"{{custom_header_percentage_size}} -" @navbar-height);
			}
		}

		// Custom header when #wpadminbar is visible.
		body.admin-bar .custom-header {
			&,
			iframe,
			img,
			video {
				height: calc(~"{{custom_header_percentage_size}} - 32px" - @navbar-height);
			}
			@media screen and (max-width:782px) {
				&,
				iframe,
				img,
				video {
						height: calc(~"{{custom_header_percentage_size}} - 46px" - @navbar-height);
				}
			}
		}

		// Fix screen reader text (14px).
		.screen-reader-text:focus {
			font-size: 1.4rem;
		}
	';

	/**
	 * Apply replacements.
	 */
	$less = str_replace( array_keys( $replacements ), array_values( $replacements ), $less );

	/**
	 * Parse Less and return CSS.
	 */
	return $less_parser->parse( $less )->getCss();
}

/**
 * Return Bootstrap inline CSS code.
 *
 * This CSS code can be obtained by running `var_dump(bootswatch_generate_inline_css()`.
 *
 * @return String CSS code.
 */
function bootswatch_bootstrap_inline_css() {
	$css = '
		body.fixed-navbar #wpadminbar {
			position: fixed;
		}
		body.fixed-navbar {
			padding-top: 70px;
		}
		body.admin-bar .navbar-fixed-top {
			top: 32px;
		}
		@media screen and (max-width: 782px) {
			body.admin-bar .navbar-fixed-top {
				top: 46px;
			}
		}
		.custom-header {
			overflow: hidden;
			padding-left: 0;
			padding-right: 0;
			position: relative;
			top: -20px;
			width: 100%;
		}
		.custom-header iframe,
		.custom-header img,
		.custom-header video {
			object-fit: cover;
			width: 100%;
		}
		.custom-header,
		.custom-header iframe,
		.custom-header img,
		.custom-header video {
			height: calc(100vh - 50px);
		}
		body.admin-bar .custom-header,
		body.admin-bar .custom-header iframe,
		body.admin-bar .custom-header img,
		body.admin-bar .custom-header video {
			height: calc(100vh - 32px - 50px);
		}
		@media screen and (max-width: 782px) {
			body.admin-bar .custom-header,
			body.admin-bar .custom-header iframe,
			body.admin-bar .custom-header img,
			body.admin-bar .custom-header video {
				height: calc(100vh - 46px - 50px);
			}
		}
		.screen-reader-text:focus {
			font-size: 1.4rem;
		}
	';
	return $css;
}
