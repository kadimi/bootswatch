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
	<header class="entry-header <?php echo ( ! is_sticky() || ! is_home() ) ? 'page-header' : ''; ?> panel-heading">
		<h2 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_title(); ?>
			</a>
		</h2>

		<?php if ( 'post' === get_post_type() ) : ?>
			<p class="entry-meta"><?php bootswatch_posted_on(); ?></p>
		<?php endif; ?>
	</header>

	<div class="entry-content panel-body">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'bootswatch' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php bootswatch_link_pages(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer panel-footer">
		<?php bootswatch_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
