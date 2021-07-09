<?php
namespace leen\phphelper\common;

/**
 * 获取各种信息功能的类
 * @Author: Leen
 * @Date:   2021-01-06 15:15:28
 * @Email:  leeningln@163.com
 * @Last Modified By : Leen
 */
class GetInfo
{

    private static $_instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * [getOS 获取用户浏览器请求时所处的操作系统]
     * @method   getOS
     * @return   [type]                   [description]
     * @DateTime 2021-01-06T15:17:50+0800
     * @Author   Leen
     */
    public static function getOS()
    {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

        if (strpos($agent, 'windows nt')) {
            $platform = 'windows';
        } elseif (strpos($agent, 'macintosh')) {
            $platform = 'mac';
        } elseif (strpos($agent, 'ipod')) {
            $platform = 'ipod';
        } elseif (strpos($agent, 'ipad')) {
            $platform = 'ipad';
        } elseif (strpos($agent, 'iphone')) {
            $platform = 'iphone';
        } elseif (strpos($agent, 'android')) {
            $platform = 'android';
        } elseif (strpos($agent, 'unix')) {
            $platform = 'unix';
        } elseif (strpos($agent, 'linux')) {
            $platform = 'linux';
        } else {
            $platform = 'other';
        }
        return $platform;
    }

    /**
     * [getOS2 获取操作系统]
     * @method   getOS2
     * @return   [type]                   [description]
     * @DateTime 2021-01-06T15:18:02+0800
     * @Author   Leen
     */
    private function getOS2()
    {
        $os = 0;
        $Agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/win/i', $Agent)) {
            $os = 0;
        } elseif (preg_match('/mac/i', $Agent)) {
            $os = 1;
        }
        return $os;
    }

}
