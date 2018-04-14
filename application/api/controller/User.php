<?php
namespace app\api\controller;
use app\api\controller\Common;
use app\admin\controller\Uploadify;
use think\Cache;
use think\db\Query;
use app\api\model;


class User extends Common{
	//模拟地址 http://localhost/jraz/index.php/api/user/publish
	//protected $uid = 1;//测试时用的id
    //测试时关闭token验证
    //public function _initialize(){}  //关闭时调用父类检验token
    /*
    发布信息，求职招聘，二手市场，房屋出租等等
     */
    public function publish(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        //$uid = $this->uid;//测试用
        $data = I('post.');
        //$files = request()->file('forum_image');
        $cate = I('post.cate_1',false);//发布所属板块
        switch ($cate) {
            case 'house':
                $modal = 'life_house_rent';
                break;
            case 'seek':
                $modal = 'life_house_seek';
            	break;
            case 'job':
                $modal = 'life_job_search';
                break;
            case 'car':
                $modal = 'life_car_business';
                break;
            case 'market':
                $modal = 'life_second_market';
                break;
            case 'friends':
                $modal = 'life_city_friends';
                break;           
            default:
                $this->apiReturn("请输入发布类型","402","请输入发布类型");
        }
        $model = D($modal);
        $upload = new Uploadify();
        $rootpath = I('post.rootpath',false); //根目录文件夹
        $savepath = I('post.savepath',false); //子目录文件夹
        $type = I('post.cate_2'); //上传类型1单图2多图
        if ($type) {
            if (!($rootpath && $savepath && $type)) {
                $this->apiReturn("请输入上传参数","402","请输入上传参数");
            }
            $info = $upload->imgUpload($rootpath,$savepath,$type);
          	//$this->apiReturn("asd","200",$info);
            if ($info['code']) {
                foreach ($info['fileinfo'] as $k => $v) {
                    $path_arr[] = $v['relative_path'];//地址放入数组
                    $data['picture'] = implode(',', $path_arr);//将数组合成以逗号相隔的字符串
                }
            }
        }
        //data处理，暂时无法使用allowField过滤非数据表字段的数据
        unset($data['HTTP_TOKEN'],$data['cate_1'],$data['rootpath'],$data['savepath'],$data['cate_2']);
        $data['uid'] = $uid;
        $life_res = $model->add($data);
        //用户相关，我的帖子
        $post_data = array(
            'id' => $uid.rand(1,9999).'01',
            'post_id' => $life_res,
            'uid' => $uid,
            'place' => $modal,
          	'time' => time(),
            );
        $post_res = M('user_post')->save($post_data);
        $related_res = M('user_related')->where('uid',$uid)->setInc('posts',1);
      	
        if ($life_res && $post_res && $related_res) {
            $this->apiReturn("发布成功","200","发布成功");
        }
        //dump($related_res);
    }
    /*
    查看个人中心
     */
    public function userInfo(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = $this->uid;//测试用
        if (I('post.uid')) {
            $uid = I('post.uid');//查看别人的主页
        }
        $user = M('user');
        $field = 'name,head_portrait,create_time';
        $res = $user->where('uid',$uid)->field($field)->find();
        $res['ant_age'] = round((time()-$res['create_time'])/86400);
        unset($res['create_time']);
        $res['head_portrait'] = img_url_transform($res['head_portrait'],'absolute');//组装地址
        $result['info'] = $res;
        if ($res) {
            $this->apiReturn("查询成功","200",$result);
        }
    }
    /*
    编辑资料
     */
    public function editInfo(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = $this->uid;//测试用
        $data = I('post.');
        $upload = new Uploadify();
        $rootpath = 'user'; //根目录文件夹
        $savepath = 'head_portrait'; //子目录文件夹
        $info = $upload->imgUpload($rootpath,$savepath,1);
        if ($info['code']) {
            $data['head_portrait'] = $info['fileinfo'][0]['relative_path'];
        }
        $result = M('user')->where('uid',$uid)->save($data);
        if ($result) {
            $this->apiReturn("修改成功","200","修改成功");
        }
    }
    /*
    收藏帖子
     */
    public function collection(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = $this->uid;//测试用
        $post_id = I('post.post_id');//收藏的帖子id
        $place = I('post.place');//收藏数据表地址
        $status = I('post.status');//1收藏2取消收藏
        $where['post_id'] = $post_id;
        $where['uid'] = $uid;
        $where['place'] = $place;
        if ($status == '1') { //收藏
            $count = M('user_collection')->where($where)->count();
            if ($count) {
                $this->apiReturn("您已收藏过","400","您已收藏过");
            }
            $col_data = array(
                'id' => $uid.rand(1,9999).'02',
                'post_id' => $post_id,
                'uid' => $uid,
                'place' => $place,
                'time' => time(),
                );
            $res = M('user_collection')->save($col_data);
            if ($res) {
                $this->apiReturn("收藏成功","200","收藏成功");
            }else{
                $this->apiReturn("收藏失败","401","收藏失败");
            }
        }
        if ($status == '2') {
            $result = M('user_collection')->where($where)->delete();
            if ($result) {
                $this->apiReturn("取消收藏","200","取消收藏");
            }else{
                $this->apiReturn("取消收藏失败","401","取消收藏失败");
            }
        }
    }
    /*
    用户相关，我的发布，我的收藏
     */
    public function userRelated(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = $this->uid;//测试用
        if (I('post.uid')) {
            $uid = I('post.uid');//查看别人的主页
        }
        $p = input('post.p/d',1);
        $cate = I('post.cate',false);//发布所属板块
        switch ($cate) {
            case 'publish':
                $modal = 'user_post';
                break;
            case 'collection':
                $modal = 'user_collection';
                break;          
            default:
                $this->apiReturn("请输入发布类型","200","请输入发布类型");
        }
        $model = D($modal);
        $field = 'id,status';
        $userInfo = $model->where('uid',$uid)->page($p,PAGES)->order('time desc')->field($field,true)->select();
        if (empty($userInfo)) {
            $this->apiReturn("这里没有任何东西喔~","402","这里没有任何东西喔~");
        }
        foreach ($userInfo as $k => $v) {
            if ($modal == 'user_collection') {
                $det_field = 'id,title,picture,content';
            }else{
                $det_field = 'id,title,picture';
            }
            if ($v['place'] == 'news') { //新闻
                $list[] = M($v['place'])->where('id',$v['post_id'])->field($det_field)->find();
                $news_cont = clear_all($list[$k]['content']);  //获取纯文本内容
                $list[$k]['content'] = mb_substr($news_cont,0,60,'utf-8');
                $pic_arr = explode(',',$list[$k]['picture']);
                $list[$k]['picture'] = current($pic_arr);//取第一张
            }else{
                $list[] = M($v['place'])->where('id',$v['post_id'])->field($det_field)->find();
                if ($list[$k]['picture'] !== '') {
                    $pic_arr[] = explode(',',$list[$k]['picture']);
                    foreach ($pic_arr as $k1 => $v1) {
                        $list[$k]['picture'] = img_url_transform($v1,'absolute');//组装地址
                    }
                    $list[$k]['picture'] = current($list[$k]['picture']);//取第一张
                }else{
                    $list[$k]['picture'] = '';
                }
            }
            $list[$k]['time'] = $v['time'];
            switch ($v['place']) {
                case 'life_house_rent':
                    $place = '房屋出租';
                    break;
                case 'life_house_seek':
                    $place = '房屋求租';
                    break;
                case 'life_job_search':
                    $place = '求职招聘';
                    break;
                case 'life_car_business':
                    $place = '汽车买卖';
                    break;
                case 'life_second_market':
                    $place = '二手市场';
                    break;
                case 'life_city_friends':
                    $place = '同城交友';
                    break;
                case 'news':
                    $place = '新闻';
                    break;
                default:
                    $place = '蚂蚁专属';
                    break;
            }
            $list[$k]['place'] = $place;
            
        }
        $count = $model->where($where)->count();
        $pager = new Page($count,PAGES);
        $page =  $pager->totalPages;
        // dump($list);
        $result['list'] = $list;
        $result['page'] = $page;
        $result['p'] = $p;
        if ($result) {
            $this->apiReturn("查询成功","200",$result);
        }
    }
    /*
    私信
     */
    public function chat(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = $this->uid;//测试用
        $to_id = I('post.to_id');
        $content = I('post.content');
        $data = array(
            'from_id' => $uid,
            'to_id' => $to_id,
            'content' => $content,
            'time' => time(),
            'status' => 0,
            );
        $res = M('user_message')->add($data);
        $result['content'] = $data['content'];
        $result['time'] = date('m-d H:i',$data['time']);
        if ($res) {
            $this->apiReturn("查询成功","200",$result);
        }
    }
    /*
    帖子评论
     */
    public function postReply(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = $this->uid;//测试用
        $reply = I('post.');
        if ($reply['pid']) {
            $pid = $reply['pid'];
            $target_msg_id = $reply['target_msg_id'];
        }else{
            $pid = 0;
            $target_msg_id = $reply['belong_uid'];
        }
        $data = array(
            'post_id' => $reply['post_id'], //帖子id
            'content' => $reply['content'], //内容
            'msg_id' => $uid, 
            'target_msg_id' => $target_msg_id, //评论人
            'uid' => $reply['belong_uid'],  //帖子所属用户
            'time' => time(),
            'status' => 0,
            'pid' => $pid,                 //评论的父级ID
          	'place' => $reply['place'],
            );
        $res = M('user_post_reply')->add($data);
        if ($res) {
            $this->apiReturn("评论成功","200","评论成功");
        }
    }
  	/*
    新闻点赞
     */
    public function clickZan(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = 2;
        $id = I('post.id');
        $count = M('user_clickzan')->where("id=$id and uid=$uid")->count();
        if ($count) {
            $this->apiReturn("您已点赞过","400","您已点赞过");
        }
        $news_result = M('news')->where('id',$id)->setInc('interest',1);
        $data = array(
            'id' => $id,
            'uid' => $uid,
            );
        $user_result = M('user_clickzan')->save($data);

        if ($news_result && $user_result) {
            $this->apiReturn("点赞成功","200","点赞成功");
        }else{
            $this->apiReturn("点赞失败","403","点赞失败");
        }
    }
  	/*
    评论点赞
     */
    public function comtZan(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = 2;
        $id = I('post.id'); //评论id
        $post_id = I('post.post_id');
        $place = I('post.place');
        $where['id'] = $id;
        $where['post_id'] = $post_id;
        $where['uid'] = $uid;
        $where['place'] = $place;
        $count = M('user_comtzan')->where($where)->count();
        if ($count) {
            $this->apiReturn("您已点赞过","400","您已点赞过");
        }
        $post_result = M('user_post_reply')->where('id',$id)->setInc('interest',1);
        $data = array(
            'id' => $id,
            'uid' => $uid,
            'place' => $place,
            'post_id' => $post_id,
            );
        $user_result = M('user_comtzan')->save($data);

        if ($post_result && $user_result) {
            $this->apiReturn("点赞成功","200","点赞成功");
        }else{
            $this->apiReturn("点赞失败","403","点赞失败");
        }
    }
    /*
    消息首界面
     */
    public function msgHome(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = 2;//测试用
        $user_msg = M('user_message')->where("to_id=$uid and status=0")->count();//私信回复数
        $com_reply = M('user_post_reply')->where("target_msg_id=$uid and status=0")->count();//评论回复数
        $post_reply = M('user_post_reply')->where("uid=$uid and status=0")->count();//帖子回复数
        $result['user_msg'] = $user_msg;
        $result['com_reply'] = $com_reply;
        $result['post_reply'] = $post_reply;
        $result['total_msg'] = $user_msg + $com_reply + $post_reply;
        $this->apiReturn("查询成功","200",$result);
    }
    /*
    消息类别界面，私信、评论、回复
     */
    public function msgList(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = $this->uid;//测试用
        $cate = I('post.cate',false);//消息查看类型
        switch ($cate) {
            case 'user_msg':
                $model = 'user_message';
                $msg = M($model)->where("to_id=2 and status=0")->select();
                break;
            case 'com_reply':
                $model = 'user_post_reply';
                $com_reply = M($model)->where("target_msg_id=$uid and status=0")->select();
                break;
            case 'post_reply':
                $model = 'user_post_reply';
                $field = 'post_id,content,msg_id,time';
                $post_reply = M($model)->where("uid=$uid and status=0")->select();
                break;          
            default:
                $this->apiReturn("请传入查看类型","402","请传入查看类型");
        }
        $this->apiReturn("查询成功","200",$msg);
    }
    /*
    消息详情界面，私信、评论、回复
     */
    public function msgDet(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        // $uid = $this->uid;//测试用
        $id = I('post.id',false);//帖子、评论、私信id
        $cate = I('post.cate',false);//消息查看类型
        switch ($cate) {
            case 'user_msg':
                $model = 'user_message';
                $msg = M($model)->where("id=$id")->find();
                break;
            case 'com_reply':
                $model = 'user_post_reply';
                $com_reply = M($model)->where("id=$id")->find();
                break;
            case 'post_reply':
                $model = 'user_post_reply';
                $post_reply = M($model)->where("id=$id")->find();
                break;          
            default:
                $this->apiReturn("请传入查看类型","402","请传入查看类型");
        }
    }





	/*
    退出登录
     */
    public function loginOut(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        $uid = $cache['uid'];//从token中获取用户id
        $result = $this->clearToken($uid);//删除数据库中的token
        if($result){
            $this->apiReturn("注销成功",'200',"注销成功");
        }else{
            $this->apiReturn("注销失败",'401',"注销失败");
        }
    }
    /*
    修改密码
     */
    public function changePwd(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);//在缓存中找到对应消息
        $uid = $cache['uid'];//从缓存中获取
        $oldpwd = input('post.oldpwd');//旧密码
        $newpwd = input('post.newpwd');//新密码
        //验证旧密码是否正确
        $datapwd = M('User')->where("uid=".$uid)->getField("password");//获取数据库中密码
        if($datapwd !== md5($oldpwd.C('AUTH_CODE'))){
            $this->apiReturn("您输入的密码有误",'400.4',"您输入的密码有误");
        }
        //保存新密码
        $data['password'] = md5($newpwd.C('AUTH_CODE'));//新密码加密
        $result = M('User')->where("uid=".$uid)->save($data);//保存
        if($result !== false){
            $this->apiReturn("密码修改成功",'200',"密码修改成功");
        }else{
            $this->apiReturn("密码修改失败",'401',"密码修改失败");
        }
    }

}