<?php
namespace leen\phphelper\string;

/**
 * 字符串处理类
 * @Author: Leen
 * @Date:   2021-01-06 14:57:03
 * @Email:  leeningln@163.com
 * @Last Modified By : Leen
 */
class Handle
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
     * [encodeChange 字符串编码转换]
     * @method   encodeChange
     * @param    [type]                   $str          [字符串]
     * @param    string                   $targetEncode [目标编码，如：UTF-8]
     * @return   [type]                                 [description]
     * @DateTime 2021-01-06T14:57:50+0800
     * @Author   Leen
     */
    public static function encodeChange($str, $targetEncode = 'UTF-8')
    {
        $encode = mb_detect_encoding($str, array("ASCII", 'UTF-8', "GB2312", "GBK", 'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16', 'Windows-1251', 'Windows-1252', 'Windows-1254'));
        return mb_convert_encoding($str, $targetEncode, $encode);
    }
}
