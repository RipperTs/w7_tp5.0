<?php

use app\common\enum\DeliveryType as DeliveryTypeEnum;

// 订单详情
$detail = isset($detail) ? $detail : null;

?>
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget__order-detail widget-body am-margin-bottom-lg">
                    <!-- 基本信息 -->
                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">基本信息</div>
                    </div>
                    <div class="am-scrollable-horizontal">
                        <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs">
                            <tbody>
                            <tr>
                                <th>赋能ID</th>
                                <th>口令</th>
                                <th>用户信息</th>
                                <th>转发标题</th>
                            </tr>
                            <tr>
                                <td><?= $detail['generate_id'] ?></td>
                                <td><?= $detail['key'] ?></td>
                                <td>
                                    <p><?= $detail['user']['nickName'] ?></p>
                                    <p class="am-link-muted">(用户id：<?= $detail['user']['user_id'] ?>)</p>
                                </td>
                                <td><?= $detail['title'] ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">分享链接</div>
                    </div>
                    <div class="am-scrollable-horizontal">
                        <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs">
                            <tbody>
                            <tr>
                                <th>准备跳转地址</th>
                                <th>生成分享链接地址</th>
                            </tr>
                            <tr>
                                <td><?= $detail['hara_url'] ?></td>
                                <td><?= $detail['share_url'] ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">分享详细信息</div>
                    </div>
                    <div class="am-scrollable-horizontal">
                        <table class="regional-table am-table am-table-bordered am-table-centered
                                am-text-nowrap am-margin-bottom-xs">
                            <tbody>
                            <tr>
                                <th>转发图片</th>
                                <th>转发内容</th>
                            </tr>
                            <tr>
                                <td>
                                    <a href="<?= $detail['image']['file_path'] ?>" title="点击查看大图" target="_blank">
                                        <img src="<?= $detail['image']['file_path'] ?>" width="72" height="72" alt="">
                                    </a>
                                </td>
                                <td><?= $detail['content'] ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('.my-form').superForm();

    });
</script>
