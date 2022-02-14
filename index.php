<?php
// +----------------------------------------------------------------------
// | ThinkPHP BY W7 [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://wslmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Company ( 沈阳创彩科技有限公司 )
// +----------------------------------------------------------------------
// | Author: wslmf <wangyifani@foxmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;
//强制php版本
if (version_compare(PHP_VERSION, '7.1.0', '<')) die('require PHP >= 7.1.0 !');

// 处理微擎ThinkPHP路由规则
require __DIR__ . '/start.php';

// 加载ThinkPHP框架
require __DIR__ . '/source/thinkphp/base.php';

// 注册并绑定路由规则
Route::bind($tpM . "/" . $controller . "/" . $method);
App::route(false);
// 执行应用并响应
App::run()->send();
