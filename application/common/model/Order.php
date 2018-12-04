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
use think\facade\Request;
use think\facade\Hook;
use app\common\service\Message;
use think\Db;
use app\common\model\agent\Order as AgentOrderModel;
use app\common\exception\BaseException;
/**
 * 订单模型
 * Class Order
 * @package app\common\model
 */
class Order extends BaseModel
{
    protected $name = 'order';
	protected $pk = 'order_id';
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'app_id',
        'update_time'
    ];
    /**
     * 订单模型初始化
     */
    public static function init()
    {	
        parent::init();
        // 监听订单处理事件
        $static = new static;
        Hook::listen('order', $static);
    }
    /**
     * 订单商品列表
     * @return \think\model\relation\HasMany
     */
    public function item()
    {
        return $this->hasMany('OrderList');
    }
    /**
     * 关联订单收货地址表
     * @return \think\model\relation\HasOne
     */
    public function address()
    {
        return $this->hasOne('OrderAddress');
    }
    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
    /**
     * 关联物流公司表
     * @return \think\model\relation\BelongsTo
     */
    public function express()
    {
        return $this->belongsTo('Express');
    }
    /**
     * 改价金额（差价）
     * @param $value
     * @return array
     */
    public function getUpdatePriceAttr($value)
    {	
        return [
            'symbol' => $value < 0 ? '-' : '+',
            'value' => sprintf('%.2f', abs($value))
        ];
    }
    /**
     * 付款状态
     * @param $value
     * @return array
     */
    public function getPayStatusAttr($value)
    {
        $status = [10 => '待付款', 20 => '已付款'];
        return ['text' => $status[$value], 'value' => $value];
    }
    /**
     * 发货状态
     * @param $value
     * @return array
     */
    public function getDeliveryStatusAttr($value)
    {
        $status = [10 => '待发货', 20 => '已发货'];
        return ['text' => $status[$value], 'value' => $value];
    }
    /**
     * 收货状态
     * @param $value
     * @return array
     */
    public function getReceiptStatusAttr($value)
    {
        $status = [10 => '待收货', 20 => '已收货'];
        return ['text' => $status[$value], 'value' => $value];
    }
    /**
     * 收货状态
     * @param $value
     * @return array
     */
    public function getOrderStatusAttr($value)
    {
        $status = [10 => '进行中', 20 => '取消', 30 => '已完成'];
        return ['text' => $status[$value], 'value' => $value];
    }
    /**
     * 生成订单号
     * @return string
     */
    protected function orderNo()
    {	
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
    /**
     * 订单详情
     * @param $where
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {	
        is_array($where) ? $filter = $where : $filter['order_id'] = (int)$where;
        return self::get($filter, ['item.image', 'address', 'express']);
    }
	 /**
     * 订单确认-立即购买
     * @param User $user
     * @param $item_id
     * @param $item_num
     * @param $item_sku_id
     * @return array
     * @throws \think\exception\DbException
     * @throws \app\common\exception\BaseException
     */
    public function getBuyNow($user, $item_id, $item_num, $item_sku_id)
    {
        // 商品信息
        /* @var Item $Item */
        $Item = Item::detail($item_id);
		
        // 判断商品是否下架
        if (!$Item || $Item['is_delete'] || $Item['status'] === 20) {
            throw new BaseException(['msg' => '很抱歉，商品信息不存在或已下架']);
        }
        // 商品sku信息
        $Item['item_sku'] = $Item->getItemSku($item_sku_id);
		
        // 判断商品库存
        if ($item_num > $Item['item_sku']['stock_num']) {
            $this->setError('很抱歉，商品库存不足');
        }
        // 商品单价
        $Item['item_price'] = $Item['item_sku']['item_price'];
        // 商品总价
        $Item['total_num'] = $item_num;
        $Item['total_price'] = $totalPrice = bcmul($Item['item_price'], $item_num, 2);
		
        // 商品总重量
        $total_weight = bcmul($Item['item_sku']['weight'], $item_num, 2);
        // 当前用户收货城市id
        $cityId = $user['address_default'] ? $user['address_default']['city_id'] : null;
		
        // 是否存在收货地址
        $exist_address = !empty($user['address']);
		
        // 验证用户收货地址是否存在运费规则中
        if (!$intraRegion = $Item['delivery']->checkAddress($cityId)) {
            $exist_address && $this->setError('很抱歉，您的收货地址不在配送范围内');
        }
		
        // 计算配送费用
        $expressPrice = $intraRegion ? $Item['delivery']->calcTotalFee($item_num, $total_weight, $cityId) : 0;
			
        // 订单总金额 (含运费)
        $orderPayPrice = bcadd($totalPrice, $expressPrice, 2);
			
        // 可用优惠券列表
        $couponList = UserCoupon::getUserCouponList($user['user_id'], $totalPrice);
	
        return [
            'item_list' => [$Item],               // 商品详情
            'order_total_num' => $item_num,        // 商品总数量
            'order_total_price' => $totalPrice,     // 商品总金额 (不含运费)
            'order_pay_price' => $orderPayPrice,    // 订单总金额 (含运费)
            'coupon_list' => array_values($couponList),   // 优惠券列表
            'address' => $user['address_default'],  // 默认地址
            'exist_address' => $exist_address,      // 是否存在收货地址
            'express_price' => $expressPrice,       // 配送费用
            'intra_region' => $intraRegion,         // 当前用户收货城市是否存在配送规则中
            'has_error' => $this->hasError(),
            'error_msg' => $this->getError(),
        ];
    }
    /**
     * 创建新订单
     * @param $user_id
     * @param $order
     * @param $coupon_id
     * @param string $remark
     * @return bool
     * @throws \Exception
     */
    public function createOrder($user_id, $order, $coupon_id = null, $remark = '')
    {
        if (empty($order['address'])) {
            $this->error = '请先选择收货地址';
            return false;
        }
        // 设置订单优惠券信息
        $this->setCouponPrice($order, $coupon_id);
        Db::startTrans();
        try {
            // 记录订单信息
            $this->add($user_id, $order, $remark);
            // 保存订单商品信息
            $this->saveOrder($user_id, $order);
            // 更新商品库存 (针对下单减库存的商品)
            $this->updateStockNum($order['item_list']);
            // 记录收货地址
            $this->saveAddress($user_id, $order['address']);
            // 记录分销商订单
            AgentOrderModel::createOrder($this, $this['item']);
            // 事务提交
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            $this->error = $e->getMessage();
            return false;
        }
    }
    /**
     * 设置订单优惠券信息
     * @param $order
     * @param $coupon_id
     * @return bool
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function setCouponPrice(&$order, $coupon_id)
    {
        if ($coupon_id > 0 && !empty($order['coupon_list'])) {
            // 获取优惠券信息
            $couponInfo = [];
            foreach ($order['coupon_list'] as $coupon)
                $coupon['user_coupon_id'] == $coupon_id && $couponInfo = $coupon;
            if (empty($couponInfo)) throw new BaseException(['msg' => '未找到优惠券信息']);
            // 计算订单金额 (抵扣后)
            $orderTotalPrice = bcsub($order['order_total_price'], $couponInfo['reduced_price'], 2);
            $orderTotalPrice <= 0 && $orderTotalPrice = '0.01';
            // 记录订单信息
            $order['coupon_id'] = $coupon_id;
            $order['coupon_price'] = $couponInfo['reduced_price'];
            $order['order_pay_price'] = bcadd($orderTotalPrice, $order['express_price'], 2);
            // 设置优惠券使用状态
            $model = UserCoupon::detail($coupon_id);
            $model->setIsUse();
            return true;
        }
        $order['coupon_id'] = 0;
        $order['coupon_price'] = 0.00;
        return true;
    }
    /**
     * 新增订单记录
     * @param $user_id
     * @param $order
     * @param string $remark
     * @return false|int
     */
    private function add($user_id, &$order, $remark = '')
    {
        return $this->save([
            'user_id' => $user_id,
            'app_id' => self::$app_id,
            'order_no' => $this->orderNo(),
            'total_price' => $order['order_total_price'],
            'coupon_id' => $order['coupon_id'],
            'coupon_price' => $order['coupon_price'],
            'pay_price' => $order['order_pay_price'],
            'express_price' => $order['express_price'],
            'buyer_remark' => trim($remark),
        ]);
    }
    /**
     * 保存订单商品信息
     * @param $user_id
     * @param $order
     * @return int
     */
    private function saveOrder($user_id, &$order)
    {
        // 订单商品列表
        $itemsList = [];
        // 订单商品实付款金额 (不包含运费)
        $realTotalPrice = bcsub($order['order_pay_price'], $order['express_price'], 2);
        foreach ($order['item_list'] as $Item) {
            /* @var Item $Item */
            // 计算商品实际付款价
            $total_pay_price = $realTotalPrice * $Item['total_price'] / $order['order_total_price'];
            $itemsList[] = [
                'user_id' => $user_id,
                'app_id' => self::$app_id,
                'item_id' => $Item['item_id'],
                'name' => $Item['name'],
                'image_id' => $Item['image'][0]['image_id'],
                'type' => $Item['type'],
                'spec_type' => $Item['spec_type'],
                'spec_sku_id' => $Item['item_sku']['spec_sku_id'],
                'item_sku_id' => $Item['item_sku']['item_sku_id'],
                'item_attr' => $Item['item_sku']['item_attr'],
                'content' => $Item['content'],
                'item_no' => $Item['item_sku']['item_no'],
                'item_price' => $Item['item_sku']['item_price'],
                'line_price' => $Item['item_sku']['line_price'],
                'weight' => $Item['item_sku']['weight'],
                'total_num' => $Item['total_num'],
                'total_price' => $Item['total_price'],
                'total_pay_price' => sprintf('%.2f', $total_pay_price),
            ];
        }
        return $this->item()->saveAll($itemsList);
    }
    /**
     * 更新商品库存 (针对下单减库存的商品)
     * @param $item_list
     * @throws \Exception
     */
    private function updateStockNum($item_list)
    {
        $deductStockData = [];
        foreach ($item_list as $Item) {
            // 下单减库存
            $Item['type'] === 10 && $deductStockData[] = [
                'item_sku_id' => $Item['item_sku']['item_sku_id'],
                'stock_num' => ['dec', $Item['total_num']]
            ];
        }
        !empty($deductStockData) && (new ItemSku)->isUpdate()->saveAll($deductStockData);
    }
    /**
     * 记录收货地址
     * @param $user_id
     * @param $address
     * @return false|\think\Model
     */
    private function saveAddress($user_id, $address)
    {
        return $this->address()->save([
            'user_id' => $user_id,
            'app_id' => self::$app_id,
            'name' => $address['name'],
            'phone' => $address['phone'],
            'province_id' => $address['province_id'],
            'city_id' => $address['city_id'],
            'region_id' => $address['region_id'],
            'detail' => $address['detail'],
        ]);
    }
    /**
     * 用户中心订单列表
     * @param $user_id
     * @param string $type
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListapi($user_id, $type = 'all')
    {
        // 筛选条件
        $filter = [];
        // 订单数据类型
        switch ($type) {
            case 'all':
                break;
            case 'payment';
                $filter['pay_status'] = 10;
                break;
            case 'delivery';
                $filter['pay_status'] = 20;
                $filter['delivery_status'] = 10;
                break;
            case 'received';
                $filter['pay_status'] = 20;
                $filter['delivery_status'] = 20;
                $filter['receipt_status'] = 10;
                break;
            case 'comment';
                $filter['order_status'] = 30;
                $filter['is_comment'] = 0;
                break;
        }
        return $this->with(['item.image'])
            ->where('user_id', '=', $user_id)
            ->where('order_status', '<>', 20)
            ->where($filter)
            ->order(['create_time' => 'desc'])
            ->select();
    }
    /**
     * 取消订单
     * @return bool|false|int
     * @throws \Exception
     */
    public function cancel()
    {
        if ($this['pay_status']['value'] === 20) {
            $this->error = '已付款订单不可取消';
            return false;
        }
        // 回退商品库存
		
        $this->backStock($this['item']);
		
        return $this->save(['order_status' => 20]);
    }
    /**
     * 回退商品库存
     * @param $itemsList
     * @return array|false
     * @throws \Exception
     */
    private function backStock(&$itemsList)
    {
        $itemSpecSave = [];
        foreach ($itemsList as $Item) {
            // 下单减库存
            if ($Item['type'] === 10) {
                $itemSpecSave[] = [
                    'item_sku_id' => $Item['item_sku_id'],
                    'stock_num' => ['inc', $Item['total_num']]
                ];
            }
        }
        // 更新商品规格库存
        return !empty($itemSpecSave) && (new ItemSku)->isUpdate()->saveAll($itemSpecSave);
    }
    /**
     * 确认收货
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function receipt()
    {
        // 验证订单是否合法
        if ($this['delivery_status']['value'] === 10 || $this['receipt_status']['value'] === 20) {
            $this->error = '该订单不合法';
            return false;
        }
        $this->startTrans();
        try {
            // 更新订单状态
            $this->save([
                'receipt_status' => 20,
                'receipt_time' => time(),
                'order_status' => 30
            ]);
            // 发放分销商佣金
            AgentOrderModel::grantMoney($this['order_id']);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    /**
     * 获取订单总数
     * @param $user_id
     * @param string $type
     * @return int|string
     */
    public function getCount($user_id, $type = 'all')
    {
        // 筛选条件
        $filter = [];
        // 订单数据类型
        switch ($type) {
            case 'all':
                break;
            case 'payment';
                $filter['pay_status'] = 10;
                break;
            case 'received';
                $filter['pay_status'] = 20;
                $filter['delivery_status'] = 20;
                $filter['receipt_status'] = 10;
                break;
            case 'comment';
                $filter['order_status'] = 30;
                $filter['is_comment'] = 0;
                break;
        }
        return $this->where('user_id', '=', $user_id)
            ->where('order_status', '<>', 20)
            ->where($filter)
            ->count();
    }
    /**
     * 订单详情
     * @param $order_id
     * @param null $user_id
     * @return null|static
     * @throws BaseException
     * @throws \think\exception\DbException
     */
   public static function getUserOrderDetail($order_id, $user_id)
    {
        if (!$order = self::get([
            'order_id' => $order_id,
            'user_id' => $user_id
        ], ['item' => ['image', 'sku', 'item'], 'address', 'express'])) {
            throw new BaseException(['msg' => '订单不存在']);
        }
        return $order;
    }
    /**
     * 判断商品库存不足 (未付款订单)
     * @param $itemsList
     * @return bool
     */
    public function checkStatusFromOrder(&$itemsList)
    {
		
        foreach ($itemsList as $Item) {
			
            // 判断商品是否下架
            if (!$Item['item'] || $Item['item']['status'] !== 10) {
                $this->setError('很抱歉，商品 [' . $Item['name'] . '] 已下架');
                return false;
            }
            // 付款减库存
            if ($Item['type'] === 20 && $Item['sku']['stock_num'] < 1) {
                $this->setError('很抱歉，商品 [' . $Item['name'] . '] 库存不足');
                return false;
            }
			
        }
        return true;
    }
    /**
     * 设置错误信息
     * @param $error
     */
    private function setError($error)
    {
        empty($this->error) && $this->error = $error;
    }
    /**
     * 是否存在错误
     * @return bool
     */
    public function hasError()
    {
        return !empty($this->error);
    }
	/**
     * 订单列表
     * @param string $dataType
     * @param array $query
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($dataType,$query = [],$user_id)
    {	
		$where=$this->transferDataType($dataType);
		if(!empty($user_id)){
			$where['user_id']=$user_id;
		}
		
        // 检索查询
        $this->setWhere($query);
        // 获取数据列表
        return $this->with(['item.image', 'address', 'user'])
            ->where($where)
			
            ->order(['create_time' => 'desc'])
            ->paginate(10, false, [
                'query' => Request::instance()->request()
            ]);
    }
    /**
     * 订单列表(全部)
     * @param $dataType
     * @param array $query
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListAll($dataType, $query = [])
    {
        // 检索查询
        $this->setWhere($query);
        // 获取数据列表
        return $this->with(['item.image', 'address', 'user'])
            ->where($this->transferDataType($dataType))
            ->order(['create_time' => 'desc'])
            ->select();
    }
    /**
     * 订单导出
     * @param $dataType
     * @param $query
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function exportList($dataType, $query)
    {
        // 获取订单列表
        $list = $this->getListAll($dataType, $query);
	
        // 表格标题
        $tileArray = ['订单号', '商品名称', '单价', '数量', '付款金额', '运费金额', '下单时间',
            '买家', '买家留言', '收货人姓名', '联系电话', '收货人地址', '物流公司', '物流单号',
            '付款状态', '付款时间', '发货状态', '发货时间', '收货状态', '收货时间', '订单状态',
            '微信支付交易号', '是否已评价'];
        // 表格内容
        $dataArray = [];
        foreach ($list as $order) {
            /* @var OrderAddress $address */
            $address = $order['address'];
            foreach ($order['item'] as $Item) {
                $dataArray[] = [
                    '订单号' => $this->filterValue($order['order_no']),
                    '商品名称' => $Item['name'],
                    '单价' => $Item['item_price'],
                    '数量' => $Item['total_num'],
                    '付款金额' => $this->filterValue($order['pay_price']),
                    '运费金额' => $this->filterValue($order['express_price']),
                    '下单时间' => $this->filterValue($order['create_time']),
                    '买家' => $this->filterValue($order['user']['nickName']),
                    '买家留言' => $this->filterValue($order['buyer_remark']),
                    '收货人姓名' => $this->filterValue($order['address']['name']),
                    '联系电话' => $this->filterValue($order['address']['phone']),
                    '收货人地址' => $this->filterValue($address ? $address->getFullAddress() : ''),
                    '物流公司' => $this->filterValue($order['express']['express_name']),
                    '物流单号' => $this->filterValue($order['express_no']),
                    '付款状态' => $this->filterValue($order['pay_status']['text']),
                    '付款时间' => $this->filterTime($order['pay_time']),
                    '发货状态' => $this->filterValue($order['delivery_status']['text']),
                    '发货时间' => $this->filterTime($order['delivery_time']),
                    '收货状态' => $this->filterValue($order['receipt_status']['text']),
                    '收货时间' => $this->filterTime($order['receipt_time']),
                    '订单状态' => $this->filterValue($order['order_status']['text']),
                    '微信支付交易号' => $this->filterValue($order['transaction_id']),
                    '是否已评价' => $this->filterValue($order['is_comment'] ? '是' : '否'),
                ];
            }
        }
        // 导出csv文件
        $filename = 'order-' . date('YmdHis');
        return export_excel($filename . '.csv', $tileArray, $dataArray);
    }
    /**
     * 批量发货模板
     */
    public function deliveryTpl()
    {
        // 导出csv文件
        $filename = 'delivery-' . date('YmdHis');
        return export_excel($filename . '.csv', ['订单号', '物流单号']);
    }
    /**
     * 表格值过滤
     * @param $value
     * @return string
     */
    private function filterValue($value)
    {
        return "\t" . $value . "\t";
    }
    /**
     * 日期值过滤
     * @param $value
     * @return string
     */
    private function filterTime($value)
    {
        if (!$value) return '';
        return $this->filterValue(date('Y-m-d H:i:s', $value));
    }
    /**
     * 设置检索查询条件
     * @param $query
     */
    private function setWhere($query)
    {
        if (isset($query['order_no'])) {
            !empty($query['order_no']) && $this->where('order_no', 'like', '%' . trim($query['order_no']) . '%');
        }
    }
    /**
     * 转义数据类型条件
     * @param $dataType
     * @return array
     */
    private function transferDataType($dataType)
    {
		
        // 数据类型
        $filter = [];
        switch ($dataType) {
            case 'delivery':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 10
                ];
                break;
            case 'receipt':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 20,
                    'receipt_status' => 10
                ];
                break;
            case 'pay':
                $filter = ['pay_status' => 10, 'order_status' => 10];
                break;
            case 'complete':
                $filter = ['order_status' => 30];
                break;
            case 'cancel':
                $filter = ['order_status' => 20];
                break;
            case 'all':
                $filter = [];
                break;
        }
        return $filter;
    }
    /**
     * 确认发货
     * @param $data
     * @param bool $sendMsg 是否发送消息通知
     * @return bool|false|int
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function delivery($data, $sendMsg = true)
    {
        if ($this['pay_status']['value'] === 10
            || $this['delivery_status']['value'] === 20) {
            $this->error = '该订单不合法';
            return false;
        }
        // 更新订单状态
        $status = $this->save([
            'express_id' => $data['express_id'],
            'express_no' => $data['express_no'],
            'delivery_status' => 20,
            'delivery_time' => time(),
        ]);
        // 发送消息通知
        ($status && $sendMsg) && $this->deliveryMessage($this['order_id']);
        return $status;
    }
    /**
     * 确认发货后发送消息通知
     * @param $order_id
     * @return bool
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    private function deliveryMessage($order_id)
    {
        $orderIds = is_array($order_id) ? $order_id : [$order_id];
        // 发送消息通知
        $Message = new Message;
        foreach ($orderIds as $orderId) {
            $Message->delivery(self::detail($orderId));
        }
        return true;
    }
    /**
     * 确认发货
     * @param $data
     * @return bool
     * @throws \think\exception\DbException
     */
    public function batchDelivery($data)
    {
        // 获取csv文件中的数据
        $csvData = $this->getCsvData();
        if (count($csvData) <= 1) {
            $this->error = '模板文件中没有订单数据';
            return false;
        }
        // 删除csv标题
        unset($csvData[0]);
        // 批量发货
        try {
            $this->startTrans();
            $orderIds = [];
            foreach ($csvData as $item) {
                if (!isset($item[0])
                    || empty($item[0])
                    || !isset($item[1])
                    || empty($item[1])
                ) {
                    $this->error = '模板文件数据不合法';
                    return false;
                }
                $orderIds[] = $item[0];
                if (!$model = self::detail(['order_no' => $item[0]])) {
                    $this->error = '订单号 ' . $item[0] . ' 不存在';
                    return false;
                }
                if (!$status = $model->delivery([
                    'express_id' => $data['express_id'],
                    'express_no' => $item[1],
                ], false)) {
                    $this->error = ' 订单号：' . $item[0] . ' ' . $model->error;
                    return false;
                }
            }
            // 发送消息通知
            $this->deliveryMessage($orderIds);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    /**
     * 获取csv文件中的数据
     * @return array|bool
     */
    private function getCsvData()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('iFile');
        if (!$file) {
            $this->error = '请上传发货模板';
            return false;
        }
        setlocale(LC_ALL, 'zh_CN');
        $data = [];
        $csvFile = fopen($file->getInfo()['tmp_name'], 'r');
        while ($row = fgetcsv($csvFile)) {
            $data[] = $row;
        }
        return $data;
    }
    /**
     * 修改订单价格
     * @param $data
     * @return bool
     */
    public function updatePrice($data)
    {
        if ($this['pay_status']['value'] !== 10) {
            $this->error = '该订单不合法';
            return false;
        }
        // 实际付款金额
        $payPrice = bcadd($data['update_price'], $data['update_express_price'], 2);
        if ($payPrice <= 0) {
            $this->error = '订单实付款价格不能为0.00元';
            return false;
        }
        return $this->save([
                'order_no' => $this->orderNo(), // 修改订单号, 否则微信支付提示重复
                'pay_price' => $payPrice,
                'update_price' => $data['update_price'] - ($this['total_price'] - $this['coupon_price']),
                'express_price' => $data['update_express_price']
            ]) !== false;
    }
    /**
     * 获取已付款订单总数 (可指定某天)
     * @param null $day
     * @return int|string
     */
    public function getPayOrderTotal($day = null)
    {
        $filter['pay_status'] = 20;
        if (!is_null($day)) {
            $startTime = strtotime($day);
            $filter['pay_time'] = ['between',$startTime,$startTime + 86400];
        }
        return $this->getOrderTotal($filter);
    }
    /**
     * 获取订单总数量
     * @param array $filter
     * @return int|string
     */
    public function getOrderTotal($filter = [])
    {
        return $this->where($filter)->count();
    }
    /**
     * 获取某天的总销售额
     * @param $day
     * @return float|int
     */
    public function getOrderTotalPrice($day)
    {
        $startTime = strtotime($day);
        return $this->where('pay_time', '>=', $startTime)
            ->where('pay_time', '<', $startTime + 86400)
            ->where('pay_status', '=', 20)
            ->sum('pay_price');
    }
    /**
     * 获取某天的下单用户数
     * @param $day
     * @return float|int
     */
    public function getPayOrderUserTotal($day)
    {
        $startTime = strtotime($day);
        $userIds = $this->distinct(true)
            ->where('pay_time', '>=', $startTime)
            ->where('pay_time', '<', $startTime + 86400)
            ->where('pay_status', '=', 20)
            ->column('user_id');
        return count($userIds);
    }
}