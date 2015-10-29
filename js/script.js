/**
 * script.js
 *
 * Theme main JavaScript file.
 */
jQuery(document).ready( function($) {

	// Add Bootstrap classes in some important elements.
	$('table').addClass('table table-striped table-hover');

	/**
	 * Add caret to parents in primary menu
	 *
	 * @todo Remove at WordPress 4.4.
	 */
	$('#wp-calendar').addClass( 'table table-striped table-bordered');
	$('.menu-item-has-children > a').append(' <span class="caret"></span>');
});
