<?php

use Orchestra\Testbench\TestCase;

/**
 * Class ServiceProviderTest
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class ServiceProviderTest extends TestCase {
	protected function getPackageProviders($app) {
		return ['Cosninix\Sin\SinServiceProvider'];
	}

	protected function getPackageAliases($app) {
		return [
			'Sin' => 'Cosninix\Sin\Sin'
		];
	}

	protected function getEnvironmentSetUp($app) {
		$app['config']->set('app.locale', 'en');
	}

	public function testService() {

		$sin = app('Sin');
		$result = $sin->lang('de::german|en::english');
		$this->assertEquals('english', $result);
	}

	public function testFacade() {
		$result = Sin::lang('nl::de facade|en::the facade');
		$this->assertEquals('the facade', $result);
	}

	public function testHelper() {
		$result = ___('nl::de helper|en::the helper');
		$this->assertEquals('the helper', $result);
	}

}
