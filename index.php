<?php
namespace leen\phphelper;

use leen\phphelper\http\Curl;
use \leen\phphelper\time\Time;
use leen\phphelper\Test;

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
