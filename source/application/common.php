<?php

// 应用公共函数库文件

use think\Request;
use think\Log;


if (!function_exists('tp_url')) {
    /**
     * tp_Url生成
     * @param string $url 路由地址
     * @param string|array $vars 变量
     * @param bool|string $suffix 生成的URL后缀
     * @param bool|string $domain 域名
     * @return string
     */
    function tp_url($url = '', $tpp = '')
    {
        return request()->domain() . '/web/index.php?m=' . MODULE_NAME . '&c=site&a=entry&do=' . $url . '&tpp=' . $tpp;
    }
}

/**
 * 获取api接口请求地址
 * @param $str
 * @return string
 */
function baseApiUrl($url = '', $str = '')
{
    $url = empty($url) ? request()->domain() : $url;
    return $url . '/app/index.php?m=' . MODULE_NAME . '&c=entry&a=wxapp&i=' . MODULE_UNIACID . '&do=api&tpp=/' . $str;
}


if (!function_exists('siteUrl')) {
    /**
     * 生成url
     * @param string $url 路由地址,类似于tp5的url()函数的第一个参数 如：index/index/hello
     * @param string $vars 路由参数
     * @param string $weDoor 微擎入口 web-Web端入口,app-App端入口
     * @return array|string
     */
    function siteUrl($url = '', $vars = '', $weDoor = '')
    {
        global $_GPC, $_W;
        $param = $url;
        if (empty($weDoor)) {
            $baseUrl = request()->baseUrl(true);
            if (isset($_GPC["i"])) {
                list($i, $c, $a) = [$_W["uniacid"], "entry", "site"];
            } else {
                list($c, $a) = ["site", "entry"];
            }
        } else {
            $baseUrl = request()->domain() . "/" . $weDoor . "/index.php";
            if ("app" == $weDoor) {
                list($i, $c, $a) = [$_W["uniacid"], "entry", "site"];
            } else {
                list($c, $a) = ["site", "entry"];
            }
        }
        $url = $baseUrl . '?m=' . MODULE_NAME . "&";
        $frequency = substr_count($param, '/');
        list($model, $controller, $method) = explode('/', $param);
        if (!empty($c)) {
            $url .= "c={$c}&";
        }
        if (!empty($a)) {
            $url .= "a={$a}&";
        }
        if (!empty($i)) {
            $url .= "i={$i}&";
        }
        if ($frequency == 1) {
            $url .= "do={$_GPC["do"]}&";
        } else {
            $url .= "do={$model}&";
        }
        if ($frequency == 1) {
            $url .= "tpp=/{$param}";
        } else {
            $url .= "tpp=/{$controller}/{$method}";
        }
        if (!empty($vars)) {
            $queryString = http_build_query($vars, '', '&');
            $url .= "&" . $queryString;
        }
        return $url;
    }
}


if (!function_exists('weCopyright')) {
    /**
     * 微擎版权信息
     * @return string
     */
    function weCopyright()
    {
        global $_W;
        $html = '<div class="copyright">';
        if (!isset($_W['setting']['copyright']['footerleft']) || empty($_W['setting']['copyright']['footerleft'])) {
            $html .= 'Powered by <a href="http://www.we7.cc"><b>微擎</b></a> v' . IMS_VERSION . ' © 2014-' . date('Y') . ' <a href="http://www.we7.cc">www.we7.cc</a>';
        } else {
            $html .= $_W['setting']['copyright']['footerleft'];
        }
        $html .= ' </div>';
        if (isset($_W['setting']['copyright']['icp']) && !empty($_W['setting']['copyright']['icp'])) {
            $html .= '<div>备案号：<a href="http://www.miitbeian.gov.cn" target="_blank">' . $_W['setting']['copyright']['icp'] . '</a></div>';
        }
        return $html;
    }
}

/**
 * 打印调试函数
 * @param $content
 * @param $is_die
 */
function pre($content, $is_die = true)
{
    header('Content-type: text/html; charset=utf-8');
    echo '<pre>' . print_r($content, true);
    $is_die && die();
}

/**
 * 驼峰命名转下划线命名
 * @param $str
 * @return string
 */
function toUnderScore($str)
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
        return '_' . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/_{2,}/', '_', $dstr), '_');
}

/**
 * 生成密码hash值
 * @param $password
 * @return string
 */
function tp5_web_hash($password)
{
    return md5(md5($password) . 'yoshop_salt_SmTRx');
}

/**
 * 获取当前域名及根路径
 * @return string
 */
function base_url()
{
    static $baseUrl = '';
    if (empty($baseUrl)) {
        $request = Request::instance();
        $subDir = str_replace('\\', '/', dirname($request->server('PHP_SELF')));
        $baseUrl = $request->scheme() . '://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
    }
    return $baseUrl;
}

/**
 * 写入日志 (使用tp自带驱动记录到runtime目录中)
 * @param $value
 * @param string $type
 */
