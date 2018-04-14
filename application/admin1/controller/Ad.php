<?php
namespace app\admin\controller;
use think\Page;

class Ad extends Base{

    public function ad(){       
        $act = I('get.act','add');
        $ad_id = I('get.id/d');
        $ad_info = array();
        if($ad_id){
            $ad_info = D('news_advertising')->where('id',$ad_id)->find();
            $ad_info['begin_time'] = date('Y-m-d',$ad_info['begin_time']);
            $ad_info['end_time'] = date('Y-m-d',$ad_info['end_time']);
        }
        $position = D('ad_position')->where('1=1')->select();
        //dump($ad_info);
        $this->assign('info',$ad_info);
        $this->assign('act',$act);
        $this->assign('position',$position);
        return $this->fetch();
    }
    
    public function adList(){
        //搜索关键词
        $ad = M('news_advertising');
        $status = I('status');
        $keywords = trim(I('keywords'));
        $where['title'] = array('like', '%' . $keywords . '%');
        $where['status'] = array('like', '%' . $status . '%');
        if (I('category')) {
            $where['cate'] = I('category');
        }
        //dump($where);
        $p = input('p/d',1);
        $res = $ad->where($where)->page("$p,7")->select();
        foreach ($res as $val){
                $val['begin_time'] = date('Y-m-d H:i',$val['begin_time']);
                $val['end_time'] = date('Y-m-d H:i',$val['end_time']);
                if ($val['status'] == '0') {
                    $val['status'] = "停用";
                }
                if ($val['status'] == '1') {
                    $val['status'] = "启用";
                }
                $list[] = $val;
                //dump($val);
            }
        $count = $ad->where($where)->count();
        $pager = new Page($count,7);
        $page = $pager->show();
        //$category = D('News_category')->select();//取出分类
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('pager',$pager);
        //$this->assign('category',$category);    
        return $this->fetch();
    }
    
    public function adHandle(){
    	$data = I('post.');
    	$data['begin_time'] = strtotime($data['begin_time']);
    	$data['end_time'] = strtotime($data['end_time']);
    	
    	if($data['act'] == 'add'){
            unset($data['act']);
    		$r = D('news_advertising')->add($data);
    	}
    	if($data['act'] == 'edit'){
    		//$r = D('news_advertising')->where('ad_id', $data['ad_id'])->save($data);
    	}
    	
    	if($data['act'] == 'del'){
            //$r = D('news_advertising')->where('ad_id', $data['del_id'])->delete();
    		//if($r) exit(json_encode(1));
    	}
    	$referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U('Admin/Ad/adList');
        // 不管是添加还是修改广告 都清除一下缓存
        dump($data);
        
    	// if($r){
    	// 	$this->success("操作成功",U('Admin/Ad/adList'));
    	// }else{
    	// 	$this->error("操作失败",$referurl);
    	// }
    }
    
    public function posiAdd(){
        $act = I('get.act','add');
        $ad_id = I('get.id/d');
        $data = I('post.');
        if($ad_id){
            $ad_info = D('ad_position')->where('id',$ad_id)->find();
        }
        //dump($ad_info);
        $this->assign('info',$ad_info);
        $this->assign('act',$act);
        return $this->fetch();
    }

    public function position(){
        //搜索关键词
        $ad = M('ad_position');
        $p = input('p/d',1);
        $res = $ad->where($where)->page("$p,7")->select();
        $count = $ad->where($where)->count();
        $pager = new Page($count,7);
        $page = $pager->show();
        //$category = D('News_category')->select();//取出分类
        $this->assign('list',$res);
        $this->assign('page',$page);
        $this->assign('pager',$pager);
        //$this->assign('category',$category);    
        return $this->fetch();
    }

    public function poHandle(){
        $data = I('post.');
        if($data['act'] == 'add'){
            unset($data['act'],$data['id']);
            $data['is_open'] = 1;
            $r = D('ad_position')->add($data);
        }
        if($data['act'] == 'edit'){
            unset($data['act']);
            $r = D('ad_position')->where('id', $data['id'])->save($data);
        }
        if($data['act'] == 'del'){
            $r = D('ad_position')->where('id', $data['id'])->delete();
            if($r) exit(json_encode(1));
        }
        if ($r) {
            $this->redirect('Ad/position');
        }
    }
}