<?php

namespace app\common\library\wechat;

use app\api\model\Wxapp;

/**
 * 微信小程序用户管理类
 * Class WxUser
 * @package app\common\library\wechat
 */
class WxUser extends WxBase
{
    /**
     * 获取session_key
     * @param $code
     * @return array|mixed
     */
    public function sessionKey($code)
    {
        /**
         * code 换取 session_key
         * ​这是一个 HTTPS 接口，开发者服务器使用登录凭证 code 获取 session_key 和 openid。
         * 其中 session_key 是对用户数据进行加密签名的密钥。为了自身应用安全，session_key 不应该在网络上传输。
         */
        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $result = json_decode(curl($url, [
            'appid' => $this->appId,
            'secret' => $this->appSecret,
            'grant_type' => 'authorization_code',
            'js_code' => $code
        ]), true);
        if (isset($result['errcode'])) {
            $this->error = $result['errmsg'];
            return false;
        }
        return $result;
    }

    /**
     * 拼接引导用户进入授权页面的链接获取code
     * @return string
     */
    public function getCode()
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize";
        $wxConfig = Wxapp::getWxappCache();
        $redirect_uri = $wxConfig['redirect_uri'] . "/login/login/";
        $response_type = "code";
        $scope = "snsapi_userinfo";
        $state = "STATE#wechat_redirect";
        return $url . '?appid=' . $this->appId . '&redirect_uri=' . $redirect_uri . '&response_type=' . $response_type . '&scope=' . $scope . '&state=' . $state;
    }

    /**
     * code 换取 session_key
     * @param $code
     * @return bool|mixed
     */
    public function getAccessTokenWeb($code)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token";
        $result = json_decode(curl($url, [
            'appid' => $this->appId,
            'secret' => $this->appSecret,
            'code' => $code,
            'grant_type' => 'authorization_code'
        ]), true);
        if (isset($result['errcode'])) {
            $this->error = $result['errmsg'];
            return false;
        }
        return $result;
    }

    /**
     * session_key 换取 用户信息
     * @param $data
     * @return bool|mixed
     */
    public function getUserInfo($data)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo";
        $result = json_decode(curl($url, [
            'access_token' => $data['access_token'],
            'openid' => $data['openid'],
            'lang' => "zh_CN"
        ]), true);
        if (isset($result['errcode'])) {
            $this->error = $result['errmsg'];
            return false;
        }
        return $result;
    }

}