<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

( function() {

	global $post;

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return;
	}

	/**
	 * Determine if we should use the `panel-footer` class.
	 */
	$use_panel_class = is_archive() || is_home();

	/**
	 * Prepare classes.
	 */
	$classes = array(
		'entry-footer',
	);
	if ( $use_panel_class ) {
		$classes[] = 'panel-footer';
	}

	?>

	<footer class="<?php echo implode( ' ', $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
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

	<?php

} )();
