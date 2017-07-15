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
?>

<div id="comments" class="comments-area"><?php

	if ( have_comments() ) {

		get_template_part( 'template-parts/snippets/comments', 'title' );
		get_template_part( 'template-parts/snippets/comments', 'list' );
		get_template_part( 'template-parts/snippets/comments', 'navigation' );
	}

	get_template_part( 'template-parts/snippets/comments', 'closed' );

	comment_form();

?></div>
