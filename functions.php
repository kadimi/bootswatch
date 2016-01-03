<?php
/**
 * Bootswatch functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootswatch
 */

if ( ! function_exists( 'bootswatch_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bootswatch_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Bootswatch, use a find and replace
	 * to change 'bootswatch' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'bootswatch', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

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

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bootswatch_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'bootswatch_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bootswatch_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bootswatch_content_width', 640 );
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
	 * Bootswatch theme setting value.
	 * @var string
	 */
	$bootswatch_theme = bootswatch_get_option( 'theme' );

	/**
	 * Selected Bootswatch theme, if none is selected, use Bootstrap.
	 */
	if ( $bootswatch_theme ) {
		wp_enqueue_style( 'bootswatch' . $bootswatch_theme, get_template_directory_uri() . '/vendor/bootswatch/themes/' . $bootswatch_theme . '/' . $bootswatch_theme . '.min.css' );
	} else {
		wp_enqueue_style( 'bootswatch-bootstrap', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css' );
	}

	/**
	 * Style.css
	 */
	wp_enqueue_style( 'bootswatch', get_template_directory_uri() . '/style.css' );

	/**
	 * Scripts.
	 */
	wp_enqueue_script( 'bootswatch-bootstrap', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'bootswatch', get_template_directory_uri() . '/js/script.js', array( 'jquery' ) );

	/**
	 * Comment reply script.
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bootswatch_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load all extras from ./inc/extras/
 */
foreach ( glob( get_template_directory() . '/inc/extras/*.php') as $extra ) {
    require $extra;
}
