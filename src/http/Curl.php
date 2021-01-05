<?php
namespace leen\phphelper\http;

/**
 * curl模拟http请求相关
 * @Author: Leen
 * @Date:   2021-01-04 14:47:28
 * @Email:  lining@yoozoo.com
 * @Last Modified By : Leen
 */
/**
 *
 */
class Curl
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
     * [send curl模拟http请求]
     * @method   send
     * @param    [type]                   $url          [请求的url]
     * @param    string                   $method       [请求方法，如：get, post, put, deleted]
     * @param    array                    $data         [请求的参数数据]
     * @param    boolean                  $https        [是否使用https，true:使用，false:不使用]
     * @param    integer                  $time_out     [超时时间]
     * @param    string                   $postDataType [post请求的请求数据格式，如:json]
     * @return   [type]                                 [description]
     * @DateTime 2021-01-04T14:52:23+0800
     * @Author   Leen
     */
    public static function send($url, $method='get', $data = array(), $https = false, $time_out=3, $postDataType='')
    {
        $user_agent =isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';

        $user_agent         =  $_SERVER['HTTP_USER_AGENT'];
        $curlPost = '';
        if(!empty($data)){
            $curlPost = http_build_query($data);
        }

        //初始化
        $curl = curl_init();
        if (strcasecmp($method, 'get')==0) {
            $url .= '?'.$curlPost;
        }elseif(strcasecmp($method, 'post')==0){
            curl_setopt($curl, CURLOPT_POST, 1);                        // 发送一个常规的Post请求
            if (isset($postDataType) && $postDataType=='json') {
                $jsonData = json_encode($data);
                $headers = array("Content-type: application/json;charset='utf-8'", "Accept: application/json", "Cache-Control: no-cache", "Pragma: no-cache",'Content-Length:' . strlen($jsonData));
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl,CURLOPT_POSTFIELDS,$jsonData);
            }else{
                curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);          // Post提交的数据包，可以是数组也可以是params1=1&params2=2
            }
        }

        if( $https )
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);              // 对认证证书来源的检查
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);              // 从证书中检查SSL加密算法是否存在
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);              // 使用自动跳转
        }

        curl_setopt($curl, CURLOPT_URL, $url);                      // 要访问的地址
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);                    // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0);                      // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);              // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_USERAGENT,$user_agent);          // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);                 // 自动设置Referer

        //执行并获取HTML文档内容
        $results = curl_exec($curl);

        //释放curl句柄
        curl_close($curl);

        //返回获得的数据
        return $results;
    }

}
