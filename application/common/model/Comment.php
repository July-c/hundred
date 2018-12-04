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
use app\common\exception\BaseException;
use app\common\model\Comment as CommentModel;
use think\Db;
/**
 * 商品评价模型
 * Class Comment
 * @package app\common\model
 */
class Comment extends BaseModel
{
    protected $name = 'comment';
	 protected $pk = 'comment_id';
	 /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'status',
        'sort',
        'order_id',
        'item_id',
        'list_id',
        'is_delete',
        'update_time'
    ];
    /**
     * 所属订单
     * @return \think\model\relation\BelongsTo
     */
    public function order()
    {
		
        return $this->belongsTo('Order');
    }
    /**
     * 订单商品
     * @return \think\model\relation\BelongsTo
     */
    public function OrderList()
    {
		
        return $this->belongsTo('OrderList');
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
     * 关联评价图片表
     * @return \think\model\relation\HasMany
     */
    public function image()
    {
	
        return $this->hasMany('CommentImage')->order(['id' => 'asc'])->with('file');
    }
    /**
     * 评价详情
     * @param $comment_id
     * @return Comment|null
     * @throws \think\exception\DbException
     */
    public static function detail($comment_id)
    {
		
        return self::get($comment_id, ['user', 'order', 'OrderList', 'image']);
    }
    /**
     * 更新记录
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
		
        // 开启事务
        Db::startTrans();
        try {
            // 删除评价图片
            $this->image()->delete();
            // 添加评论图片
            isset($data['images']) && $this->addCommentImages($data['images']);
            // 是否为图片评价
            $data['is_picture'] = !$this->image()->select()->isEmpty();
            // 更新评论记录
            $this->allowField(true)->save($data);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            Db::rollback();
            return false;
        }
    }
    /**
     * 添加评论图片
     * @param $images
     * @return int
     */
    private function addCommentImages($images)
    {
		
        $data = array_map(function ($image_id) {
            return [
                'image_id' => $image_id,
                'app_id' => self::$app_id
            ];
        }, $images);
		
        return $this->image()->saveAll($data);
    }
    /**
     * 获取评价列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($item_id,$user_id)
    {
		if(!empty($item_id)){
			$where[]=['item_id','=',$item_id];
		}
		if(!empty($user_id)){
			$where[]=['user_id','=',$user_id];
		}
	
		$where[]=['is_delete', '=', 0];
		
        return $this->with(['user', 'order', 'OrderList'])
            ->where($where)
            ->order(['sort' => 'asc', 'create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }
	 /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        return $this->save(['is_delete' => 1]);
    }
    /**
     * 获取评价总数量
     * @return int|string
     */
    public function getCommentTotal()
    {
        return $this->where(['is_delete' => 0])->count();
    }
	 /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    /*public function user()
    {
        return $this->belongsTo('User')->field(['user_id', 'nickName', 'avatarUrl']);
    }*/
    /**
     * 获取指定商品评价列表
     * @param $item_id
     * @param int $scoreType
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getCommentList($item_id, $scoreType = -1)
    {
        // 筛选条件
        $filter = [
            'item_id' => $item_id,
            'is_delete' => 0,
            'status' => 1,
        ];
        // 评分
        $scoreType > 0 && $filter['score'] = $scoreType;
        return $this->with(['user', 'OrderList', 'image.file'])
            ->where($filter)
            ->order(['sort' => 'asc', 'create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }
    /**
     * 获取指定评分总数
     * @param $item_id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getTotal($item_id)
    {
		
        return $this->field([
            'count(comment_id) AS `all`',
            'count(score = 10 OR NULL) AS `praise`',
            'count(score = 20 OR NULL) AS `review`',
            'count(score = 30 OR NULL) AS `negative`',
        ])->where([
            'item_id' => $item_id,
            'is_delete' => 0,
            'status' => 1
        ])->find();
    }
    /**
     * 验证订单是否允许评价
     * @param Order $order
     * @return boolean
     */
    public function checkOrderAllowComment($order)
    {
        // 验证订单是否已完成
        if ($order['order_status']['value'] !== 30) {
            $this->error = '该订单未完成，无法评价';
            return false;
        }
        // 验证订单是否已评价
        if ($order['is_comment'] === 1) {
            $this->error = '该订单已完成评价';
            return false;
        }
        return true;
    }
    /**
     * 根据已完成订单商品 添加评价
     * @param Order $order
     * @param \think\Collection|OrderList $itemsList
     * @param $formJsonData
     * @return boolean
     * @throws \Exception
     */
    public function addForOrder($order, $itemsList, $formJsonData)
    {
        // 生成 formData
        $formData = $this->formatFormData($formJsonData);
        // 生成评价数据		
        $data = $this->createCommentData($order['user_id'], $order['order_id'], $itemsList, $formData);
		
        if (empty($data)) {
            $this->error = '没有输入评价内容';
            return false;
        }
        // 开启事务
        Db::startTrans();
        try {
            // 记录评价内容
            $result = $this->isUpdate(false)->saveAll($data);
            // 记录评价图片
            $this->saveAllImages($data, $formData);
			
            // 更新订单评价状态
            $isComment = count($itemsList) === count($data);
			
            $this->updateOrderIsComment($order, $isComment, $result);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            $this->error = $e->getMessage();
            return false;
        }
    }
    /**
     * 更新订单评价状态
     * @param Order $order
     * @param $isComment
     * @param $commentList
     * @return array|false
     * @throws \Exception
     */
    private function updateOrderIsComment($order, $isComment, &$commentList)
    {
        // 更新订单商品
        $orderData = [];
        foreach ($commentList as $comment) {
            $orderData[] = [
                'list_id' => $comment['list_id'],
                'is_comment' => 1
            ];
        }
        // 更新订单
        $isComment && $order->save(['is_comment' => 1]);
		
        return (new OrderList)->saveAll($orderData);
    }
    /**
     * 生成评价数据
     * @param $user_id
     * @param $order_id
     * @param $itemsList
     * @param $formData
     * @return array
     * @throws BaseException
     */
    private function createCommentData($user_id, $order_id, &$itemsList, &$formData)
    {
        $data = [];
        foreach ($itemsList as $Item) {
            /*if (!isset($formData[$Item['item_id']])) {
                throw new BaseException(['msg' => '提交的数据不合法']);
            }*/
            $formData = $formData[0];
            !empty($formData['content']) && $data[$Item['list_id']] = [
                'score' => $formData['score'],
                'content' => $formData['content'],
                'is_picture' => !empty($formData['uploaded']),
                'sort' => 100,
                'status' => 1,
                'user_id' => $user_id,
                'order_id' => $order_id,
                'item_id' => $Item['item_id'],
                'list_id' => $Item['list_id'],
                'app_id' => self::$app_id
            ];
        }
        return $data;
    }
    /**
     * 格式化 formData
     * @param string $formJsonData
     * @return array
     */
    private function formatFormData($formJsonData)
    {
        return array_column(json_decode($formJsonData, true), null, 'list_id');
    }
    /**
     * 记录评价图片
     * @param $commentList
     * @param $formData
     * @return bool
     * @throws \Exception
     */
    private function saveAllImages(&$commentList, &$formData)
    {
        // 生成评价图片数据
        $imageData = [];
        foreach ($commentList as $comment) {
           // $item = $formData[$comment['list_id']];
			
            foreach ($formData['uploaded'] as $imageId) {
				
                $imageData[] = [
                    'comment_id' => $comment['comment_id'],
                    'image_id' => $imageId,
                    'app_id' => self::$app_id
                ];
            }
        }
        $model = new CommentImage;
        return !empty($imageData) && $model->saveAll($imageData);
    }
}