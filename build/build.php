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
		'hidden-0' => '^\..*',
		'hidden-1' => '\.(csslintrc|csscomb\.json|bower\.json|gitignore|travis\.yml)$',
		'build'  => '^build',
		'file-0' => '^codesniffer\.ruleset\.xml$',
		'file-1' => '^README\.md$',
		'file-2' => '^composer.(json|lock)$',
		'wp.dev' => '^(ip|hostname)$',
	],
	'vendor_ignored_patterns' => [
		'extensions'   => '\.md$',
		'bootstrap-0'  => '^thomaspark/bootswatch/bower_components/bootstrap/(fonts|grunt|js|nuget)/',
		'bootstrap-1'  => '^thomaspark/bootswatch/bower_components/bootstrap/[^/]+$',
		'bootstrap-2'  => '^thomaspark/bootswatch/bower_components/bootstrap/dist/css/(bootstrap\.css|bootstrap\.css\.map|bootstrap\.min\.css\.map|bootstrap-theme\.css|bootstrap-theme\.css\.map|bootstrap-theme\.min\.css\.map)$',
		'bootswatch-0'  => '^thomaspark/bootswatch/[^/]+$',
		'bootswatch-1' => '^thomaspark/bootswatch/(cerulean|cosmo|cyborg|darkly|flatly|journal|lumen|paper|readable|sandstone|simplex|slate|spacelab|superhero|united|yeti)/(bootstrap\.css|_bootswatch\.scss|index\.html|thumbnail\.png|_variables\.scss)$',
		'bootswatch-2' => '^thomaspark/bootswatch/(custom|default|fonts|global|help|tests)/',
		'bootswatch-3' => '^thomaspark/bootswatch/bower_components/(bootstrap-sass-official|font-awesome|html5shiv|jquery|respond)',
		'bootswatch-4' => '^thomaspark/bootswatch/(2|api|assets)',
		'cssjanus-0'   => '^cssjanus/cssjanus/[^/]+$',
		'cssjanus-1'   => '^cssjanus/cssjanus/test/$',
		'filesystem'   => '^symfony/filesystem/Tests/$',
	],
] ) );
