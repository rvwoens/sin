<?php

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use Cosninix\Sin\SinBase;

/**
 * Class SimpleSinTest
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class SimpleSinTest extends TestCase {

	/**
	 * Define environment setup.
	 * @param Application $app
	 */
	protected function getEnvironmentSetUp($app) {
		$app['config']->set('app.locale', 'en');
	}

	/**
	 * test the base class
	 */
	public function testString() {
		$obj = new SinBase(app('config'));
		$result = $obj->lang('de::german|en::english');
		$this->assertEquals('english', $result);
	}
}
