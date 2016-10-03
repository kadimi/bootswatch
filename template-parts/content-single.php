<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootswatch
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php do_action( 'bootswatch_before_.entry-meta' ); ?>
		<div class="entry-meta">
			<?php bootswatch_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php do_action( 'bootswatch_before_.entry-meta' ); ?>
	</header><!-- .entry-header -->

	<?php do_action( 'bootswatch_before_.entry-content' ); ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php bootswatch_link_pages(); ?>
	</div><!-- .entry-content -->
	<?php do_action( 'bootswatch_after_.entry-content' ); ?>

	<hr>

	<?php do_action( 'bootswatch_before_.entry-footer' ); ?>
	<footer class="entry-footer">
		<?php bootswatch_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php do_action( 'bootswatch_after_.entry-footer' ); ?>
</article><!-- #post-## -->

