<?php namespace Cosninix\Sin;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;
use Laravel\Lumen\Application as LumenApplication;

/**
 * Class SinServiceProvider
 * @package Cosninix\Sin
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class SinServiceProvider extends ServiceProvider {
    const SINCLASS = 'Sin';

    /**
     * Boot the service provider.
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register() {
        $this->app->singleton(self::SINCLASS, function($app) {
            return $this->createSinClient($app['config']);
        });
        require_once(__DIR__ . DIRECTORY_SEPARATOR. 'SinHelper.php');
    }


    /**
     * Get the services provided by the provider
     * @return array
     */
    public function provides() {
        return [self::SINCLASS];
    }

    /**
     * @param Config $config
     * @return Client
     */
    protected function createSinClient(Config $config) {
        return new Sin($config);
    }
}
