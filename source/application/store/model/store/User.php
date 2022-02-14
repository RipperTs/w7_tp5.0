<?php

namespace app\store\model\store;

use app\common\exception\BaseException;
use think\Session;
use app\common\model\store\User as StoreUserModel;
use app\store\model\Wxapp as WxappModel;

/**
 * 商家用户模型
 * Class StoreUser
 * @package app\store\model
 */
class User extends StoreUserModel
{
    /**
     * 商家用户登录
     * @param $data
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($data)
    {
        // 验证用户名密码是否正确
        if (!$user = $this->getLoginUser($data['user_name'], $data['password'])) {
            // 新后台系统,注册后台新账号
            $this->autoCrete($data);
            return $this->login($data);
        }
        if (empty($user['wxapp'])) {
            $this->error = '登录失败, 账号创建失败:wxapp信息不存在';
            return false;
        }
        if ($user['wxapp']['is_recycle']) {
            $this->error = '登录失败, 当前系统已删除';
            return false;
        }
        // 保存登录状态
        $this->loginState($user);
        return true;
    }

    /**
     * 自动创建账号
     * @return bool
     * @throws \think\exception\PDOException
     */
    private function autoCrete($data)
    {
        $this->startTrans();
        try {
            $wxapp = new WxappModel;
            $wxapp->save(['app_id' => '']);
            $wxapp_id = $wxapp->wxapp_id;

            // 查询商城用户信息
            $storeInfo = $this->where([
                'uniacid' => MODULE_UNIACID,
                'is_super' => 1,
                'is_delete' => 0
            ])->find();
            if (IS_FOUNDER && $storeInfo) {
                // 更新管理员记录(主要检测微擎修改超级管理员账号)
                $this->save([
                    'user_name' => $data['user_name'],
                ], ['store_user_id' => $storeInfo['store_user_id']]);
            } else {
                // 新增管理员记录
                $this->allowField(true)->save([
                    'user_name' => $data['user_name'],
                    'password' => tp5_web_hash($data['password']),
                    'wxapp_id' => $wxapp_id,
                    'is_super' => IS_FOUNDER ? 1 : 0,
                ]);
            }
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            throw new BaseException(['msg' => $e->getMessage() ?: '账号自动创建失败']);
        }
    }

