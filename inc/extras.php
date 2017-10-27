<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Bootswatch
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bootswatch_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'bootswatch_body_classes' );

/**
 * Wrapper for get_template_part with hooks `bootswatch_(before|after)_${slug}_$name`.
 *
 * @param  String $slug Slug.
 * @param  String $name Name.
 */
function bootswatch_get_template_part( $slug, $name = null ) {

	$call = rand( 100000 , 999999 );
	$part = $name ? "$slug::$name" : $slug;
	$cb   = '__return_null';

	bootswatch_add_action( "bootswatch_before_$part", $cb, 10, PHP_INT_MAX );
	bootswatch_add_action( "bootswatch_before_$part::$call", $cb, 10, PHP_INT_MAX );
	do_action( "bootswatch_before_$part", $slug, $name );
	do_action( "bootswatch_before_$part::$call", $slug, $name );

	get_template_part( 'bootswatch-' . $slug, $name );

	bootswatch_add_action( "bootswatch_after_$part::$call", $cb, 10, PHP_INT_MAX );
	bootswatch_add_action( "bootswatch_after_$part", $cb, 10, PHP_INT_MAX );
	do_action( "bootswatch_after_$part::$call", $slug, $name );
	do_action( "bootswatch_after_$part", $slug, $name );
}

global $bootswatch_log;
$bootswatch_log = [];

/**
 * Does nothing yet.
 *
 * @param  String $message Log message.
 * @param  Arrays $args    Arguments.
 */
function bootswatch_log( $message, $args ) {

	global $bootswatch_log;

	$bootswatch_log[] = [
		'message' => $message,
		'arguments' => $args,
	];
}

add_action( 'bootswatch_shutdown', function() {

	if ( ! defined( 'BOOTSWATCH_DEBUG' ) || ! BOOTSWATCH_DEBUG ) {
		return;
	}

	global $bootswatch_log;

	$start = $bootswatch_log[0]['arguments']['start'];
	$end   = end( $bootswatch_log )['arguments']['end'];

	$render = [
		'full'    => sprintf( '%dms', ( $end - $start ) * 1000 ),
		'partial' => [],
	];

	/**
	 * Build tags stats table.
	 */
	$tags_stats = [];
	array_walk( $bootswatch_log, function( $log_entry ) use ( &$tags_stats ) {

		/**
		 * Only and action log entriy.
		 */
		if ( ! array_key_exists( 'arguments', $log_entry ) || ! array_key_exists( 'tag', $log_entry['arguments'] ) ) {
			return;
		}
		$tag  = $log_entry['arguments']['tag'];
		$args = $log_entry['arguments'];

		/**
		 * Only template parts tags.
		 */
		if ( ! preg_match( '/^bootswatch_(after|before)_template-parts/', $tag ) ) {
			return;
		}

		/**
		 * Only numbered tags.
		 */
		if ( ! preg_match( '/::\d+$/', $tag ) ) {
			return;
		}

		$tags_stats[ $tag ] = [
			'start' => $args['start'],
			'end' => $args['end'],
		];
		return;
	} );

	foreach ( $tags_stats as $tag => $stats ) {

		preg_match( '/^bootswatch_(after|before)_(.+)::(\d+)$/', $tag, $tag_parts );
		list( $unused, $when, $part, $call ) = $tag_parts;
		$start = $tags_stats[ "bootswatch_before_$part::$call" ]['end'];
		$end = $tags_stats[ "bootswatch_after_$part::$call" ]['start'];

		if ( ! array_key_exists( $part, $render['partial'] ) ) {
			// First call.
			$render['partial'][ $part ] = [
				'total_calls'    => 0,
				'total_duration_ms' => 0,
			];
		} else {
			if ( 'after' === $when ) {
				// Another call.
				$render['partial'][ $part ]['total_calls']       += 1;
				$render['partial'][ $part ]['total_duration_ms'] += 1000 * ($end -$start);
			}
		}
	}

	foreach ( $render['partial'] as &$partial ) {
		$partial['total_duration_ms'] = sprintf( '%d', $partial['total_duration_ms'] );
	}
	! d( get_theme_mods() );
	! d( $render );
} );

/**
 * Wrapper around `add_action()` with some debuggin tools.
 *
 * @param string   $tag      The name of the action to which the $function_to_add is hooked.
 * @param callable $callback The name of the function you wish to be called.
 * @param int      $priority Optional. Used to specify the order in which the functions
 *                           associated with a particular action are executed. Default 10.
 *                           Lower numbers correspond with earlier execution,
 *                           and functions with the same priority are executed
 *                           in the order in which they were added to the action.
 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
 * @return true Will always return true.
 */
function bootswatch_add_action( $tag, $callback, $priority = 10, $accepted_args = 1 ) {
	return add_action( $tag, function() use ( $tag, $callback ) {

		/**
		 * Fire callback while counting duratoin.
		 */
		$args    = func_get_args();
		$timer_0 = microtime( true );
		call_user_func( $callback, $args );
		$timer_1 = microtime( true );

		/**
		 * Write to log.
		 */
		bootswatch_log( 'Bootswatch action', [
			'tag'       => $tag,
			'callback'  => $callback,
			'arguments' => $args,
			'start'     => $timer_0,
			'end'       => $timer_1,
			'duration'  => $timer_1 - $timer_0,
		] );
	}, $priority, $accepted_args );
}

/**
 * Returns bootswatch theme version.
 */
function bootswatch_version() {
	return wp_get_theme()->get( 'Version' );
}

function bootswatch_admin_notice( $message, $id, $type = 'success', $is_dismissible = true ) {

	$id = "bootswatch-notice-$id";

	/**
	 * Skip dismissed notices.
	 */
	if ( $_COOKIE[ "$id-dismissed" ] ) {
		return;
	}

	/**
	 * Classes.
	 */
	$classes = sprintf( 'notice notice-%s %s bootswatch-notice'
		, $type
		, $is_dismissible ? 'is-dismissible' : ''
	);

	/**
	 * Prepare message.
	 *
	 * Add the title if this is the first notice.
	 */
	static $once_html = false;
	$__message = '';
	$__message .= ! $once_html ? ( '<h3>' . __( 'Howdy! Bootswatch here...', 'bootswatch' ) . '</h3>' ) : '';
	$__message .= '<p>' . $message . '</p>';
	printf( '<div id="%s" class="%s">%s</div>', $id, $classes, $__message );
	$once_html = true;

	/**
	 * Output JavaScript common with all dismissible notices.
	 */
	static $once_js   = false;
	if ( $is_dismissible && ! $once_js ) {
		?>
		<script>
			function boostwatchCreateCookie( name, value = 1, days = 7 ) {
				var expiry_date = (new Date((new Date).getTime() + days * 86400000)).toUTCString();
				document.cookie = `${name}=${value}; expires=${expiry_date}; path=/`;
			}
			function boostwatchSetupNotice( noticeID ) {
				jQuery( document ).on( 'click', `#${noticeID} .notice-dismiss`, function() {
					boostwatchCreateCookie( `${noticeID}-dismissed`, 1, 7 );
				} );
			}
		</script>
		<?php
		$once_js = true;
	}

	/**
	 * Outout JS for this notice if it's dismissible
	 */
	if ( $is_dismissible ) {
		?>
		<script>
			jQuery( function($) {
				boostwatchSetupNotice( '<?php echo esc_html( $id ); ?>' );
			} );
		</script>
		<?php
	}
}
