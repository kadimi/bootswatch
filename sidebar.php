<?php
if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}
?>

<div id="secondary" class="col-md-4">
	<?php dynamic_sidebar( 'sidebar' ); ?>
</div>
