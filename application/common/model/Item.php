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
use think\Db;
use think\facade\Request;
/**
 * 商品模型
 * Class Item
 * @package app\common\model
 */
class Item extends BaseModel
{
    protected $name = 'item';
    protected $pk = 'item_id';
    //protected $append = ['sales_num'];
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'sales_initial',
        'sales_actual',
        'is_delete',
        'app_id',
        'create_time',
        'update_time'
    ];
    /**
     * 计算显示销量 (初始销量 + 实际销量)
     * @param $value
     * @param $data
     * @return mixed
     */             
    public function getGoodsSalesAttr($value, $data=[])
    {
        return $data['sales_initial'] + $data['sales_actual'];
    }
    /**
     * 关联商品分类表
     * @return \think\model\relation\BelongsTo
     */
    public function category()
    { 
       return $this->belongsTo('Category','','category_id');
    }
    /**
     * 关联商品规格表
     * @return \think\model\relation\HasMany
     */
    public function sku()
    {
		
        return $this->hasMany('ItemSku')->order(['item_sku_id' => 'asc']);
    }
    /**
     * 关联商品规格关系表
     * @return \think\model\relation\BelongsToMany
     */
    public function specRel()
    {
        return $this->belongsToMany('SpecValue','ItemSpecRel')->order(['spec_value_id' => 'asc']);
    }
    /**
     * 关联商品图片表
     * @return \think\model\relation\HasMany
     */
    public function image()
    {
        return $this->hasMany('ItemImage','item_id','item_id')->order(['id' => 'asc'])->with('file');
    }
    /**
     * 关联运费模板表
     * @return \think\model\relation\BelongsTo
     */
    public function delivery()
    {
        return $this->BelongsTo('Delivery','','delivery_id');
    }
    /**
     * 关联订单评价表
     * @return \think\model\relation\HasMany
     */
    public function commentData()
    {
        return $this->hasMany('Comment','comment_id','item_id');
    }
    /**
     * 计费方式
     * @param $value
     * @return mixed
     */
    public function getGoodsStatusAttr($value)
    {
        $status = [10 => '上架', 20 => '下架'];
        return ['text' => $status[$value], 'value' => $value];
    }
    /**
     * 商品多规格信息
     * @param \think\Collection $spec_rel
     * @param \think\Collection $skuData
     * @return array
     */
    public function getManySpecData($spec_rel, $skuData)
    {
		
        // spec_attr
        $specAttrData = [];
	
        foreach ($spec_rel->toArray() as $item) {
            if (!isset($specAttrData[$item['spec_id']])) {
                $specAttrData[$item['spec_id']] = [
                    'group_id' => $item['spec']['spec_id'],
                    'group_name' => $item['spec']['spec_name'],
                    'spec_items' => [],
                ];
            }
            $specAttrData[$item['spec_id']]['spec_items'][] = [
                'item_id' => $item['spec_value_id'],
                'spec_value' => $item['spec_value'],
            ];
        }
        // spec_list
        $specListData = [];
        foreach ($skuData->toArray() as $item) {
		
            $specListData[] = [
                'item_sku_id' => $item['item_sku_id'],
                'spec_sku_id' => $item['spec_sku_id'],
                'rows' => [],
                'form' => [
                    'item_no' => $item['item_no'],
                    'item_price' => $item['item_price'],
                    'weight' => $item['weight'],
                    'line_price' => $item['line_price'],
                    'stock_num' => $item['stock_num'],
                ],
            ];
			
        }
		
        return ['spec_attr' => array_values($specAttrData), 'spec_list' => $specListData];
    }
	/**
     * 商品详情：HTML实体转换回普通字符
     * @param $value
     * @return string
     */
    public function getContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }
    /**
     * 根据商品id集获取商品列表
     * @param $itemIds
     * @param null $status
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListByIds($itemIds, $status = null)
    {
		
        $filter[] = ['item_id','in', $itemIds];
        $status > 0 && $filter[] = ['status','=',$status];
        return $this->with(['category', 'image.file', 'sku', 'spec_rel.spec', 'delivery.rule'])
            ->where($filter)
            ->select();
    }
    /**
     * 获取商品列表
     * @param int $status
     * @param int $category_id
     * @param string $search
     * @param string $sortType
     * @param bool $sortPrice
     * @param int $listRows
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($status = null, $category_id = 0, $search = '', $sortType = 'all', $sortPrice = false, $listRows = 15)
    {
		
        // 筛选条件
        $filter = [];
        $category_id > 0 && $filter[] = ['category_id','IN', Category::getSubCategoryId($category_id)];
        $status > 0 && $filter[] = ['status','=', $status];
        !empty($search) && $filter[] = ['name','like', '%' . trim($search) . '%'];
        // 排序规则
        $sort = [];
		
        if ($sortType === 'all') {
            $sort = ['sort', 'item_id' => 'desc'];
        } elseif ($sortType === 'sales') {
            $sort = ['sales_num' => 'desc'];
        } elseif ($sortType === 'price') {
            $sort = $sortPrice ? ['item_price' => 'desc'] : ['item_price'];
        }
        // 商品表名称
        $tableName = $this->getTable();
		
        // 多规格商品 最高价与最低价
        $ItemSku = new ItemSku;
        $minPriceSql = $ItemSku->field(['MIN(item_price)'])
            ->where('item_id', 'EXP', "= `$tableName`.`item_id`")->buildSql();
			
        $maxPriceSql = $ItemSku->field(['MAX(item_price)'])
            ->where('item_id', 'EXP', "= `$tableName`.`item_id`")->buildSql();
        // 执行查询
        $list = $this
            ->field(['*', '(sales_initial + sales_actual) as sales_num',
                "$minPriceSql AS item_price",
                "$maxPriceSql AS line_price"
            ])
            ->with(['category','image.file'])
            ->where('is_delete', '=', 0)
            ->where($filter)
            ->order($sort)
            ->paginate($listRows, false, [
                'query' => Request::instance()->request()
            ]);
        return $list;
    }
	
	   /**
     * 已删除商品列表
     * @param int $status
     * @param int $category_id
     * @param string $search
     * @param string $sortType
     * @param bool $sortPrice
     * @param int $listRows
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
	  public function endList($status = null, $category_id = 0, $search = '', $sortType = 'all', $sortPrice = false, $listRows = 15)
    {
		
        // 筛选条件
        $filter = [];
        $category_id > 0 && $filter[] = ['category_id','IN', Category::getSubCategoryId($category_id)];
        $status > 0 && $filter[] = ['status','=', $status];
        !empty($search) && $filter[] = ['name','like', '%' . trim($search) . '%'];
        // 排序规则
        $sort = [];
		
        if ($sortType === 'all') {
            $sort = ['sort', 'item_id' => 'desc'];
        } elseif ($sortType === 'sales') {
            $sort = ['sales_num' => 'desc'];
        } elseif ($sortType === 'price') {
            $sort = $sortPrice ? ['max_price' => 'desc'] : ['min_price'];
        }
        // 商品表名称
        $tableName = $this->getTable();
		
        // 多规格商品 最高价与最低价
        $ItemSku = new ItemSku;
        $minPriceSql = $ItemSku->field(['MIN(item_price)'])
            ->where('item_id', 'EXP', "= `$tableName`.`item_id`")->buildSql();
			
        $maxPriceSql = $ItemSku->field(['MAX(item_price)'])
            ->where('item_id', 'EXP', "= `$tableName`.`item_id`")->buildSql();
        // 执行查询
        $list = $this
            ->field(['*', '(sales_initial + sales_actual) as sales_num',
                "$minPriceSql AS min_price",
                "$maxPriceSql AS max_price"
            ])
            ->with(['category','image.file'])
            ->where('is_delete', '=', 1)
            ->where($filter)
            ->order($sort)
            ->paginate($listRows, false, [
                'query' => Request::instance()->request()
            ]);
        return $list;
    }
    /**
     * 获取商品详情
     * @param $item_id
     * @return static|false|\PDOStatement|string|\think\Model
     */
    public static function detail($item_id)
    {	
        $model = new static;
        return $model->with([
            'category',
            'image.file',
            'sku',
            'specRel.spec',
            'delivery.rule',
            'commentData' => function ($query) {
                $query->with('user')->where(['is_delete' => 0, 'status' => 1])->limit(2);
            }
        ])->withCount(['commentData' => function ($query) {
            $query->where(['is_delete' => 0, 'status' => 1]);
        }])->where('item_id', '=', $item_id)->find();
    }
    /**
     * 商品多规格信息
     * @param $item_sku_id
     * @return array|bool
     */
    public function getItemSku($item_sku_id)
    {
		
        $itemSkuData = array_column($this['sku']->toArray(), null, 'spec_sku_id');
        if (!isset($itemSkuData[$item_sku_id])) {
            return false;
        }
        $item_sku = $itemSkuData[$item_sku_id];
	
        // 多规格文字内容
        $item_sku['item_attr'] = '';
        if ($this['spec_type'] === 20) {
            $attrs = explode('_', $item_sku['spec_sku_id']);
            $spec_rel = array_column($this['spec_rel']->toArray(), null, 'spec_value_id');
            foreach ($attrs as $specValueId) {
			if(isset($spec_rel[$specValueId])) {
                $item_sku['item_attr'] .= $spec_rel[$specValueId]['spec']['spec_name'] . ':'
                    . $spec_rel[$specValueId]['spec_value'] . '; ';
            }
            }
        }
        return $item_sku;
    }
    /**
     * 添加商品
     * @param array $data
     * @return bool
     */
    public function add(array $data)
    {
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['app_id'] = $data['sku']['app_id'] = self::$app_id;
        $data['sales_actual'] = 0;
        // 开启事务
		
        Db::startTrans();
        try {
			
            // 添加商品
            $result = $this->allowField(true)->save($data);
            $this['item_id'] = $this['item_id'];
            // 商品规格
            $this->addItemSpec($data);
            // 商品图片
            $this->addImages($data['images']);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            Db::rollback();
        }
        return false;
    }
    /**
     * 添加商品图片
     * @param $images
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function addImages($images)
    {
         $this->image()->where('item_id',"=",$this['item_id'])->delete();
         $data = array_map(function ($image_id) {
            return [
                'image_id' => $image_id,
                'item_id' => $this['item_id'],
                'app_id' => self::$app_id
            ];
        }, $images);
        return $this->image()->saveAll($data);
    }
    /**
     * 编辑商品
     * @param $data
     * @return bool
     */
    public function edit($data,$item_id)
    {
			
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['app_id'] = $data['sku']['app_id'] = self::$app_id;
        // 开启事务
        Db::startTrans();
        try {
            // 保存商品
            $this->allowField(true)->save($data);
            // 商品规格
            $this->addItemSpec($data, true);
            // 商品图片
			$this->addImages($data['images'],$this['item_id']);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            $this->error = $e->getMessage();
            return false;
        }
    }
    /**
     * 添加商品规格
     * @param $data
     * @param $isUpdate
     * @throws \Exception
     */
    private function addItemSpec(&$data, $isUpdate = false)
    {
		
        // 更新模式: 先删除所有规格
        $model = new ItemSku;
        if($isUpdate){
            $model->removeAll($this['item_id']);
        }
		
        // 添加规格数据
        if ($data['spec_type'] === '10') {
            $data['sku']['item_id'] = $this['item_id'];
            $data['sku']['create_time'] = time();
            // 单规格
            $model->save($data['sku']);
        } else if ($data['spec_type'] === '20') {
            // 添加商品与规格关系记录
			
            $model->addSpecRel($this['item_id'], $data['spec_many']['spec_attr']);
            // 添加商品sku
            $model->addSkuList($this['item_id'], $data['spec_many']['spec_list']);
        }
    }
    /**
     * 修改商品状态
     * @param $state
     * @return false|int
     */
    public function setStatus($state)
    {
        return $this->save(['status' => $state ? 10 : 20]) !== false;
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
     * 恢复商品状态
     * @return false|int
     */
    public function setrecovery()
    {
        return $this->save(['is_delete' =>0]);
    }
    /**
     * 获取当前商品总数
     * @param array $where
     * @return int|string
     */
    public function getitemTotal($where = [])
    {
        $this->where('is_delete', '=', 0);
       // print_r($where);die;
       // print_r($this->where($where)->count());die;
        return $this->where($where)->count();
       // return $this->count();
    }
}