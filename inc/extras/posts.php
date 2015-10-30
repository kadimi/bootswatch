<?php

function bootstwatch_post_classes($classes) {
	if ( is_sticky() AND is_home() ) {
		$classes[] = 'well';
	}
	$classes[] = 'panel';
	$classes[] = 'panel-default';
	
	return $classes;
}
add_filter( 'post_class', 'bootstwatch_post_classes' );

function dbj_edit_post_link($output) {
    $output = str_replace('class="post-edit-link"', 'class="post-edit-link btn btn-default"', $output);
    return $output;
}
add_filter('edit_post_link', 'dbj_edit_post_link');

/**
 * Link Pages
 * @author toscha
 * @link http://wordpress.stackexchange.com/questions/14406/how-to-style-current-page-number-wp-link-pages
 * @param  array $args
 * @return void
 * Modification of wp_link_pages() with an extra element to highlight the current page.
 */
function bootstrap_link_pages( $args = array () ) {
    $defaults = array(
        'before'      => '<p>' . __('Pages:'),
        'after'       => '</p>',
        'before_link' => '',
        'after_link'  => '',
        'current_before' => '',
        'current_after' => '',
        'link_before' => '',
        'link_after'  => '',
        'pagelink'    => '%',
        'echo'        => 1
    );

    $r = wp_parse_args( $args, $defaults );
    $r = apply_filters( 'wp_link_pages_args', $r );
    extract( $r, EXTR_SKIP );

    global $page, $numpages, $multipage, $more, $pagenow;

    if ( ! $multipage )
    {
        return;
    }

    $output = $before;

    for ( $i = 1; $i < ( $numpages + 1 ); $i++ )
    {
        $j       = str_replace( '%', $i, $pagelink );
        $output .= ' ';

        if ( $i != $page || ( ! $more && 1 == $page ) )
        {
            $output .= "{$before_link}" . _wp_link_page( $i ) . "{$link_before}{$j}{$link_after}</a>{$after_link}";
        }
        else
        {
            $output .= "{$current_before}{$link_before}<a>{$j}</a>{$link_after}{$current_after}";
        }
    }

    print $output . $after;
}

function bootswatch_link_pages() {

	$args = array(
		'before' => '<ul class="pagination">',
		'after' => '</ul>',
		'before_link' => '<li>',
		'after_link' => '</li>',
		'current_before' => '<li class="active">',
		'current_after' => '</li>',
		'previouspagelink' => '&laquo;',
		'nextpagelink' => '&raquo;'
	);

	return bootstrap_link_pages( $args );
}
