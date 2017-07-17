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

		bootswatch_get_template_part( 'template-parts/components/comments', 'title' );
		bootswatch_get_template_part( 'template-parts/components/comments', 'list' );
		bootswatch_get_template_part( 'template-parts/components/comments', 'navigation' );
	}

	bootswatch_get_template_part( 'template-parts/components/comments', 'closed' );

	comment_form();

?></div>
