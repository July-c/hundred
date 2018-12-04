<?php
// +----------------------------------------------------------------------
// | API 
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
namespace app\api\controller;
use app\common\model\User as UserModel;
/**
 * 用户管理
 * Class User
 * @package app\api
 */
class User extends Controller
{
	/**
     * app/web/等手机号登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
	public function app_login()
    {
        $model = new UserModel;
		$user=$model->app_login($this->request->post());
		if($user){
			return $this->renderSuccess([
				'user_id' => $user,
				'token' => $model->getToken()
			]);
		}
		return $this->renderError('登录失败');
    }
	/*
	*app/web/等手机号注册
	* @return array
	*/
	public function app_reg(){
		$model = new UserModel;
        return $this->renderSuccess([
            'user_id' => $model->reg($this->request->post()),
            'token' => $model->getToken()
        ]);
	
	}
    /*
     * 用户自动登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login()
    {
		
        $model = new UserModel;		
		
        return $this->renderSuccess([
            'user_id' => $model->login($this->request->post()),
            'token' => $model->getToken()
        ]);
    }
}