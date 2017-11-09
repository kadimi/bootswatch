<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Bootswatch
 */

if ( ! function_exists( 'bootswatch_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function bootswatch_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>' /* . '<time class="updated" datetime="%3$s">%4$s</time>' */;
			}

		$time_string = sprintf( $time_string, esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ), esc_attr( get_the_modified_date( 'c' ) ), esc_html( get_the_modified_date() ) );

		// Translators: %s ia a date.
		$posted_on = sprintf( esc_html_x( 'Posted on %s', 'post date', 'bootswatch' ), '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' );

		// Translators: %s ia a name.
		$byline = sprintf( esc_html_x( 'by %s', 'post author', 'bootswatch' ), '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>' );

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}
endif;

if ( ! function_exists( 'bootswatch_posts_navigation' ) ) {
	/**
	 * Displays pagination.
	 */
	function bootswatch_posts_navigation() {
		$links = paginate_links( [
			'type' => 'array',
		] );
		if ( $links ) {
			foreach ( $links as $index => $link ) {
				$link = '<li>' . $link . '</li>';
				$link = str_replace( "<li><span class='page-numbers current'>", '<li class="active"><a>', $link );
				$link = str_replace( '</span></li>', '</a></li>', $link );
				$links[ $index ] = $link;
			}
			echo '<nav><ul class="pagination">' . implode( $links, "\n" ) . '</ul></nav>'; // XSS OK.
		}
	}
}


if ( ! function_exists( 'bootswatch_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function bootswatch_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'bootswatch' ) );
			if ( $categories_list && bootswatch_categorized_blog() ) {
				// Translators: %s ia a category name.
				printf( '<p class="cat-links small">' . esc_html__( 'Posted in %s', 'bootswatch' ) . '</p>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = str_replace( 'rel="tag"', 'rel="tag" class="btn btn-primary btn-xs"', get_the_tag_list( '', ' ' ) );

			if ( $tags_list ) {
				// Translators: %s ia a tag name.
				printf( '<p class="tags-links small">' . esc_html__( 'Tagged %1$s', 'bootswatch' ) . '</p>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( bootswatch_can_we_use_comments_popup_link() ) {
			echo '<p class="comments-link lead">';
			comments_popup_link( esc_html__( 'Leave a comment', 'bootswatch' ), esc_html__( '1 Comment', 'bootswatch' ), esc_html__( '% Comments', 'bootswatch' ) );
			echo '</p>';
		}

		edit_post_link( sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'bootswatch' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			)
			, '<p>'
			, '</p>'
		);
	}
endif;

/**
 * Prints previous and next posts links.
 */
function bootswatch_post_navigation() {

	$replacements = [
		'/<div class="nav-links">/'    => '<ul class="nav-links pager">',
		'/<div class="nav-previous">/' => '<li class="nav-previous previous">',
		'/<div class="nav-next">/'     => '<li class="nav-next next">',
		'/<\/a><\/div>/'                 => '</a></li>',
		'/rel="prev">(.*?)</'          => 'rel="prev">&laquo; $1<',
		'/rel="next">(.*?)</'          => 'rel="prev">$1 &raquo;<',
		'/<\/li><\/div>/'                => '</li></ul>',
	];

	$nav = get_the_post_navigation();
	foreach ( $replacements as $pattern => $replacement ) {
		$nav = preg_replace( $pattern , $replacement, $nav );
	}
	echo $nav; // WPCS: XSS OK.
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function bootswatch_categorized_blog() {
	$all_the_cool_cats = get_transient( 'bootswatch_categories' );
	if ( ! $all_the_cool_cats ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'bootswatch_categories', $all_the_cool_cats );
	}

	return $all_the_cool_cats > 1;
}

/**
 * Flush out the transients used in bootswatch_categorized_blog.
 */
function bootswatch_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'bootswatch_categories' );
}
add_action( 'edit_category', 'bootswatch_category_transient_flusher' );
add_action( 'save_post',     'bootswatch_category_transient_flusher' );

/**
 * Helps us know if we can use the tag `comments_popup_link()`.
 *
 * It's because the tag `comments_popup_link()` must be within The Loop or a comment loop.
 */
function bootswatch_can_we_use_comments_popup_link() {
	return ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() );
}