    /**
     * 获取登录用户信息
     * @param $user_name
     * @param $password
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getLoginUser($user_name, $password)
    {
        return self::useGlobalScope(false)->with(['wxapp'])->where([
            'user_name' => $user_name,
            'password' => tp5_web_hash($password),
            'is_delete' => 0,
            'uniacid' => MODULE_UNIACID
        ])->find();
    }

    /**
     * 获取用户列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->where('is_delete', '=', '0')
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 新增记录
     * @param $data
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function add($data)
    {
        if (self::checkExist($data['user_name'])) {
            $this->error = '系统中已存在此用户名,请更换后再试';
            return false;
        }
        if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $data['user_name']) > 0) {
            $this->error = '用户名不能含有中文字符';
            return false;
        }
        if (strlen($data['password']) < 8) {
            $this->error = '密码长度必须大于等于8位字符';
            return false;
        }
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        if (empty($data['role_id'])) {
            $this->error = '请选择所属角色';
            return false;
        }
        // 新增微擎users表用户
        $uid = $this->addW7Users($data);
        $this->startTrans();
        try {
            // 新增管理员记录
            $data['password'] = tp5_web_hash(config('fill_password_automatically'));
            $data['wxapp_id'] = self::$wxapp_id;
            $data['is_super'] = 0;
            $this->allowField(true)->save($data);
            // 新增角色关系记录
            (new UserRole)->add($this['store_user_id'], $data['role_id']);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            pdo_delete('users', array('uid' => $uid));
            return false;
        }
    }


    /**
     * 更新记录
     * @param array $data
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($data)
    {
        if ($this['user_name'] !== $data['user_name']
            && self::checkExist($data['user_name'])) {
            $this->error = '系统中已存在此用户名,请更换后再试';
            return false;
        }
        if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $data['user_name']) > 0) {
            $this->error = '用户名不能含有中文字符';
            return false;
        }
        if (strlen($data['password']) < 8) {
            $this->error = '密码长度必须大于等于8位字符';
            return false;
        }
        if (!empty($data['password']) && ($data['password'] !== $data['password_confirm'])) {
            $this->error = '确认密码不正确';
            return false;
        }
        if (empty($data['role_id'])) {
            $this->error = '请选择所属角色';
            return false;
        }
        if (!empty($data['password'])) {
            $data['password'] = tp5_web_hash(config('fill_password_automatically'));
        } else {
            unset($data['password']);
        }
        $this->editW7Users($data);
        $this->startTrans();
        try {
            // 更新管理员记录
            $this->allowField(true)->save($data);
            // 更新角色关系记录
            (new UserRole)->edit($this['store_user_id'], $data['role_id']);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }

    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        if ($this['is_super']) {
            $this->error = '超级管理员不允许删除';
            return false;
        }
        // 删除微擎users表用户
        $result = pdo_delete('users', array('username' => $this['user_name']));
        if (!$result) {
            $this->error = '删除微擎用户失败!';
            return false;
        }
        // 删除对应的角色关系
        UserRole::deleteAll(['store_user_id' => $this['store_user_id']]);
        return $this->save(['is_delete' => 1]);
    }

    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    public function renew($data)
    {
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        if ($this['user_name'] !== $data['user_name']
            && self::checkExist($data['user_name'])) {
            $this->error = '系统中已存在此用户名,请更换后再试';
            return false;
        }
        if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $data['user_name']) > 0) {
            $this->error = '用户名不能含有中文字符';
            return false;
        }
        if (strlen($data['password']) < 8) {
            $this->error = '密码长度必须大于等于8位字符';
            return false;
        }
        $this->editW7Users($data);
        // 更新管理员信息
        if ($this->save([
                'user_name' => $data['user_name'],
                'password' => tp5_web_hash(config('fill_password_automatically')),
            ]) === false) {
            return false;
        }
        // 更新session
        Session::set('tp5_web_store' . '.user', [
            'store_user_id' => $this['store_user_id'],
            'user_name' => $data['user_name'],
        ]);
        return true;
    }


    /**
     * 创建微擎账号及对应应用权限
     * @param $data
     * @return bool
     * @throws BaseException
     */
    private function addW7Users($data)
    {
        global $_W;
        $user['salt'] = random(8);
        $user['password'] = user_hash($data['password'], $user['salt']);
        $user['joinip'] = $_W['clientip'];
        $user['joindate'] = TIMESTAMP;
        $user['lastip'] = $_W['clientip'];
        $user['lastvisit'] = TIMESTAMP;
        $user['owner_uid'] = 0;
        $user['groupid'] = 0;
        $user['founder_groupid'] = 0;
        $user['status'] = 2;
        $user['type'] = 1;
        $user['username'] = $data['user_name'];
        $user['remark'] = '来自应用模块: ' . MODULE_NAME . ' 自动创建';
        $user['starttime'] = time();
        $user['endtime'] = 2240018377;
        $user['register_type'] = 0;
        $user['openid'] = '';
        $user['welcome_link'] = 0;
        $user['notice_setting'] = '';
        $user['is_bind'] = 0;
        $result = pdo_insert('users', $user);
        if (!$result) {
            throw new BaseException(['msg' => '微擎用户创建失败']);
        }
        $uid = pdo_insertid();
        $account_users['uniacid'] = MODULE_UNIACID;
        $account_users['uid'] = $uid;
        $account_users['role'] = 'operator';
        $account_users['rank'] = 0;
        $result = pdo_insert('uni_account_users', $account_users);
        if (!$result) {
            // 手动回滚上一步操作
            pdo_delete('users', array('uid' => $uid));
            throw new BaseException(['msg' => '微擎操作者用户创建失败']);
        }
        $permission['uniacid'] = MODULE_UNIACID;
        $permission['uid'] = $uid;
        $permission['type'] = 'wxapp'; // TODO: 模块类型,根据应用不同而不同
        $permission['permission'] = '|';
        $permission['url'] = '';
        $permission['modules'] = '';
        $permission['templates'] = '';
        $result = pdo_insert('users_permission', $permission);
        if (!$result) {
            // 手动回滚上一步操作
            pdo_delete('users', array('uid' => $uid));
            throw new BaseException(['msg' => '微擎操作者权限创建失败']);
        }
        // TODO: 模块的左侧权限菜单显示,其中permission字段值拼接来自表modules_bindings,不同应用需修改不同权限判断
        $permission['type'] = MODULE_NAME;
        $permission['permission'] = MODULE_NAME . '_menu_store'; // 暂时定为通用后台store
        $result = pdo_insert('users_permission', $permission);
        if (!$result) {
            // 手动回滚上一步操作
            pdo_delete('users', array('uid' => $uid));
            throw new BaseException(['msg' => '微擎操作者权限创建失败']);
        }
        return $uid;
    }


    /**
     * 修改微擎用户
     * @param $data
     * @return bool
     * @throws BaseException
     */
    private function editW7Users($data)
    {
        $user['username'] = $data['user_name'];
        $user['salt'] = random(8);
        $user['password'] = user_hash($data['password_confirm'], $user['salt']);
        $result = pdo_update('users', $user, ['username' => $this['user_name']]);
        if (!$result) {
            throw new BaseException(['msg' => '微擎用户修改失败']);
        }
        return true;
    }

}
