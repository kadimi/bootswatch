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
		'languages/bootswatch.pot' => [
			"# SOME DESCRIPTIVE TITLE.\n"             => '',
			'same license as the Bootswatch package'  => 'GPLv3',
			'(C) YEAR'                                => '(C) ' . date( 'Y' ),
			"# FIRST AUTHOR <EMAIL@ADDRESS>, YEAR.\n" => '',
			'charset=CHARSET'                         => 'charset=utf-8',
			"#, fuzzy\n"                              => '',
			"#\n"                                     => '',
		],
	],
	'preg_replacements' => [
		'vendor/autoload.php' => [
			'/Composer([a-z]+)[0-9a-f]{32}/i' => 'Composer$1Bootswatch',
		],
		'vendor/composer/autoload_real.php' => [
			'/Composer([a-z]+)[0-9a-f]{32}/i' => 'Composer$1Bootswatch',
		],
		'vendor/composer/autoload_static.php' => [
			'/Composer([a-z]+)[0-9a-f]{32}/i' => 'Composer$1Bootswatch',
		],
		'languages/bootswatch.pot' => [
			sprintf( "/\"%s:[^\n]+\n/", 'Language' )        => '',
			sprintf( "/\"%s:[^\n]+\n/", 'Language-Team' )   => '',
			sprintf( "/\"%s:[^\n]+\n/", 'Last-Translator' ) => '',
			sprintf( "/\"%s:[^\n]+\n/", 'Plural-Forms' )    => '',
			'/"POT-Creation-Date: .*/'                      => '"PO-Creattion-Date: YEAR-MO-DA HO:MI+ZONE\n"',
		],
		'languages/bootswatch-ar.po' => [
			'/"POT-Creation-Date: .*/' => '"PO-Creattion-Date: YEAR-MO-DA HO:MI+ZONE\n"',
		],
		'languages/bootswatch-fr.po' => [
			'/"POT-Creation-Date: .*/' => '"PO-Creattion-Date: YEAR-MO-DA HO:MI+ZONE\n"',
		],
	],
	'vendor_ignored_patterns' => [
		'extensions'   => '\.md$',
		'cssjanus-0'   => '^cssjanus/cssjanus/[^/]+$',
		'cssjanus-1'   => '^cssjanus/cssjanus/test/$',
	],
] ) );
