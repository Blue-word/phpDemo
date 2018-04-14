<?php
namespace app\admin\controller;
use think\Db;
use think\Page;

class System extends Base{
	
	/*
	 * 配置入口
	 */
	public function index()
	{          
		/*配置列表*/
		$group_list = array('news_set'=>'网站信息','basic'=>'基本设置','sms'=>'短信设置','shopping'=>'购物流程设置','smtp'=>'邮件设置','water'=>'水印设置','distribut'=>'分销设置');		
		$this->assign('group_list',$group_list);
		$inc_type =  I('get.inc_type','news_set');
		$this->assign('inc_type',$inc_type);
		$config = tpCache($inc_type);
		$this->assign('config',$config);//当前配置项
                C('TOKEN_ON',false);
		return $this->fetch($inc_type);
	}

	public function handle(){
		$param = I('post.');
		$inc_type = $param['inc_type'];
		if ($inc_type == 'news_set') {
			D('config')->where("name='original_statement' AND inc_type='news_set'")->save(['desc'  => '1']);
			D('config')->where("name='reproduit_statement' AND inc_type='news_set'")->save(['desc'  => '2']);
		}
		//unset($param['__hash__']);
		unset($param['inc_type']);
		tpCache($inc_type,$param);
		//dump($inc_type);
		$this->success("操作成功",U('System/index',array('inc_type'=>$inc_type)));
	}

	function right_list(){
          $p = I('p/d',1);
          $right_list = M('system_menu')->page($p.',7')->select();
          $this->assign('list',$logs);
          $count = M('system_menu')->where('1=1')->count();
          $Page = new Page($count,7);
          $show = $Page->show();
     	$group = array('system'=>'系统设置','content'=>'内容管理','goods'=>'商品中心','member'=>'会员中心',
     			'order'=>'订单中心','marketing'=>'营销推广','tools'=>'插件工具','count'=>'统计报表'
     	);
          $this->assign('pager',$Page);
          $this->assign('page',$show);
     	$this->assign('right_list',$right_list);
     	$this->assign('group',$group);
     	return $this->fetch();
     }

     public function edit_right(){
     	if(IS_POST){
     		$data = I('post.');
     		$data['right'] = implode(',',$data['right']);
     		if(!empty($data['id'])){
     			M('system_menu')->where(array('id'=>$data['id']))->save($data);
     		}else{
     			if(M('system_menu')->where(array('name'=>$data['name']))->count()>0){
     				$this->error('该权限名称已添加，请检查',U('System/right_list'));
     			}
     			unset($data['id']);
     			M('system_menu')->add($data);
     		}
     		$this->success('操作成功',U('System/right_list'));
     		exit;
     	}
     	$id = I('id');
     	if($id){
     		$info = M('system_menu')->where(array('id'=>$id))->find();
     		$info['right'] = explode(',', $info['right']);
     		$this->assign('info',$info);
     	}
     	$group = array('system'=>'系统设置','content'=>'内容管理','goods'=>'商品中心','member'=>'会员中心',
     			'order'=>'订单中心','marketing'=>'营销推广','tools'=>'插件工具','count'=>'统计报表'
     	);
     	$planPath = APP_PATH.'admin/controller';
     	$planList = array();
     	$dirRes   = opendir($planPath);
     	while($dir = readdir($dirRes))
     	{
     		if(!in_array($dir,array('.','..','.svn')))
     		{
     			$planList[] = basename($dir,'.class.php');
     		}
     	}
          //dump($info);
          //dump($dir);
     	$this->assign('planList',$planList);
     	$this->assign('group',$group);
        return $this->fetch();
     }

     function ajax_get_action()
     {
          $control = I('controller');
          $advContrl = get_class_methods("app\\admin\\controller\\".str_replace('.php','',$control));
          //dump($advContrl);
          $baseContrl = get_class_methods('app\admin\controller\Base');
          $diffArray  = array_diff($advContrl,$baseContrl);
          $html = '';
          foreach ($diffArray as $val){
               $html .= "<option value='".$val."'>".$val."</option>";
          }
          exit($html);
     }

}