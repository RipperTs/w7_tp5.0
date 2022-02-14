<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">首页轮播图</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <?php if (checkPrivilege('wxapp.banner/add')) : ?>
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-success"
                                               href="<?= siteUrl('wxapp.banner/add') ?>">
                                                <span class="am-icon-plus"></span> 新增
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{:lang("图片")}}</th>
                                <th>{{:lang("备注")}}</th>
                                <th>{{:lang("排序")}}</th>
                                <th>{{:lang("状态")}}</th>
                                <th>{{:lang("添加时间")}}</th>
                                <th>{{:lang("操作")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $k => $item) { ?>
                                <tr>
                                    <td class="am-text-middle"><?php echo $item['banner_id'] ?></td>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['image']['file_path'] ?>" title="点击查看大图" target="_blank">
                                            <img src="<?= $item['image']['file_path'] ?>" width="100" height="60" alt="商品图片">
                                        </a>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class="item-title "><?= $item['remarks'] ?></p>
                                    </td>
                                    <td class="am-text-middle"><?= $item['sort'] ?></td>
                                    <td class="am-text-middle">
                                            <span class="j-state am-badge x-cur-p
                                           am-badge-<?= $item['status'] == 10 ? 'success' : 'warning' ?>"
                                                  data-id="<?= $item['banner_id'] ?>"
                                                  data-state="<?= $item['status'] ?>">
                                                <?= $item['status'] == 10 ? '显示' : '隐藏' ?>
                                            </span>
                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('wxapp.banner/edit')) : ?>
                                                <a href="<?= siteUrl(
                                                    'wxapp.banner/edit',
                                                    ['banner_id' => $item['banner_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('wxapp.banner/delete')) : ?>
                                                <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['banner_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

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

        // 商品状态
        $('.j-state').click(function () {
            // 验证权限
            if (!"<?= checkPrivilege('wxapp.banner/state') ?>") {
                return false;
            }
            var data = $(this).data();

            layer.confirm('确定要' + (parseInt(data.state) === 10 ? '隐藏' : '显示') + '该轮播图吗？', {
                title: '友情提示'
            }, function (index) {
                $.post("<?= siteUrl('wxapp.banner/state') ?>", {
                    banner_id: data.id,
                    state: Number(!(parseInt(data.state) === 10))
                }, function (result) {
                    result.code === 1 ? $.show_success(result.msg, result.url) :
                        $.show_error(result.msg);
                });
                layer.close(index);
            });

        });

        // 删除元素
        var url = "<?= siteUrl('wxapp.banner/delete') ?>";
        $('.item-delete').delete('banner_id', url);

    });
</script>
