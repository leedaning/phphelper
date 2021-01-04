<?php
namespace phphelper\http;

/**
 * 时间处理相关
 * @Author: Leen
 * @Date:   2021-01-04 16:38:59
 * @Email:  lining@yoozoo.com
 * @Last Modified By : Leen
 */
class TimeReleated
{

    private static $_instance = null;
    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if ( !(self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * [timeHandle 将制定日期往前或往后推一段时间，支持批量处理]
     * @method   timeHandle
     * @param    [type]                   $times  [时间戳数组]
     * @param    [type]                   $offset [时间偏移量]
     * @param    string                   $type   [偏移类型，+:往后偏移; -:往前偏移;]
     * @return   [type]                           [description]
     * @DateTime 2021-01-04T16:49:52+0800
     * @Author   Leen
     */
    public static function timeHandle($times, $offset=60*60*24, $type='-')
    {
        $timeArr = [];
        foreach ($times as $key => $value) {
            switch ($type) {
                case '+':
                    $timeArr[$key] = $value - $offset;
                    break;
                case '-':
                default:
                    $timeArr[$key] = $value - $offset;
                    break;
            }
        }
        return $timeArr;
    }

    /**
     * [createDateArr 生成指定日期段做为value的数组，或多维数组]
     * @method   createDateArr
     * @param    [type]                   $start_time  [开始日期，可以是时间戳也可以是日期格式（至少包含年月日）]
     * @param    [type]                   $end_time    [结束日期，可以是时间戳也可以是日期格式（至少包含年月日）]
     * @param    string                   $date_format [日期格式，如Ymd]
     * @param    [type]                   $step        [间隔秒数，如：60*60*24]
     * @param    array                    $field       [二维数组中的字段]
     * @return   [type]                                [description]
     * @DateTime 2021-01-04T16:50:27+0800
     * @Author   Leen
     */
    public static function createDateArr($start_time, $end_time, $date_format='Ymd', $step=60*60*24, $field=[])
    {
        $start_time = strtotime($start_time) ? strtotime($start_time) : $start_time;
        $end_time = strtotime($end_time) ? strtotime($end_time) : $end_time;
        if (abs($start_time-$end_time)>=$step) {
            $arr = range($start_time, $end_time, $step);
        }else{
            $arr = [$start_time];
        }
        $date_arr = [];
        // 方法一：
        array_walk($arr, function(&$item, $key) use($field, &$date_arr, $date_format){
            // $date_arr[date($date_format, $item)] = $field;       // 生成指定日期段做为key的数组
            $date_arr[] = date($date_format, $item);        // 生成指定日期段做为value的数组
        });
        return $date_arr;
    }
}