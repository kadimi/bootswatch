<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

( function() {

	/**
	 * Determine if we should use the `panel` class.
	 */
	$use_panel_class = is_archive() || is_home();

	/**
	 * Determine if we should use the `page-header` class.
	 */
	$use_page_header_class = is_singular();

	/**
	 * Prepare classes.
	 */
	$classes = array( 'entry-header' );
	if ( $use_panel_class ) {
		$classes[] = 'panel-heading';
	}
	if ( $use_page_header_class ) {
		$classes[] = 'page-header';
	}
	?>

	<header class="<?php echo implode( ' ', $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
		<?php bootswatch_get_template_part( 'template-parts/components/entry', 'title' ); ?>
		<?php bootswatch_get_template_part( 'template-parts/components/entry', 'meta' ); ?>
	</header>

	<?php
} )();
