<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootswatch
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<?php do_action( 'bootswatch_before.entry-meta' ); ?>
		<div class="entry-meta">
			<?php bootswatch_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php do_action( 'bootswatch_after.entry-meta' ); ?>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php bootswatch_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

