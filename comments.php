<?php
/**
 * Comments.
 *
 * @package Bootswatch
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/**
 * Wrap comment form title in <h2> if there are no comments
 */
add_filter( 'bootswatch_comment_form_args', function( $args ) {
	if ( ! have_comments() ) {
		$args['title_reply_before'] = '<h2>';
		$args['title_reply_after']  = '</h2>';
	}
	return $args;
} );

?>

<div id="comments" class="comments-area"><?php

	if ( have_comments() ) {

		bootswatch_get_template_part( 'template-parts/components/comments', 'title' );
		bootswatch_get_template_part( 'template-parts/components/comments', 'list' );
		bootswatch_get_template_part( 'template-parts/components/comments', 'navigation' );
	}

	bootswatch_get_template_part( 'template-parts/components/comments', 'closed' );

	comment_form( apply_filters( 'bootswatch_comment_form_args', [] ) );

?></div>
