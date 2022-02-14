<?php
defined('IN_IA') or exit('Access Denied');

require IA_ROOT . '/data/config.php';
$db_config = $config['db']['master'];

return [
    // 数据库类型
    'type' => 'mysql',
    // 服务器地址
    'hostname' => isset($db_config['host']) ? $db_config['host'] : '127.0.0.1',
    // 数据库名
    'database' => isset($db_config['database']) ? $db_config['database'] : '',
    // 用户名
    'username' => isset($db_config['username']) ? $db_config['username'] : '',
    // 密码
    'password' => isset($db_config['password']) ? $db_config['password'] : '',
    // 端口
    'hostport' => isset($db_config['port']) ? $db_config['port'] : '',
    // 连接dsn
    'dsn' => '',
    // 数据库连接参数
    'params' => [],
    // 数据库编码默认采用utf8
    'charset' => isset($db_config['charset']) ? $db_config['charset'] : 'utf8',
    // 数据库表前缀
    'prefix' => isset($db_config['tablepre']) ? $db_config['tablepre'] . MODULE_NAME . '_' : '',
    // 数据库调试模式
    'debug' => false,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy' => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate' => false,
    // 读写分离后 主服务器数量
    'master_num' => 1,
    // 指定从服务器序号
    'slave_no' => '',
    // 是否严格检查字段是否存在
    'fields_strict' => true,
    // 数据集返回类型
    'resultset_type' => 'collection',
    // 自动写入时间戳字段
    'auto_timestamp' => true,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain' => false,
];
