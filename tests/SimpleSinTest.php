<?php
use PHPUnit\Framework\TestCase;
use Cosninix\Sin\Sin;

require_once('ConfigFaker.php');
/**
 * Class SimpleSinTest
 * @version 1.0
 * @Author Ronald vanWoensel <rvw@cosninix.com>
 */
class SimpleSinTest extends TestCase {

   	public function testString() {
        $config = new ConfigFaker();
   		$obj = new Sin($config);
   		$result=$obj->lang('de::german|en::english');
   		$this->assertEquals('english',$result);
    }
}
