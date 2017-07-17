<?php
/**
 * Comments list.
 *
 * @package Bootswatch
 */

?>
<div class="comment-list">
	<?php
		wp_list_comments( [
			'style' => 'div',
			'walker' => new Walker_Comment_Bootswatch(),
			'short_ping' => true,
		] );
	?>
</div><!-- .comment-list -->
