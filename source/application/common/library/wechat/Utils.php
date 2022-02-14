<?php


namespace app\common\library\wechat;

use app\common\exception\BaseException;
use app\common\model\Wxapp as WxappModel;

/**
 * 微信公众号工具类
 * Class Utils
 * @package app\common\library\wechat
 */
class Utils extends WxBase
{

    // 授权系统类型
    private $systemType = [
        'super' => '@super_admin',
        'admin' => '@admin',
        'front' => '@front',
    ];

    /**
     * 返回wx.config所需参数
     * @param $url
     * @return array
     * @throws BaseException
     */
    public function signature($url)
    {
        $time = time();
        $noncestr = uniqid();
        $sign = [
            'noncestr' => $noncestr,
            'jsapi_ticket' => $this->getTicket(),
            'timestamp' => $time,
            'url' => $url
        ];
        // TODO: 校验签名
        $sign = $this->makeSign($sign);
        return [
            'appId' => $this->appId,
            'timestamp' => $time,
            'nonceStr' => $noncestr,
            'signature' => $sign
        ];
    }

    /**
     * 生成签名
     * @param $values
     * @return string
     */
    private function makeSign($values)
    {
        // 签名步骤一：按字典序排序参数
        ksort($values);
        // 签名步骤二: 转换url参数
        $string = $this->toUrlParams($values);
        return sha1($string);
    }

    /**
     * 格式化参数格式化成url参数
     * @param $values
     * @return string
     */
    private function toUrlParams($values)
    {
        $buff = '';
        foreach ($values as $k => $v) {
            if ($k != 'sign' && $v != '' && !is_array($v)) {
                $buff .= $k . '=' . $v . '&';
            }
        }
        return trim($buff, '&');
    }

    /**
     * 检查域名授权
     * @return array|int[]
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function checkDomain($type = '')
    {
        $wxConfig = WxappModel::detail()->toArray();
        if (!cache($wxConfig['wxapp_id'] . '@checkDomain' . $this->systemType[$type])) {
            if (!array_key_exists($type, $this->systemType)) return ['code' => 0, 'msg' => '授权验证失败'];
            $url = str_replace(['http://', 'https://'], ['', ''], request()->domain());
            $time = time();
            // TODO: 加密算法如下,请求url+网站识别码+当前时间戳+当前系统类型 执行MD5加密
            $data = [
                'identifier' => $wxConfig['identifier'],
                'sign' => md5($url . $wxConfig['identifier'] . $time . $this->systemType[$type]),
                'timestamp' => $time
            ];
            $result = curlPost('https://auth.axa2.com/index.php?s=/api/Domain/check', $data);
            $result = json_decode($result, true);
            // 仅成功缓存
            if ($result['code'] == 0) {
                return $result;
            }
            cache($wxConfig['wxapp_id'] . '@checkDomain' . $this->systemType[$type], $result, 300);
        }
        return cache($wxConfig['wxapp_id'] . '@checkDomain' . $this->systemType[$type]);
    }

}