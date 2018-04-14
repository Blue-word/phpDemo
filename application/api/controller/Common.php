<?php
namespace app\api\controller;
use think\Controller;
use think\Session;
use think\Cache;
use think\Request;

class Common extends Controller{
	//模拟地址http://localhost/jraz/index.php/api/user/loginOut
	public $session_id;


	//空操作
	public function _empty(){
	    $this->apiReturn("URL地址找不到",'404',"URL地址找不到");
	}

	public function _initialize() {
		Session::start();
        $this->session_id = session_id(); // 当前的session_id
        define('SESSION_ID',$this->session_id);
        $token = I('server.HTTP_TOKEN');
        if($token == ''){       //拦截token为空
            $this->apiReturn("无授权访问数据权限",'406',"无授权访问数据权限");
        }
        //$session_id = $this->session_id;
        //$info = Request::instance()->header();//获取HTTP请求头信息
        $cache = Cache::get($token);//获取HTTP头信息中的token并缓存
        if (!$cache) {   //缓存不存在则从数据库获取
        	//$where['session_id'] = $session_id;
        	$where['token'] = $token;
        	$uid = M('token')->where($where)->find();
        	if ($uid > 0) {
        		$user_info = M('user')->where('uid',$uid['uid'])->field('password',true)->find();
        		$user_info['token'] = $uid['token'];
        		Cache::set($token,$user_info);//重新写入缓存
        		$cache = Cache::get($token);//重新获取缓存
        		if ($token == $cache['token']) {
		        	$this->apiReturn("验证失败",'403',"验证失败");
		        }
        	}else{
        		$this->apiReturn('登录信息已失效，请重新登录','500','登录信息已失效，请重新登录');
        	}
        }
        //dump($cache);
        if ($token !== $cache['token']) {
        	$this->apiReturn("验证失败",'403',"验证失败");
        }
    }

    /**
     * 创建一个新的Token，以用户名+UID+时间戳+盐的MD5加密
     * @param  string $username 用户名
     * @param  int $uid      id
     * @return string           32位加密数据
     */
    public function createToken($username="",$uid='0'){
        $time = time();
        $token = md5($username.$uid.$time.C('AUTH_CODE'));
        return $token;
    }
    /**
     * 清除Token表中对应uid的Token
     * @param  int $uid 用户id
     * @return boolean      删除是否成功
     */
    public function clearToken($uid='0'){
        $isdelete = M('Token')->where('uid='.$uid)->delete();//删除对应token
        if($isdelete >= 0){//只要语句不出错，就返回真
            return true;
        }else{
            return false;
        }
    }

    /*API返回信息
    *JSON格式
    *@param $msg 返回状态信息
    *@param $code 返回状态码
    *@param $data 返回数据
    */
    public function apiReturn($msg='',$code=404,$data=''){
        $result=array(
            "code" => $code,
            "msg" => $msg,
            "result" => $data
            );
        $this->ajaxReturn($result,'json');
        exit;
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @param int $json_option 传递给json_encode的option参数
     * @return void
     */
    protected function ajaxReturn($data,$type='',$json_option=0) {
        if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)){
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data,$json_option));
            case 'XML'  :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler.'('.json_encode($data,$json_option).');');  
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);            
            default     :
                // 用于扩展其他返回格式数据
                Hook::listen('ajax_return',$data);
        }
    }



}