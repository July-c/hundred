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
use app\common\model\Order as OrderModel;
use app\common\model\App as AppModel;
use app\common\model\Cart as CartModel;
use app\common\model\AppPrepayId as AppPrepayIdModel;
use app\common\library\wechat\WxPay;
/**
 * 订单控制器
 * Class Order
 * @package app\api\controller
 */
class Order extends Controller
{
    /* @var \app\common\model\User $user */
    private $user;
    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function initialize()
    {
        parent::initialize();
        $this->user = $this->getUser();   // 用户信息
    }
    /**
     * 订单确认-立即购买
     * @param $item_id
     * @param $item_num
     * @param $item_sku_id
     * @param $coupon_id
     * @param string $remark
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function buyNow($item_id, $item_num, $item_sku_id, $coupon_id = null, $remark = '')
    {
        // 商品结算信息
        $model = new OrderModel;
		
        $order = $model->getBuyNow($this->user, $item_id, $item_num, $item_sku_id);
		
        if (!$this->request->isPost()) {
            return $this->renderSuccess($order);
        }
        if ($model->hasError()) {
            return $this->renderError($model->getError());
        }
        // 创建订单
        if ($model->createOrder($this->user['user_id'], $order, $coupon_id, $remark)) {
            // 发起微信支付
			
            return $this->renderSuccess([
                'payment' => $this->unifiedorder($model, $this->user),
                'order_id' => $model['order_id']
            ]);
        }
        $error = $model->getError() ?: '订单创建失败';
        return $this->renderError($error);
    }
    /**
     * 订单确认-购物车结算
     * @param string $cart_ids (支持字符串ID集)
     * @param $coupon_id
     * @param string $remark
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function cart($cart_ids, $coupon_id = null, $remark = '')
    {
        // 商品结算信息
        $Card = new CartModel($this->user['user_id']);
        $order = $Card->getList($this->user, $cart_ids);
		
        if (!$this->request->isPost()){
            return $this->renderSuccess($order);
        }
        // 创建订单
        $model = new OrderModel;
		
        if ($model->createOrder($this->user['user_id'], $order, $coupon_id, $remark)) {
            // 移出购物车中已下单的商品
            $Card->clearAll($cart_ids);
            // 发起微信支付
            return $this->renderSuccess([
                'payment' => $this->unifiedorder($model, $this->user),
                'order_id' => $model['order_id']
            ]);
        }
        return $this->renderError($model->getError() ?: '订单创建失败');
    }
    /**
     * 构建微信支付
     * @param $order
     * @param $user
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    private function unifiedorder($order, $user)
    {
        // 统一下单API
        $wxConfig = AppModel::getAppCache();
        $WxPay = new WxPay($wxConfig);
		
        $payment = $WxPay->unifiedorder($order['order_no'], $user['open_id'], $order['pay_price']);
		
        // 记录prepay_id
        $model = new AppPrepayIdModel;
        $model->add($payment['prepay_id'], $order['order_id'], $user['user_id']);
        return $payment;
    }
}