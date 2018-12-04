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
namespace app\api\controller\user;
use app\api\controller\Controller;
use app\common\model\Order as OrderModel;
use app\common\model\OrderList as OrderListModel;
use app\common\model\Comment as CommentModel;
/**
 * 订单评价管理
 * Class Comment
 * @package app\api\controller\user
 */
class Comment extends Controller
{
    /**
     * 待评价订单商品列表
     * @param $order_id
     * @return array
     * @throws \Exception
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function order($order_id)
    {
		
        // 用户信息
        $user = $this->getUser();
        // 订单信息
        $order = OrderModel::getUserOrderDetail($order_id, $user['user_id']);
        // 验证订单是否已完成
        $model = new CommentModel;
        if (!$model->checkOrderAllowComment($order)) {
            return $this->renderError($model->getError());
        }
        // 待评价商品列表
        /* @var \think\Collection $itemsList */
        $itemsList = OrderListModel::getNotComment($order_id);
        if ($itemsList->isEmpty()) {
            return $this->renderError('该订单没有可评价的商品');
        }
        // 提交商品评价
        if ($this->request->isPost()) {
            $formData = $this->request->post('formData', '', null);
            if ($model->addForOrder($order, $itemsList, $formData)) {
                return $this->renderSuccess([], '评价发表成功');
            }
            return $this->renderError($model->getError() ?: '评价发表失败');
        }
        return $this->renderSuccess(compact('itemsList'));
    }
}