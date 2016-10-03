<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootswatch
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'bootswatch_before_.entry-header' ); ?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php do_action( 'bootswatch_after_.entry-header' ); ?>

	<?php do_action( 'bootswatch_before_.entry-content' ); ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bootswatch' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php do_action( 'bootswatch_after_.entry-content' ); ?>

	<?php do_action( 'bootswatch_before_.entry-footer' ); ?>
	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'bootswatch' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
	<?php do_action( 'bootswatch_after_.entry-footer' ); ?>
</article><!-- #post-## -->

