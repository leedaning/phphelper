<?php
namespace leen\phphelper;

/**
 * @Author: Leen
 * @Date:   2021-01-05 16:12:23
 * @Email:  lining@yoozoo.com
 * @Last Modified By : Leen
 */
class Test
{

    private static $_instance = null;
    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        die('Test leen');
        if ( !(self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}