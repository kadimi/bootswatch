<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

/**
 * Determine if we should use short version of the post.
 */
$use_short =  ! is_singular() && ! post_password_required();

/**
 * Determine if we should use the `panel` class.
 */
$use_panel_class = is_archive() || is_home();

/**
 * Classes.
 */
$classes = [ 'entry-content' ];
if ( $use_panel_class ) {
	$classes[] = 'panel-body';
}

/**
 * Featured image.
 */
$has_thumbnail  = ( $tmp = get_post_thumbnail_id( get_the_ID() ) ) && get_post( $tmp );
$thumbnail_size = apply_filters( 'bootswatch_thumbnail_size', 'full' );

/**
 * Columns.
*/
$thumbnail_columns = apply_filters( 'bootswatch_thumbnail_columns', 6 );
$content_columns   = 12 - $thumbnail_columns;
$thumbnail_first   = is_singular() || apply_filters( 'bootswatch_thumbnail_first', false );
/**
 * Prepare the featured image.
 */
ob_start();
?>
	<?php if ( $use_short && $has_thumbnail ) : ?>
		<div class="col-md-<?php echo $thumbnail_columns; ?>">
	<?php endif; ?>

	<?php if ( $has_thumbnail ) : ?>
		<p>
			<?php if ( $use_short ) : ?>
				<?php echo wp_get_attachment_link( get_post_thumbnail_id( get_the_ID() ), $thumbnail_size ); ?>
			<?php else : ?>
				<?php the_post_thumbnail( $thumbnail_size ); ?>
			<?php endif; ?>
		</p>
	<?php endif; ?>

	<?php if ( $use_short && $has_thumbnail ) : ?>
		</div>
	<?php endif; ?>
<?php
$thumbnail_output = ob_get_clean();

/**
 * Prepare the content.
 */
ob_start();
?>
	<?php if ( $use_short && $has_thumbnail ) : ?>
		<div class="col-md-<?php echo $content_columns; ?>">
	<?php endif; ?>

	<?php
		if ( $use_short ) {
			if ( is_search() ) {
				the_excerpt();
			} else {
				the_content( sprintf(
					/* translators: %s: Post title. */
					apply_filters( 'bootswatch_read_more_text', esc_html__( 'Continue reading %s &rarr;', 'bootswatch' ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			}
		} else {
			the_content();
		}
	?>

	<?php if ( $has_thumbnail ) : ?>
		</div>
	<?php endif; ?>
<?php
$content_output = ob_get_clean();

/**
 * Output.
 */
?>
<div class="<?php echo implode( ' ', $classes ); ?>">

	<?php if ( $use_short && $has_thumbnail ) : ?>
		<div class="row">
	<?php endif; ?>

	<?php if ( $thumbnail_first ) : ?>
		<?php echo $thumbnail_output ?>
		<?php echo $content_output ?>
	<?php else: ?>
		<?php echo $content_output ?>
		<?php echo $thumbnail_output ?>
	<?php endif; ?>

	<?php if ( $use_short && $has_thumbnail ) : ?>
		</div>
	<?php endif; ?>

	<?php bootswatch_link_pages(); ?>
</div><!-- .entry-content -->
