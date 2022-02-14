<?php

namespace app\store\controller;

use app\store\model\store\User as StoreUser;
use think\Session;

/**
 * 商户认证
 * Class Passport
 * @package app\store\controller
 */
class Passport extends Controller
{
    /**
     * 商户后台登录
     * @return array|bool|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login()
    {
        if ($this->request->isAjax()) {
            $model = new StoreUser;
            if ($model->login($this->postData('User'))) {
                return $this->renderSuccess('登录成功', siteUrl('index/index'));
            }
            return $this->renderError($model->getError() ?: '登录失败');
        }
        $this->view->engine->layout(false);
        return $this->fetch('login', [
            // 系统版本号
            'version' => IMS_VERSION
        ]);
    }


    /**
     * 退出登录
     */
    public function logout()
    {
        Session::clear('tp5_web_store');
        $url = request()->domain() . "/web/index.php?c=account&a=manage&iscontroller=1";
        echo '<script>alert("退出成功");window.location.href="' . $url . '"</script>';
        exit;
    }


}
