<?php
/**
 * Bootswatch search form.
 *
 * @package Bootswatch
 */

/**
 * Search form
 *
 * @param  Array|String $classes Additional form classes.
 */
function bootswatch_search_form( $classes = '' ) {

	if ( is_array( $classes ) ) {
		$classes = implode( ' ', $classes );
	}

	?>
	<form class="<?php echo esc_attr( $classes ); ?>" action="<?php echo esc_url( home_url() ); ?>">
		<div class="input-group">
			<input class="form-control" name="s" value="<?php echo get_search_query(); ?>">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-default"><?php esc_html_e( 'Search', 'bootswatch' ); ?></button>
				</span>
		</div>
	</form>
<?php
}
