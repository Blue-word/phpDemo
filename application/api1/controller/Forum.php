<?php
namespace app\api\controller;
use app\api\controller\Common;
use think\Page;

class Forum extends Common{
	//模拟地址 http://localhost/jraz/index.php/V1/forum/forumList
	//Life接口无需验证token
    public function _initialize(){
    	//定义子类_initialize，不调用父类构造方法
    }  
    /*
    论坛信息列表，求职招聘，二手市场，房屋出租等等
     */
	public function forumList(){
        $cate_1 = I('post.cate_1',false);//列表所属板块
        $cate_2 = I('post.cate_2','create_time');//排序字段
        $cate_3 = I('post.cate_3');//精准字段
        switch ($cate_1) {
            case 'house':
                $modal = 'life_house_rent';
                break;
            case 'job':
                $modal = 'life_job_search';
                break;
            case 'car':
                $modal = 'life_car_service';
                break;
            case 'market':
                $modal = 'life_second_market';
                break;
            case 'friends':
                $modal = 'life_city_friends';
                break;           
            default:
                $this->apiReturn("请传入论坛类型","402","请传入论坛类型");
        }
        $p = input('post.p/d',1);
        $modal = D($modal);
        $order = "$cate_2";//搜索字段
        if ($cate_3) {
        	$where["$cate_2"] = array('like', '%' . $cate_3 . '%');
        }
        $res = $modal->where($where)->page('p',PAGES)->order($order)->select();
        //
        foreach ($res as $k => $v) {
            $path_arr[] = explode(',',$v['picture']);
            foreach ($path_arr as $k1 => $v1) {
                $res[$k]['picture'] = img_url_transform($v1,'absolute');//组装地址
            }
            $res[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $res[$k]['empty_time'] = date('Y-m-d',$v['empty_time']);
        }
        $count = D('news')->where($where)->count();
        $pager = new Page($count,7);
        $page =  $pager->totalPages;
        $res['pages'] = $page;
        if ($res) {
            //$result['forumList'] = $res;
            //$this->apiReturn("查询成功","200",$result);
        }
        dump($res);
        //dump($path_arr);

    }
	/*
    论坛列表中的详情页信息，求职招聘，二手市场，房屋出租等等
     */
    public function forumInfo(){
    	$id  = I('post.id');
    	$cate_1 = I('post.cate_1',false);//列表所属板块
    	switch ($cate_1) {
            case 'house':
                $modal = 'life_house_rent';
                break;
            case 'job':
                $modal = 'life_job_search';
                break;
            case 'car':
                $modal = 'life_car_service';
                break;
            case 'market':
                $modal = 'life_second_market';
                break;
            case 'friends':
                $modal = 'life_city_friends';
                break;           
            default:
                $this->apiReturn("请传入论坛类型","402","请传入论坛类型");
        }
        $modal = D($modal);
        $res = $modal->where('id',$id)->find();
        $pic_arr = explode(',',$res['picture']);
        foreach ($pic_arr as $k => $v) {
            $path_arr[] = img_url_transform($v,'absolute');
        }
        $res['picture'] = $path_arr;
        dump($pic_arr);
        //$result['info'] = $res;
        //$result['picture'] = $picture; //图片信息，暂未做
        // if ($res) {
        //     $this->apiReturn("查询成功","200",$res);
        // }
    }

    public function jobIndustry(){
        $res = M('life_job_industry')->field('id,name')->select();
        if ($res) {
            $this->apiReturn("查询成功","200",$res);
        }
    }

}
