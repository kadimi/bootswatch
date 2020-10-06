<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootswatch
 */

( function () {

	/**
	 * Determine if we should use the `page_header` class.
	 */
	$use_page_header_class = false;
	if ( is_singular() ) {
		$use_page_header_class = true;
	}

	/**
	 * Determine if we should use the `panel` class.
	 */
	$use_panel_class = is_archive() || is_home();

	/**
	 * Prepare classes.
	 */
	$classes = get_post_class();
	if ( $use_page_header_class ) {
		$classes[] = 'page-header';
	}
	if ( $use_panel_class ) {
		$classes[] = 'panel';
		$classes[] = 'panel-default';
	}

	?>

	<article id="post-<?php the_ID(); ?>" class="<?php echo implode( ' ', $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
		<?php bootswatch_get_template_part( 'template-parts/components/entry', 'header' ); ?>
		<?php bootswatch_get_template_part( 'template-parts/components/entry', 'content' ); ?>
		<?php bootswatch_get_template_part( 'template-parts/components/entry', 'footer' ); ?>
	</article><!-- #post-## -->

	<?php

} )();
