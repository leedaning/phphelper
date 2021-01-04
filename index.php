<?php
namespace phphelper;

use \phphelper\http\CurlReleated;
use \phphelper\http\TimeReleated;

/**
 * @Author: Leen
 * @Date:   2021-01-04 16:14:21
 * @Email:  lining@yoozoo.com
 * @Last Modified By : Leen
 */

spl_autoload_register(function ($class) {
    if ($class) {
        $file = str_replace('\\', '/', $class);
        $file .= '.php';
        $file = '../' . $file;
        if (file_exists($file)) {
            include "$file";
        }
    }
});

CurlReleated::getInstance();
TimeReleated::getInstance();

