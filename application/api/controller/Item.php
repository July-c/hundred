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
use app\common\model\Item as ItemModel;
use app\common\model\Cart as CartModel;
use app\common\model\ItemsSku;
use app\common\model\ItemSpecRel;
use app\common\model\ItemImage;
use app\common\service\qrcode\Item as ItemPoster;
/**
 * 商品控制器
 * Class Item
 * @package app\api\controller
 */
class Item extends Controller
{
    /**
     * 商品列表
     * @param $category_id
     * @param $search
     * @param $sortType
     * @param $sortPrice
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($category_id, $search, $sortType, $sortPrice)
    {
        $model = new ItemModel;
        $list = $model->getList(10, $category_id, $search, $sortType, $sortPrice);
        return $this->renderSuccess(compact('list'));
    }
    /**
     * 获取商品详情
     * @param $item_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($item_id)
    {
        // 商品详情
        $detail = ItemModel::detail($item_id);
		
        if (!$detail || $detail['is_delete']|| $detail['status'] !== 10) {
            return $this->renderError('很抱歉，商品信息不存在或已下架');
        }
        // 多规格商品sku信息
        $specData = $detail['spec_type'] === 20 ? $detail->getManySpecData($detail['spec_rel'], $detail['sku']) : null;
        // 购物车商品总数量
        if ($user = $this->getUser(false)) {
            $cart_total_num = (new CartModel($user['user_id']))->getTotalNum();
        }
        return $this->renderSuccess(compact('detail', 'cart_total_num', 'specData'));
    }
    /**
     * 获取推广二维码
     * @param $item_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function poster($item_id)
    {
        // 商品详情
        $detail = ItemModel::detail($item_id);
        $Qrcode = new ItemPoster($detail, $this->getUser(false));
        return $this->renderSuccess([
            'qrcode' => $Qrcode->getImage(),
        ]);
    }
}