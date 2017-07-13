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
 * Inform administrator about recommended plugins.
 */
add_action( 'admin_notices', function() {

	$recommended_plugins = apply_filters( 'bootswatch_recommended_plugins', [
		[
			'name' => 'Titan Framework',
			'file' => 'titan-framework/titan-framework.php',
			'description' => '{{ucf_verb}} {{link}} to enable Bootswatch customizer options section.',
		],
		[
			'name' => 'Less PHP Compiler',
			'file' => 'lessphp/less-plugin.php',
			'description' => 'Once you {{verb}} {{link}}, you can create even more Bootswatch based themes (advanced feature).',
		],
	] );

	$output = '';

	foreach ( $recommended_plugins as $plugin ) {
		if ( is_plugin_active( $plugin['file'] ) ) {
			continue;
		}

		$is_plugin_installed = file_exists( WP_PLUGIN_DIR . '/' . ( $plugin['file'] ) );

		if ( $is_plugin_installed ) {
			$verb = __( 'activate', 'bootswatch' );
			$ucf_verb = ucfirst( $verb );
			$url  = admin_url( 'plugins.php' );
			$link = sprintf( '<strong><a href="%s">%s</a></strong>', $url, $plugin['name'] );
		} else {
			$verb = __( 'install', 'bootswatch' );
			$ucf_verb = ucfirst( $verb );
			$slug = explode( '/', $plugin['file'] )[0];
			$url  = admin_url( sprintf( 'plugin-install.php?tab=plugin-information&plugin=%s&TB_iframe=true&width=640&height=480', $slug ) );
			$link = sprintf( '<strong><a class="thickbox" href="%s">%s</a></strong>', $url, $plugin['name'] );
		}
		$output .= '<p>' . str_replace( [ '{{link}}', '{{verb}}', '{{ucf_verb}}' ], [ $link, $verb, $ucf_verb ], $plugin['description'] ) . '</p>';
	}

	if ( $output ) {
		?>
		<div class="notice notice-success is-dismissible">
			<h4><?php __( 'Howdy, Bootswatch here!', 'bootswatch' ) ?></h4>
			<?php echo $output; // XSS OK. ?>
	    </div>
	    <?php
	}
} );
