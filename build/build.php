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
		'bin'      => '^bin/.*$',
		'css'      => '^css/.*$',
		'hidden-0' => '^\..*',
		'hidden-1' => '\.(bower\.json|csscomb\.json|csslintrc|gitignore|jscsrc|travis\.yml)$',
		'build'    => '^build',
		'file-0'   => '^codesniffer\.ruleset\.xml$',
		'file-1'   => '^README\.md$',
		'file-2'   => '^composer.(json|lock)$',
		'readme'   => '^readme/.*$',
		'tests'    => '^tests/.*$',
		'wp.dev'   => '^(ip|hostname)$',
	],
	'vendor_ignored_patterns' => [
		'extensions'   => '\.md$',
		'cssjanus-0'   => '^cssjanus/cssjanus/[^/]+$',
		'cssjanus-1'   => '^cssjanus/cssjanus/test/$',
	],
] ) );
