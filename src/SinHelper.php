<?php   // define helper function in global namespace
/*
 * @Author Ronald van Woensel <rvw@cosninix.com>
 */
if (!function_exists('___')) {
	/**
	 * Sin::lang helper
	 * @param $file
	 * @return string
	 */
	function ___() {
		// call with same arguments given to ___()
		return call_user_func_array([app(\Cosninix\Sin\SinServiceProvider::SINIOC), "lang"], func_get_args());
	}
}
