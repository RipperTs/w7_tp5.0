<?php

namespace app\store\model;

use app\common\library\helper;
use app\common\model\Store as StoreModel;
use app\store\model\recharge\Order as OrderModel;
use app\store\model\recharge\Plan as PlanModel;

/**
 * 商城模型
 * Class Store
 * @package app\store\model
 */
class Store extends StoreModel
{
    private $UserModel;
    private $GenerateModel;

    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        $this->UserModel = new User;
        $this->GenerateModel = new Generate;
    }

    /**
     * 后台首页数据
     * @return array
     * @throws \think\Exception
     */
    public function getHomeData()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        // 最近七天日期
        $lately7days = $this->getLately7days();
        $data = [
            'widget-card' => [
                // 充值套餐总量
                'plan_total' => $this->getRechargePlanTotal(),
                // 用户总量
                'user_total' => $this->getUserTotal(),
                // 赋能记录总量
                'generate_total' => $this->getGenerateTotal(),
                // 充值金额总量
                'recharge_total' => $this->getRechargePriceTotal()
            ],
        ];

        return $data;
    }

    /**
     * 最近七天日期
     */
    private function getLately7days()
    {
        // 获取当前周几
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $date[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        return array_reverse($date);
    }


    /**
     * 获取用户总量
     * @param null $day
     * @return string
     * @throws \think\Exception
     */
    private function getUserTotal($day = null)
    {
        return number_format($this->UserModel->getUserTotal($day));
    }

    /**
     * 获取充值套餐总数量
     * @param null $day
     * @return string
     */
    private function getRechargePlanTotal($day = null)
    {
        return number_format((new PlanModel)->getRechargePlanTotal($day));
    }

    /**
     * 获取用户充值总金额
     * @param null $day
     * @return string
     */
    private function getRechargePriceTotal($day = null)
    {
        return helper::number2((new OrderModel())->getRechargePriceTotal($day));
    }

    /**
     * 获取赋能订单总量
     * @param null $day
     * @return string
     */
    private function getGenerateTotal($day = null)
    {
        return number_format($this->GenerateModel->getGenerateTotal($day));
    }

    /**
     * 获取订单总量
     * @param null $day
     * @return string
     * @throws \think\Exception
     */
    private function getOrderTotal($day = null)
    {
        return number_format($this->OrderModel->getPayOrderTotal($day, $day));
    }

    /**
     * 获取订单总量 (指定日期)
     * @param $days
     * @return array
     * @throws \think\Exception
     */
    private function getOrderTotalByDate($days)
    {
        $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotal($day);
        }
        return $data;
    }


}