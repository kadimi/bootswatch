<?php
/**
 * Comment form enhancements.
 *
 * @package Bootswatch
 */

/**
 * Alter comment form fields `Author`, `Email` and `Website`
 *
 * @param  Array $fields Fields.
 * @return Array         Fields altered.
 */
function bootswatch_comment_form_fields( $fields ) {

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = $req ? ' aria-required="true"' : '';
	$html5 = current_theme_supports( 'html5', 'comment-form' ) ? true : false;

	$div_tpl = '<div class="form-group comment-form-{{field}}">{{label}} {{input}}</div>';
	$label_tpl = '<label for="{{field}}" class="col-sm-2 control-label">{{label}}{{required}}</label>';
	$input_tpl = '<div class="col-sm-10"><input{{param}}></div>';

	$fields = array();

	$fields_parameters = array(
		'author' => array(
			'label'       => __( 'Name' ),
			'type'        => 'text',
			'value'       => esc_attr( $commenter['comment_author'] ),
			'required'    => $req,
			'size'        => 30,
			'maxlength'   => 245,
			'describedby' => '',
		),
		'email' => array(
			'label'       => __( 'Email' ),
			'type'        => $html5 ? 'email' : 'text',
			'value'       => esc_attr( $commenter['comment_author_email'] ),
			'required'    => $req,
			'size'        => 30,
			'maxlength'   => 100,
			'describedby' => 'email-notes',
		),
		'url' => array(
			'label'       => __( 'Website' ),
			'type'        => $html5 ? 'url' : 'text',
			'value'       => esc_attr( $commenter['comment_author_url'] ),
			'required'    => false,
			'size'        => 30,
			'maxlength'   => 200,
			'describedby' => '',
		),
	);

	foreach ( $fields_parameters as $field => $parameter ) {

		// Add some defaults to field.
		$parameter += array( 'id' => $field, 'name' => $field, 'class' => 'form-control' );

		// Build <input>.
		$input = $input_tpl;
		foreach ( array( 'name', 'id', 'type', 'value', 'required', 'size', 'maxlength', 'describedby', 'class' ) as $p ) {
			if ( $parameter[ $p ] ) {
				$input = str_replace( '{{param}}', sprintf( ' %s="%s"{{param}}', $p, $parameter[ $p ] ), $input );
			}
		}
		$input = str_replace( '{{param}}', '', $input );

		// Build <label>.
		$label = $label_tpl;
		$label = str_replace( '{{label}}', $parameter['label'], $label );
		$label = str_replace( '{{required}}', $parameter['required'] ? ' <span class="required">*</span>' : '', $label );

		// Build field <div>.
		$div = $div_tpl;
		$div = str_replace( array( '{{input}}', '{{label}}', '{{field}}' ), array( $input, $label, $field ),$div );

		// Add field to $fields array.
		$fields[ $field ] = $div;
	}
	return $fields;
}
add_filter( 'comment_form_default_fields', 'bootswatch_comment_form_fields' );

/**
 * Callback function for the `comment_form_defaults` filter hook
 *
 * @param  Array $defaults Defaults.
 * @return Array          Defaults modified
 */
function bootswatch_comment_form( $defaults ) {
	$defaults['class_form'] = 'form-horizontal';
	return $defaults;
};

add_filter( 'comment_form_defaults', 'bootswatch_comment_form' );
