<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

/**
 * Determine if we should use the `page_header` class.
 */
if ( is_singular() ) {
	$use_page_header_class = true;
} else if ( ! is_sticky() || ! is_home() ) {
	$use_page_header_class = true;
} else {
	$use_page_header_class = false;
}

/**
 * Determine if we should display meta.
 */
if ( 'post' === get_post_type() ) {
	$show_meta = true;
} else {
	$show_meta = false;
}
?>

<header class="entry-header<?php echo $use_page_header_class ? ' page-header' : ''; ?>">
	<?php get_template_part( 'template-parts/snippets/entry', 'title' ); ?>
	<?php if ( $show_meta ) : ?>
		<?php get_template_part( 'template-parts/snippets/entry', 'meta' ); ?>
	<?php endif; ?>
</header><!-- .entry-header -->
<?php do_action( 'bootswatch_after_.entry-header' ); ?>
