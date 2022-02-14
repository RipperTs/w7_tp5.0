<?php


namespace app\store\model;


class Generate extends \app\common\model\Generate
{

    /**
     * 获取赋能订单数量
     * @param null $day
     * @return int|string
     * @throws \think\Exception
     */
    public function getGenerateTotal($day = null)
    {
        if (!is_null($day)) {
            $startTime = strtotime($day);
            $this->where('create_time', '>=', $startTime)
                ->where('create_time', '<', $startTime + 86400);
        }
        return $this->where('is_delete', '=', '0')->count();
    }
}