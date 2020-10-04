<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

if ( 'post' === get_post_type() ) {
	?>
	<p class="entry-meta pull-right"><?php bootswatch_posted_on(); ?></p>
	<p class="pull-right"><?php bootswatch_category_list( get_the_ID() ); ?></p>
	<?php
}
