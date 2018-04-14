<?php
namespace app\admin\controller;
use think\Page;
/**
* 
*/
class Life extends Base{

	private $house_status;//房屋出租审核状态
	private $house_type;//房屋类型，求租或者出租
	private $job_type;//求职招聘，1求职2招聘
	private $car_type;//求职招聘，1求职2招聘

	public function _initialize(){
		$this->house_status = C('HOUSE_STATUS');
		$this->house_type	= C('HOUSE_TYPE');
		$this->job_type	= C('JOB_TYPE');
		$this->car_type	= C('CAR_TYPE');
	}

	public function houseRent(){
		$model = D('life_house_rent');
		$type = I('type');
		$status = I('status');
		$keywords = trim(I('keywords'));//搜索关键词
		$where['type'] = array('like', '%' . $type . '%');
		$where['status'] = array('like', '%' . $status . '%');
		$where['title'] = array('like', '%' . $keywords . '%');
		$p = input('p/d',1);
		$res = $model->where($where)->page("$p,7")->select();
		foreach ($res as $val) {
			$val['empty_time'] = date('Y-m-d H:i:s',$val['empty_time']);
			$val['status'] = $this->house_status[$val['status']];
			$val['type']   = $this->house_type[$val['type']];
			$list[] = $val;
		}
		//dump($where);
		$count = $model->where($where)->count();
		$pager = new Page($count,7);
		$page = $pager->show();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('pager',$pager);
		return $this->fetch();
	}

	public function houseHandel(){
		$model = M('life_house_rent');
		$id = I('get.id');
		$act = I('get.act','detail');
		if ($act == 'detail') {
			$res = $model->where('id',$id)->find();
			$res['empty_time'] = date('Y-m-d H:i:s',$res['empty_time']);
		}
		if ($act == 'check') {
			$status = I('status');
			$d = $model->where('id',$id)->save(array('status'=>$status));
			if($d){
        		$this->redirect('Life/houseRent');
	        }else{
	        	$this->error("操作失败",U('Life/houseHandel',array('id'=>$id,'act'=>'detail')));
	        }
		}
		//dump($id);
		$this->assign('act',$act);
		$this->assign('list',$res);
		return $this->fetch('houseRentDet');
	}

