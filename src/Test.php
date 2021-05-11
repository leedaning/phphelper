<?php
namespace leen\phphelper;

// include './time/Time.php';
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

    /**
     * [search 查询]
     * @method   search
     * @param    [date/int]                   $start_time [开始时间/日期]
     * @param    [date/int]                   $end_time   [结束时间/日期]
     * @return   [type]                                   [description]
     * @DateTime 2021-05-11T10:11:02+0800
     * @Author   Leen
     */
    public static function search()
    {

        $start_time = $_REQUEST['start_time'] ?? '';
        $end_time = $_REQUEST['end_time'] ?? '';

        echo PHP_EOL . '<BR>start_time:';print_r($start_time);
        echo PHP_EOL . '<BR>end_time:';print_r($end_time);
        $start_time_type = Time::checkDateOrTime($start_time);
        $end_time_type = Time::checkDateOrTime($end_time);
        echo PHP_EOL . '<BR>start_time_type:';print_r($start_time_type);
        echo PHP_EOL . '<BR>end_time_type:';print_r($end_time_type);
    }
}

$obj = Test::getInstance();
// $obj = new Test();

echo PHP_EOL . '2147483648 日期：'.date('Y-m-d H:i:s', '2147483647');
$obj->getDateArr();
$obj->search();