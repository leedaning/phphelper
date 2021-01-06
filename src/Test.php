<?php
namespace leen\phphelper;

include './time/Time.php';
use leen\phphelper\time\Time;

/**
 * @Author: Leen
 * @Date:   2021-01-05 16:12:23
 * @Email:  lining@yoozoo.com
 * @Last Modified By : Leen
 */
class Test
{

    private static $_instance = null;
    private static $timeObj;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if ( !(self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /*public function __construct(Time $timeObj)
    {
        $this->timeObj = $timeObj;
    }*/

    public static function getDateArr()
    {
        self::$timeObj = Time::getInstance();
        echo self::$timeObj->current_time();
        echo '<BR><BR>';print_r(self::$timeObj::createDateArr('2021-01-01', '2021-01-06'));
    }
}

$obj = Test::getInstance();
// $obj = new Test();


$obj->getDateArr();