	public function jobSearch(){
		$model = M('life_job_search');
		$type = I('type');
		$status = I('status');
		$keywords = trim(I('keywords'));//搜索关键词
		$where['type'] = array('like', '%' . $type . '%');
		$where['status'] = array('like', '%' . $status . '%');
		$where['title'] = array('like', '%' . $keywords . '%');
		$p = input('p/d',1);
		$res = $model->where($where)->page("$p,7")->select();
		foreach ($res as $val) {
			//$val['empty_time'] = date('Y-m-d H:i:s',$val['empty_time']);
			$val['status'] = $this->house_status[$val['status']];
			$val['type']   = $this->job_type[$val['type']];
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

	public function jobHandel(){
		$model = M('life_job_search');
		$id = I('get.id');
		$act = I('get.act','detail');
		if ($act == 'detail') {
			$res = $model->where('id',$id)->find();
			$res['time'] = date('Y-m-d H:i:s',$res['time']);
		}
		if ($act == 'check') {
			$status = I('status');
			if (empty($status)) {
        		$this->error("请审核是否通过",U('Life/jobHandel',array('id'=>$id,'act'=>'detail')));
        	}
			$d = $model->where('id',$id)->save(array('status'=>$status));
			if($d){
        		$this->redirect('Life/jobSearch');
	        }else{
	        	$this->error("操作失败",U('Life/jobHandel',array('id'=>$id,'act'=>'detail')));
	        }
		}
		if($act == 'del'){
        	$r = $model->where('id',$id)->delete();
        	if($r) exit(json_encode(1));
        }
		//dump($id);
		$this->assign('act',$act);
		$this->assign('list',$res);
		return $this->fetch('jobSearchDet');
	}

	public function carBusiness(){
		$model = D('life_car_business');
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
		//dump($res);
		$count = $model->where($where)->count();
		$pager = new Page($count,7);
		$page = $pager->show();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('pager',$pager);
		return $this->fetch();
	}

	public function carHandel(){
		$model = M('life_car_business');
		$id = I('get.id');
		$act = I('get.act','detail');
		if ($act == 'detail') {
			$res = $model->where('id',$id)->find();
			$res['time'] = date('Y-m-d H:i:s',$res['time']);
		}
		if ($act == 'check') {
			$status = I('status');
			if (empty($status)) {
        		$this->error("请审核是否通过",U('Life/carHandel',array('id'=>$id,'act'=>'detail')));
        	}
			$d = $model->where('id',$id)->save(array('status'=>$status));
			if($d){
        		$this->redirect('Life/carBusiness');
	        }else{
	        	$this->error("操作失败",U('Life/carHandel',array('id'=>$id,'act'=>'detail')));
	        }
		}
		if($act == 'del'){
        	$r = $model->where('id',$id)->delete();
        	if($r) exit(json_encode(1));
        }
		//dump($id);
		$this->assign('act',$act);
		$this->assign('list',$res);
		return $this->fetch('carBusinessDet');
	}

	public function secondMarket(){
		$model = D('life_second_market');
		//搜索区
		//$type = I('type');
		$status = I('status');
		$keywords = trim(I('keywords'));//搜索关键词
		//$where['type'] = array('like', '%' . $type . '%');
		$where['status'] = array('like', '%' . $status . '%');
		$where['title'] = array('like', '%' . $keywords . '%');
		$p = input('p/d',1);
		$res = $model->where($where)->page("$p,7")->select();
		foreach ($res as $val) {
			$val['time'] = date('Y-m-d H:i:s',$val['time']);
			$val['status'] = $this->house_status[$val['status']];
			//$val['type']   = $this->car_type[$val['type']];
			$list[] = $val;
		}
		//dump($where);
		$count = $model->where($where)->count();
		$pager = new Page($count,7);
		$page = $pager->show();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('pager',$pager);
		return $this->fetch();
	}

	public function marketHandel(){
		$model = M('life_second_market');
		$id = I('get.id');
		$act = I('get.act','detail');
		if ($act == 'detail') {
			$res = $model->where('id',$id)->find();
			$res['time'] = date('Y-m-d H:i:s',$res['time']);
		}
		if ($act == 'check') {
			$status = I('status');
			if (empty($status)) {
        		$this->error("请审核是否通过",U('Life/marketHandel',array('id'=>$id,'act'=>'detail')));
        	}
			$d = $model->where('id',$id)->save(array('status'=>$status));
			if($d){
        		$this->redirect('Life/secondMarket');
	        }else{
	        	$this->error("操作失败",U('Life/marketHandel',array('id'=>$id,'act'=>'detail')));
	        }
		}
		if($act == 'del'){
        	$r = $model->where('id',$id)->delete();
        	if($r) exit(json_encode(1));
        }
		$this->assign('act',$act);
		$this->assign('list',$res);
		return $this->fetch('secondMarketDet');
	}

	public function cityFriends(){
		$model = D('life_city_friends');
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
		//dump($res);
		$count = $model->where($where)->count();
		$pager = new Page($count,7);
		$page = $pager->show();
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('pager',$pager);
		return $this->fetch();
	}

	public function friendHandel(){
		$model = M('life_city_friends');
		$id = I('get.id');
		$act = I('get.act','detail');
		if ($act == 'detail') {
			$res = $model->where('id',$id)->find();
			$res['time'] = date('Y-m-d H:i:s',$res['time']);
		}
		if ($act == 'check') {
			$status = I('status');
			if (empty($status)) {
        		$this->error("请审核是否通过",U('Life/friendHandel',array('id'=>$id,'act'=>'detail')));
        	}
			$d = $model->where('id',$id)->save(array('status'=>$status));
			if($d){
        		$this->redirect('Life/cityFriends');
	        }else{
	        	$this->error("操作失败",U('Life/friendHandel',array('id'=>$id,'act'=>'detail')));
	        }
		}
		if($act == 'del'){
        	$r = $model->where('id',$id)->delete();
        	if($r) exit(json_encode(1));
        }
		$this->assign('act',$act);
		$this->assign('list',$res);
		return $this->fetch('cityFriendsDet');
	}

	public function industry(){
		$model = M('life_job_industry');
		$status = I('status');
		$keywords = trim(I('keywords'));//搜索关键词
		$where['status'] = array('like', '%' . $status . '%');
		$where['name'] = array('like', '%' . $keywords . '%');
		$p = input('p/d',1);
		$res = $model->where($where)->page("$p,7")->select();
		foreach ($res as $val) {
			$val['time'] = date('Y-m-d H:i:s',$val['time']);
			if ($val['status'] == 0) {
        			$val['status'] = "停用";
        		}else{
        			$val['status'] = "启用";
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

	public function industryAdd(){
		$model = M('life_job_industry');
		$act = I('get.act','add');
		$id = I('get.id');
		$info = $model->where('id',$id)->find();
		
        $this->assign('act',$act);
        $this->assign('info',$info);
		return $this->fetch();
	}

	public function industryHandle(){
		$model = M('life_job_industry');
		$data = I('post.');
		//dump($data);
		if ($data['act'] == 'add') {
			$data = array(
				'name' => I('post.name'),
				'time' => time(),
				'status' => 1,
			);
			$res = $model->add($data);
		}
		if ($data['act'] == 'edit') {
			unset($data['act']);
			$res = $model->where('id',$data['id'])->save($data);
		}
		if ($data['act'] == 'del'){
        	$res = $model->where('id', $data['id'])->delete();
        	if($res) exit(json_encode(1)); 

        }
        if($res){
        	$this->redirect('Admin/Life/industry');
        }else{
        	$this->error("操作失败",U('Admin/Life/industryAdd'));
        }
	}
}