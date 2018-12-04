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
use app\common\model\AppPage as AppPageModel;
use app\common\model\AppCategory as AppCategoryModel;
/**
 * 小程序页面管理
 * Class Page
 * @package app\user\controller\App
 */
class Tpl extends Controller
{
    /**
     * 页面列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new AppPageModel;
        $list = $model->getList();
		
        return $this->fetch('index', compact('list'));
    }
    /**
     * 新增页面
     * @return array|mixed
     */
    public function add()
    {
        $model = new AppPageModel;
		
        if (!$this->request->isAjax()) {
            // 商品分类
            $catgory = Category::getCacheTree();
            return $this->fetch('add', compact('catgory'));
        }
        // 接收post数据
        $post = $this->request->post('data', null, null);
        if (!$model->add(json_decode($post, true))) {
            return $this->renderError('添加失败');
        }
        return $this->renderSuccess('添加成功', url('tpl/index'));
    }
    /**
     * 编辑页面
     * @param $page_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($page_id)
    {
        $model = AppPageModel::detail($page_id);
        if (!$this->request->isAjax()) {
            $jsonData = $model['page_data']['json'];
            // 商品分类
            $catgory = Category::getCacheTree();
			
            return $this->fetch('edit', compact('jsonData', 'catgory'));
        }
        // 接收post数据
        $post = $this->request->post('data', null, null);
        if (!$model->edit(json_decode($post, true))) {
            return $this->renderError('更新失败');
        }
        return $this->renderSuccess('更新成功');
    }
    /**
     * 删除页面
     * @param $page_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($page_id)
    {
        // 帮助详情
        $model = AppPageModel::detail($page_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
    /**
     * 设置默认首页
     * @param $page_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function setHome($page_id)
    {
        // 帮助详情
        $model = AppPageModel::detail($page_id);
        if (!$model->setHome()) {
            return $this->renderError($model->getError() ?: '设置失败');
        }
        return $this->renderSuccess('设置成功');
    }
    /**
     * 分类模板
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function category()
    {
        $model = AppCategoryModel::detail();
        if ($this->request->isAjax()) {
            if ($model->edit($this->postData('category'))) {
                return $this->renderSuccess('更新成功');
            }
            return $this->renderError($model->getError() ?: '更新失败');
        }
        return $this->fetch('category', compact('model'));
    }
    /**
     * 页面链接
     * @return mixed
     */
    public function links()
    {
        return $this->fetch('links');
    }
}