<?php
/**
 * Comments list.
 *
 * @package Bootswatch
 */

?>
<div class="comment-list">
	<?php
	wp_list_comments(
		array(
			'style'      => 'div',
			'walker'     => new Bootswatch_Walker_Comment(),
			'short_ping' => true,
		) 
	);
	?>
</div><!-- .comment-list -->
