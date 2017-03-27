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
		parent::html5_comment( $comment, $depth, $args );
		$output = ob_get_clean();
		$output = str_replace( // WPCS XSS OK.
			[
				'class="comment-body"',
				'comment-reply-link',
				'class="comment-metadata"',
				'class="comment-edit-link"',
				'class="reply"',
				'<article id="div-comment-',
				'</article>',
			],
			[
				'class="comment-body well"',
				'comment-reply-link btn btn-default btn-xs',
				'class="comment-metadata small text-right"',
				'class="comment-edit-link btn btn-danger btn-xs"',
				'class="reply text-right"',
				sprintf( '<div class="row"><div class="col-md-%1$d col-md-offset-%2$d"><article id="div-comment-'
					, ( 13 - $depth )
					, ( $depth -1 )
				),
				'</article></div></div>',
			],
			$output
		);

		// Fix line exceeding link.
		$output = preg_replace( "/\s*<\/time>\n\s+<\/a>/s", '</time></a>', $output );

		echo $output; // WPCS XSS OK.
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
		parent::ping( $comment, $depth, array_merge( $args, [
			'style' => 'div',
		] ) );
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
