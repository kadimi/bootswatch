<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootswatch
 */

get_header(); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="col-md-8">
			<div id="content" role="main">
				<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content', 'page' );
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					}
				} else {
					get_template_part( 'template-parts/content', 'none' );
				}
				?>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer();?>
