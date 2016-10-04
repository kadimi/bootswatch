<?php
/**
 * Custom comments walker.
 *
 * @package Bootswatch
 */

/**
 * Walker_Comment_Bootswatch
 *
 * Custom comments walker.
 */
class Walker_Comment_Bootswatch extends Walker_Comment {

	/**
	 * Same as Walker_Comment::html5_comment() plus some Bootstrap classes and style locked on `div`.
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		ob_start();
		parent::html5_comment( $comment, $depth, array_merge( $args, [ 'style' => 'div' ] ) );
		echo str_replace( // WPCS XSS OK.
			[
				'class="comment-body"',
				'comment-reply-link',
			],
			[
				'class="comment-body well"',
				'comment-reply-link btn btn-info btn-xs',
			],
			ob_get_clean()
		);
	}

	/**
	 * Same as Walker_Comment::ping() plus some Bootstrap classes and style locked on `div`.
	 *
	 * @param WP_Comment $comment The comment object.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function ping( $comment, $depth, $args ) {
		ob_start();
		parent::ping( $comment, $depth, array_merge( $args, [ 'style' => 'div' ] ) );
		echo str_replace( // WPCS XSS OK.
			[
				'class="comment-body"',
			],
			[
				'class="comment-body well well-sm"',
			],
			ob_get_clean()
		);
	}
}
