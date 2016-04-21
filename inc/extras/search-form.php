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
	$form = str_replace( 'class="search', 'class="' . $classes . ' search', get_search_form( false ) );
	echo $form; // XSS OK.
}

/**
 * Generates Bootstrap powered WordPress compatible search form.
 *
 * @param  String $form Form HTML.
 * @return String       Modified form HTML.
 */
function bootswatch_get_search_form( $form ) {
	ob_start();
	?>
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url() ); ?>">
		<div class="input-group">
			<input class="form-control" name="s" value="<?php echo get_search_query(); ?>">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span>\
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'bootswatch' ); ?></span>
				</button>
			</span>
		</div>
	</form>
	<?php
	$form = ob_get_clean();
	return $form;
}
add_filter( 'get_search_form', 'bootswatch_get_search_form' );
