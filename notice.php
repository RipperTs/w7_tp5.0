<?php
if (!$xml = file_get_contents('php://input')) {
    returnCode(false, 'Not found DATA');
}
// 将服务器返回的XML数据转化为数组
$data = fromXml($xml);
$attach = json_decode($data['attach'], true);
$url = $attach['domain'] . '/app/index.php?m=' . $attach['module'] . '&c=entry&a=site&i=' . $attach['uniacid'] . '&do=api&tpp=/notify/order';
header('Location:' . $url);
die;

function toXml($values)
{
    if (!is_array($values)
        || count($values) <= 0
    ) {
        return false;
    }

    $xml = "<xml>";
    foreach ($values as $key => $val) {
        if (is_numeric($val)) {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
    }
    $xml .= "</xml>";
    return $xml;
}

function fromXml($xml)
{
    // 禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}

function returnCode($returnCode = true, $msg = null)
{
    $return = [
        'return_code' => $returnCode ? 'SUCCESS' : 'FAIL',
        'return_msg' => $msg ?: 'OK',
    ];
    die(toXml($return));
}
