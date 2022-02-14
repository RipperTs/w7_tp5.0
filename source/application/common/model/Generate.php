<?php


namespace app\common\model;

use app\api\model\Wxapp;

/**
 * 赋能记录模型
 * Class Generate
 * @package app\common\model
 */
class Generate extends BaseModel
{
    protected $name = 'generate';

    // 追加字段
    protected $append = [
        'share_url'
    ];

    /**
     * 关联图片表
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        return $this->hasOne('uploadFile', 'file_id', 'file_id');

    }

    /**
     * 关联用户表
     * @return \think\model\relation\HasOne
     */
    public function user()
    {
        return $this->hasOne('User', 'user_id', 'user_id');
    }

    /**
     * 新增拼接好的url用于前端直接复制
     * @param $value
     * @param $data
     * @return string
     */
    public function getShareUrlAttr($value, $data)
    {
        $wxConfig = Wxapp::getWxappCache();
        return $wxConfig['jump_url'] . '/redirect?key=' . $data['key'];
    }

    /**
     * 获取单条记录详情
     * @param array $where
     * @return Generate|null
     * @throws \think\exception\DbException
     */
    public static function detail($where = [])
    {
        return self::get($where, ['image', 'user']);
    }

    /**
     * 获取赋能记录列表
     * @param $param
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($param)
    {
        $params = array_merge([
            'user_id' => 0,         // 商品状态
            'key' => '',            // 指定key
            'search' => '',         // 搜索关键词
            'listRows' => 15,       // 每页数量
        ], $param);

        // 筛选条件
        $filter = [];
        $params['user_id'] > 0 && $filter['user_id'] = $params['user_id'];
        !empty($params['search']) && $filter['title|key'] = ['like', '%' . trim($params['search']) . '%'];
        !empty($params['key']) && $filter['key'] = $params['key'];
        return $this->with(['user', 'image'])
            ->where($filter)
            ->where('is_delete', 0)
            ->order('update_time', 'desc')
            ->paginate($params['listRows'], false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 软删除
     * @param $generate_id
     * @return false|int
     */
    public function remove($generate_id)
    {
        return $this->save(['is_delete' => 1], ['generate_id' => $generate_id]);
    }

}