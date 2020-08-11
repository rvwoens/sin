<?php namespace Cosninix\Sin;

use Illuminate\Support\Facades\Facade;

/**
 * Class SinFacade
 * @package Cosninix\Sin
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class SinFacade extends Facade {
    protected static function getFacadeAccessor() {
        return Sin::class;
    }
}
