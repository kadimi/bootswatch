<?php
/**
 * Snippet.
 *
 * @package Bootswatch
 */

if ( 'post' === get_post_type() ) {
	?>
	<div class="entry-meta"><?php bootswatch_posted_on(); ?></div>
	<?php
}
