<?php
/**
 * Bootswatch posts enhancements.
 *
 * @package Bootswatch
 */

/**
 * Adds relevant post classes.
 *
 * - Adds `well` and `well-lg` to sticky posts in home.
 *
 * @param  Array $classes Classes.
 * @return Array          Classes with possible additions.
 */
function bootstwatch_post_classes( $classes ) {
	if ( is_sticky() && is_home() ) {
		$classes[] = 'well';
		$classes[] = 'well-lg';
	}
	return $classes;
}
add_filter( 'post_class', 'bootstwatch_post_classes' );

/**
 * Adds relevant post link classes.
 *
 * - Adds `post-edit-link`,  `btn` and `btn-default` to post links.
 *
 * @param  String $output Post link.
 * @return String         Post link modified.
 */
function bootstwatch_edit_post_link( $output ) {
	$output = str_replace( 'class="post-edit-link"', 'class="post-edit-link btn btn-default"', $output );
	return $output;
}
add_filter( 'edit_post_link', 'bootstwatch_edit_post_link' );

/**
 * Outputs page links.
 */
function bootswatch_link_pages() {

	/**
	 * Helps prevent hooking function twice.
	 */
	static $once;

	/**
	 * Put current link in empty `a` tag.
	 */
	if ( ! $once ) {
		add_filter( 'wp_link_pages_link', function( $link ) {
			return is_numeric( $link ) ? '<a class="active">' . $link . '</a>' : $link;
		} );
	}

	/**
	 * Generate links.
	 */
	$links = wp_link_pages( [
		'after' => '</li></ul>',
		'before' => '<ul class="pagination"><li>',
		'echo' => false,
		'separator' => '</li><li>',
	] );

	/**
	 * Move active class from `a` to `li`.
	 */
	$links = str_replace( '<li><a class="active">', '<li class="active"><a>', $links );

	/**
	 * Output.
	 */
	echo $links; // XSS OK.

	/**
	 * Prevent hooking function twice.
	 */
	$once = true;
}

add_filter( 'the_content', 'bootswatch_content' );
add_filter( 'comment_text', 'bootswatch_content' );

/**
 * Adds Bootstrap classes to some important elements.
 *
 * @param  String $output The content.
 * @return String         The filtered content.
 */
function bootswatch_content( $output ) {
	return str_replace( '<table>', '<table class="table table-striped table-bordered">', $output );
}
