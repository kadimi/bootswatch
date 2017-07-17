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
?>

<header class="entry-header<?php echo $use_page_header_class ? ' page-header' : ''; ?>">
	<?php bootswatch_get_template_part( 'template-parts/components/entry', 'title' ); ?>
	<?php bootswatch_get_template_part( 'template-parts/components/entry', 'meta' ); ?>
</header>
