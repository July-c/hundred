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
namespace app\user\controller\market;
use app\user\controller\Controller;
use app\common\model\Coupon as CouponModel;
use app\common\model\UserCoupon as UserCouponModel;
/**
 * 优惠券管理
 * Class Coupon
 * @package app\user\controller\market
 */
class Coupon extends Controller
{
    /* @var CouponModel $model */
    private $model;
    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        $this->model = new CouponModel;
    }
    /**
     * 优惠券列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
		
        $list = $this->model->getList();
        return $this->fetch('index', compact('list'));
    }
    /**
     * 添加优惠券
     * @return array|mixed
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        if ($this->model->add($this->postData('coupon'))) {
            return $this->renderSuccess('添加成功', url('market.coupon/index'));
        }
        return $this->renderError($this->model->getError() ?: '添加失败');
    }
    /**
     * 更新优惠券
     * @param $coupon_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($coupon_id)
    {
        // 优惠券详情
        $model = CouponModel::detail($coupon_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 更新记录
        if ($model->edit($this->postData('coupon'))) {
            return $this->renderSuccess('更新成功', url('market.coupon/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
    /**
     * 删除优惠券
     * @param $coupon_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function delete($coupon_id)
    {
        // 优惠券详情
        $model = CouponModel::detail($coupon_id);
        // 更新记录
        if ($model->setDelete()) {
            return $this->renderSuccess('删除成功', url('market.coupon/index'));
        }
        return $this->renderError($model->getError() ?: '删除成功');
    }
    /**
     * 领取记录
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function receive()
    {
        $model = new UserCouponModel;
        $list = $model->getList();	
        return $this->fetch('receive', compact('list'));
    }
}