<?php

namespace app\common\library\wechat;

/**
 * 小程序用户加密数据解密服务类
 * Class WxBizDataCrypt
 */
class WxBizDataCrypt extends WxBase
{
    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;


    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData($encryptedData, $sessionKey, $iv, &$data)
    {
        if (strlen($sessionKey) != 24) {
            return self::$IllegalAesKey;
        }
        $aesKey = base64_decode($sessionKey);


        if (strlen($iv) != 24) {
            return self::$IllegalIv;
        }
        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj = json_decode($result);
        if ($dataObj == NULL) {
            return self::$IllegalBuffer;
        }
        if ($dataObj->watermark->appId != $this->appId) {
            return self::$IllegalBuffer;
        }
        $data = $result;
        return self::$OK;
    }

}

