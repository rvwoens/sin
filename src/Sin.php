<?php namespace Cosninix\Sin;

use Illuminate\Support\Facades\Facade;

/**
 * Class SinFacade
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class Sin extends Facade {
	protected static function getFacadeAccessor() {
		return SinServiceProvider::SINIOC;
	}
}
