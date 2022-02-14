<?php
global $_W;
$tablename = trim(tablename('tp5_web_'),"`");
$uniacid = $_W['uniacid'];

pdo_query("
DROP TABLE IF EXISTS `{$tablename}banner`;
DROP TABLE IF EXISTS `{$tablename}admin_user`;
DROP TABLE IF EXISTS `{$tablename}generate`;
DROP TABLE IF EXISTS `{$tablename}recharge_order`;
DROP TABLE IF EXISTS `{$tablename}recharge_order_plan`;
DROP TABLE IF EXISTS `{$tablename}recharge_plan`;
DROP TABLE IF EXISTS `{$tablename}setting`;
DROP TABLE IF EXISTS `{$tablename}store_access`;
DROP TABLE IF EXISTS `{$tablename}store_role`;
DROP TABLE IF EXISTS `{$tablename}store_role_access`;
DROP TABLE IF EXISTS `{$tablename}store_user`;
DROP TABLE IF EXISTS `{$tablename}store_user_role`;
DROP TABLE IF EXISTS `{$tablename}upload_file`;
DROP TABLE IF EXISTS `{$tablename}upload_group`;
DROP TABLE IF EXISTS `{$tablename}user`;
DROP TABLE IF EXISTS `{$tablename}user_address`;
DROP TABLE IF EXISTS `{$tablename}user_balance_log`;
DROP TABLE IF EXISTS `{$tablename}user_grade`;
DROP TABLE IF EXISTS `{$tablename}user_grade_log`;
DROP TABLE IF EXISTS `{$tablename}user_points_log`;
DROP TABLE IF EXISTS `{$tablename}wxapp`;
DROP TABLE IF EXISTS `{$tablename}wxapp_category`;
DROP TABLE IF EXISTS `{$tablename}wxapp_formid`;
DROP TABLE IF EXISTS `{$tablename}wxapp_help`;
DROP TABLE IF EXISTS `{$tablename}wxapp_page`;
DROP TABLE IF EXISTS `{$tablename}wxapp_prepay_id`;

");