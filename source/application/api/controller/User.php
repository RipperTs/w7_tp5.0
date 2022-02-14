<?php

namespace app\api\controller;

use app\api\model\User as UserModel;
use app\common\library\wechat\WxUser;
use app\api\model\Wxapp;

/**
 * 用户管理
 * Class User
 * @package app\api
 */
class User extends Controller
{

    /**
     * 微信公众号登录
     */
    public function userLogin($code)
    {
        $wxConfig = Wxapp::getWxappCache(); // 从缓存中获取微信公众号信息
        $WxUser = new WxUser($wxConfig['app_id'], $wxConfig['app_secret']);
        $data = $WxUser->getAccessTokenWeb($code);      // 用code换取AccessToken
        $userInfo = $WxUser->getUserInfo($data);        // 用AccessToken获取用户信息
        $userInfo = $this->organizeUserInfo($userInfo, request()->param());  // 将微信公众号返回的用户信息整理成和萤火用户表吻合
        $model = new UserModel;
        return $this->renderSuccess($model->loginH5($userInfo), '登陆成功');     // 执行微信登录，用户信息入库，生成 token 等操作，然后将 user_id 和 token 返回给前台
    }

    /**
     * 将微信公众号返回的用户信息整理成和用户表吻合的数据
     * @param $userInfo
     * @return array
     */
    private function organizeUserInfo($userInfo, $param)
    {
        return [
            'open_id' => $userInfo['openid'],
            'nickName' => $userInfo['nickname'],
            'avatarUrl' => $userInfo['headimgurl'],
            'gender' => $userInfo['sex'],
            'country' => $userInfo['country'],
            'province' => $userInfo['province'],
            'city' => $userInfo['city'],
            'wxapp_id' => $param['wxapp_id']
        ];
    }

    /**
     * 用户自动登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login()
    {
        $model = new UserModel;
        return $this->renderSuccess([
            'user_id' => $model->login($this->request->post()),
            'token' => $model->getToken()
        ]);
    }

    /**
     * 生成引导用户进入授权页面的链接,返回给前端
     * @return array
     * @throws \think\exception\DbException
     */
    public function getCode()
    {
        $wxConfig = Wxapp::getWxappCache();
        $WxUser = new WxUser($wxConfig['app_id'], $wxConfig['app_secret']);
        $url = $WxUser->getCode();
        return $this->renderSuccess(compact('url'));
    }

    /**
     * 当前用户详情
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        // 当前用户信息
        $userInfo = $this->getUser();
        return $this->renderSuccess(compact('userInfo'));
    }

}
