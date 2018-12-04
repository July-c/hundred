<?php
// +----------------------------------------------------------------------
// | Common 
// +----------------------------------------------------------------------
// | 版权所有 2015-2020 武汉市微易科技有限公司，并保留所有权利。
// +----------------------------------------------------------------------
// | 网站地址: https://www.kdfu.cn
// +----------------------------------------------------------------------
// | 这不是一个自由软件！您只能在不用于商业目的的前提下使用本程序
// +----------------------------------------------------------------------
// | 不允许对程序代码以任何形式任何目的的再发布
// +----------------------------------------------------------------------
// | Author: 微小易    Date: 2018-12-01
// +----------------------------------------------------------------------
namespace app\common\model;
use think\facade\Session;
use think\model\relation\RelationShip;
/**
 * 商家用户模型
 * Class StoreUser
 * @package app\common\model
 */
class StoreUser extends BaseModel
{
    protected $name = 'manager';
    /**
     * 关联微信小程序表
     * @return \think\model\relation\BelongsTo
     */
    public function app() {
        return $this->belongsTo('App','','app_id');
    }
    /**
     * 新增默认商家用户信息
     * @param $app_id
     * @return false|int
     */
    public function insertDefault($app_id)
    {
        return $this->save([
            'user_name' => 'wymall_' . $app_id,
            'password' => md5(uniqid()),
            'app_id' => $app_id,
        ]);
    }
    /**
     * 商家用户登录
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($data)
    {
        if (!$user = self::useGlobalScope(false)->with(['app'])->where([
            'user_name' => $data['user_name'],
            'password' => wymall_pass($data['password'])
        ])->find()) {
            $this->error = '登录失败, 用户名或密码错误';
            return false;
        }
        if (empty($user['app'])) {
            $this->error = '登录失败, 未找到小程序信息';
            return false;
        }
        // 保存登录状态
        Session::set('wymall_store', [
            'user' => [
                'user_id' => $user['user_id'],
                'user_name' => $user['user_name'],
            ],
            'app' => $user['app']['app_id'],						'ver' =>$user['app']['ver'],			
            'is_login' => true,
        ]);
        return true;
    }
    /**
     * 商户信息
     * @param $user_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($user_id)
    {
        return self::get($user_id);
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
        // 更新管理员信息
        if ($this->save([
                'user_name' => $data['user_name'],
                'password' => wymall_pass($data['password']),
            ]) === false) {
            return false;
        }
        // 更新session
        Session::set('wymall_store.user', [
            'user_id' => $this['user_id'],
            'user_name' => $data['user_name'],
        ]);
        return true;
    }
}