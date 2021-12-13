<?php
namespace leen\phphelper;

use leen\phphelper\http\Curl;
use \leen\phphelper\time\Time;
use leen\phphelper\Test;
use leen\phphelper\number\Number;

/**
 * @Author: Leen
 * @Date:   2021-01-04 16:14:21
 * @Email:  leeningln@163.com
 * @Last Modified By : Leen
 */

// 自动加载一：php spl_autoload_register
/*spl_autoload_register(function ($class) {
    if ($class) {
        $file = str_replace('\\', '/', $class);
        $file .= '.php';
        $file = '../' . $file;
        if (file_exists($file)) {
            include "$file";
        }
    }
});*/

// 自动加载二：composer autoload
// print_r(require_once __DIR__ . '/vendor/autoload.php');die;
require_once __DIR__ . '/vendor/autoload.php';


Curl::getInstance();
Time::getInstance();
Test::getInstance();

echo PHP_EOL . '<BR><BR>';
$time = 2147483648;
$date = Time::timeToDate($time, 'Y-m-d H:i:s' , 'UTC');
// $date = date('Y-m-d H:i:s', $time);
echo PHP_EOL . '<BR>time:' . $time;
echo PHP_EOL . '<BR>date:' . $date;

$time = Time::dateToTime($date);
// $time = strtotime($date);
echo PHP_EOL . '<BR>time:' . $time;

$pi = 3.1415926;
echo PHP_EOL . '<BR>pi:'.$pi;
echo PHP_EOL . '<BR>pi:'. Number::numFormate($pi, 3, 'percentage');

