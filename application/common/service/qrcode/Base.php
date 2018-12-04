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
namespace app\common\service\qrcode;
use think\facade\App;
use app\common\library\wechat\Qrcode;
use app\common\model\App as AppModel;

/**
 * 二维码服务基类
 * Class Base
 * @package app\common\service\qrcode
 */
class Base
{
    /**
     * 构造方法
     * Base constructor.
     */
    public function __construct()
    {
    }

    /**
     * 保存小程序码到文件
     * @param $app_id
     * @param $scene
     * @param null $page
     * @return string
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    protected function saveQrcode($app_id, $scene, $page = null)
    {	
        // 文件路径
        $fileName = 'qrcode_' . md5($app_id . $scene . $page) . '.png';
	
      $savePath = WEB_PATH . '/' . 'temp' . '/' . $app_id . '/' . $fileName;
	
       // if (file_exists($savePath)) return $savePath;
        // 小程序配置信息
        $wxConfig = AppModel::getAppCache($app_id);
	
        // 请求api获取小程序码
        $Qrcode = new Qrcode($wxConfig['appkey'], $wxConfig['app_secret']);
			
        $content = $Qrcode->getQrcode($scene, $page);

        // 保存到文件
        file_put_contents($savePath, $content);
        return $savePath;
    }

    /**
     * 获取网络图片到临时目录
     * @param $app_id
     * @param $url
     * @param string $mark
     * @return string
     */
    protected function saveTempImage($app_id, $url, $mark = 'temp')
    {
        $dirPath = App::getRootPath() . '/runtime/image/' . $app_id;
        !is_dir($dirPath) && mkdir($dirPath, 0755, true);
        $savePath = $dirPath . '/' . $mark . '_' . md5($url) . '.png';
        if (file_exists($savePath)) return $savePath;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        $img = curl_exec($ch);
        curl_close($ch);
        $fp = fopen($savePath, 'w');
        fwrite($fp, $img);
        fclose($fp);
        return $savePath;
    }

}