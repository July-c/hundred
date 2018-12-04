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
use think\Model;
use think\facade\Request;
use think\facade\Session;
/**
 * 模型基类
 * Class BaseModel
 * @package app\common\model
 */
class BaseModel extends Model
{
    public static $app_id;
    public static $base_url;
    /**
     * 模型基类初始化
     */
    public static function init()
    {
        parent::init();
        // 获取当前域名
        self::$base_url = base_url();
        // 后期静态绑定app_id
        self::bindAppId();
    }
    /**
     * 后期静态绑定类名称
     * 用于定义全局查询范围的app_id条件
     * 子类调用方式:
     *   非静态方法:  self::$app_id
     *   静态方法中:  $self = new static();   $self::$app_id
     * @param $calledClass
     */
    private static function bindAppId()
    {
        $request = Request::instance();		self::$app_id = $request->param('app_id');
        if(!self::$app_id = $request->param('app_id')){
            self::$app_id = Session::get('wymall_store')['app'];
        }
    }
    /**
     * 获取当前域名
     * @return string
     */
    protected static function baseUrl()
    {
        $request = Request::instance();
        $host = $request->scheme() . '://' . $request->host();
        $dirname = dirname($request->baseUrl());
        return empty($dirname) ? $host : $host . $dirname . '/';
    }
    /**
     * 定义全局的查询范围
     * @param \think\db\Query $query
     */
    protected function base($query)
    {
        if (self::$app_id > 0) {
            $query->where($query->getTable() . '.app_id', self::$app_id);
        }
    }
}