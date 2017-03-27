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
	<header class="entry-header <?php echo ( ! is_sticky() || ! is_home() ) ? 'page-header' : ''; ?>">

		<?php do_action( 'bootswatch_before_.entry-title' ); ?>
		<h2 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_title(); ?>
			</a>
		</h2>
		<?php do_action( 'bootswatch_after_.entry-title' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<?php do_action( 'bootswatch_before_.entry-meta' ); ?>
				<div class="entry-meta"><?php bootswatch_posted_on(); ?></div>
			<?php do_action( 'bootswatch_after_.entry-meta' ); ?>

		<?php endif; ?>
	</header>

	<?php do_action( 'bootswatch_before_.entry-content' ); ?>
	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'bootswatch' ), array(
					'span' => array(
						'class' => array(),
					),
				) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

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
