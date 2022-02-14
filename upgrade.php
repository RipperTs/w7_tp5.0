<?php
/**
 * Created by PhpStorm.
 * User: wslmf
 * Date: 2020/12/05
 * 以后升级有修改、添加字段都要在这里进行判断，防止版本断更之后字段不统一而报错
 */
global $_GPC, $_W;
$tablename = trim(tablename('tp5_web_'), "`");
$updateTableName = trim('tp5_web_', "`");
$uniacid = $_W['uniacid'];

/*------------------------------------1.0.1版本升级开始 2020-12-05----------------------------------*/
// 新增点赞数量和评论数量
//if (!pdo_fieldexists($updateTableName . 'generate', 'zan_num') && !pdo_fieldexists($updateTableName . 'generate', 'com_num')) {
//    $sql = "ALTER TABLE `{$tablename}generate`
//ADD `zan_num` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数量' AFTER `user_id`,
//ADD `com_num` int(11) NOT NULL DEFAULT '0' COMMENT '评论数量' AFTER `zan_num`,
//CHANGE `type` `type` tinyint(3) NOT NULL DEFAULT '10' COMMENT '类型 10 网站赋能 20 二维码赋能  30  收款码赋能  40  公众号赋能 50 视频赋能' AFTER `aliUrl`;
//";
//    pdo_query($sql);
//}
/*------------------------------------1.0.1版本升级开始 2020-12-05----------------------------------*/