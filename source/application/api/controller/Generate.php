<?php


namespace app\api\controller;

use  app\api\model\Generate as GenerateModel;
use  app\common\service\qrcode\Generate as GenerateServer;
use app\common\enum\user\balanceLog\Scene as SceneEnum;
use app\api\model\user\BalanceLog as BalanceLogModel;
use think\Db;
use app\api\model\Wxapp;
use think\Cache;

/**
 * 赋能记录控制器
 * Class Generate
 * @package app\api\controller
 */
class Generate extends Controller
{

    /**
     * 获取赋能详情
     * @param $key
     * @return array
     * @throws \think\exception\DbException
     */
    public function detail($key)
    {
        $detail = GenerateModel::detail(['key' => $key, 'user_id' => $this->getUser()['user_id']]);
        return $this->renderSuccess(compact('detail'));
    }

    /**
     * 获取赋能记录列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        // 整理请求的参数
        $param = array_merge($this->request->param(), [
            'user_id' => $this->getUser()['user_id']
        ]);
        // 获取列表数据
        $model = new GenerateModel;
        $list = $model->getList($param);
        return $this->renderSuccess(compact('list'));
    }


    /**
     * 新增赋能记录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function create()
    {
        $user = $this->getUser();
        $param = $this->request->post();
        if ($user['balance'] <= 0 && $param['is_switch'] == 10) {
            return $this->renderError('您的余额不足,请充值后再试!');
        }
        if ($param['is_switch'] == 20 && !$this->checkFreeNum($user)) {
            return $this->renderError('您的免费生成次数已达到上限!');
        }
        $param['key'] = uniqid();
        $param['user_id'] = $user['user_id'];
        $wxConfig = Wxapp::getWxappCache();
        // 启动事务
        Db::startTrans();
        try {
            (new GenerateModel)->allowField(true)->save($param);
            // 仅开关开启再付费
            if ($param['is_switch'] == 10) {
                $user->where('user_id', $user['user_id'])->setDec('balance');
                // 新增余额变动记录
                BalanceLogModel::add(SceneEnum::CONSUME, [
                    'user_id' => $user['user_id'],
                    'money' => -1,
                    'remark' => '赋能消耗',
                ], [$param['key']]);
            }
            // TODO: 缓存口令 不存入数据库
            cache($param['key'], $param['command'], $wxConfig['command_time'] * 86400);
            // 提交事务
            Db::commit();
            return $this->renderSuccess([
                'url' => $wxConfig['jump_url'] . '/redirect?key=' . $param['key'],
                'key' => $param['key'],
            ], '赋能成功,您可以复制链接,下载海报,点击右上角转发到微信QQ等社交用户!');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $this->renderError($e->getMessage() ?: '系统繁忙');
        }
    }

    /**
     * 检查免费次数
     * @param $user
     * @return bool
     */
    protected function checkFreeNum($user)
    {
        if (cache($user['user_id']) > 2) {
            return false;
        }
        Cache::inc($user['user_id']);
        return true;
    }

    /**
     * 根据key查找赋能记录
     * @param $key
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function findKey($key)
    {
        $detail = (new  GenerateModel)->where('key', $key)->find();
        $command = cache($key); // 取出口令
        return $this->renderSuccess(compact('detail', 'command'));
    }

    /**
     * 获取海报图片
     * @param $generate_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function poster($key)
    {
        $detail = GenerateModel::detail(['key' => $key]);
        $Qrcode = new GenerateServer($detail, $this->getUser(false), $this->request->param());
        return $this->renderSuccess([
            'qrcode' => $Qrcode->getImage(),
        ]);
    }


}