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
use think\facade\session;
use think\facade\App;
use think\db;
use ZipArchive;
use app\common\model\App as AppModel;
use app\common\model\Store as StoreModel;
/**
 * 后台首页
 * Class Index
 * @package app\user\controller
 */
class Index extends Controller
{
    /**
     * 后台首页
     * @return mixed
     */
    public function index()
    {
        $model = new StoreModel;
        $data = $model->getHomeData();
		$version= Session::get('wymall_store.ver');	
        return $this->fetch('index', compact('data','version'));
    }
	public function update()	
	{	
		$version= Session::get('wymall_store.ver');	
        $hosturl = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
        $updatehost = "https://updata.kdfu.cn/index.php/Home/Index/updata";
        $updatehosturl = $updatehost . "?a=updata&v=" . $version . "&u=" . $hosturl;
        $updatenowinfo = curl($updatehosturl);
		$file = json_decode($updatenowinfo,true);
		if ($file['code']=='200'){
			$rootPath = App::getRootPath();
			$updatedir = 'runtime/log/';
			$updatezip = $this->get_file($file['file'],$version,$rootPath.$updatedir);
			$zip = new ZipArchive;
			$zip->open($updatezip['save_path']);
			$archive = $zip->extractTo($rootPath);
			$zip->close(); 
			if ($archive !==true){
				$file['msg'] = "升级失败";
			}else{
				$sqlfile = $rootPath . 'updata.sql';
				if(file_exists($sqlfile)){
					$sql = file_get_contents($sqlfile);
					if($sql){
						$sql = str_replace("wy_", config('database.prefix'), $sql);
						error_reporting(0);
						foreach(explode("\r\n", $sql) as $v){
							Db::execute($v);
						}
					}
					unlink($sqlfile);
				}
				$file['msg'] = "升级完成！请检查是否还有新的更新包";
			}
			unlink($updatezip['save_path']);
			Session::set('wymall_store.ver',$file['version']);
			$app = AppModel::detail();
			$app->edit(['ver'=>$file['version']]);		
			
		}
		return $this->renderSuccess($file['msg']);
	}
	function get_file($url, $filename,$save_dir,$type = 0) {
		$filename=$filename.'.zip';
		if (trim($url) == '') {
			return false;
		}
		//获取远程文件所采用的方法
		ob_start();
		readfile($url);
		$content = ob_get_contents();
		ob_end_clean();
		$fp2 = @fopen($save_dir . $filename, 'a');
		fwrite($fp2, $content);
		fclose($fp2);
		unset($content, $url);
		return array(
			'file_name' => $filename,
			'save_path' => $save_dir . $filename
		);
	}
}