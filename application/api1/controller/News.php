<?php
namespace app\api\controller;
use app\api\controller\Common;
use think\Page;

class News extends Common{
	//模拟地址 http://localhost/jraz/index.php/V1/news/newsCate
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
    新闻列表
     */
    public function newsList(){
        $cate_id = I('post.cate_id');
        $p = input('post.p/d',1);
        $where['cate'] = $cate_id;
        $where['status'] = 1;
        $field = 'id,title,picture,source,comment';
        $res = M('news')->where($where)->order('publish_time desc')->page('p',PAGES)->field($field)->select();
        foreach ($res as $k => $v) {
            $res[$k]['picture'] = explode(',',$v['picture']);
        }
        $count = D('news')->where($where)->count();
        $pager = new Page($count,7);
        $page =  $pager->totalPages;
        $res['pages'] = $page;
        //dump($res);
        if ($res) {
            $this->apiReturn('查询成功','200',$res);
        }else{
            $this->apiReturn('查询错误','400','查询错误');
        }
    }
    /*
    新闻详情
     */
    public function newsDet(){
        $id = I('post.id',97);
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
        //用户评论,时间传时间戳,按点赞数选取两个
        $comment_field = 'id,msg_id,time,content';//缺点赞
        $comment = M('user_post_reply')->where('post_id',$res['id'])->field($comment_field)->select();
        foreach ($comment as $k => $v) {
            $user_field = 'name,head_portrait,create_time';
            $com_user = M('user')->where('uid',$v['id'])->field($user_field)->find();
            $com_user['head_portrait'] = img_url_transform($com_user['head_portrait'],'absolute');//蚁龄
            $com_user['ant_age'] = round((time()-$com_user['create_time'])/86400);//蚁龄
            unset($com_user['create_time']);
            $comment[$k]['time'] = time_change($v['time']);//时间转换
            $comment[$k]['user_info'] = $com_user;
            //dump($comment);
        }
        //热门新闻,当天评论数最多的三条新闻
        $hot_field = 'id,title,publish_time,source,picture';
        $hot_news = M('news')->where('publish_time','<=',mktime(0,0,0,date('m'),date('d'),date('Y')))->field($hot_field)->order('id desc')->limit(3)->select();
        foreach ($hot_news as $k1 => $v1) {
            $hot_news[$k1]['publish_time'] = date('m-d H:i',$v1['publish_time']);
            $hot_news[$k1]['picture'] = strstr($v1['picture'],',',true);//返回
        }
        $result['news_info'] = $res;
        $result['comment'] = $comment;
        $result['hot_news'] = $hot_news;
        dump($result);
        //$this->apiReturn('查询成功','200',$result);

        //dump($com_user);
    }
    /*
    新闻内容详情
     */
    public function contentDet(){
        $id = I('post.id',131);
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
        $field = 'title,content,position,cate';
        $res = M('news_advertising')->where('position',$position)->field($field)->select();
        $this->apiReturn('查询成功','200',$res);
        //dump($res);
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