<?php
namespace leen\phphelper\number;

/**
 * 数字处理类
 * @Author: Leen
 * @Date:   2021-12-13 15:59:02
 * @Email:  leeningln@163.com
 * @Last Modified By : Leen
 */
class Number
{

    /**
     * [numFormate 保留两位小数]
     * @method   numFormate
     * @param    [type]                   $number [要处理的数字]
     * @param    int|integer              $len    [位数]
     * @param    string                   $opty   [操作类型，percentage:转换为百分比;默认不做处理]
     * @return   [type]                           [description]
     * @DateTime 2021-12-13T16:05:34+0800
     * @Author   Leen
     */
    public static function numFormate($number, int $len=2, $opty = '')
    {
        if (!empty($opty) && $opty = 'percentage') {
            $num = sprintf("%01." .$len . "f", $number * 100) . '%'; // 保留两位小数
        } else {
            $num = sprintf("%01." .$len . "f", $number); // 保留两位小数
        }
        return $num;
    }
}