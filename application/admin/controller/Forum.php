<?php
namespace app\admin\controller;
use think\Page;
/**
* 
*/
class Forum extends Base{

	private $house_status;//房屋出租审核状态
	private $car_type;//求职招聘，1求职2招聘

	public function _initialize(){
		$this->house_status = C('HOUSE_STATUS');
		$this->car_type	= C('CAR_TYPE');
	}

	public function carService(){
		$model = D('life_car_service');
		//搜索区
		$status = I('status');
		$keywords = trim(I('keywords'));//搜索关键词
		$where['status'] = array('like', '%' . $status . '%');
		$where['title'] = array('like', '%' . $keywords . '%');
		$p = input('p/d',1);
		$res = $model->where($where)->page("$p,7")->select();
		foreach ($res as $val) {
			$val['time'] = date('Y-m-d H:i:s',$val['time']);
			$val['status'] = $this->house_status[$val['status']];
			$list[] = $val;
		}
		//dump($list);
		$count = $model->where($where)->count();
		$pager = new Page($count,7);
		$page = $pager->show();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('pager',$pager);
		return $this->fetch();
	}

	public function carServiceDet(){
		$field = ('id,name');
		$model = D('life_car_service');
		$act = I('get.act');
		$id = I('get.id');
		if ($act == 'detail') {
			$res = $model->where('id',$id)->find();
			$res['time'] = date('Y-m-d H:i:s',$res['time']);
		}
		//dump($res);
		$this->assign('act',$act);
		$this->assign('list',$res);
		return $this->fetch();
	}

	public function carHandel(){
		$model = D('life_car_service');
		$id = I('get.id');
		$act = I('get.act','detail');
		$status = I('status');
		if ($act == 'check') {
			if (empty($status)) {
        		$this->error("请审核是否通过",U('Forum/carServiceDet',array('id'=>$id,'act'=>'detail')));
        	}
			$d = $model->where('id',$id)->save(array('status'=>$status));
			if($d){
        		$this->redirect('Forum/carService');
	        }else{
	        	$this->error("操作失败",U('Forum/carServiceDet',array('id'=>$id,'act'=>'detail')));
	        }
		}
		if($act == 'del'){
        	$r = $model->where('id',$id)->delete();
        	if($r) exit(json_encode(1));
        }
		//dump($id);
		$this->assign('act',$act);
		$this->assign('list',$res);
		return $this->fetch('carServiceDet');
	}

	public function skillService(){
		return $this->fetch();
	}
}