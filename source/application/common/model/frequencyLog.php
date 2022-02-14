<?php


namespace app\common\model;

/**
 * 剩余次数变动模型
 * Class frequencyLog
 * @package app\common\model
 */
class frequencyLog extends BaseModel
{
    protected $name = 'frequency_log';

    /**
     * 关联用户表
     * @return \think\model\relation\HasOne
     */
    public function user()
    {
        return $this->hasOne('User', 'user_id', 'user_id');
    }

    /**
     * 关联赋能记录表
     * @return \think\model\relation\HasOne
     */
    public function generate()
    {
        return $this->hasOne('Generate', 'generate_key', 'key');
    }

    /**
     * 新增赋能记录
     * @param $param
     * @return false|int
     */
    public static function add($param)
    {
        return (new self)->allowField(true)->save($param);
    }


    /**
     * 获取记录详情
     * @param $log_id
     * @return frequencyLog|null
     * @throws \think\exception\DbException
     */
    public static function detail($log_id)
    {
        return self::get(['log_id' => $log_id], ['user', 'generate.image']);
    }

}