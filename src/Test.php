<?php
namespace leen\phphelper;

// include './time/Time.php';
use leen\phphelper\time\Time;

/**
 * @Author: Leen
 * @Date:   2021-01-05 16:12:23
 * @Email:  leeningln@163.com
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

    /**
     * [verifyStrtotime 验证strtotime函数的问题]
     * 临界值：
     * 1620366999
     * 1620367000
     * 临界值：
     * 1620609999
     * 1620610000
     * @method   verifyStrtotime
     * @param    string                   $times [description]
     * @return   [type]                          [description]
     * @DateTime 2021-07-09T14:51:20+0800
     * @Author   Leen
     */
    public static function verifyStrtotime($times)
    {
        echo PHP_EOL . '<BR>times:';var_dump($times);
        $date = date('Y-m-d H:i:s', $times);
        echo PHP_EOL . '<BR>date:';var_dump($date);
    }
}

$obj = Test::getInstance();
// $obj = new Test();
/*1620366999
1620367000*/
/*echo PHP_EOL . '2147483648 日期：'.date('Y-m-d H:i:s', '2147483647');
$obj->getDateArr();
$obj->search();*/

$times = isset($_REQUEST['times']) ? $_REQUEST['times'] : time();
Test::verifyStrtotime($times);

$date = Time::dtPeriod($times, $fmt = 'Y-m-d', 60 * 60 * 24 * 7);
echo PHP_EOL . '<BR>data:';print_r($date);
