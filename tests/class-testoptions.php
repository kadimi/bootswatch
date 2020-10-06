<?php
/**
 * Class SampleTest
 *
 * @package Bootswatch
 */

namespace Bootswatch\Test;

/**
 * Test Case.
 */
class TestOptions extends MonkeyTestCase {

	/**
	 * Setup.
	 */
	protected function setUp() {

		require_once 'inc/options.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

		set_theme_mod(
			'bootswatch',
			array(
				'optionTrue'        => true,
				'optionFalse'       => false,
				'optionString'      => 'string',
				'optionEmptyString' => '',
				'optionNumber'      => 123,
				'optionZero'        => 0,
				'optionOne'         => 1,
			) 
		);
	}

	/**
	 * Missing documentation.
	 */
	protected function test_bootswatch_get_option_returns_correct_value() {

		/**
		 * Truthy.
		 */
		$this->assertSame( bootswatch_get_option( 'optionTrue' ), true );
		$this->assertSame( bootswatch_get_option( 'optionNumber' ), 123 );
		$this->assertSame( bootswatch_get_option( 'optionString' ), 'string' );
		$this->assertSame( bootswatch_get_option( 'optionOne' ), 1 );

		/**
		 * Falsy.
		 */
		$this->assertSame( bootswatch_get_option( 'optionFalse' ), false );
		$this->assertSame( bootswatch_get_option( 'optionZero' ), false );
		$this->assertSame( bootswatch_get_option( 'optionEmptyString' ), false );

		/**
		 * Falsy with default.
		 */
		$this->assertSame( bootswatch_get_option( 'optionFalse', 'default' ), 'default' );
		$this->assertSame( bootswatch_get_option( 'optionZero', 'default' ), 'default' );
		$this->assertSame( bootswatch_get_option( 'optionEmptyString', 'default' ), 'default' );

		/**
		 * Non-existent.
		 */
		$this->assertSame( bootswatch_get_option( 'optionNotExists' ), false );
		$this->assertSame( bootswatch_get_option( 'optionNotExists', 'default' ), 'default' );
	}
}
