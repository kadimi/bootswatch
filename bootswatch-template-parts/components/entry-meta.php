<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

if ( 'post' === get_post_type() ) {
	?>
	<div class="clearfix">
		<p class="entry-meta pull-right"><?php bootswatch_posted_on(); ?></p>
		<p class="pull-left"><?php bootswatch_category_list( get_the_ID() ); ?></p>
	</div>
	<?php
}
