<?php
use Orchestra\Testbench\TestCase;

/**
 * Class BladeTest
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class BladeTest extends TestCase {
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

	protected function bladeCompile($value, array $args = []) {
		$generated = \Blade::compileString($value);

		ob_start() and extract($args, EXTR_SKIP);

		// We'll include the view contents for parsing within a catcher
		// so we can avoid any WSOD errors. If an exception occurs we
		// will throw it out to the exception handler.
		try {
			eval('?>'.$generated);
		}

			// If we caught an exception, we'll silently flush the output
			// buffer so that no partially rendered views get thrown out
			// to the client and confuse the user with junk.
		catch (\Exception $e) {
			ob_get_clean();
			throw $e;
		}

		$content = ob_get_clean();

		return $content;
	}

	/**
	 * the payoff: our Blade test
	 * @throws Exception
	 */
	public function testBlade() {
		$result = $this->bladeCompile('<h1>@slang("nl::blade testje|en::blade testing")</h1>');
		$this->assertEquals('<h1>blade testing</h1>', $result);
	}


}
