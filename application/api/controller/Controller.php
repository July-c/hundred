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
use app\common\exception\BaseException;
use think\Controller as ThinkController;
use think\exception\HttpException;
/**
 * API控制器基类
 * Class BaseController
 * @package app\store\controller
 */
class Controller extends ThinkController
{
    const JSON_SUCCESS_STATUS = 1;
    const JSON_ERROR_STATUS = 0;
    /* @ver $app_id 小程序id */
    protected $app_id;
    /**
     * 基类初始化
     * @throws BaseException
     */
    public function initialize()
    {
		
        // 当前小程序id
        $this->app_id = $this->getAppId();
		
    }
    /**
     * 获取当前小程序ID
     * @return mixed
     * @throws BaseException
     */
    private function getAppId()
    {
        if (!$app_id = $this->request->param('app_id')) {
            throw new BaseException(['msg' => '缺少必要的参数：app_id']);
        }
		
        return $app_id;
    }
    /**
     * 获取当前用户信息
     * @param bool $is_force
     * @return UserModel|bool|null
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    protected function getUser($is_force = true)
    {
        if (!$token = $this->request->param('token')) {
           // $is_force && $this->throwError('缺少必要的参数：token', -1);
            return false;
        }
        if (!$user = UserModel::getUser($token)) {
           //$is_force && $this->throwError('没有找到用户信息', -1);
            return false;
        }
		
        return $user;
    }
    /**
     * 输出错误信息
     * @param int $code
     * @param $msg
     * @throws BaseException
     */
    protected function throwError($msg, $code = 0)
    {
		
        throw new BaseException(['code' => $code, 'msg' => $msg]);
    }
    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderJson($code = self::JSON_SUCCESS_STATUS, $msg = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }
    /**
     * 返回操作成功json
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderSuccess($data = [], $msg = 'success')
    {
        return $this->renderJson(self::JSON_SUCCESS_STATUS, $msg, $data);
    }
    /**
     * 返回操作失败json
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $data = [])
    {
        return $this->renderJson(self::JSON_ERROR_STATUS, $msg, $data);
    }
    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key)
    {
        return $this->request->post($key . '/a');
    }
}