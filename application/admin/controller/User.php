<?php
namespace app\admin\controller;
use think\Page;
/**
* 
*/
class User extends Base{

	public function userList(){
		$model = M('user');
		$p = input('p/d',1);
		$res = $model->where($where)->page("$p,7")->select();
		foreach ($res as $val) {
			$val['create_time'] = date('Y-m-d H:i:s',$val['create_time']);
			if ($val['sex'] == '1') {
				$val['sex'] = '男';
			}
			if ($val['sex'] == '0') {
				$val['sex'] = '女';
			}
			$list[] = $val;
		}
		//dump($res);
		$count = $model->where($where)->count();
		$pager = new Page($count,7);
		$page = $pager->show();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('pager',$pager);
		return $this->fetch();
	}

	public function userHandel(){
		$model = M('user');
		$data = I('post.');
    	$r = $model->where('uid',$data['uid'])->delete();
    	if($r) exit(json_encode(1));
	}
}