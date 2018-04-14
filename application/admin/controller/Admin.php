<?php
namespace app\admin\controller;
use think\Page;
use think\Verify;
use think\Db;
use think\Session;
/**
* 
*/
class Admin extends Base{
	
	public function admin(){
		return $this->fetch();
	}

	public function index(){
		$list = array();
    	$keywords = I('keywords/s');
    	if(empty($keywords)){
    		$res = D('admin')->select();
    	}else{
			$res = DB::name('admin')->where('user_name','like','%'.$keywords.'%')->order('admin_id')->select();
    	}
    	$role = D('admin_role')->getField('role_id,role_name');
    	if($res && $role){
    		foreach ($res as $val){
    			$val['role'] =  $role[$val['role_id']];
    			$val['add_time'] = date('Y-m-d H:i:s',$val['add_time']);
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);
		return $this->fetch();
	}

    /*
     * 管理员登陆
     */
    public function login(){
        if(session('?admin_id') && session('admin_id')>0){
             //$this->error("您已登录",U('Admin/Index/index'));
        }
        //dump(I('post.'));
      
        if(IS_POST){
            $condition['user_name'] = I('post.username/s');
            $condition['password'] = I('post.password/s');

            if(!empty($condition['user_name']) && !empty($condition['password'])){
                $condition['password'] = encrypt($condition['password']);
                $admin_info = M('admin')->join(PREFIX.'admin_role', PREFIX.'admin.role_id='.PREFIX.'admin_role.role_id','INNER')->where($condition)->find();
                //dump($admin_info);
                if(is_array($admin_info)){
                    session('admin_id',$admin_info['admin_id']);
                    session('act_list',$admin_info['act_list']);
                    M('admin')->where("admin_id = ".$admin_info['admin_id'])->save(array('last_login'=>time(),'last_ip'=>  getIP()));
                    session('last_login_time',$admin_info['last_login']);
                    session('last_login_ip',$admin_info['last_ip']);
                    adminLog('后台登录');
                    $url = session('from_url') ? session('from_url') : U('Admin/Index/index');
                    if($url){
                         $this->success("登陆成功",U('admin/index/index'));
                    }
                    //exit(json_encode(array('status'=>1,'url'=>$url)));
                    //dump($url);
                }else{
                    $this->error("用户名或密码不正确");
                }
            }else{
                $this->error("用户名或密码不能为空");
                //exit(json_encode(array('status'=>0,'msg'=>'请填写账号密码')));
            }
        }
        
       return $this->fetch();
    }

	public function admin_info(){
    	$admin_id = I('get.admin_id/d',0);
    	if($admin_id){
    		$info = D('admin')->where("admin_id", $admin_id)->find();
			$info['password'] =  "";
    		$this->assign('info',$info);
    	}
    	$act = empty($admin_id) ? 'add' : 'edit';
    	$this->assign('act',$act);
    	$role = D('admin_role')->where('1=1')->select();
    	$this->assign('role',$role);
    	return $this->fetch();
    }

    public function adminHandle(){
        $data = I('post.');
        if(empty($data['password'])){
            unset($data['password']);
        }else{
            $data['password'] = encrypt($data['password']);
            //$data['password'] = encrypt($data['password']);
        }
        if($data['act'] == 'add'){
            unset($data['admin_id']);           
            $data['add_time'] = time();
            if(D('admin')->where("user_name", $data['user_name'])->count()){
                $this->error("此用户名已被注册，请更换",U('Admin/Admin/admin_info'));
            }else{
                $r = D('admin')->add($data);
            }
        }
        
        if($data['act'] == 'edit'){
            unset($data['act']);
            $r = D('admin')->where('admin_id', $data['admin_id'])->save($data);
        }
        
        if($data['act'] == 'del' && $data['admin_id']>1){
            $r = D('admin')->where('admin_id', $data['admin_id'])->delete();
            exit(json_encode(1));
        }

        //dump($data);
        
        if($r){
            $this->success("操作成功",U('Admin/Admin/index'));
        }else{
            $this->error("操作失败",U('Admin/Admin/index'));
        }
    }

	public function role(){
		$list = D('admin_role')->order('role_id desc')->select();
    	$this->assign('list',$list);
		return $this->fetch();
	}

	public function role_info(){
    	$role_id = I('get.role_id/d');
    	$detail = array();
    	if($role_id){
    		$detail = M('admin_role')->where("role_id",$role_id)->find();
    		$detail['act_list'] = explode(',', $detail['act_list']);
    		$this->assign('detail',$detail);
    	}
		$right = M('system_menu')->order('id')->select();
		foreach ($right as $val){
			if(!empty($detail)){
				$val['enable'] = in_array($val['id'], $detail['act_list']);
			}
			$modules[$val['group']][] = $val;
		}
		//权限组
		$group = array('system'=>'系统设置','content'=>'内容管理','goods'=>'商品中心','member'=>'会员中心',
				'order'=>'订单中心','marketing'=>'营销推广','tools'=>'插件工具','count'=>'统计报表'
		);
		$this->assign('group',$group);
		$this->assign('modules',$modules);
    	return $this->fetch();
    }

    public function roleSave(){
    	$data = I('post.');
    	$res = $data['data'];
    	$res['act_list'] = is_array($data['right']) ? implode(',', $data['right']) : '';
        if(empty($res['act_list']))
            $this->error("请选择权限!");        
    	if(empty($data['role_id'])){
    		$r = D('admin_role')->add($res);
    	}else{
    		$r = D('admin_role')->where('role_id', $data['role_id'])->save($res);
    	}
        //dump($res);
		if($r){
			adminLog('管理角色');
			$this->success("操作成功!",U('Admin/Admin/role',array('role_id'=>$data['role_id'])));
		}else{
			$this->error("操作失败!",U('Admin/Admin/role'));
		}
    }

    

	public function log(){
    	$p = I('p/d',1);
    	$logs = DB::name('admin_log')->alias('l')->join('__ADMIN__ a','a.admin_id =l.admin_id')->order('log_time DESC')->page($p.',7')->select();
    	//$logs['log_time'] = date('Y-m-d H:i:s',$logs['log_time']);
    	$count = DB::name('admin_log')->where('1=1')->count();
    	$Page = new Page($count,7);
    	$show = $Page->show();
        $this->assign('list',$logs);
		$this->assign('pager',$Page);
		$this->assign('page',$show);
    	return $this->fetch();
    }

	public function supplier()
	{
		$supplier_count = DB::name('suppliers')->count();
		$page = new Page($supplier_count, 10);
		$show = $page->show();
		$supplier_list = DB::name('suppliers')
				->alias('s')
				->field('s.*,a.admin_id,a.user_name')
				->join('__ADMIN__ a','a.suppliers_id = s.suppliers_id','LEFT')
				->limit($page->firstRow, $page->listRows)
				->select();
		$this->assign('list', $supplier_list);
		$this->assign('page', $show);
		return $this->fetch();
	}


    /**
     * 退出登陆
     */
    public function logout(){
        session_unset();
        session_destroy();
        session::clear();
        $this->success("退出成功",U('Admin/Admin/login'));
    }
    /**
     * 验证码获取
     */
    // public function vertify()
    // {
    //     $config = array(
    //         'fontSize' => 30,
    //         'length' => 4,
    //         'useCurve' => true,
    //         'useNoise' => false,
    //         'reset' => false
    //     );    
    //     $Verify = new Verify($config);
    //     $Verify->entry("admin_login");
    // }

    public function roleDel(){
        $role_id = I('post.role_id/d');
        $admin = D('admin')->where('role_id',$role_id)->find();
        if($admin){
            exit(json_encode("请先清空所属该角色的管理员"));
        }else{
            $d = M('admin_role')->where("role_id", $role_id)->delete();
            if($d){
                exit(json_encode(1));
            }else{
                exit(json_encode("删除失败"));
            }
        }
    }
}