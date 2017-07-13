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

	$commenter     = wp_get_current_commenter();
	$req           = get_option( 'require_name_email' );
	$required      = $req ? 'required' : '';
	$aria_required = $req ? 'true' : '';

	$div_tpl   = '<div class="form-group comment-form-{{field}}">{{label}} {{input}}</div>';
	$label_tpl = '<label for="{{field}}" class="col-sm-2 control-label">{{label}}{{required}}</label>';
	$input_tpl = '<div class="col-sm-10"><input{{param}}></div>';

	$fields_parameters = array(
		'author' => array(
			'label'         => __( 'Name', 'bootswatch' ),
			'type'          => 'text',
			'value'         => esc_attr( $commenter['comment_author'] ),
			'required'      => $required,
			'aria-required' => $aria_required,
			'size'          => 30,
			'maxlength'     => 245,
		),
		'email' => array(
			'label'         => __( 'Email', 'bootswatch' ),
			'type'          => 'email',
			'value'         => esc_attr( $commenter['comment_author_email'] ),
			'required'      => $required,
			'aria-required' => $aria_required,
			'size'          => 30,
			'maxlength'     => 100,
			'describedby'   => 'email-notes',
		),
		'url' => array(
			'label'     => __( 'Website', 'bootswatch' ),
			'type'      => 'url',
			'value'     => esc_attr( $commenter['comment_author_url'] ),
			'size'      => 30,
			'maxlength' => 200,
		),
	);

	foreach ( $fields_parameters as $field => $parameter ) {

		// Add some defaults to field.
		$parameter += [
			'id' => $field,
			'name' => $field,
			'class' => 'form-control',
		];

		// Build <input>.
		$input = $input_tpl;
		foreach ( array( 'name', 'id', 'type', 'value', 'required', 'aria-required', 'size', 'maxlength', 'describedby', 'class' ) as $p ) {
			if ( ! empty( $parameter[ $p ] ) ) {
				$input = str_replace( '{{param}}', sprintf( ' %s="%s"{{param}}', $p, $parameter[ $p ] ), $input );
			}
		}
		$input = str_replace( '{{param}}', '', $input );

		// Build <label>.
		$label = $label_tpl;
		$label = str_replace( '{{label}}', $parameter['label'], $label );
		$label = str_replace( '{{required}}', ! empty( $parameter['required'] ) ? ' <span class="required">*</span>' : '', $label );

		// Build field <div>.
		$div = $div_tpl;
		$div = str_replace( array( '{{input}}', '{{label}}', '{{field}}' ), array( $input, $label, $field ), $div );

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
 * @return Array           Defaults modified
 */
function bootswatch_comment_form( $defaults ) {
	$defaults['class_form']    = 'form-horizontal well';
	$defaults['comment_field'] = '
		<div class="form-group comment-form-comment">
			<label for="comment" class="col-sm-2 control-label">' . _x( 'Comment', 'noun', 'bootswatch' ) . ' <span class="required">*</span></label>
			<div class="col-sm-10">
				<textarea class="form-control" id="comment" name="comment" cols="45" rows="8" required="required" aria-required="true"></textarea>
			</div>
		</div>'
	;
	$defaults['submit_field']  = '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">%1$s %2$s</div></div>';
	$defaults['class_submit']  = 'btn btn-primary btn-lg';
	return $defaults;
};
add_filter( 'comment_form_defaults', 'bootswatch_comment_form' );
