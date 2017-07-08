<?php
/**
 * Snippet.
 *
 * @todo Improve this comment.
 *
 * @package Bootswatch
 */

/**
 * Determine if we should use short version of the post.
 */
if ( ! is_singular() && ! post_password_required() ) {
	$use_short = true;
} else {
	$use_short = false;
}

/**
 * Determine featured image size.
 */
if ( $use_short ) {
	$featured_image_size = apply_filters( 'bootswatch_thumbnail_size_short', 'thumbnail' );
} else {
	$featured_image_size = apply_filters( 'bootswatch_thumbnail_size', 'large' );
}

?>

<?php do_action( 'bootswatch_before_.entry-content' ); ?>
<div class="entry-content">
	<p><?php the_post_thumbnail( $featured_image_size ); ?></p>
	<?php
		if ( $use_short ) {
			if ( is_search() ) {
				the_excerpt();
			} else {
				the_content( sprintf(
					/* translators: %s: Post title. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'bootswatch' ), array(
						'span' => array(
							'class' => array(),
						),
					) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			}
		} else {
			the_content();
		}
	?>
	<?php bootswatch_link_pages(); ?>
</div><!-- .entry-content -->
<?php do_action( 'bootswatch_after_.entry-content' ); ?>
