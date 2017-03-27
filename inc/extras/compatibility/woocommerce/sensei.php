<?php

global $woothemes_sensei;
remove_action( 'sensei_before_main_content', [ $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ] );
remove_action( 'sensei_after_main_content', [ $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ] );

add_action('sensei_before_main_content', 'my_theme_wrapper_start', 10);
add_action('sensei_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
	?>
	<div class="container">
		<div class="row">
			<div id="primary" class="<?php echo esc_attr( bootswatch_primary_classes() ); ?>">
				<div id="content" role="main">
	<?php
}

function my_theme_wrapper_end() {
	?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php
	get_sidebar();
}
