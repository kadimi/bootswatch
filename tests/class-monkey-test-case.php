<?php
/**
 * Class SampleTest
 *
 * @package Kadimi\Bootswatch
 */

namespace Kadimi\Bootswatch\Test;

use Brain\Monkey;

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
