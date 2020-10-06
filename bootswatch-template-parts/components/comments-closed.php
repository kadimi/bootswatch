<?php
/**
 * Comments closed.
 *
 * @package Bootswatch
 */

/**
 * Add a note if the comments are closed and there are comments.
 */
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
	?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'bootswatch' ); ?></p>
	<?php
}
