<?php

namespace app\api\controller\user;

use app\api\controller\Controller;
use app\api\model\User as UserModel;
use app\api\model\Setting as SettingModel;
use app\common\library\wechat\WxBizDataCrypt;

/**
 * 个人中心主页
 * Class Index
 * @package app\api\controller\user
 */
class Index extends Controller
{
    /**
     * 获取当前用户信息
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        // 当前用户信息
        $user = $this->getUser(false);
        // 订单总数
        return $this->renderSuccess([
            'userInfo' => $user,
            'setting' => [
                'points_name' => SettingModel::getPointsName(),
            ],
            'menus' => (new UserModel)->getMenus()   // 个人中心菜单列表
        ]);
    }

    /**
     * 获取用户手机号接口
     * @param $encryptedData
     * @param $iv
     * @return array
     * @throws \app\common\exception\BaseException
     */
    public function getUserPhone($encryptedData, $iv)
    {
        $WxBizDataCrypt = new WxBizDataCrypt;
        $WxBizDataCrypt->decryptData($encryptedData, $this->getSessionKey(), $iv, $data);
        return $this->renderSuccess(json_decode($data, true));
    }


}
