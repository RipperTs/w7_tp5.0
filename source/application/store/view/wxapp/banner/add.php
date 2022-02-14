<link rel="stylesheet" href="<?= SITE_URL ?>/assets/store/css/goods.css?v=<?= $version ?>">
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/common/plugins/umeditor/themes/default/css/umeditor.css">
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">新增轮播图</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">{{:lang("轮播备注")}} </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="banner[remarks]" value="" required>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">{{:lang("轮播图片")}} </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="am-form-file">
                                            <button type="button" class="upload-file am-btn am-btn-secondary am-radius">
                                                <i class="am-icon-cloud-upload"></i> {{:lang("选择图片")}}
                                            </button>
                                            <div class="uploader-list am-cf">
                                            </div>
                                        </div>
                                        <div class="help-block am-margin-top-sm">
                                            <small style="color: #ff5656">尺寸710x450像素，大小2M以下 (选择一张)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">状态 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <label class="am-radio-inline">
                                            <input type="radio" name="banner[status]" value="10" data-am-ucheck checked>
                                            显示
                                        </label>
                                        <label class="am-radio-inline">
                                            <input type="radio" name="banner[status]" value="20" data-am-ucheck>
                                            隐藏
                                        </label>
                                    </div>
                                </div>
                                <div class="am-form-group" >
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">排序</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type="number" class="tpl-form-input" name="banner[sort]" value="100" required>
                                        <small>数字越小越靠前</small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">H5端跳转地址</label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type="text" class="tpl-form-input" name="banner[h5_links]" value="0" required>
                                        <small>
                                            <p><b>H5端跳转路径,可直接在网页地址栏复制. 0表示不跳转</b></p>
                                        </small>
                                    </div>
                                </div>

                                <!-- 表单提交按钮 -->
                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                        <button type="submit" class="j-submit am-btn am-btn-secondary">{{:lang("提交")}}
                                        </button>
                                    </div>
                                </div>

                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 图片文件列表模板 -->
<!-- {{include file="layouts/_template/tpl_file_item" /}} -->
<script id="tpl-file-item" type="text/template">
    {{ each list }}
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
        <input type="hidden" name="{{ name }}" value="{{ $value.file_id }}">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>
<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}


<script src="<?= SITE_URL ?>/assets/common/js/vue.min.js"></script>
<script src="<?= SITE_URL ?>/assets/common/js/ddsort.js"></script>
<script src="<?= SITE_URL ?>/assets/common/plugins/umeditor/umeditor.config.js?v=<?= $version ?>"></script>
<script src="<?= SITE_URL ?>/assets/common/plugins/umeditor/umeditor.min.js"></script>
<script src="<?= SITE_URL ?>/assets/store/js/goods.spec.js?v=<?= $version ?>"></script>

<script>
    $(function() {
        // // 选择图片
        // $('.upload-file').selectImages({
        //     name: 'goods[images][]'
        //     , multiple: true
        // });
        // 选择图片
        $('.upload-file').selectImages({
            name: 'banner[file_id]'
        });

        // 图片列表拖动
        $('.uploader-list').DDSort({
            target: '.file-item',
            delay: 100, // 延时处理，默认为 50 ms，防止手抖点击 A 链接无效
            floatStyle: {
                'border': '1px solid #ccc',
                'background-color': '#fff'
            }
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
