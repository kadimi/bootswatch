<?php
/**
 * Header.
 *
 * @package Bootswatch
 */

do_action( 'bootswatch_before_.page-header' );

if ( is_search() ) {
	?>
	<header class="page-header">
		<h1 class="page-title"><?php
			// Translators: %s is a search string.
			printf( esc_html__( 'Search Results for: %s', 'bootswatch' ), '<span>' . get_search_query() . '</span>' );
		?></h1>
	</header>
	<?php
}

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

do_action( 'bootswatch_after_.page-header' );
