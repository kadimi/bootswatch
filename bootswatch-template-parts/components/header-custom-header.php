<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

if ( ( is_front_page() && has_custom_header() ) ) {
	?>
	<div class="container-fluid custom-header">
		<div class="row">
			<div class="col-md-12 ">
				<?php the_custom_header_markup(); ?>
			</div>
		</div>
	</div>
	<?php
}
