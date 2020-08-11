<?php namespace Cosninix\Sin;
/**
 * @Author Ronald van Woensel <rvw@cosninix.com>
 */
if (!function_exists('sinlang')) {
    /**
     * Sin::lang helper
     * @param $file
     * @return string
     */
    function sinlang($text) {
        return app(SinServiceProvider::SINCLASS)->lang($text);
    }
}
