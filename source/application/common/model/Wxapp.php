<?php

namespace app\common\model;

use think\Cache;
use app\common\exception\BaseException;
use app\common\library\wechat\Utils;

/**
 * 微信小程序模型
 * Class Wxapp
 * @package app\common\model
 */
class Wxapp extends BaseModel
{
    protected $name = 'wxapp';


    /**
     * 小程序页面
     * @return \think\model\relation\HasOne
     */
    public function diyPage()
    {
        return $this->hasOne('WxappPage');
    }

    /**
     * 获取小程序信息
     * @param int|null $wxappId
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail($wxappId = null)
    {
        is_null($wxappId) && $wxappId = static::$wxapp_id;
        return static::get(['uniacid' => MODULE_UNIACID]);
    }

    /**
     * 从缓存中获取小程序信息
     * @param int|null $wxappId 小程序id
     * @return array $data
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function getWxappCache($wxappId = null)
    {
        // 小程序id
        is_null($wxappId) && $wxappId = static::$wxapp_id;
        if (!$data = Cache::get("wxapp_{$wxappId}_" . MODULE_UNIACID)) {
            // 获取小程序详情, 解除hidden属性
            $detail = self::detail($wxappId)->hidden([], true);
            if (empty($detail)) throw new BaseException(['msg' => '未找到当前小程序信息']);
            // 写入缓存
            $data = $detail->toArray();
            Cache::tag('cache')->set("wxapp_{$wxappId}_" . MODULE_UNIACID, $data);
        }
        return $data;
    }

    /**
     * 获取share_url
     * @param $wxappId
     * @param $key
     * @return string
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function baseApiUrl($key, $wxappId = '')
    {
        is_null($wxappId) && $wxappId = static::$wxapp_id;
        $wxConfig = self::getWxappCache($wxappId);
        $returnUrl = baseApiUrl($wxConfig['redirect_uri'], 'generate/redirects&key=' . $key . '&wxapp_id=' . $wxappId);
        // 长链接转短链接
//        $utils = new Utils('wx7433459b12dec40b', '373a543f2ac43481d4b7c13877be195c');
//        $result = $utils->shorturl($returnUrl);
//        if ($result['errcode'] == 0) {
//            return $result['short_url'];
//        }
        return $returnUrl;
    }

}
