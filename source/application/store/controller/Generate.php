<?php


namespace app\store\controller;

use app\common\model\Generate as GenerateModel;
use app\store\model\Wxapp;
/**
 * 赋能记录控制器
 * Class Generate
 * @package app\store\controller
 */
class Generate extends Controller
{
    /**
     * 赋能记录列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $model = new GenerateModel();
        $list = $model->getList($this->request->param());
        return $this->fetch('index', compact('list'));
    }


    /**
     * 删除赋能记录
     * @param $generate_id
     * @return array|bool
     */
    public function delete($generate_id)
    {
        $model = new GenerateModel();
        if ($model->remove($generate_id)) {
            return $this->renderSuccess('删除成功');
        }
        return $this->renderError('删除失败');
    }

    /**
     * 获取赋能记录详情
     * @param $generate_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function detail($generate_id)
    {
        $detail = GenerateModel::detail(['generate_id' => $generate_id]);
        return $this->fetch('detail', compact('detail'));
    }


}