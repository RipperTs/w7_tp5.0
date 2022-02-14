<?php

namespace app\store\controller\wxapp;

use app\store\controller\Controller;
use app\common\model\Banner as BannerModel;

/**
 * 轮播图管理
 * Class Banner
 * 2020年10月01日12:41:45
 */
class Banner extends Controller
{

    /**
     * 轮播图列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = BannerModel::with('image')
            ->order(['sort' => 'asc', 'update_time' => 'desc'])
            ->select();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 新增轮播图
     * @return array|bool|mixed
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        $banner = $this->postData('banner');
        if (empty($banner['file_id'])) {
            return $this->renderError('请添加轮播图片！');
        }
        $model = new BannerModel;
        $res = $model->add($banner);
        if ($res) {
            return $this->renderSuccess('添加成功', siteUrl('wxapp.banner/index'));
        }
        return $this->renderError('添加失败');
    }

    /**
     * 修改轮播图
     * @param $banner_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($banner_id)
    {
        $model = BannerModel::detail($banner_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        $model->edit($this->postData('banner'));
        return $this->renderSuccess('操作成功', siteUrl('wxapp.banner/index'));
    }


    /**
     * 修改轮播图状态
     * @param $banner_id
     * @param $state
     * @return array|bool
     */
    public function state($banner_id, $state)
    {
        $model = new BannerModel;
        $data['status'] = $state == 0 ? 20 : 10;
        $res = $model->save($data, ['banner_id' => $banner_id]);
        if ($res) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError('操作失败');
    }

    /**
     * 删除轮播图
     * @param $banner_id
     * @return array|bool
     */
    public function delete($banner_id)
    {
        $res = BannerModel::where('banner_id', $banner_id)->delete();
        if ($res) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError('操作失败');
    }

}
