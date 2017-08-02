<?php
/**
 * Bootswatch content wrapper.
 *
 * @package Bootswatch
 */

/**
 * Opens content wrapper.
 *
 * @return void
 */
function bootswatch_content_wrapper() {
	?>
	<div class="container">
		<div class="row">
			<div id="primary" class="<?php echo esc_attr( bootswatch_primary_classes() ); ?>">
				<div id="content" role="main">
	<?php
}

/**
 * Closes content wrapper.
 *
 * @return void
 */
function bootswatch_content_wrapper_end() {
	?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php
}
