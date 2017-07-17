<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootswatch
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php bootswatch_get_template_part( 'template-parts/components/entry', 'header' ); ?>
	<?php bootswatch_get_template_part( 'template-parts/components/entry', 'content' ); ?>
	<?php bootswatch_get_template_part( 'template-parts/components/entry', 'footer' ); ?>
</article><!-- #post-## -->
