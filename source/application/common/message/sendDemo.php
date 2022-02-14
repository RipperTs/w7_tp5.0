<?php


namespace app\common\message;


use think\Controller;
use think\Queue;

/**
 * 添加消息队列demo
 * Class sendDemo
 * @package app\common\message
 */
class sendDemo extends Controller
{

    public function index()
    {
        // 定义要传递给队列的数据(类型是数组)
        $jobData = ['type' => 1, 'data_id' => 12, 'ts' => time()];
        // 将该任务推送到消息队列，等待对应的消费者去执行
        // todo: 因微擎框架限制,此处必须传递参数uniacid
        $isPushed = Queue::push('app\common\message\DoJob', ['uniacid' => MODULE_UNIACID, 'data' => $jobData], 'JobQueue');
        if ($isPushed !== false) {
            return '消息已发出';
        } else {
            return '消息发送出错';
        }
    }

}