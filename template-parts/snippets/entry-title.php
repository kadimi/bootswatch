<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

?>

<?php do_action( 'bootswatch_before_.entry-title' ); ?>
<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
<?php do_action( 'bootswatch_after_.entry-title' );