function log_write($value, $type = 'tp5-info')
{
    $msg = is_string($value) ? $value : var_export($value, true);
    Log::record($msg, $type);
}

/**
 * curl请求指定url (get)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curl($url, $data = [])
{
    // 处理get数据
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

/**
 * curl请求指定url (post)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curlPost($url, $data = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

if (!function_exists('array_column')) {
    /**
     * array_column 兼容低版本php
     * (PHP < 5.5.0)
     * @param $array
     * @param $columnKey
     * @param null $indexKey
     * @return array
     */
    function array_column($array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = is_object($subArray) ? $subArray->$columnKey : $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $index = is_object($subArray) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $index = is_object($subArray) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = is_object($subArray) ? $subArray->$columnKey : $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}

/**
 * 多维数组合并
 * @param $array1
 * @param $array2
 * @return array
 */
function array_merge_multiple($array1, $array2)
{
    $merge = $array1 + $array2;
    $data = [];
    foreach ($merge as $key => $val) {
        if (
            isset($array1[$key])
            && is_array($array1[$key])
            && isset($array2[$key])
            && is_array($array2[$key])
        ) {
            $data[$key] = array_merge_multiple($array1[$key], $array2[$key]);
        } else {
            $data[$key] = isset($array2[$key]) ? $array2[$key] : $array1[$key];
        }
    }
    return $data;
}

/**
 * 二维数组排序
 * @param $arr
 * @param $keys
 * @param bool $desc
 * @return mixed
 */
function array_sort($arr, $keys, $desc = false)
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($desc) {
        arsort($key_value);
    } else {
        asort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

/**
 * 数据导出到excel(csv文件)
 * @param $fileName
 * @param array $tileArray
 * @param array $dataArray
 */
function export_excel($fileName, $tileArray = [], $dataArray = [])
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 0);
    ob_end_clean();
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=" . $fileName);
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));// 转码 防止乱码(比如微信昵称)
    fputcsv($fp, $tileArray);
    $index = 0;
    foreach ($dataArray as $item) {
        if ($index == 1000) {
            $index = 0;
            ob_flush();
            flush();
        }
        $index++;
        fputcsv($fp, $item);
    }
    ob_flush();
    flush();
    ob_end_clean();
}

/**
 * 隐藏敏感字符
 * @param $value
 * @return string
 */
function substr_cut($value)
{
    $strlen = mb_strlen($value, 'utf-8');
    if ($strlen <= 1) return $value;
    $firstStr = mb_substr($value, 0, 1, 'utf-8');
    $lastStr = mb_substr($value, -1, 1, 'utf-8');
    return $strlen == 2 ? $firstStr . str_repeat('*', $strlen - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
}

/**
 * 获取当前系统版本号
 * @return mixed|null
 * @throws Exception
 */
function get_version()
{
    return '';
}

/**
 * 获取全局唯一标识符
 * @param bool $trim
 * @return string
 */
function getGuidV4($trim = true)
{
    // Windows
    if (function_exists('com_create_guid') === true) {
        $charid = com_create_guid();
        return $trim == true ? trim($charid, '{}') : $charid;
    }
    // OSX/Linux
    if (function_exists('openssl_random_pseudo_bytes') === true) {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    // Fallback (PHP 4.2+)
    mt_srand((double)microtime() * 10000);
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45);                  // "-"
    $lbrace = $trim ? "" : chr(123);    // "{"
    $rbrace = $trim ? "" : chr(125);    // "}"
    $guidv4 = $lbrace .
        substr($charid, 0, 8) . $hyphen .
        substr($charid, 8, 4) . $hyphen .
        substr($charid, 12, 4) . $hyphen .
        substr($charid, 16, 4) . $hyphen .
        substr($charid, 20, 12) .
        $rbrace;
    return $guidv4;
}

/**
 * 时间戳转换日期
 * @param $timeStamp
 * @return false|string
 */
function format_time($timeStamp)
{
    return date('Y-m-d H:i:s', $timeStamp);
}

/**
 * 左侧填充0
 * @param $value
 * @param int $padLength
 * @return string
 */
function pad_left($value, $padLength = 2)
{
    return \str_pad($value, $padLength, "0", STR_PAD_LEFT);
}

/**
 * 过滤emoji表情
 * @param $text
 * @return null|string|string[]
 */
function filter_emoji($text)
{
    // 此处的preg_replace用于过滤emoji表情
    // 如需支持emoji表情, 需将mysql的编码改为utf8mb4
    return preg_replace('/[\xf0-\xf7].{3}/', '', $text);
}

/**
 * 根据指定长度截取字符串
 * @param $str
 * @param int $length
 * @return bool|string
 */
function str_substr($str, $length = 30)
{
    if (strlen($str) > $length) {
        $str = mb_substr($str, 0, $length);
    }
    return $str;
}


/**
 * 取文本中间
 * @param $str
 * @param $leftStr
 * @param $rightStr
 * @return false|string
 */
function getIntermediate($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    $right = strpos($str, $rightStr, $left);
    if ($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
}


