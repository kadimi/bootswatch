<?php
/**
 * Comments title.
 *
 * @package Bootswatch
 */

$count = get_comments_number();

// Translators: %1$s is a number and %2$s is a post title.
$format = esc_html( _nx(
	'%1$s thought on &ldquo;%2$s&rdquo;',
	'%1$s thoughts on &ldquo;%2$s&rdquo;',
	$count,
	'comments title',
	'bootswatch'
) );

?>

<h2 class="comments-title"><?php printf( $format, number_format_i18n( $count ), '<span>' . get_the_title() . '</span>' ); // WPCS: XSS OK. ?></h2>
