<?php namespace Cosninix\Sin;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;
use Laravel\Lumen\Application as LumenApplication;

/**
 * Class SinServiceProvider
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class SinServiceProvider extends ServiceProvider {
	const SINIOC = 'Sin';

	/**
	 * Boot the service provider.
	 * Register blade @sin(..)
	 */
	public function boot() {
		Blade::directive('slang', function ($expression) {
			return "<?php echo ___($expression); ?>";
		});
	}

	/**
	 * Register the service provider.
	 */
	public function register() {
		$this->app->singleton(self::SINIOC, function ($app) {
			return $this->createSinClient($app['config']);
		});
		require_once(__DIR__ . DIRECTORY_SEPARATOR. 'SinHelper.php');
	}


	/**
	 * Get the services provided by the provider
	 * @return array
	 */
	public function provides() {
		return [self::SINIOC];
	}

	/**
	 * @param Config $config
	 * @return Client
	 */
	protected function createSinClient(Config $config) {
		return new SinBase($config);
	}
}
