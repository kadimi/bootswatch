<?php
/**
 * Bootswatch depedencies manager.
 *
 * @package Bootswatch
 */

/**
 * Require composer autoloader and TGMPA.
 */
require get_template_directory() . '/vendor/autoload.php';

/**
 * Recommend Titan Framework.
 */
bootswatch_recommend_plugin( [
	'name' => 'Titan Framework',
	'file' => 'titan-framework/titan-framework.php',
	'description' => '{{ucf_verb}} {{link}} to enable Bootswatch customizer options section.',
] );

/**
 * Recommend Less PHP Compiler,
 */
bootswatch_recommend_plugin( [
	'name' => 'Less PHP Compiler',
	'file' => 'lessphp/less-plugin.php',
	'description' => 'Once you {{verb}} {{link}}, you can create even more Bootswatch based themes (advanced feature).',
] );

/**
 * Recommends a plugin in an admin notice.
 *
 * @param Array $plugin Plugin data.
 */
function bootswatch_recommend_plugin( $plugin ) {
	add_filter( 'bootswatch_recommended_plugins', function( $recommended_plugins ) use ( $plugin ) {
		$recommended_plugins[] = $plugin;
		return $recommended_plugins;
	} );
}

/**
 * Inform administrator about recommended plugins.
 */
add_action( 'admin_notices', function() {

	/**
	 * No notices on the update screen.
	 */
	if ( 'update' === get_current_screen()['id'] ) {
		return;
	}

	$recommended_plugins = apply_filters( 'bootswatch_recommended_plugins', [] );
	$notice_id           = 'bootswatch-notice-dependencies';
	$dismissed           = ! empty( $_COOKIE[ "$notice_id-dismissed" ] );

	$output = '';

	foreach ( $recommended_plugins as $plugin ) {
		if ( is_plugin_active( $plugin['file'] ) ) {
			// Plugin is installed and active.
			continue;
		} else if ( file_exists( WP_PLUGIN_DIR . '/' . ( $plugin['file'] ) ) ) {
			// Plugin is installed but inactive.
			$verb = __( 'activate', 'bootswatch' );
			$ucf_verb = ucfirst( $verb );
			$url = admin_url( 'plugins.php?plugin_status=inactive' );
		} else {
			// Plugin is not installed.
			$verb = __( 'install', 'bootswatch' );
			$ucf_verb = ucfirst( $verb );
			$url  = admin_url( sprintf( 'plugin-install.php?tab=plugin-information&plugin=%s', explode( '/', $plugin['file'] )[0] ) );
		}
		$link = sprintf( '<strong><a href="%s">%s</a></strong>', $url, $plugin['name'] );
		$output .= '<p>' . str_replace( [ '{{link}}', '{{verb}}', '{{ucf_verb}}' ], [ $link, $verb, $ucf_verb ], $plugin['description'] ) . '</p>';
	}

	if ( $output ) {
		?>
		<div class="notice notice-success is-dismissible bootswatch-notice" id="<?php echo $notice_id; // XSS OK. ?>">
			<h4><?php __( 'Howdy, Bootswatch here!', 'bootswatch' ) ?></h4>
			<?php echo $output; // XSS OK. ?>
		</div>
		<script>
			jQuery( document ).ready( function($) {
				var noticeID = '<?php echo $notice_id; // XSS OK. ?>';
				$( document ).on( 'click', `#${noticeID} .notice-dismiss`, function() {
					boostwatchCreateCookie( `${noticeID}-dismissed`, 1, 7 );
				} );
				function boostwatchCreateCookie( name, value = 1, days = 7 ) {
					document.cookie = `${name}=${value}; expires=${(new Date((new Date).getTime() + days * 86400000)).toUTCString()}; path=/`;
				}
			} );
		</script>
		<?php
	}
} );
