<?php
/**
 * Bootswatch build script.
 *
 * @package Bootswatch
 */

namespace Kadimi;

require 'build/class-bootswatchbuild.php';

( new BootswatchBuild(
	array(
		'ignored_patterns' => array(
			'bin'      => '^bin/.*$',
			'css'      => '^css/.*$',
			'hidden-0' => '^\..*',
			'hidden-1' => '\.(bower\.json|csscomb\.json|csslintrc|gitignore|jscsrc|travis\.yml)$',
			'build'    => '^build',
			'file-0'   => '^codesniffer\.ruleset\.xml$',
			'file-1'   => '^README\.md$',
			'file-2'   => '^composer.(json|lock)$',
			'readme'   => '^readme/.*$',
			'tests'    => '^((tests/.*)|phpunit\.xml\.dist)$',
			'wp.dev'   => '^(ip|hostname|wp)$',
		),
		'str_replacements' => array(
			'vendor/composer/autoload_static.php' => array(
				'ClassLoader::class' => "'Composer\Autoload\ClassLoader'",
			),
			'languages/bootswatch.pot' => array(
				"# SOME DESCRIPTIVE TITLE.\n"             => '',
				'same license as the Bootswatch package'  => 'GPLv3',
				'(C) YEAR'                                => '(C) ' . date( 'Y' ),
				"# FIRST AUTHOR <EMAIL@ADDRESS>, YEAR.\n" => '',
				'charset=CHARSET'                         => 'charset=utf-8',
				"#, fuzzy\n"                              => '',
				"#\n"                                     => '',
			),
		),
		'preg_replacements' => array(
			'vendor/autoload.php' => array(
				'/Composer([a-z]+)[0-9a-f]{32}/i' => 'Composer$1Bootswatch',
			),
			'vendor/composer/autoload_real.php' => array(
				'/Composer([a-z]+)[0-9a-f]{32}/i' => 'Composer$1Bootswatch',
			),
			'vendor/composer/autoload_static.php' => array(
				'/Composer([a-z]+)[0-9a-f]{32}/i' => 'Composer$1Bootswatch',
			),
			'languages/bootswatch.pot' => array(
				sprintf( "/\"%s:[^\n]+\n/", 'Language' ) => '',
				sprintf( "/\"%s:[^\n]+\n/", 'Language-Team' ) => '',
				sprintf( "/\"%s:[^\n]+\n/", 'Last-Translator' ) => '',
				sprintf( "/\"%s:[^\n]+\n/", 'Plural-Forms' ) => '',
				'/"(PO|POT)-([a-z]+)-Date: .*/i'         => '"$1-$2-Date: YEAR-MO-DA HO:MI+ZONE\n"',
			),
			'languages/ar.po' => array(
				'/"(PO|POT)-([a-z]+)-Date: .*/i' => '"$1-$2-Date: YEAR-MO-DA HO:MI+ZONE\n"',
			),
			'languages/fr.po' => array(
				'/"(PO|POT)-([a-z]+)-Date: .*/i' => '"$1-$2-Date: YEAR-MO-DA HO:MI+ZONE\n"',
			),
		),
		'vendor_ignored_patterns' => array(
			'extensions' => '\.md$',
			'cssjanus-0' => '^cssjanus/cssjanus/[^/]+$',
			'cssjanus-1' => '^cssjanus/cssjanus/test/$',
		),
	) 
) );
