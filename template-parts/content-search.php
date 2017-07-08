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

		<?php do_action( 'bootswatch_before_.entry-title' ); ?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php do_action( 'bootswatch_after_.entry-title' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<?php do_action( 'bootswatch_before_.entry-meta' ); ?>
		<div class="entry-meta">
			<?php bootswatch_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php do_action( 'bootswatch_after_.entry-meta' ); ?>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<p><?php the_post_thumbnail( apply_filters( 'bootswatch_thumbnail_size_post', 'thumbnail' ) ); ?></p>
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<hr>

	<?php do_action( 'bootswatch_before_.entry-footer' ); ?>
	<footer class="entry-footer">
		<?php bootswatch_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php do_action( 'bootswatch_after_.entry-footer' ); ?>
</article><!-- #post-## -->

