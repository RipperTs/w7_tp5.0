<?php
//判断php版本
if(version_compare(PHP_VERSION,'7.1.0','<'))  die('require PHP >= 7.1.0 !');

// [ 应用入口文件 ]

// 定义运行目录
define('WEB_PATH', __DIR__ . '/');

// 定义应用目录
define('APP_PATH', WEB_PATH . '../source/application/');

// 加载框架引导文件
require APP_PATH . '../thinkphp/start.php';
