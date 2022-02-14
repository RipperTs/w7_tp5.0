<?php

namespace app\api\controller;

use app\api\model\Wxapp as WxappModel;
use app\api\model\WxappHelp;
use app\common\model\Banner as BannerModel;
use app\common\library\wechat\Utils;
use app\common\model\Setting as SettingModel;

/**
 * 微信小程序
 * Class Wxapp
 * @package app\api\controller
 */
class Wxapp extends Controller
{
    /**
     * 小程序基础信息
     * @return array
     */
    public function base()
    {
        $wxapp = SettingModel::detail('store');
        return $this->renderSuccess($wxapp);
    }

    /**
     * 帮助中心
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function help()
    {
        $model = new WxappHelp;
        $list = $model->getList();
        return $this->renderSuccess(compact('list'));
    }

    /**
     * 轮播图列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function banner()
    {
        $bannerList = BannerModel::with('image')
            ->where(['status' => 10])
            ->order(['sort' => 'asc', 'update_time' => 'desc'])
            ->select();
        return $this->renderSuccess(compact('bannerList'));
    }


    /**
     * 获取wx.config 配置信息
     * @param $url
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function wechatUtil($url)
    {
        $wxConfig = WxappModel::getWxappCache();
        $utils = new Utils($wxConfig['app_id'], $wxConfig['app_secret']);
        $result = $utils->signature($url);
        // TODO: 分配JSSDK权限列表
        $result['jsApiList'] = [
            "onMenuShareAppMessage",
            "onMenuShareTimeline",
            "onMenuShareQQ",
            "onMenuShareWeibo",
            "onMenuShareQZone",
            "chooseWXPay"
        ];
        return $this->renderSuccess($result);
    }


}
