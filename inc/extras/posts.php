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

	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'wp_link_pages_args', $args );

	$before = $args['before'];
	$after = $args['after'];
	$before_link = $args['before_link'];
	$after_link = $args['after_link'];
	$current_before = $args['current_before'];
	$current_after = $args['current_after'];
	$link_before = $args['link_before'];
	$link_after = $args['link_after'];
	$pagelink = $args['pagelink'];
	$echo = $args['echo'];

	global $page, $numpages, $multipage, $more, $pagenow;

	if ( ! $multipage ) {
		return;
	}

	$output = $before;

	for ( $i = 1; $i < ( $numpages + 1 ); $i++ ) {
		$j       = str_replace( '%', $i, $pagelink );
		$output .= ' ';

		if ( $i != $page || ( ! $more && 1 == $page ) ) {
			$output .= sprintf( '%1$s%2$s%3$s%4$s%5$s</a>%6$s'
				, $before_link
				, _wp_link_page( $i )
				, $link_before
				, $j
				, $link_after
				, $after_link
			);
		} else {
			$output .= sprintf( '%1$s%2$s<a>%3$s</a>%4$s%5$s'
				, $current_before
				, $link_before
				, $j
				, $link_after
				, $current_after
			);			
		}
	}

	$output .= $after;

	if ( $echo ) {
		print $output; // WPCS: xss ok.
	} else {
		return $output;
	}
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
