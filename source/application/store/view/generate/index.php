<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">赋能记录列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="tpp" value="<?= $request->get('tpp') ?>">
                            <input type="hidden" name="m" value="<?= $request->get('m') ?>">
                            <input type="hidden" name="c" value="<?= $request->get('c') ?>">
                            <input type="hidden" name="do" value="<?= $request->get('do') ?>">
                            <input type="hidden" name="a" value="<?= $request->get('a') ?>">
                            <div class="am-u-sm-12 am-u-md-9 am-u-sm-push-3">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="search"
                                                   placeholder="请输入口令/转发标题"
                                                   value="<?= $request->get('search') ?>">
                                            <div class="am-input-group-btn">
                                                <button class="am-btn am-btn-default am-icon-search"
                                                        type="submit"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>赋能ID</th>
                                <th>转发图片</th>
                                <th>口令</th>
                                <th>转发标题</th>
                                <th>用户信息</th>
                                <th>生成时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['generate_id'] ?></td>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['image']['file_path'] ?>" title="点击查看大图" target="_blank">
                                            <img src="<?= $item['image']['file_path'] ?>" width="72" height="72" alt="">
                                        </a>
                                    </td>
                                    <td class="am-text-middle"><?= $item['key'] ?></td>
                                    <td class="am-text-middle"><?= $item['title'] ?></td>
                                    <td class="am-text-middle">
                                        <p>用户ID: <?= $item['user']['user_id'] ?></p>
                                        <p>用户昵称: <?= $item['user']['nickName'] ?></p>
                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('generate/detail')): ?>
                                                <a href="<?= siteUrl('generate/detail',
                                                    ['generate_id' => $item['generate_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 查看详情
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('generate/delete')): ?>
                                                <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['generate_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="8" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="am-u-lg-12 am-cf">
                        <div class="am-fr"><?= $list->render() ?> </div>
                        <div class="am-fr pagination-total am-margin-right">
                            <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        // 删除元素
        var url = "<?= siteUrl('generate/delete') ?>";
        $('.item-delete').delete('generate_id', url);

    });
</script>

