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
	return str_replace( 'class="search-form', 'class="search-form ' . $classes, get_search_form( false ) );
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
	$classes   = [
		'form'   => join( ' ', apply_filters( 'bootswatch_search_form_classes', [
			'my-2',
			'my-lg-0',
		] ) ),
		'input'  => join( ' ', apply_filters( 'bootswatch_search_form_input_classes', [
			'form-control',
			'my-2',
			'mr-sm-2',
		] ) ),
		'submit' => join( ' ', apply_filters( 'bootswatch_search_form_submit_classes', [
			'btn',
			'btn-outline-primary',
		] ) ),
	];

	ob_start();
	?>

	<form role="search" class="search-form <?php echo $classes['form']; ?>" action="<?php echo esc_url( home_url() ); ?>">
		<label class="sr-only" for="<?php echo $unique_id; // XSS OK. ?>">
			<?php echo esc_html_x( 'Search for:', 'label', 'bootswatch' ); ?>
		</label>
		<input type="search" id="<?php echo $unique_id; // XSS OK. ?>" class="<?php echo $classes['input']; ?>" value="<?php echo get_search_query(); ?>" name="s">
		<button class="<?php echo $classes['submit']; ?>" type="submit" role="button"><?php esc_html_e( 'Search', 'bootswatch' ); ?></button>
	</form>

	<?php
	$form = ob_get_clean();
	return $form;
}
add_filter( 'get_search_form', 'bootswatch_get_search_form_cb' );
