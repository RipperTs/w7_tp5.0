<?php

namespace app\common\model;

/**
 * 首页轮播图模型
 * Class Banner
 * @package app\common\model
 */
class Banner extends BaseModel
{
    protected $name = 'banner';

    /**
     * 关联图片
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        return $this->hasOne('uploadFile', 'file_id', 'file_id');
    }

    /**
     * 获取轮播详情
     * @param $banner_id
     * @return Banner|null
     * @throws \think\exception\DbException
     */
    public static function detail($banner_id)
    {
        return self::get(['banner_id' => $banner_id], ['image']);
    }


    /**
     * 添加轮播图
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        return $this->allowField(true)->save($data);
    }

    /**
     * 更新记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        return $this->allowField(true)->save($data) !== false;
    }


}
