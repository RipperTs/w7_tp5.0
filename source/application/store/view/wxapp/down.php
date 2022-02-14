<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">前端接口</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    接口地址 <span class="tpl-form-line-small-title">API</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" readonly
                                           value="<?= request()->domain() . '/app/index.php?m=' . MODULE_NAME . '&c=entry&a=wxapp&i=' . MODULE_UNIACID . '&do=api&tpp=/' ?>"
                                           required>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">程序文件</div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9">
                                    <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                        <a href="<?= '/addons/' . MODULE_NAME . '/front.zip' ?>"
                                           class="am-btn am-btn-secondary am-btn-xs">前端文件下载</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tips am-margin-bottom-sm am-u-sm-12">
                                <div class="pre">
                                    <p>新建一个站点,将前端文件下载后放在网站根目录,配置好伪静态即可使用! 环境要求: Nginx</p>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">伪静态</div>
                            </div>
                            <div class="tips am-margin-bottom-sm am-u-sm-12">
                                <div class="pre">
                                    <p>如果删除此模块后重新安装,伪静态会随之改变,请重新配置此项!</p>
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-form-label">
                                    Nginx
                                </label>
                                <div class="am-u-sm-9">
                                     <textarea readonly rows="10">location /api/ {
    proxy_pass <?= request()->domain() . '/app/index.php?m=' . MODULE_NAME . '&c=entry&a=wxapp&i=' . MODULE_UNIACID . '&do=api&tpp=/' ?>;
}
location / {
  try_files $uri $uri/ /index.html;
}
proxy_set_header X-Forwarded-For $remote_addr;
proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                                     </textarea>
                                    <small>前端务必配置此伪静态才可正常访问,仅Vue开发需要设置此项</small>
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
