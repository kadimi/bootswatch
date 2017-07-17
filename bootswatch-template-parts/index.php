<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootswatch
 */

get_header(); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="<?php echo esc_attr( bootswatch_primary_classes() ); ?>">
			<div id="content" role="main">
				<?php
				if ( have_posts() ) {
					bootswatch_get_template_part( 'template-parts/partial', 'header' );
					bootswatch_get_template_part( 'template-parts/partial', 'content' );
					bootswatch_get_template_part( 'template-parts/partial', 'navigation' );
				} else {
					bootswatch_get_template_part( 'template-parts/content', 'none' );
				}
				?>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer();?>
