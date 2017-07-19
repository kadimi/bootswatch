<?php
/**
 * Bootswatch functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootswatch
 */

add_action( 'after_setup_theme', function() {

	load_theme_textdomain( 'bootswatch', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'bootswatch' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );
} );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bootswatch_content_width() {
	$GLOBALS['content_width'] = ! is_active_sidebar( 'sidebar' )
		? 1140
		: 750
	;
}

add_action( 'after_setup_theme', 'bootswatch_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bootswatch_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'bootswatch' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget well clearfix %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'bootswatch_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bootswatch_scripts() {

	/**
	 * Current Bootswatch theme with fallback to Bootstrap
	 */
	$theme = bootswatch_get_option( 'theme', 'bootstrap' );
	/**
	 * Default variable overrides.
	 */
	$variables_overrides = [
		'@icon-font-path' => '../vendor/kadimi/bootswatch-light/light/fonts/',
	];
	$variables_overrides = apply_filters( 'bootswatch_variables_overrides', $variables_overrides, $theme );

	/**
	 * Bootswatch or bootstrap theme.
	 */
	$theme_path = bootswatch_make_theme_file( $theme, $variables_overrides );
	$theme_url  = site_url( substr( $theme_path, strlen( ABSPATH ) ) );
	wp_enqueue_style( 'bootswatch-' . $theme, $theme_url );

	/**
	 * Style.css.
	 */
	wp_enqueue_style( 'bootswatch', get_template_directory_uri() . '/style.css' );

	/**
	 * Scripts.
	 */
	wp_enqueue_script( 'bootswatch-bootstrap', bootswatch_get_bootstrap_part_uri( 'script' ), [ 'jquery' ] );

	/**
	 * Comment reply script.
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bootswatch_scripts' );

/**
 * Load all extras from ./inc/
 */
$extras = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( get_template_directory() . '/inc' ), RecursiveIteratorIterator::SELF_FIRST );
foreach ( $extras as $extra => $unused ) {
	if ( preg_match( '/\/[\w-]+\.php$/', $extra ) ) {
		require $extra;
	}
}
