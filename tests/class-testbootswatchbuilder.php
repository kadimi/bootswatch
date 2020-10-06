<?php
/**
 * Class SampleTest
 *
 * @package Bootswatch
 */

namespace Bootswatch\Test;

/**
 * Test case.
 */
class TestBootswatchBuilder extends MonkeyTestCase {

	/**
	 * Undocumented.
	 */
	protected function setUp() {
		require_once 'inc/bootswatch-builder.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	}

	/**
	 * Undocumented.
	 */
	protected function test_bootswatch_get_filesystem_returns_WP_Filesystem_Direct_instance() {
		$this->assertThat( bootswatch_get_filesystem(), $this->isInstanceOf( 'WP_Filesystem_Direct' ) );
	}

	/**
	 * Undocumented.
	 */
	protected function test_bootswatch_get_filesystem_returns_same_instance() {
		$a = bootswatch_get_filesystem();
		$b = bootswatch_get_filesystem();
		$this->assertSame( $a, $b );
	}

	/**
	 * Undocumented.
	 */
	protected function test_bootswatch_light_directory_returns_existing_path() {
		$dir = preg_replace( '/^\/tmp\/wordpress/', '../../..', bootswatch_light_directory() );
		$this->assertDirectoryExists( $dir );
	}

	/**
	 * Undocumented.
	 */
	protected function test_bootswatch_light_directory_returns_correct_directory() {
		$dir = preg_replace( '/^\/tmp\/wordpress/', '../../..', bootswatch_light_directory() );
		$this->assertDirectoryExists( $dir . '/cerulean' );
	}

	/**
	 * Undocumented.
	 */
	protected function test_bootswatch_parse_less() {
		if ( class_exists( 'Less_Parser' ) ) {
			$less   = '@red: red; body{ color: @red; }';
			$parsed = bootswatch_parse_less( $less );
			$this->assertEquals( 'body{color:#f00}', $parsed );
		}
	}
}
