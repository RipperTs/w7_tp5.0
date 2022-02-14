<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">小程序设置</div>
                            </div>
                            <div class="tips am-margin-bottom-sm am-u-sm-12">
                                <div class="pre">
                                    <p>更改此页面数据,须到设置中清理缓存,否则可能造成设置不生效!</p>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    AppID <span class="tpl-form-line-small-title">小程序ID</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[app_id]"
                                           value="<?= $model['app_id'] == '' ? WECHATAPPID : $model['app_id'] ?>">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    AppSecret <span class="tpl-form-line-small-title">小程序密钥</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[app_secret]"
                                           value="<?= $model['app_secret'] == '' ? WECHATSECRET : $model['app_secret'] ?>">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    赋能口令有效期(天)
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[command_time]"
                                           value="<?= $model['command_time'] ?>"
                                           placeholder="请输入赋能口令有效期天数,失效将无法自动复制直接跳转">
                                </div>
                            </div>
                            <div style="display: none;">
                                <div class="widget-head am-cf">
                                    <div class="widget-title am-fl">系统授权码</div>
                                </div>
                                <div class="tips am-margin-bottom-sm am-u-sm-12">
                                    <div class="pre">
                                        <p style="color: red">请正确填写此项,否则将无法访问系统!</p>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label form-require">
                                        识别码
                                    </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="wxapp[identifier]"
                                               value="<?= $model['identifier'] ?>" placeholder="请输入系统识别码" required>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">域名设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    赋能跳转域名
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[jump_url]"
                                           value="<?= $model['jump_url'] ?>"
                                           placeholder="请输入生成的赋能链接域名,包含https:// 不含 尾部 / 通常是前端搭建好的域名地址">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    登陆回调域名
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[redirect_uri]"
                                           value="<?= $model['redirect_uri'] ?>"
                                           placeholder="请输入微信公众号登录回调域名,包含https:// 不含 尾部 / 通常是前端搭建好的域名地址">
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">微信支付设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    微信支付商户号 <span class="tpl-form-line-small-title">MCHID</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[mchid]"
                                           value="<?= $model['mchid'] ?>">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    微信支付密钥 <span class="tpl-form-line-small-title">APIKEY</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[apikey]"
                                           value="<?= $model['apikey'] ?>">
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-form-label">
                                    apiclient_cert.pem
                                </label>
                                <div class="am-u-sm-9">
                                     <textarea rows="6" name="wxapp[cert_pem]"
                                               placeholder="使用文本编辑器打开apiclient_cert.pem文件，将文件的全部内容复制进来"><?= $pem['cert'] ?></textarea>
                                    <small>使用文本编辑器打开apiclient_cert.pem文件，将文件的全部内容复制进来</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    apiclient_key.pem
                                </label>
                                <div class="am-u-sm-9">
                                     <textarea rows="6" name="wxapp[key_pem]"
                                               placeholder="使用文本编辑器打开apiclient_key.pem文件，将文件的全部内容复制进来"><?= $pem['key'] ?></textarea>
                                    <small>使用文本编辑器打开apiclient_key.pem文件，将文件的全部内容复制进来</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
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
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
