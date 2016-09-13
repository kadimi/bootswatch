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
	if ( is_sticky() and is_home() ) {
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
 * Link Pages.
 *
 * Modification of wp_link_pages() with an extra element to highlight the current page.
 *
 * @author toscho
 * @link http://wordpress.stackexchange.com/questions/14406/how-to-style-current-page-number-wp-link-pages
 *
 * @param  Array $args Arguments.
 */
function bootstrap_link_pages( $args = array() ) {
	$defaults = array(
		'before'      => '<p>' . __( 'Pages:' ),
		'after'       => '</p>',
		'before_link' => '',
		'after_link'  => '',
		'current_before' => '',
		'current_after' => '',
		'link_before' => '',
		'link_after'  => '',
		'pagelink'    => '%',
		'echo'        => 1,
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );

	$before = $r['before'];
	$after = $r['after'];
	$before_link = $r['before_link'];
	$after_link = $r['after_link'];
	$current_before = $r['current_before'];
	$current_after = $r['current_after'];
	$link_before = $r['link_before'];
	$link_after = $r['link_after'];
	$pagelink = $r['pagelink'];
	$echo = $r['echo'];

	global $page, $numpages, $multipage, $more, $pagenow;

	if ( ! $multipage ) {
		return;
	}

	$output = $before;

	for ( $i = 1; $i < ( $numpages + 1 ); $i++ ) {
		$j       = str_replace( '%', $i, $pagelink );
		$output .= ' ';

		if ( $i != $page || ( ! $more && 1 == $page ) ) {
			$output .= "{$before_link}" . _wp_link_page( $i ) . "{$link_before}{$j}{$link_after}</a>{$after_link}";
		} else {
			$output .= "{$current_before}{$link_before}<a>{$j}</a>{$link_after}{$current_after}";
		}
	}

	print $output . $after; // WPCS: xss ok.
}

/**
 * Ouputs page links.
 */
function bootswatch_link_pages() {

	$args = array(
		'before' => '<ul class="pagination">',
		'after' => '</ul>',
		'before_link' => '<li>',
		'after_link' => '</li>',
		'current_before' => '<li class="active">',
		'current_after' => '</li>',
		'previouspagelink' => '&laquo;',
		'nextpagelink' => '&raquo;',
	);

	bootstrap_link_pages( $args );
}
