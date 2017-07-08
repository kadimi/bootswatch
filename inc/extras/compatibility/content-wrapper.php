<?php
/**
 * Bootswatch content wrapper.
 *
 * @package Bootswatch
 */

function bootswatch_content_wrapper() {
	?>
	<div class="container">
		<div class="row">
			<div id="primary" class="<?php echo esc_attr( bootswatch_primary_classes() ); ?>">
				<div id="content" role="main">
	<?php
}

function bootswatch_content_wrapper_end() {
	?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php
	get_sidebar();
}
