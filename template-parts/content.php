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
	<?php get_template_part( 'template-parts/snippets/entry', 'header' ); ?>
	<?php get_template_part( 'template-parts/snippets/entry', 'content' ); ?>
	<?php get_template_part( 'template-parts/snippets/entry', 'footer' ); ?>
</article><!-- #post-## -->
