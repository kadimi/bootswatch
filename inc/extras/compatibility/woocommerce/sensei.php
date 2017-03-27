<?php
/**
 * Bootswatch WooCommerce/Sensei compatibility.
 *
 * @package Bootswatch
 */

remove_action( 'sensei_before_main_content', [ Sensei()->frontend, 'sensei_output_content_wrapper' ] );
remove_action( 'sensei_after_main_content', [ Sensei()->frontend, 'sensei_output_content_wrapper_end' ] );

add_action( 'sensei_before_main_content', function() {
	?>
	<div class="container">
		<div class="row">
			<div id="primary" class="<?php echo esc_attr( bootswatch_primary_classes() ); ?>">
				<div id="content" role="main">
	<?php
} );

add_action( 'sensei_after_main_content', function () {
	?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php
	get_sidebar();
} );
