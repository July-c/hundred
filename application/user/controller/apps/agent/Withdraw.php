<?php
// +----------------------------------------------------------------------
// | User 
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
namespace app\user\controller\apps\agent;
use app\user\controller\Controller;
use app\common\model\agent\Withdraw as WithdrawModel;
/**
 * 分销商提现申请
 * Class Setting
 * @package app\user\controller\apps\agent
 */
class Withdraw extends Controller
{
    /**
     * 提现记录列表
     * @param int $user_id
     * @param int $apply_status
     * @param int $pay_type
     * @param string $search
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($user_id = null, $apply_status = -1, $pay_type = -1, $search = '')
    {
        $model = new WithdrawModel;
		
        return $this->fetch('index', [
            'list' => $model->getListUser($user_id, $apply_status, $pay_type, $search)
        ]);
    }
    /**
     * 分销商审核
     * @param $id
     * @return array
     * @throws \think\exception\DbException
     */
    public function submit($id)
    {
        $model = WithdrawModel::detail($id);
        if ($model->submit($this->postData('withdraw'))) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }
    /**
     * 确认打款
     * @param $id
     * @return array
     * @throws \think\exception\DbException
     */
    public function money($id)
    {
        $model = WithdrawModel::detail($id);
        if ($model->money()) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }
}