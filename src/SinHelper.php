<?php   // define helper function in global namespace
/**
 * @Author Ronald van Woensel <rvw@cosninix.com>
 */
if (!function_exists('sinlang')) {
    /**
     * Sin::lang helper
     * @param $file
     * @return string
     */
    function sinlang() {
        // call with same arguments given to sinlang()
        return call_user_func_array(array(app(\Cosninix\Sin\SinServiceProvider::SINCLASS), "lang"), func_get_args());
    }
}
