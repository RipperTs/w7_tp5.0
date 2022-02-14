<div class="page-home row-content am-cf">

    <!-- 商城统计 -->
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12 am-margin-bottom">
            <div class="widget am-cf">
                <div class="widget-head">
                    <div class="widget-title">数据统计</div>
                </div>
                <div class="widget-body am-cf">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-3">
                        <div class="widget-card card__blue am-cf">
                            <div class="card-header">套餐数量</div>
                            <div class="card-body">
                                <div class="card-value"><?= $data['widget-card']['plan_total'] ?></div>
                                <div class="card-description">充值套餐总数量</div>
                                <span class="card-icon iconfont icon-goods"></span>
                            </div>
                        </div>
                    </div>

                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-3">
                        <div class="widget-card card__red am-cf">
                            <div class="card-header">用户总量</div>
                            <div class="card-body">
                                <div class="card-value"><?= $data['widget-card']['user_total'] ?></div>
                                <div class="card-description">当前用户总数量</div>
                                <span class="card-icon iconfont icon-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-3">
                        <div class="widget-card card__violet am-cf">
                            <div class="card-header">赋能总量</div>
                            <div class="card-body">
                                <div class="card-value"><?= $data['widget-card']['generate_total'] ?></div>
                                <div class="card-description">历史生成的赋能记录总数量</div>
                                <span class="card-icon iconfont icon-order"></span>
                            </div>
                        </div>
                    </div>

                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-3">
                        <div class="widget-card card__primary am-cf">
                            <div class="card-header">充值金额</div>
                            <div class="card-body">
                                <div class="card-value"><?= $data['widget-card']['recharge_total'] ?></div>
                                <div class="card-description">用户历史充值总金额</div>
                                <span class="card-icon iconfont icon-haoping2"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<script src="<?= SITE_URL ?>/assets/common/js/echarts.min.js"></script>
<script src="<?= SITE_URL ?>/assets/common/js/echarts-walden.js"></script>
<script type="text/javascript">



</script>