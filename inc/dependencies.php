<?php
/**
 * Bootswatch depedencies manager.
 *
 * @package Bootswatch
 */

/**
 * Require composer autoloader.
 */
get_template_part( 'vendor/autoload' );

/**
 * Recommend Less PHP Compiler,
 */
bootswatch_recommend_plugin( [
	'name' => 'Less PHP Compiler',
	'file' => 'lessphp/less-plugin.php',
	'description' => __( 'Once you {{verb}} {{link}}, you can create even more Bootswatch based themes (advanced feature).', 'bootswatch' ),
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
	 * Make sure current theme is Bootswatch.
	 */
	if ( 'Bootswatch' !== wp_get_theme()->get( 'Name' ) ) {
		return;
	}

	/**
	 * No notices on the update screen.
	 */
	if ( 'update' === get_current_screen()->id ) {
		return;
	}

	/**
	 * Output admin notices.
	 */
	$recommended_plugins = apply_filters( 'bootswatch_recommended_plugins', [] );
	foreach ( $recommended_plugins as $plugin ) {
		$message = '';
		if ( is_plugin_active( $plugin['file'] ) ) {
			// Plugin is installed and active.
			continue;
		} else if ( file_exists( WP_PLUGIN_DIR . '/' . ( $plugin['file'] ) ) ) {
			// Plugin is installed but inactive.
			$verb = _x( 'activate', 'once you "activate"...', 'bootswatch' );
			$ucf_verb = ucfirst( $verb );
			$url = admin_url( 'plugins.php?plugin_status=inactive' );
		} else {
			// Plugin is not installed.
			$verb = _x( 'install', 'once you "install"...', 'bootswatch' );
			$ucf_verb = ucfirst( $verb );
			$url  = admin_url( sprintf( 'plugin-install.php?tab=plugin-information&plugin=%s', explode( '/', $plugin['file'] )[0] ) );
		}
		$link = sprintf( '<strong><a href="%s">%s</a></strong>', $url, $plugin['name'] );
		$message .= str_replace( [ '{{link}}', '{{verb}}', '{{ucf_verb}}' ], [ $link, $verb, $ucf_verb ], $plugin['description'] );
		/**
		 * Display notice.
		 */
		bootswatch_admin_notice( $message, 'dependencies' );
	}

} );
