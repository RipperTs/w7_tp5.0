<?php


namespace app\common\message;

use think\Db;
use think\Queue\Job;

/**
 * 消息队列处理类
 * Class DoJob
 * @package app\common\message
 */
class DoJob
{


    public function fire(Job $job,$data)
    {
        // todo: 因微擎框架限制,此处必须定义常量否则无法使用数据库操作
        define('MODULE_UNIACID', $data['uniacid']);
        if(empty($data)){
            $job->delete();
            return 0;
        }

        // 有些消息在到达消费者时,可能已经不再需要执行了
//        $isJobStillNeedToBeDone = $this->checkDatabaseToSeeIfJobNeedToBeDone($data);
//        if(!$isJobStillNeedToBeDone){
//            $job->delete();
//            return 0;
//        }

    }

}