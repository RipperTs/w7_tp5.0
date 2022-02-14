<?php

namespace app\store\controller;

use app\store\model\Wxapp as WxappModel;

/**
 * 小程序管理
 * Class Wxapp
 * @package app\store\controller
 */
class Wxapp extends Controller
{
    public function setting()
    {
        // 当前小程序信息
        $model = WxappModel::detail();
        if (!$this->request->isAjax()) {
            // 证书目录
            $filePath = APP_PATH . 'common/library/wechat/cert/' . MODULE_UNIACID . '/';
            $cert = file_get_contents($filePath . 'cert.pem');
            $key = file_get_contents($filePath . 'key.pem');
            $pem = [
                'cert' => $cert,
                'key' => $key,
            ];
            return $this->fetch('setting', compact('model', 'pem'));
        }
        // 更新小程序设置
        if ($model->edit($this->postData('wxapp'))) {
            return $this->renderSuccess('更新成功');
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 下载程序包文件
     * @return mixed
     */
    public function down()
    {
        return $this->fetch();
    }

}
