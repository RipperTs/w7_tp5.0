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

global $_GPC, $_W;

// 微擎模块
$m = $_GPC['m'];
// 防止报未定义uid错误
$_W['uid'] = isset($_W['uid']) ? $_W['uid'] : null;
// 定义当前模块
define('MODULE_NAME', $m);
// 获取全局小程序appid配置
define('WECHATAPPID', $_W['account']['key']);
define('WECHATSECRET', $_W['account']['secret']);
// 定义平台ID
define('MODULE_UNIACID', $_W['uniacid']);
// 定义当前框架跟目录(非微擎框架根目录)
define('ROOT_URL', '/');
// 定义运行目录
define('WEB_PATH', __DIR__ . '/web/');
// 定义应用目录
define('APP_PATH', WEB_PATH . '../source/application/');
// 定义模版静态文件访问公共地址
define('SITE_URL', '//' . $_SERVER['HTTP_HOST'] . '/addons/' . MODULE_NAME . '/web');
// 定义炮灰域名访问地址(非公开)
define('SITE_PATH', '/addons/' . MODULE_NAME . '/web/html/');
// 定义微擎登陆用户名
define('USER_NAME', isset($_W['username']) ? $_W['username'] : null);
// 定义微擎登陆用户ID
define('W7_UID', $_W['uid']);
// 微擎创办者权限
define('IS_FOUNDER', $_W['isfounder']);
// 微擎管理员权限
define('IS_ADMIN', $_W['isadmin']);
// 微擎登陆用户所有信息
define('W7_USER', $_W['user']);
// 定义think文件路径
define('THINKPATH', str_replace('\\', '/', dirname(dirname(__FILE__))) . '/' . $m . '/source');

// ThinkPHP路由规则处理
$tpM = $_GPC['do'] != $_GET['do'] && $_GET['do'] ? $_GET['do'] : $_GPC['do'];
$_GPC['tpp'] = $tpp = $_GPC['tpp'];
if (!empty($tpp)) {
    list($model, $controller, $method) = explode('/', $tpp);
}
empty($controller) && $controller = 'index';
empty($method) && $method = 'index';