<?php
/**
 * Bootswatch search form.
 *
 * @package Bootswatch
 */

/**
 * Get search form.
 *
 * @param  Array|String $classes Additional form classes.
 */
function bootswatch_get_search_form( $classes = '' ) {

	if ( is_array( $classes ) ) {
		$classes = implode( ' ', $classes );
	}
	return str_replace( 'class="search', 'class="' . $classes . ' search', get_search_form( false ) );
}

/**
 * Output search form.
 *
 * @param  Array|String $classes Additional form classes.
 */
function bootswatch_search_form( $classes = '' ) {
	echo bootswatch_get_search_form( $classes ); // XSS OK.
}

/**
 * Generates Bootstrap powered WordPress compatible search form.
 *
 * @return String       Form HTML.
 */
function bootswatch_get_search_form_cb() {

	$unique_id = esc_attr( uniqid( 'search-form-' ) );
	ob_start();
	?>
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url() ); ?>">
		<div class="input-group">
			<label for="<?php echo $unique_id; // XSS OK. ?>">
				<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'bootswatch' ); ?></span>
			</label>
			<input type="search" id="<?php echo $unique_id; // XSS OK. ?>" class="form-control" value="<?php echo get_search_query(); ?>" name="s">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'bootswatch' ); ?></span>
				</button>
			</span>
		</div>
	</form>
	<?php
	$form = ob_get_clean();
	return $form;
}
add_filter( 'get_search_form', 'bootswatch_get_search_form_cb' );
