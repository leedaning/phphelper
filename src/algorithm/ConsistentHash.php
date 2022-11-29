<?php
namespace leen\phphelper\algorithm;

/**
 * 一致性hash
 * @Author: Leen
 * @Date:   2022-11-28 18:14:23
 * @Email:  leeningln@163.com
 * @Last Modified By : Leen
 */
class ConsistentHash
{
    protected static $hashRing;
    protected static $_instance = null;

    final public function __construct()
    {
        self::$hashRing = $this->getHashRing();
    }
    final public function __clone(){}

    public static function getInstance()
    {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * [getNode 根据参数值获取数据对应存储的结点]
     * @method   getNode
     * @param    array                    $params [description]
     * @return   [type]                           [description]
     * @DateTime 2022-11-29T14:44:34+0800
     * @Author   Leen
     */
    public function getNode($params = [])
    {

        //计算图片hash
        $imgKey = fmod(crc32($params['imgName']), pow(2, 32));
        $imgKey = abs($imgKey);

        foreach (self::$hashRing as $hostKey => $h) {
            if ($imgKey < $hostKey) {
                return $h;
            }
        }
        return current(self::$hashRing);
    }

    /**
     * [getHashRing 获取hash环]
     * @method   getHashRing
     * @return   [type]                   [description]
     * @DateTime 2022-11-29T11:58:54+0800
     * @Author   Leen
     */
    public function getHashRing()
    {
        $hostsMap = ['img1.nede.com', 'img2.node.com', 'img3.node.com'];
        $hashRing = [];
        //将节点映射到hash环上面
        if (empty($hashRing)) {
            foreach ($hostsMap as $h) {
                $hostKey = fmod(crc32($h), pow(2, 32));
                $hostKey = abs($hostKey);
                $hashRing[$hostKey] = $h;
            }
            //从小到大排序，便于查找
            ksort($hashRing);
        }
        return $hashRing;
    }
}
