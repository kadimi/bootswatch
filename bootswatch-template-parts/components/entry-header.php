<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

/**
 * Determine if we should use the `panel` class.
 */
$use_panel_class = is_archive() || is_home();

/**
 * Prepare classes.
 */
$classes = [ 'entry-header' ];
if ( $use_panel_class ) {
	$classes[] = 'panel-heading';
}
?>

<header class="<?php echo implode( ' ', $classes ); ?>">
	<?php bootswatch_get_template_part( 'template-parts/components/entry', 'title' ); ?>
	<?php bootswatch_get_template_part( 'template-parts/components/entry', 'meta' ); ?>
</header>
