<?php namespace Cosninix\Sin;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * Class SinServiceProvider
 * @package Cosninix\Sin
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class SinServiceProvider extends ServiceProvider {
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
        $this->app->singleton(Sin::class, function($app) {
            return $this->createSinClient($app['config']);
        });
    }


    /**
     * Get the services provided by the provider
     * @return array
     */
    public function provides() {
        return [Sin::class];
    }

    /**
     * @param Config $config
     * @return Client
     */
    protected function createSinClient(Config $config) {
        return new Sin($config->get('app.language'));
    }
}
