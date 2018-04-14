<?php
namespace app\api\controller;
use app\api\controller\Common;
use think\Page;

class News extends Common{
	//模拟地址 http://localhost/jraz/index.php/api/news/newsCate
	//News接口无需验证token
    public function _initialize(){
    	//定义子类_initialize，不调用父类构造方法
    }
	/*
    获取新闻分类
     */
    public function newsCate(){
    	$modal = M('news_category');
    	$type = I('post.type');
        $field = 'id,name,description';
    	$result = $modal->where('cate',$type)->field($field)->select();
    	$this->apiReturn('查询成功','200',$result);
    	//dump($result);
    }
  	/*
    轮播新闻列表
     */
    public function rotationList(){
        $cate_id = I('post.cate_id');
        $p = input('post.p/d',1);
        $where['cate'] = $cate_id;
        $where['status'] = 1;
        $where['is_rotation'] = 1;
        $field = 'id,title,picture';
        $res = M('news')->where($where)->order('publish_time desc')->limit(5)->field($field)->select();
      	if (empty($res)) {
        	$this->apiReturn('查询错误','400','没有轮播新闻');
        }
        foreach ($res as $k => $v) {
            $res[$k]['picture'] = explode(',',$v['picture']);
            $res[$k]['picture'] = $res[$k]['picture'][0];//取第一张
          	$res[$k]['url'] = 'http://106.15.199.8/jraz/admin/news/test/id/'.$v['id'];
        }
      	//dump($res);
        if ($res) {
            $this->apiReturn('查询成功','200',$res);
        }else{
            $this->apiReturn('查询错误','400','查询错误');
        }
    }
    /*
    新闻列表
     */
    public function newsList(){
        $cate_id = I('post.cate_id');
        $p = input('post.p/d',1);
        $where['cate'] = $cate_id;
        $where['status'] = 1;
        $field = 'id,title,picture,source,comment';
        $res = M('news')->where($where)->order('publish_time desc')->page($p,PAGES)->field($field)->select();
        foreach ($res as $k => $v) {
            $res[$k]['picture'] = explode(',',$v['picture']);
          	$res[$k]['url'] = 'http://106.15.199.8/jraz/admin/news/test/id/'.$v['id'];
        }
        $count = D('news')->where($where)->count();
        $pager = new Page($count,PAGES);
        $page =  $pager->totalPages;
      	$result['list'] = $res;
      	$result['pages'] = $page;
      	$result['page'] = $p;
      	
        if ($result) {
            $this->apiReturn('查询成功','200',$result);
        }else{
            $this->apiReturn('查询错误','400','查询错误');
        }
    }
    /*
    新闻详情
     */
    public function newsDet(){
        $id = I('post.id',169);
        //新闻详情
        $news_field = 'id,author_id,title,publish_time,source,statement,interest';
        $res = M('news')->where('id',$id)->field($news_field)->find();
        if (!$res) {
            $this->apiReturn('没有该新闻','400','没有该新闻');
        }
        $res['publish_time'] = date('m-d H:i',$res['publish_time']);
        //声明
        $statement = M('config')->where('desc',$res['statement'])->getField('value');
        $res['statement'] = $statement;
        //管理员头像
        $admin_field = 'nickname,head_portrait';
        $admin_head = M('admin')->where('admin_id='.$res['author_id'])->field($admin_field)->find();
        $res['nickname'] = $admin_head['nickname'];
        $res['head_portrait'] = img_url_transform($admin_head['head_portrait'],'absolute');
        //用户评论3条,时间传时间戳,按点赞数选取两个
        $comment_field = 'id,post_id,msg_id,time,content,pid';//缺点赞
        $comment_where['post_id'] = $res['id'];
        $comment_where['pid'] = '0';
        $comment = M('user_post_reply')->where($comment_where)->field($comment_field)->limit(3)->select();
        foreach ($comment as $k => $v) {
            $user_field = 'name,head_portrait,create_time,area';
            $com_user = M('user')->where('uid',$v['msg_id'])->field($user_field)->find();
            $com_user['head_portrait'] = img_url_transform($com_user['head_portrait'],'absolute');//蚁龄
            $com_user['ant_age'] = round((time()-$com_user['create_time'])/86400);//蚁龄
            unset($com_user['create_time']);
            $comment[$k]['time'] = time_change($v['time']);//时间转换
            $comment[$k]['user_info'] = $com_user;
            //子评论
            $sec_comment_where['post_id'] = $v['post_id'];
            $sec_comment_where['pid'] = $v['id'];
            $sec_comment_field = 'msg_id,content';
            $sec_comment = M('user_post_reply')->where($sec_comment_where)->field($sec_comment_field)->limit(3)->select();
            if (!empty($sec_comment)) {
                foreach ($sec_comment as $k2 => $v2) {
                    $sec_comment[$k2]['msg_name'] = M('user')->where('uid',$v2['msg_id'])->getField('name');
                }
                $comment[$k]['sec_comment'] = $sec_comment;
            }
            // dump($v);
        }
        //热门新闻,当天评论数最多的三条新闻
        $hot_field = 'id,title,publish_time,source,picture';
        $hot_news = M('news')->where('publish_time','<=',mktime(0,0,0,date('m'),date('d'),date('Y')))->where('status','1')->field($hot_field)->order('id desc')->limit(3)->select();
        foreach ($hot_news as $k1 => $v1) {
            $hot_news[$k1]['publish_time'] = date('m-d H:i',$v1['publish_time']);
            $hot_news[$k1]['picture'] = explode(',',$v1['picture']);
            $hot_news[$k1]['picture'] = $hot_news[$k1]['picture'][0];//取第一张
            //$hot_news[$k1]['picture'] = strstr($v1['picture'],',',true);//返回
            $hot_news[$k1]['url'] = 'http://106.15.199.8/jraz/admin/news/test/id/'.$v1['id'];
            //dump($hot_news);
        }
        //$result['url'] = 'http://106.15.199.8/jraz/admin/news/test/id/'.$id;
        $result['news_info'] = $res;
        $result['comment'] = $comment;
        $result['hot_news'] = $hot_news;
        $this->apiReturn('查询成功','200',$result);
    }
  /*
    查看单条评论详情
     */
    public function comment_det(){
        $id = I('post.id',1);  //评论id
        $p = input('post.p/d',1);
        //用户评论3条,时间传时间戳,按点赞数选取两个
        $comment_field = 'id,msg_id,time,content,interest,post_id';//缺点赞
        $where['id'] = $id;
        $comment = M('user_post_reply')->where($where)->field($comment_field)->find();
        $user_field = 'name,head_portrait,create_time,area';
        $com_user = M('user')->where('uid',$comment['msg_id'])->field($user_field)->find();
        $com_user['head_portrait'] = img_url_transform($com_user['head_portrait'],'absolute');//蚁龄
        $com_user['ant_age'] = round((time()-$com_user['create_time'])/86400);//蚁龄
        unset($com_user['create_time']);
        $comment['user_info'] = $com_user;
        //子评论
        $sec_comment_field = 'msg_id,content,interest,time';
        $sec_comment = M('user_post_reply')->where('pid',$id)->field($sec_comment_field)->page($p,PAGES)->select();
        if (!empty($sec_comment)) {
            foreach ($sec_comment as $k => $v) {
                $user_field = 'name,head_portrait';
                $com_user = M('user')->where('uid',$v['msg_id'])->field($user_field)->find();
                $com_user['head_portrait'] = img_url_transform($com_user['head_portrait'],'absolute');//蚁龄
                $sec_comment[$k]['time'] = date('m-d h:i',$v['time']);//时间转换
                $sec_comment[$k]['user_info'] = $com_user;
                //dump($comment);
            }
            $comment['sec_comment'] = $sec_comment;
        }
        $count = D('user_post_reply')->where('pid',$id)->count();
        $pager = new Page($count,PAGES);
        $page =  $pager->totalPages;
        $comment['pages'] = $page;
        $comment['page'] = $p;
        // dump($comment);
        // dump($sec_comment);
        $this->apiReturn('查询成功','200',$comment);
    }
 	 /*
    查看全部评论
     */
    public function comment_list(){
        $id = I('post.id',169);
        $place = I('post.place');
        $p = input('post.p/d',1);
        //用户评论3条,时间传时间戳,按点赞数选取两个
        $comment_field = 'id,msg_id,time,content,interest,post_id';//缺点赞
        $where['post_id'] = $id;
        $where['place'] = $place;
        $comment = M('user_post_reply')->where($where)->page($p,PAGES)->field($comment_field)->select();
        foreach ($comment as $k => $v) {
            $user_field = 'name,head_portrait,create_time,area';
            $com_user = M('user')->where('uid',$v['msg_id'])->field($user_field)->find();
            $com_user['head_portrait'] = img_url_transform($com_user['head_portrait'],'absolute');//蚁龄
            $com_user['ant_age'] = round((time()-$com_user['create_time'])/86400);//蚁龄
            unset($com_user['create_time']);
            $comment[$k]['time'] = time_change($v['time']);//时间转换
            $comment[$k]['user_info'] = $com_user;
            //dump($comment);
            //子评论
            $sec_comment_where['post_id'] = $v['post_id'];
            $sec_comment_where['pid'] = $v['id'];
            $sec_comment_field = 'msg_id,content,post_id';
            $sec_comment = M('user_post_reply')->where($sec_comment_where)->field($sec_comment_field)->limit(3)->select();
            if (!empty($sec_comment)) {
                foreach ($sec_comment as $k1 => $v1) {
                    $sec_comment[$k1]['msg_name'] = M('user')->where('uid',$v1['msg_id'])->getField('name');
                }
                $comment[$k]['sec_comment'] = $sec_comment;
            }
        }
        $count = D('user_post_reply')->where($where)->count();
        $pager = new Page($count,PAGES);
        $page =  $pager->totalPages;
        $result['list'] = $comment;
        $result['pages'] = $page;
        $result['page'] = $p;
        //dump($result);
        $this->apiReturn('查询成功','200',$result);
    }
    /*
    新闻内容详情
     */
    public function contentDet(){
        $id = I('post.id');
        if (empty($id)) {
        	$this->apiReturn('请传入新闻ID','402','请传入新闻ID');
        }
        //$id = 50;
        $res = M('news')->where('id',$id)->find();
        $this->assign('list',$res);
        //dump($res);
        return $this->fetch('admin@news/test');
    }
    /*
    广告位置
     */
    public function position(){
        $res = M('ad_position')->field('is_open',true)->select();
        $this->apiReturn('查询成功','200',$res);
        //dump($res);
    }
    /*
    广告推广
     */
    public function advertising(){
        $position = I('post.position');
        if (empty($position)) {
            $this->apiReturn('未传入广告位置','402','未传入广告位置');
        }
        $field = 'id,title,picture,cate';
        $res = M('news_advertising')->where('position',$position)->field($field)->select();
        foreach ($res as $k => $v) {
            if ($v['picture'] !== '') { //picture为空则处理
                $path_arr[] = explode(',',$v['picture']);
                foreach ($path_arr as $k1 => $v1) {
                    $res[$k]['picture'] = img_url_transform($v1,'absolute');//组装地址
                }
            }
        }
        $this->apiReturn('查询成功','200',$res);
    }
    /*
    天气
     */
    public function weather(){
        $key = 'a6693ccf90fd4def905d7d9df9d4e50f';
        $city = I('post.city');
        $url_1 = 'https://free-api.heweather.com/v5/now?city=';
        //$url = 'http://app.jinriaozhou.com/news-au';
        $url = $url_1.$city.'&key='.$key;
        if (empty($city)) {
            $this->apiReturn('未传入城市','402','未传入城市');
        }
        $url_res = request_post1($url); 
        $arr = json_decode($url_res,true);
        $res['tmp'] = $arr['HeWeather5'][0]['now']['tmp'].'°C';
        $res['code'] = $arr['HeWeather5'][0]['now']['cond']['code'];
        $res['txt'] = $arr['HeWeather5'][0]['now']['cond']['txt'];
        $res['code'] = 'https://cdn.heweather.com/cond_icon/'.$res['code'].'.png';
        $res['time'] = date('m-d',time());
        $this->apiReturn('查询成功','200',$res);
        // dump($res);
        // dump($arr);
    }
}