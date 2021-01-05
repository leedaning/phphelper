<?php

namespace leen\phphelper\export;

/**
 * php导出大量数据到excel
 * @Author: Leen
 * @Date:   2021-01-05 11:56:58
 * @Email:  lining@yoozoo.com
 * @Last Modified By : Leen
 */

class Excel
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
     * [exportToExcel 导出大量数据到excel]
     * @method   exportToExcel
     * @param    [type]                   $data     [导出的数据; eg:[['name'=>'leen', 'sex'=>'male', 'weight'=>'60'], ['name'=>'leedaning', 'weight'=>'60']]]
     * @param    [type]                   $columns  [导出的列的key的数组，取值时是根据data中每个行数据的key取值; eg:['name', 'sex', 'weight'];]
     * @param    [type]                   $titles   [header名称; eg:['姓名', '性别', '体重']，没有用到]
     * @param    string                   $fileName [导出的文件名称]
     * @param    string                   $fileExt  [导出的文件格式，必须为csv]
     * @return   [type]                             [description]
     * @DateTime 2021-01-05T11:58:06+0800
     * @Author   Leen
     */
    public static function exportToExcel($data, $columns, $titles, $fileName = 'file', $fileExt = 'csv')
    {
        ini_set('memory_limit','1024M');
        // ini_set('max_execution_time',0);
        set_time_limit(0);
        ob_end_clean();
        ob_start();
        header( 'Content-Type: text/csv' );
        // header( 'Content-Disposition: attachment;filename='.$fileName.$fileExt); //attachment新窗口打印inline本窗口打印
        header('Content-Disposition:attachment;filename="' . $fileName . '.csv"');
        $fp = fopen('php://output', 'a');
        mb_convert_variables('GBK', 'UTF-8', $columns);
        fputcsv($fp, $columns);

        // 如果是大量数据可以在这里循环从数据库中获取，比如，每次获取1000条

        foreach ($data as $key => $val) {
            $outData = [];
            foreach ($columns as $k => $v) {
                mb_convert_variables('GBK', 'UTF-8', $val[$v]);
                $outData[$v] = isset($val[$v]) ? $val[$v] : '';
            }
            if ($key % 1000 == 0) {
                ob_flush();
                flush(); //必须同时使用ob_flush()和flush()函数来刷新输出缓冲。
            }
            fputcsv($fp, $outData);
        }
        ob_flush();
        flush();
        fclose($fp);
        ob_end_clean();
        exit;           // 必须加，不然会报错：yii\web\HeadersAlreadySentException: Headers already sent in
    }
}