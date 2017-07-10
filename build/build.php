<?php
/**
 * Bootswatch build script.
 *
 * @package Bootswatch
 */

namespace Kadimi;

require 'build/class-bootswatchbuild.php';

( new BootswatchBuild( [
	'ignored_patterns' => [
		'hidden' => '^\..*',
		'build'  => '^build',
		'file-0' => '^codesniffer\.ruleset\.xml$',
		'file-1' => '^README\.md$',
		'file-2' => '^composer.(json|lock)$',
	],
	'vendor_ignored_patterns' => [
		'extensions'   => '\.md',
		'bootstrap-0'  => '^thomaspark/bootswatch/bower_components/bootstrap/(fonts|grunt|js)',
		'bootstrap-1'  => '^thomaspark/bootswatch/bower_components/bootstrap/dist/css/(bootstrap\.css|bootstrap\.css\.map|bootstrap\.min\.css\.map|bootstrap-theme\.css|bootstrap-theme\.css\.map|bootstrap-theme\.min\.css\.map)$',
		'bootswatch-0' => '^thomaspark/bootswatch/(cerulean|cosmo|cyborg|darkly|flatly|journal|lumen|paper|readable|sandstone|simplex|slate|spacelab|superhero|united|yeti)/(bootstrap\.css|bootstrap\.min\.css|_bootswatch\.scss|thumbnail\.png|_variables\.scss)',
		'bootswatch-1' => '^thomaspark/bootswatch/(custom|global|help|tests)',
		'bootswatch-2' => '^thomaspark/bootswatch/\..*',
		'bootswatch-3' => '^thomaspark/bootswatch/bower_components/(bootstrap-sass-official|font-awesome|html5shiv|jquery|respond)',
		'bootswatch-4' => '^thomaspark/bootswatch/(2|api|assets)',
		'cssjanus'     => '^cssjanus/cssjanus/test',
		'filesystem'   => '^symfony/filesystem/Tests',
		'titan-0'      => '^gambitph/titan-framework/js/(ace-min-noconflict|dev)',
		'titan-1'      => '^gambitph/titan-framework/(languages|tests)',
		'tgpma-0'      => '^tgmpa/tgm-plugin-activation/languages',
		'tgpma-1'      => '^tgmpa/tgm-plugin-activation/.*/tgm-example-plugin.zip',
	],
] ) );
