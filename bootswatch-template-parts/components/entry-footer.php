<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

if ( ! current_user_can( 'edit_post', $post->ID ) ) {
	return;
}
?>

<footer class="entry-footer">
	<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Post title */
				esc_html__( 'Edit %s', 'bootswatch' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	?>
</footer><!-- .entry-footer -->
