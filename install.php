<?php
global $_W;
$tablename = trim(tablename('tp5_web_'),"`");
$uniacid = $_W['uniacid'];

pdo_query("
CREATE TABLE `{$tablename}admin_user` (
  `admin_user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '登录密码',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='超管用户记录表';

INSERT INTO `{$tablename}admin_user` (`admin_user_id`, `user_name`, `password`, `create_time`, `update_time`, `uniacid`) VALUES
(10001,	'admin',	'ff98bc3b7b9745450c323d4cb6b3e8b3',	1529926348,	1604628322, {$uniacid});

CREATE TABLE `{$tablename}banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `file_id` int(11) NOT NULL DEFAULT '0' COMMENT '图片文件ID',
  `remarks` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `app_links` varchar(255) NOT NULL DEFAULT '0' COMMENT '小程序跳转地址',
  `h5_links` varchar(255) NOT NULL DEFAULT '0' COMMENT 'h5跳转地址',
  `status` tinyint(3) NOT NULL DEFAULT '10' COMMENT '状态 10 显示 20 隐藏',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `wxapp_id` int(11) NOT NULL DEFAULT '10001',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{$tablename}generate` (
  `generate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'key链接转换',
  `hara_url` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '原始链接',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '转发标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '转发内容',
  `file_id` int(11) NOT NULL DEFAULT '0' COMMENT '图片文件ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `is_switch` tinyint(3) NOT NULL DEFAULT '10' COMMENT '赋能开关 10 开启 20 关闭',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0',
  `wxapp_id` int(11) NOT NULL DEFAULT '10001',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`generate_id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='赋能记录表';

CREATE TABLE `{$tablename}recharge_order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_no` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `recharge_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '充值方式(10自定义金额 20套餐充值)',
  `plan_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '充值套餐id',
  `pay_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户支付金额',
  `gift_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '赠送金额',
  `actual_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实际到账金额',
  `pay_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '支付状态(10待支付 20已支付)',
  `pay_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '付款时间',
  `transaction_id` varchar(30) NOT NULL DEFAULT '' COMMENT '微信支付交易号',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序商城id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户充值订单表';

CREATE TABLE `{$tablename}recharge_order_plan` (
  `order_plan_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `plan_id` int(11) unsigned NOT NULL COMMENT '主键id',
  `plan_name` varchar(255) NOT NULL DEFAULT '' COMMENT '方案名称',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `gift_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '赠送金额',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序商城id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户充值订单套餐快照表';

CREATE TABLE `{$tablename}recharge_plan` (
  `plan_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `plan_name` varchar(255) NOT NULL DEFAULT '' COMMENT '套餐名称',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `gift_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '赠送金额',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序(数字越小越靠前)',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序商城id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='余额充值套餐表';

CREATE TABLE `{$tablename}setting` (
  `key` varchar(30) NOT NULL COMMENT '设置项标示',
  `describe` varchar(255) NOT NULL DEFAULT '' COMMENT '设置项描述',
  `values` mediumtext NOT NULL COMMENT '设置内容（json格式）',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `unique_key` (`key`,`uniacid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商城设置记录表';

CREATE TABLE `{$tablename}store_access` (
  `access_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '权限名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '权限url',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序(数字越小越靠前)',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家用户权限表';

INSERT INTO `{$tablename}store_access` (`access_id`, `name`, `url`, `parent_id`, `sort`, `create_time`, `update_time`, `uniacid`) VALUES
(10001,	'首页',	'index/index',	0,	100,	1540628721,	1540781975, {$uniacid}),
(10002,	'管理员',	'store',	0,	105,	1540628721,	1552635011, {$uniacid}),
(10003,	'管理员管理',	'store.user',	10002,	100,	1540628721,	1540628721, {$uniacid}),
(10004,	'管理员列表',	'store.user/index',	10003,	100,	1540628721,	1540628721, {$uniacid}),
(10005,	'添加管理员',	'store.user/add',	10003,	100,	1540628721,	1540628721, {$uniacid}),
(10006,	'编辑管理员',	'store.user/edit',	10003,	100,	1540628721,	1540628721, {$uniacid}),
(10007,	'删除管理员',	'store.user/delete',	10003,	100,	1540628721,	1540628721, {$uniacid}),
(10008,	'角色管理',	'store.role',	10002,	100,	1540628721,	1540628721, {$uniacid}),
(10009,	'角色列表',	'store.role/index',	10008,	100,	1540628721,	1540628721, {$uniacid}),
(10010,	'添加角色',	'store.role/add',	10008,	100,	1540628721,	1540628721, {$uniacid}),
(10011,	'编辑角色',	'store.role/edit',	10008,	100,	1540628721,	1540628721, {$uniacid}),
(10012,	'删除角色',	'store.role/delete',	10008,	100,	1540628721,	1540628721, {$uniacid}),
(10049,	'用户管理',	'user',	0,	120,	1540628721,	1552635042, {$uniacid}),
(10050,	'用户列表',	'user/index',	10049,	100,	1540628721,	1540628721, {$uniacid}),
(10051,	'删除用户',	'user/delete',	10049,	105,	1540628721,	1540628721, {$uniacid}),
(10052,	'营销管理',	'market',	0,	135,	1540628721,	1552635080, {$uniacid}),
(10059,	'小程序',	'wxapp',	0,	140,	1540628721,	1552635087, {$uniacid}),
(10060,	'小程序设置',	'wxapp/setting',	10059,	100,	1540628721,	1540628721, {$uniacid}),
(10069,	'帮助中心',	'wxapp.help',	10059,	100,	1540628721,	1540628721, {$uniacid}),
(10070,	'帮助列表',	'wxapp.help/index',	10069,	100,	1540628721,	1540628721, {$uniacid}),
(10071,	'新增帮助',	'wxapp.help/add',	10069,	100,	1540628721,	154062872, {$uniacid}1),
(10072,	'编辑帮助',	'wxapp.help/edit',	10069,	100,	1540628721,	1540628721, {$uniacid}),
(10073,	'删除帮助',	'wxapp.help/delete',	10069,	100,	1540628721,	1540628721, {$uniacid}),
(10090,	'设置',	'setting',	0,	150,	1540628721,	1552635100, {$uniacid}),
(10091,	'公众号设置',	'setting/store',	10090,	100,	1540628721,	1604541754, {$uniacid}),
(10105,	'上传设置',	'setting/storage',	10090,	100,	1540628721,	1540628721, {$uniacid}),
(10106,	'其他',	'',	10090,	100,	1540628721,	1540628721, {$uniacid}),
(10107,	'清理缓存',	'setting.cache/clear',	10106,	100,	1540628721,	1540628721, {$uniacid}),
(10387,	'余额记录',	'user.balance',	10049,	125,	1554685953,	1554685965, {$uniacid}),
(10389,	'余额明细',	'user.balance/log',	10387,	105,	1554686031,	1554686031, {$uniacid}),
(10390,	'用户充值',	'market.recharge',	10052,	110,	1554686283,	1554686339, {$uniacid}),
(10391,	'充值套餐',	'market.recharge.plan',	10390,	100,	1554686316,	1554686316, {$uniacid}),
(10392,	'套餐列表',	'market.recharge.plan/index',	10391,	100,	1554686316,	1554686316, {$uniacid}),
(10393,	'添加套餐',	'market.recharge.plan/add',	10391,	105,	1554686316,	1554686316, {$uniacid}),
(10394,	'编辑套餐',	'market.recharge.plan/edit',	10391,	110,	1554686316,	1554686316, {$uniacid}),
(10395,	'删除套餐',	'market.recharge.plan/delete',	10391,	115,	1554686316,	1554686316, {$uniacid}),
(10396,	'充值设置',	'market.recharge/setting',	10390,	105,	1554686647,	1554686647, {$uniacid}),
(10408,	'用户充值',	'user/recharge',	10049,	110,	1557037952,	1557037952, {$uniacid}),
(11003,	'数据统计',	'statistics.data/index',	0,	138,	1572507520,	1572507520, {$uniacid}),
(11004,	'赋能记录',	'generate/lists',	0,	100,	1604541808,	1604541808, {$uniacid}),
(11005,	'赋能详情',	'generate/detail',	11004,	100,	1604541838,	1604541838, {$uniacid}),
(11006,	'删除赋能记录',	'generate/delete',	11004,	100,	1604541862,	1604541862, {$uniacid}),
(11007,	'轮播图',	'wxapp.banner/index',	10059,	100,	1604541949,	1604541949, {$uniacid}),
(11008,	'添加轮播图',	'wxapp.banner/add',	11007,	100,	1604542020,	1604542020, {$uniacid}),
(11009,	'编辑轮播图',	'wxapp.banner/edit',	11007,	100,	1604542047,	1604542047, {$uniacid}),
(11010,	'删除轮播图',	'wxapp.banner/delete',	11007,	100,	1604542065,	1604542065, {$uniacid});

CREATE TABLE `{$tablename}store_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级角色id',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序(数字越小越靠前)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家用户角色表';

CREATE TABLE `{$tablename}store_role_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家用户角色权限关系表';

CREATE TABLE `{$tablename}store_user` (
  `store_user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '登录密码',
  `real_name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `is_super` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否为超级管理员',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`store_user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家用户记录表';

INSERT INTO `{$tablename}store_user` (`store_user_id`, `user_name`, `password`, `real_name`, `is_super`, `is_delete`, `wxapp_id`, `create_time`, `update_time`, `uniacid`) VALUES
(10001,	'admin',	'ff98bc3b7b9745450c323d4cb6b3e8b3',	'管理员',	1,	0,	10001,	1529926348,	1604628293, {$uniacid});

CREATE TABLE `{$tablename}store_user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `store_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '超管用户id',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `admin_user_id` (`store_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商家用户角色记录表';

CREATE TABLE `{$tablename}upload_file` (
  `file_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件id',
  `storage` varchar(20) NOT NULL DEFAULT '' COMMENT '存储方式',
  `group_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件分组id',
  `file_url` varchar(255) NOT NULL DEFAULT '' COMMENT '存储域名',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `file_size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小(字节)',
  `file_type` varchar(20) NOT NULL DEFAULT '' COMMENT '文件类型',
  `extension` varchar(20) NOT NULL DEFAULT '' COMMENT '文件扩展名',
  `is_user` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否为c端用户上传',
  `is_recycle` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已回收',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '软删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`),
  UNIQUE KEY `path_idx` (`file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件库记录表';

CREATE TABLE `{$tablename}upload_group` (
  `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `group_type` varchar(10) NOT NULL DEFAULT '' COMMENT '文件类型',
  `group_name` varchar(30) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类排序(数字越小越靠前)',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  KEY `type_index` (`group_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件库分组记录表';

CREATE TABLE `{$tablename}user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `open_id` varchar(255) NOT NULL DEFAULT '' COMMENT '微信openid(唯一标示)',
  `nickName` varchar(255) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `avatarUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `country` varchar(50) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(50) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(50) NOT NULL DEFAULT '' COMMENT '城市',
  `address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  `balance` decimal(10,2) NOT NULL DEFAULT '3.00' COMMENT '用户可用余额（次数）',
  `points` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户可用积分',
  `pay_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户总支付的金额',
  `expend_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实际消费的金额(不含退款)',
  `grade_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级id',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `openid` (`open_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户记录表';

CREATE TABLE `{$tablename}user_address` (
  `address_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在省份id',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在城市id',
  `region_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在区id',
  `district` varchar(255) DEFAULT '' COMMENT '新市辖区(该字段用于记录region表中没有的市辖区)',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '城市',
  `state` varchar(255) NOT NULL DEFAULT '' COMMENT '州',
  `zip` varchar(10) NOT NULL DEFAULT '' COMMENT '邮编',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `type` varchar(10) NOT NULL DEFAULT '住宅' COMMENT '地址类型  住宅或公司',
  `sex` varchar(10) NOT NULL DEFAULT '未知' COMMENT '性别',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收货地址表';

CREATE TABLE `{$tablename}user_balance_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `scene` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '余额变动场景(10用户充值 20用户消费 30管理员操作 40订单退款)',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变动金额',
  `describe` varchar(500) NOT NULL DEFAULT '' COMMENT '描述/说明',
  `remark` varchar(500) NOT NULL DEFAULT '' COMMENT '管理员备注',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序商城id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户余额变动明细表';

CREATE TABLE `{$tablename}user_grade` (
  `grade_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '等级ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',
  `weight` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '等级权重(1-9999)',
  `upgrade` text NOT NULL COMMENT '升级条件',
  `equity` text NOT NULL COMMENT '等级权益(折扣率0-100)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1启用 0禁用)',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`grade_id`),
  KEY `wxapp_id` (`wxapp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户会员等级表';

CREATE TABLE `{$tablename}user_grade_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `old_grade_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '变更前的等级id',
  `new_grade_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '变更后的等级id',
  `change_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '变更类型(10后台管理员设置 20自动升级)',
  `remark` varchar(500) DEFAULT '' COMMENT '管理员备注',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户会员等级变更记录表';

CREATE TABLE `{$tablename}user_points_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `value` int(11) NOT NULL DEFAULT '0' COMMENT '变动数量',
  `describe` varchar(500) NOT NULL DEFAULT '' COMMENT '描述/说明',
  `remark` varchar(500) NOT NULL DEFAULT '' COMMENT '管理员备注',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序商城id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户积分变动明细表';

CREATE TABLE `{$tablename}wxapp` (
  `wxapp_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '小程序id',
  `app_id` varchar(50) NOT NULL DEFAULT '' COMMENT '小程序AppID',
  `app_secret` varchar(50) NOT NULL DEFAULT '' COMMENT '小程序AppSecret',
  `jump_url` varchar(50) NOT NULL DEFAULT '',
  `redirect_uri` varchar(50) NOT NULL DEFAULT '',
  `command_time` int(11) NOT NULL DEFAULT '3' COMMENT '口令缓存时间',
  `identifier` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '系统识别码',
  `mchid` varchar(50) NOT NULL DEFAULT '' COMMENT '微信商户号id',
  `apikey` varchar(255) NOT NULL DEFAULT '' COMMENT '微信支付密钥',
  `cert_pem` longtext COMMENT '证书文件cert',
  `key_pem` longtext COMMENT '证书文件key',
  `is_recycle` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否回收',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wxapp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信小程序记录表';

INSERT INTO `{$tablename}wxapp` (`wxapp_id`, `app_id`, `app_secret`, `jump_url`, `redirect_uri`, `command_time`, `identifier`, `mchid`, `apikey`, `cert_pem`, `key_pem`, `is_recycle`, `is_delete`, `create_time`, `update_time`, `uniacid`) VALUES
(10001,	'',	'',	'',	'',	3,	'',	'',	'',	'',	'',	0,	0,	1604477214,	1604647983, {$uniacid});

CREATE TABLE `{$tablename}wxapp_category` (
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `category_style` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '分类页样式(10一级分类[大图] 11一级分类[小图] 20二级分类)',
  `share_title` varchar(100) NOT NULL DEFAULT '' COMMENT '分享标题',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wxapp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信小程序分类页模板';

INSERT INTO `{$tablename}wxapp_category` (`wxapp_id`, `category_style`, `share_title`, `create_time`, `update_time`, `uniacid`) VALUES
(10001,	10,	'',	1536373988,	1536375112, {$uniacid}),
(10002,	11,	'',	1604538836,	1604538836, {$uniacid});

CREATE TABLE `{$tablename}wxapp_formid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `form_id` varchar(50) NOT NULL DEFAULT '' COMMENT '小程序form_id',
  `expiry_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `is_used` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已使用',
  `used_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '使用时间',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='小程序form_id记录表(已废弃)';

CREATE TABLE `{$tablename}wxapp_help` (
  `help_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '帮助标题',
  `content` text NOT NULL COMMENT '帮助内容',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序(数字越小越靠前)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`help_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信小程序帮助';

INSERT INTO `{$tablename}wxapp_help` (`help_id`, `title`, `content`, `sort`, `wxapp_id`, `create_time`, `update_time`, `uniacid`) VALUES
(10001,	'关于赋能',	'赋能工具作为依赖微信公众平台开发的一款快速裂变的营销工具',	100,	10001,	1535942481,	1604459082, {$uniacid}),
(10002,	'链接如何分享给好友',	'生成链接后会弹出提示框，这时候点击右上角会提示分享给好友，不仅于此，还支持分享到：微信好友、微信朋友圈、QQ好友、QQ空间等',	100,	10001,	1604459200,	1604459200, {$uniacid}),
(10003,	'关于小程序',	'小程序本身无需下载，无需注册，不占用手机内存，可以跨平台使用，响应迅速，体验接近原生APP。',	100,	10002,	1604538836,	1604538836, {$uniacid});

CREATE TABLE `{$tablename}wxapp_page` (
  `page_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '页面id',
  `page_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '页面类型(10首页 20自定义页)',
  `page_name` varchar(255) NOT NULL DEFAULT '' COMMENT '页面名称',
  `page_data` longtext NOT NULL COMMENT '页面数据',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '微信小程序id',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '软删除',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`),
  KEY `wxapp_id` (`wxapp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信小程序diy页面表';

INSERT INTO `{$tablename}wxapp_page` (`page_id`, `page_type`, `page_name`, `page_data`, `wxapp_id`, `is_delete`, `create_time`, `update_time`, `uniacid`) VALUES
(10001,	10,	'小程序首页',	'{\"items\":{\"page\":{\"id\":\"page\",\"type\":\"page\",\"name\":\"\\u9875\\u9762\\u8bbe\\u7f6e\",\"params\":{\"name\":\"\\u9875\\u9762\\u540d\\u79f0\",\"title\":\"\\u8424\\u706b\\u5c0f\\u7a0b\\u5e8f\\u5546\\u57ce\"},\"style\":{\"titleTextColor\":\"white\",\"titleBackgroundColor\":\"#ff8000\"}},\"n50214144672381\":{\"id\":\"n50214144672381\",\"type\":\"search\",\"name\":\"\\u641c\\u7d22\\u6846\",\"params\":{\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u5173\\u952e\\u5b57\\u8fdb\\u884c\\u641c\\u7d22\"},\"style\":{\"textAlign\":\"left\",\"searchStyle\":\"\"}},\"n33356112682143\":{\"id\":\"n33356112682143\",\"type\":\"coupon\",\"name\":\"\\u4f18\\u60e0\\u5238\\u7ec4\",\"style\":{\"paddingTop\":\"10\",\"background\":\"#ffffff\"},\"params\":{\"limit\":\"5\"},\"data\":{\"n214578430230592\":{\"color\":\"red\",\"reduce_price\":\"10\",\"min_price\":\"100.00\"},\"n818030369705776\":{\"color\":\"violet\",\"reduce_price\":\"10\",\"min_price\":\"100.00\"}}}}}',	10001,	0,	1536197290,	1536197290, {$uniacid}),
(10004,	10,	'小程序首页',	'{\"page\":{\"type\":\"page\",\"name\":\"\\u9875\\u9762\\u8bbe\\u7f6e\",\"params\":{\"name\":\"\\u9875\\u9762\\u6807\\u9898\",\"title\":\"\\u9875\\u9762\\u6807\\u9898\",\"share_title\":\"\\u5206\\u4eab\\u6807\\u9898\"},\"style\":{\"titleTextColor\":\"black\",\"titleBackgroundColor\":\"#ffffff\"}},\"items\":[{\"type\":\"search\",\"name\":\"\\u641c\\u7d22\\u6846\",\"params\":{\"placeholder\":\"\\u641c\\u7d22\\u5546\\u54c1\"},\"style\":{\"textAlign\":\"center\",\"searchStyle\":\"radius\"}},{\"type\":\"banner\",\"name\":\"\\u56fe\\u7247\\u8f6e\\u64ad\",\"style\":{\"btnColor\":\"#ffffff\",\"btnShape\":\"round\"},\"params\":{\"interval\":\"2800\"},\"data\":[{\"imgUrl\":\"https:\\/\\/funeng.test.noteo.cn\\/assets\\/store\\/img\\/diy\\/banner\\/01.png\",\"linkUrl\":\"\"},{\"imgUrl\":\"https:\\/\\/funeng.test.noteo.cn\\/assets\\/store\\/img\\/diy\\/banner\\/01.png\",\"linkUrl\":\"\"}]}]}',	10002,	0,	1604538836,	1604538836, {$uniacid});

CREATE TABLE `{$tablename}wxapp_prepay_id` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '订单类型(10商城订单 20拼团订单)',
  `prepay_id` varchar(50) NOT NULL DEFAULT '' COMMENT '微信支付prepay_id',
  `can_use_times` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可使用次数',
  `used_times` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '已使用次数',
  `pay_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态(1已支付)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `expiry_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='小程序prepay_id记录(已废弃)';

");
