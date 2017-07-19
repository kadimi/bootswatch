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
		'cssjanus-0'   => '^cssjanus/cssjanus/[^/]+$',
		'cssjanus-1'   => '^cssjanus/cssjanus/test/$',
	],
] ) );
