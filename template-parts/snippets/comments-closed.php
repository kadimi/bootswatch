<?php
/**
 * Comments closed.
 *
 * @package Bootswatch
 */

// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'bootswatch' ); ?></p>
<?php endif; ?>
