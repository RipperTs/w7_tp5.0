<?php
/**
 * tp5_web模块小程序接口定义
 *
 * @author caiyunduoduo
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Tp5_webModuleWxapp extends WeModuleWxapp {

    /**
     * 加载ThinkPHP框架
     * @param $name
     * @param $arguments
     * @return false|void|null
     */
    public function __call($name, $arguments)
    {
        header('Access-Control-Allow-Origin: *');//允许跨域请求
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');
        header('Access-Control-Allow-Credentials: true');//允许跨域请求
        include __DIR__.'/index.php';
        exit;
    }

}