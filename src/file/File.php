<?php
namespace leen\phphelper\file;

/**
 * 文件相关功能类
 * @Author: Leen
 * @Date:   2021-01-06 15:06:52
 * @Email:  leeningln@163.com
 * @Last Modified By : Leen
 */
class File
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
     * [my_file_exists 判断文件是否存在，支持本地和远程]
     * @method   my_file_exists
     * @param    [type]                   $file [文件地址]
     * @return   [type]                         [description]
     * @DateTime 2021-01-06T15:07:36+0800
     * @Author   Leen
     */
    public static function my_file_exists($file)
    {
        if (preg_match('/^http:\/\//', $file)) {
            //远程文件
            if (ini_get('allow_url_fopen')) {
                if (@fopen($file, 'r')) {
                    return true;
                }

            } else {
                $parseurl = parse_url($file);
                $host = $parseurl['host'];
                $path = $parseurl['path'];
                $fp = fsockopen($host, 80, $errno, $errstr, 10);
                if (!$fp) {
                    return false;
                }

                fputs($fp, "GET {$path} HTTP/1.1 \r\nhost:{$host}\r\n\r\n");
                if (preg_match('/HTTP\/1.1 200/', fgets($fp, 1024))) {
                    return true;
                }

            }
            return false;
        } elseif (preg_match('/^https:\/\//', $file)) {
            //远程文件
            if (ini_get('allow_url_fopen')) {
                if (@fopen($file, 'r')) {
                    return true;
                }

            } else {
                $parseurl = parse_url($file);
                $host = $parseurl['host'];
                $path = $parseurl['path'];
                $fp = fsockopen("ssl://" . $host, 443, $errno, $errstr, 10);
                fputs($fp, "GET $path HTTP/1.1\r\n");
                fputs($fp, "Host: $host\r\n");
                fputs($fp, "Connection: close\r\n\r\n");
                if (preg_match('/HTTP\/1.1 200/', fgets($fp, 1024))) {
                    return true;
                }

                fclose($fp);
            }
            return false;
        }
        return file_exists($file);
    }
}
