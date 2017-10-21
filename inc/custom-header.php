<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package Bootswatch
 */

/**
 * Add body class `has_header_image` if header image exists.
 */
add_action( 'body_class', function( $body_classes ) {
	if ( bootswatch_has( 'header_image' ) ) {
		return array_merge( $body_classes, [ 'has-header-image' ] );
	}
	return $body_classes;
} );

/**
 * Set up the WordPress core custom header feature.
 */
function bootswatch_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'bootswatch_custom_header_args', array(
		'default-image'      => get_parent_theme_file_uri( '/header.jpg' ),
		'header-text'        => false,
		'flex-height'        => true,
		'flex-width'         => true,
		'video'              => true,
		'wp-head-callback'   => function() {

			if ( ! is_customize_preview() ) {
				return;
			}

			?><script>
				var bootswatch_customizer = {
					"is_front_page" : <?php echo is_front_page() ? 'true' : 'false'; // XSS OK. ?>
				};
				jQuery( document ).ready( function( $ ) {
					/**
					 * Hide media placeholder if no media choosen in the customizer.
					 */
					setInterval( function() {
						var $ = jQuery;
						if ( bootswatch_customizer.is_front_page && $( '.wp-custom-header' ).children().not( 'span' ).length ) {
							$( '.custom-header' ).slideDown( 200 );
						} else {
							$( '.custom-header' ).slideUp( 200 );
						}
					}, 2000 );
				} );
			</script><?php
		},
	) ) );
	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/header.jpg',
			'thumbnail_url' => '%s/header.jpg',
			'description'   => __( 'Default Header Image', 'bootswatch' ),
		),
	) );
}
add_action( 'after_setup_theme', 'bootswatch_custom_header_setup' );
