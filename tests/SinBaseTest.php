<?php
use Orchestra\Testbench\TestCase;

/**
 * Class SinBaseTest
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class SinBaseTest extends TestCase {
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
		$app['config']->set('path.lang', './resources/lang');
	}


	public function testNop() {
		$result = Sin::lang('no conversions here');
		$this->assertEquals('no conversions here', $result);
	}

	public function testLocale() {
		$result = Sin::lang('de::kotelett|en::cutlet|nl::kotelet|fr::c&ocirc;telette');
		$this->assertEquals('cutlet', $result);

		app()->setLocale('nl');
		$result = Sin::lang('de::kotelett|en::cutlet|nl::kotelet|fr::c&ocirc;telette');
		$this->assertEquals('kotelet', $result);

		app()->setLocale('de');
		$result = Sin::lang('de::kotelett|en::cutlet|nl::kotelet|fr::c&ocirc;telette');
		$this->assertEquals('kotelett', $result);

		app()->setLocale('fr');
		$result = Sin::lang('de::kotelett|en::cutlet|nl::kotelet|fr::c&ocirc;telette');
		$this->assertEquals('c&ocirc;telette', $result);

		app()->setLocale('en'); // back to default
	}

	public function testSprintf() {
		$result = Sin::lang('nl::ik heb %d handen|en::I have %d hands', 2);
		$this->assertEquals('I have 2 hands', $result);
		$result = app('Sin')->lang('nl::ik heb %d pennen|en::I have %d pens', 4);
		$this->assertEquals('I have 4 pens', $result);
		$result = ___('nl::ik heb %d potloden|en::I have %d pencils', 5);
		$this->assertEquals('I have 5 pencils', $result);
		$result = Sin::lang('nl::ik heb %d handen en %d neus|en::I have %d hands and %d nose', 2, 1);
		$this->assertEquals('I have 2 hands and 1 nose', $result);
	}

    public function testSprintfException() {
        $result = Sin::lang('nl::ik heb %d handen en %d neus|en::I have %d hands and %d nose');
        $this->assertEquals('I have %d hands and %d nose', $result);
    }

	public function testLaravel() {
		$result = Sin::lang('de::kotelett|en::cutlet|nl::kotelet|fr::c&ocirc;telette|@@::does.not.exist');
		$this->assertEquals('cutlet', $result);

		// use a standard laravel translation auth.failed because orchestra keeps lang inside its own dir structure
		$result = Sin::lang('de::kotelett|en::cutlet|nl::kotelet|fr::c&ocirc;telette|@@::auth.failed');
		$this->assertEquals('These credentials do not match our records.', $result);
	}

	public function testIllegalSyntax() {
		$result = Sin::lang('nl::kotelet|en:wrong');
		$this->assertEquals('kotelet', $result);
		$result = Sin::lang('nl::kotelet|');
		$this->assertEquals('kotelet', $result);
		$result = Sin::lang('|nl::kotelet');	// incorrect syntax does not start with XX::...
		$this->assertEquals('|nl::kotelet', $result);
		$result = Sin::lang('nl::kotelet|::wrong');
		$this->assertEquals('kotelet', $result);
		$result = Sin::lang('nl::kotelet|de::kotelett');	// en not found
		$this->assertEquals('kotelet', $result);
		$result = Sin::lang('nl::kotelet|EN_en::wrong');	// en not found
		$this->assertEquals('kotelet', $result);
	}

	public function testArrayVersion() {
		$result = Sin::lang(['nl'=>'kotelet','en'=>'cutlet']);
		$this->assertEquals('cutlet', $result);
	}
}
