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
namespace app\user\controller;
use app\common\model\Category;
use app\common\model\Delivery;
use app\common\model\Item as ItemModel;
/**
 * 商品管理控制器
 * Class Item
 * @package app\user\controller
 */
class Item extends Controller
{
    /**
     * 商品列表(出售中)
     * @param null $status
     * @param null $category_id
     * @param string $name
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($status = null, $category_id = null, $name = '')
    {
		
        // 商品分类
        $catgory = Category::getCacheTree();
		
        // 商品列表
        $model = new ItemModel;
		
        $list = $model->getList($status, $category_id, $name);
        return $this->fetch('index', compact('list', 'catgory'));
    }
	
	/**
	*商品回收站( 已删除)
	*@param null $status
	*@param null $status
    *@param null $category_id
    *@param string $name
    *@return mixed
    *@throws \think\exception\DbException
	*/
	public function end($status = null, $category_id = null, $name = ''){
			  // 商品分类
        $catgory = Category::getCacheTree();
		
        // 商品列表
        $model = new ItemModel;
		
        $list = $model->endList($status, $category_id, $name);
		 return $this->fetch('end', compact('list', 'catgory'));
	}
	
	
    /**
     * 添加商品
     * @return array|mixed
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            // 商品分类
            $catgory = Category::getCacheTree();
            // 配送模板
            $delivery = Delivery::getAll();
            return $this->fetch('add', compact('catgory', 'delivery'));
        }
        $model = new ItemModel;
        if ($model->add($this->postData('item'))) {
            return $this->renderSuccess('添加成功', url('item/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }
    /**
     * 一键复制
     * @param $item_id
     * @return array|mixed
     */
    public function copy($item_id)
    {
        // 商品详情
        $model = ItemModel::detail($item_id);
        if (!$this->request->isAjax()) {
            // 商品分类
            $catgory = Category::getCacheTree();
            // 配送模板
            $delivery = Delivery::getAll();
            // 多规格信息
            $specData = 'null';
            if ($model['spec_type'] === 20)
                $specData = json_encode($model->getManySpecData($model['spec_rel'], $model['sku']));
            return $this->fetch('edit', compact('model', 'catgory', 'delivery', 'specData'));
        }
        $model = new ItemModel;
        if ($model->add($this->postData('item'))) {
            return $this->renderSuccess('添加成功', url('item/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }
    /**
     * 商品编辑
     * @param $item_id
     * @return array|mixed
     */
    public function edit($item_id)
    {
        // 商品详情
        $model = ItemModel::detail($item_id);
        if (!$this->request->isAjax()) {
            // 商品分类
            $catgory = Category::getCacheTree();
            // 配送模板
            $delivery = Delivery::getAll();
            // 多规格信息
            $specData = 'null';
            if ($model['spec_type'] === 20){
			   $spec = $model->getManySpecData($model['spec_rel'], $model['sku']);
               $specData = json_encode($spec);
			}
			
            return $this->fetch('edit', compact('model', 'catgory', 'delivery', 'specData'));
        }
        // 更新记录
        if ($model->edit($this->postData('item'),$item_id)) {
            return $this->renderSuccess('更新成功', url('item/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }
    /**
     * 修改商品状态
     * @param $item_id
     * @param boolean $state
     * @return array
     */
    public function state($item_id, $state)
    {
        // 商品详情
        $model = ItemModel::detail($item_id);
        if (!$model->setStatus($state)) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }
    /**
     * 删除商品
     * @param $item_id
     * @return array
     */
    public function delete($item_id)
    {
        // 商品详情
        $model = ItemModel::detail($item_id);
        if (!$model->setDelete()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
	
	/**
	* 恢复商品
	* @param $item_id
    * @param boolean $state
    * @return array
	*/
	public function recovery($item){
		 // 商品详情
        $model = ItemModel::detail($item);
        if (!$model->setrecovery()) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
		
	}
	
	
}