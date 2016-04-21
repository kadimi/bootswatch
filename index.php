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
		<div id="primary" class="col-md-8">
			<div id="content" role="main">
				<?php
				if ( have_posts() ) {

					if ( is_archive() ) {
						?>
						<header class="page-header">
							<?php
								the_archive_title( '<h1 class="page-title">', '</h1>' );
								the_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
						</header>
						<?php
					}

					while ( have_posts() ) {
						the_post();

						if ( is_single() ) {
							get_template_part( 'template-parts/content', 'single' );
						} else if ( is_page() ) {
							get_template_part( 'template-parts/content', 'page' );
						} else if ( is_archive() ) {
							get_template_part( 'template-parts/content', get_post_format() );
						} else {
							get_template_part( 'template-parts/content' );
						}

						if ( is_single() ) {
							the_post_navigation();
						}

						if ( is_single() || is_page() ) {
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						}

						if ( is_archive() ) {
							the_posts_navigation();
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
