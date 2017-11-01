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
	'str_replacements' => [
		'vendor/composer/autoload_static.php' => [
			'ClassLoader::class' => "'Composer\Autoload\ClassLoader'",
		],
	],
	'preg_replacements' => [
		'languages/bootswatch.pot' => [
			sprintf( "/\"%s:[^\n]+\n/", 'Language' )        => '',
			sprintf( "/\"%s:[^\n]+\n/", 'Language-Team' )   => '',
			sprintf( "/\"%s:[^\n]+\n/", 'Last-Translator' ) => '',
			'/"POT-Creation-Date: .*/'                      => '"PO-Creattion-Date: YEAR-MO-DA HO:MI+ZONE\n"',
			"/#, fuzzy\n/s"                                 => '',
		],
	],
	'vendor_ignored_patterns' => [
		'extensions'   => '\.md$',
		'cssjanus-0'   => '^cssjanus/cssjanus/[^/]+$',
		'cssjanus-1'   => '^cssjanus/cssjanus/test/$',
	],
] ) );
