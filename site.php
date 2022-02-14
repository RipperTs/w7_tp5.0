<?php
/**
 * tp5_web模块微站定义
 *
 * @author caiyunduoduo
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Tp5_webModuleSite extends WeModuleSite
{

    /**
     * 加载ThinkPHP入口文件
     * @param $name
     * @param $arguments
     * @return false|void|null
     */
    public function __call($name, $arguments)
    {
        include __DIR__ . '/index.php';
        exit;
    }


}