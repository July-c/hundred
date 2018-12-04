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
namespace app\common\model\agent;
use app\common\model\BaseModel;
/**
 * 分销商推荐关系模型
 * Class Referee
 * @package app\common\model\agent
 */
class Referee extends BaseModel
{
    protected $name = 'agent_referee';
    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('app\common\model\User');
    }
    /**
     * 关联分销商用户表
     * @return \think\model\relation\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('User');
    }
	/**
     * 获取我的团队列表
     * @param $user_id
     * @param int $level
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($user_id, $level = -1)
    {
        $this->with(['user', 'agent'])
            ->where('agent_id', '=', $user_id);
        $level > -1 && $this->where('level', '=', $level);
        return $this->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }
    /**
     * 创建推荐关系
     * @param $user_id
     * @param $referee_id
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function createRelation($user_id, $referee_id)
    {
        // 分销商基本设置
        $setting = Setting::getItem('basic');
        // 是否开启分销功能
        if (!$setting['is_open']) {
            return false;
        }
        // 自分享
        if ($user_id == $referee_id) {
            return false;
        }
        // # 记录一级推荐关系
        // 判断当前用户是否已存在推荐关系
        if (self::isExistReferee($user_id)) {
            return false;
        }
        // 判断推荐人是否为分销商
        if (!User::isAgentUser($referee_id)) {
            return false;
        }
        // 新增关系记录
        $model = new self;
        $model->add($referee_id, $user_id, 1);
        // # 记录二级推荐关系
        if ($setting['level'] >= 2) {
            // 二级分销商id
            $referee_2_id = self::getRefereeUserId($referee_id, 1, true);
            // 新增关系记录
            $referee_2_id > 0 && $model->add($referee_2_id, $user_id, 2);
        }
        // # 记录三级推荐关系
        if ($setting['level'] == 3) {
            // 三级分销商id
            $referee_3_id = self::getRefereeUserId($referee_id, 2, true);
            // 新增关系记录
            $referee_3_id > 0 && $model->add($referee_3_id, $user_id, 3);
        }
        return true;
    }
    /**
     * 新增关系记录
     * @param $agent_id
     * @param $user_id
     * @param int $level
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    private function add($agent_id, $user_id, $level = 1)
    {
        // 新增推荐关系
        $app_id = self::$app_id;
        $create_time = time();
        $this->insert(compact('agent_id', 'user_id', 'level', 'app_id', 'create_time'));
        // 记录分销商成员数量
        User::setMemberInc($agent_id, $level);
        return true;
    }
    /**
     * 获取上级用户id
     * @param $user_id
     * @param $level
     * @param bool $is_agent 必须是分销商
     * @return bool|mixed
     * @throws \think\exception\DbException
     */
    public static function getRefereeUserId($user_id, $level, $is_agent = false)
    {
        $agent_id = (new self)->where(compact('user_id', 'level'))
            ->value('agent_id');
        if (!$agent_id) return 0;
        return $is_agent ? (User::isAgentUser($agent_id) ? $agent_id : 0) : $agent_id;
    }
    /**
     * 是否已存在推荐关系
     * @param $user_id
     * @return bool
     * @throws \think\exception\DbException
     */
    private static function isExistReferee($user_id)
    {
        return !!self::get(['user_id' => $user_id]);
    }
}