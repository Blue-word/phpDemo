<?php
namespace app\api\controller;
use app\api\controller\Common;
use app\api\model\User;
use think\Cache;
use think\Session;
use think\db\Query;

class Login extends Common{
    //模拟地址 http://localhost/jraz/index.php/V1/login/login
	//public $uid = 1;//测试用
    //测试时关闭token验证
    public function _initialize(){}  //关闭时调用父类检验token
    /*
    登录
     */
    public function login(){
    	if (IS_POST) {
    		$type = I('post.type');
    		if (!$type) {
    			$this->apiReturn("无登录类型",'402',"无登录类型");
    		}
    		switch ($type) {
    			case 'sms':  //短信验证码登录
    				$account = I('post.account');
                    $field = 'password,create_time';//隐藏字段
    				$res = M('user')->where('account',$account)->field($field,true)->find();
    				if ($res) {
    					$uid = $res['uid'];
    					$token = $this->createToken($account,$uid);//创建加密token，身份令牌
    					$data['uid'] = $uid;
    					$data['token'] = $token;
    					if ($this->clearToken($uid)) {//更新Token，保证用户无法多处登录
    						M('token')->add($data);//新token添加到数据库
    					}
                        $res['token'] = $token;
    					Cache::set($token,$res);//将用户信息存入以token为key的缓存中
                        //dump(Cache::get($token));
    					$result['token'] = $token;
                		$result['uid'] = $uid;
    					$this->apiReturn("登录成功",'200',$result);
    				}else{
    					$this->apiReturn("用户不存在",'400',"用户不存在");
    				}
    				break;

				case 'pas':  //密码登录
    				$account  = I('post.account');
    				$pwd      = I('post.password');
            		$password = md5($pwd.C('AUTH_CODE'));//加密,撒盐
    				$where['account']  = $account;
    				$where['password'] = $password;
                    //dump($where);
    				$res = M('user')->where($where)->find();
    				if ($res) {
    					$uid = $res['uid'];
    					$token = $this->createToken($account,$uid);//创建加密token，身份令牌
    					$data['uid'] = $uid;
    					$data['token'] = $token;
    					if ($this->clearToken($uid)) {//更新Token，保证用户无法多处登录
    						M('token')->add($data);//新token添加到数据库
    					}
    					$res['token'] = $token;
                        Cache::set($token,$res);//将用户信息存入以token为key的缓存中
                        //dump(Cache::get($token));
    					$result['token'] = $token;
                		$result['uid'] = $uid;
    					$this->apiReturn("登录成功",'200',$token);
    				}else{
    					$this->apiReturn("用户不存在",'400',"用户不存在");
    				}
    				break;
    		}
    	}else{
    		$this->apiReturn("请求类型错误",'415',"请求类型错误");
    	}
    }
    /*
    注册
     */
    public function register(){
        if(IS_POST){
            $account = I('post.account');//账号
            $password = I('post.password');//密码
            $user = M('user');
            $count = $user->where('account',$account)->count();
            if($count){
                $this->apiReturn("该账号已注册",'400',"该账号已注册");
            }else{
                $data = array(
                    'account' => $account,
                    'password' => md5($password.C('AUTH_CODE')),
                    'create_time' => time(),
                );
                $result = $user->data($data)->add();
                $related_data['uid'] = $result;
                M('user_related')->data($related_data)->add();
                if($result){
                    $this->apiReturn("注册成功",'200',"注册成功");
                }else{
                    $this->apiReturn("注册失败",'401',"注册失败");
                }
            }
        }else{
            $this->apiReturn("错误的请求类型",'415',"错误的请求类型");
        }
    }
    /*
    忘记密码
     */
    public function forgetPwd(){
        if(IS_POST){
            $account = I('post.account');//账号
            $newpwd  = I('post.newpwd');//新密码
            $exist = M('user')->where("account=".$account)->find();//查找该账号是否存在
            if($exist == Null){
                $this->apiReturn("账号不存在",'400',"账号不存在");
            }
            $data['password'] = md5($newpwd.C('AUTH_CODE'));//新密码加密
            $result = M('user')->where("uid=".$exist['uid'])->save($data);//保存至数据库
            if($result){
                $this->apiReturn("密码重置成功",'200',"密码重置成功");
            }else{
                $this->apiReturn("密码重置失败",'401',"密码重置失败");
            }
        }else{
            $this->apiReturn("错误的请求类型",'415',"错误的请求类型");
        }
    }

}