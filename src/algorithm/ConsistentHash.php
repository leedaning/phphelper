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

    final public function __construct($type='')
    {
        if (!empty($type) && $type == 'virtual_node') {
            self::$hashRing = $this->setVirtualHashRing();
        }else{
            self::$hashRing = $this->getHashRing();
        }
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
     * 方法一，映射关系
     * [reflect 映射关系获取结点]
     * 通过维护一个映射关系，来获取其所在的结点
     * @method   reflect
     * @param    array                    $params [description]
     * @return   [type]                           [description]
     * @DateTime 2022-11-29T14:58:16+0800
     * @Author   Leen
     */
    public function reflect($params=[])
    {

        $hostsMap = [
            'img1.nede.com' => [
                    'logo1.png',
                    'logo2.png'
                ],
            'img2.node.com' => [
                    'logo3.png',
                    'logo4.png'
                ],
            'img3.node.com' => [
                    'logo5.png',
                    'logo6.png'
                ],
        ];
        foreach ($hostsMap as $node => $imgNames) {
            if (in_array($params['imgName'], $imgNames)) {
                return $node;
            }
        }
        return current(array_keys($hostsMap));
    }

    /**
     * 方法二：hash取余
     * [hashMod hash取余]
     * @method   hashMod
     * @param    array                    $params [description]
     * @return   [type]                           [description]
     * @DateTime 2022-11-29T15:05:31+0800
     * @Author   Leen
     */
    public function hashMod($params=[])
    {
        $hostsMap = ['img1.nede.com', 'img2.node.com', 'img3.node.com'];
        // $mod = abs(fmod(crc32($params['imgName']), count($hostsMap)));
        $mod = crc32($params['imgName']) % count($hostsMap);
        echo PHP_EOL . '<BR>mod:';print_r($mod);
        if ($mod) {
            return $hostsMap[$mod];
        }
        return current($hostsMap);
    }

    /**
     * 方法三，hash环
     * [hashRing 根据参数值获取数据对应存储的结点]
     * @method   hashRing
     * @param    array                    $params [description]
     * @return   [type]                           [description]
     * @DateTime 2022-11-29T14:44:34+0800
     * @Author   Leen
     */
    public function hashRing($params = [])
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

    /**
     * 对每个结点进行虚拟结点，解决hash环分布不均匀的问题
     * [virtualHashRing description]
     * @method   virtualHashRing
     * @param    array                    $params [description]
     * @return   [type]                           [description]
     * @DateTime 2022-11-30T10:36:58+0800
     * @Author   Leen
     */
    public function virtualHashRing($params=[])
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
     * [setVirtualHashRing 对hash环结点进行虚拟化结点]
     * @method   setVirtualHashRing
     * @DateTime 2022-11-30T10:47:53+0800
     * @Author   Leen
     */
    public function setVirtualHashRing()
    {

        $hostsMap = ['img1.nede.com', 'img2.node.com', 'img3.node.com'];
        $hashRing = [];
        //将节点映射到hash环上面
        if (empty($hashRing)) {
            for ($i=0; $i < 10; $i++) {
                foreach ($hostsMap as $h) {
                    $hostKey = fmod(crc32($h . $i), pow(2, 32));
                    $hostKey = abs($hostKey);
                    $hashRing[$hostKey] = $h;
                }
            }
            //从小到大排序，便于查找
            ksort($hashRing);
        }
        return $hashRing;
    }
}
