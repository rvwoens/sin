<?php namespace Cosninix\Sin;

use Illuminate\Support\Facades\Facade;

/**
 * Class SinFacade
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class SinFacade extends Facade {
	protected static function getFacadeAccessor() {
		return SinServiceProvider::SINCLASS;
	}
}
