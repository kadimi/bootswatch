<?php
/**
 * Class SampleTest
 *
 * @package Bootswatch
 */

namespace Bootswatch\Test;

use Brain\Monkey;

/**
 * Test case.
 */
class MonkeyTestCase extends \PHPUnit_Framework_TestCase {

	/**
	 * Setup.
	 */
	protected function setUp() {
		parent::setUp();
		Monkey\setUp();
	}

	/**
	 * Teardown.
	 */
	protected function tearDown() {
		Monkey\tearDown();
		parent::tearDown();
	}
}
