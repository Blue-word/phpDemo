<?php
namespace app\api\controller;
use app\api\controller\Common;
use app\admin\controller\Uploadify;
use think\Cache;
use think\db\Query;
use app\api\model;


class User extends Common{
	//模拟地址 http://localhost/jraz/index.php/V1/user/publish
	protected $uid = 1;//测试时用的id
    //测试时关闭token验证
    //public function _initialize(){}  //关闭时调用父类检验token
    /*
    发布信息，求职招聘，二手市场，房屋出租等等
     */
    public function publish(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        //$uid = $cache['uid'];//从token中获取用户id
        $uid = $this->uid;//测试用
        $data = I('post.');
        //$files = request()->file('forum_image');
        $cate = I('post.cate_1',false);//发布所属板块
        switch ($cate) {
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
            );
        $post_res = M('user_post')->save($post_data);
        $related_res = M('user_related')->where('uid',$uid)->setInc('posts',1);
        if ($life_res && $post_res && $related_res) {
            $this->apiReturn("发布成功","200","发布成功");
        }
        //dump($related_res);
    }
    /*
    用户信息
     */
    public function userInfo(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        //$uid = $cache['uid'];//从token中获取用户id
        $uid = $this->uid;//测试用
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
        //dump($result);
    }
    /*
    用户相关，我的发布，我的收藏
     */
    public function userRelated(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        //$uid = $cache['uid'];//从token中获取用户id
        $uid = $this->uid;//测试用
        $cate = I('post.cate',false);//发布所属板块
        switch ($cate) {
            case 'publish':
                $modal = 'user_post';
                break;
            case 'collection':
                $modal = 'user_collection';
                break;          
            default:
                $this->apiReturn("请输入发布类型","402","请输入发布类型");
        }
        $model = D($modal);
        $field = 'id,uid,status';
        $list = $model->where('uid',$uid)->field($field,true)->select();
        if (empty($list)) {
            $this->apiReturn("这里没有任何东西喔~","402","这里没有任何东西喔~");
        }
        foreach ($list as $k => $v) {
            //$field_1 = '';  //等UI图再确定不必要字段
            $list[$k] = M($v['place'])->where('id',$v['post_id'])->find();
            $pic_arr[] = explode(',',$list[$k]['picture']);
            //$list[$k]['picture'] = $pic_arr;
            foreach ($pic_arr as $k1 => $v1) {
                $list[$k]['picture'] = img_url_transform($v1,'absolute');//组装地址
            }
        }
        //dump($list);
        $result = $list;
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
        //$uid = $cache['uid'];//从token中获取用户id
        $uid = $this->uid;//测试用
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
        //dump($data);
    }
    /*
    帖子评论
     */
    public function postReply(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        //$uid = $cache['uid'];//从token中获取用户id
        $uid = $this->uid;//测试用
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
            );
        $res = M('user_post_reply')->add($data);
        if ($res) {
            $this->apiReturn("评论成功","200","评论成功");
        }
        //dump($data);
    }
    /*
    消息首界面
     */
    public function msgHome(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        //$uid = $cache['uid'];//从token中获取用户id
        $uid = $this->uid;//测试用
        $user_msg = M('user_message')->where("to_id=$uid and status=0")->count();//私信回复数
        $com_reply = M('user_post_reply')->where("target_msg_id=$uid and status=0")->count();//评论回复数
        $post_reply = M('user_post_reply')->where("uid=$uid and status=0")->count();//帖子回复数
        $result['user_msg'] = $user_msg;
        $result['com_reply'] = $com_reply;
        $result['post_reply'] = $post_reply;
        $this->apiReturn("查询成功","200",$result);
        //dump($result);
    }
    /*
    消息类别界面，私信、评论、回复
     */
    public function msgList(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        //$uid = $cache['uid'];//从token中获取用户id
        $uid = $this->uid;//测试用
        $cate = I('post.cate',false);//消息查看类型
        switch ($cate) {
            case 'user_msg':
                $model = 'user_message';
                $msg = M($model)->where("to_id=2 and status=0")->select();
                dump($msg);
                break;
            case 'com_reply':
                $model = 'user_post_reply';
                $com_reply = M($model)->where("target_msg_id=$uid and status=0")->select();
                dump($com_reply);
                break;
            case 'post_reply':
                $model = 'user_post_reply';
                $post_reply = M($model)->where("uid=$uid and status=0")->select();
                dump($post_reply);
                break;          
            default:
                $this->apiReturn("请传入查看类型","402","请传入查看类型");
        }
    }
    /*
    消息详情界面，私信、评论、回复
     */
    public function msgDet(){
        $token = I('server.HTTP_TOKEN');//接受HTTP头信息中的token
        $cache = S($token);
        //$uid = $cache['uid'];//从token中获取用户id
        $uid = $this->uid;//测试用
        $id = I('post.id',false);//帖子、评论、私信id
        $cate = I('post.cate',false);//消息查看类型
        switch ($cate) {
            case 'user_msg':
                $model = 'user_message';
                $msg = M($model)->where("id=$id")->find();
                dump($msg);
                break;
            case 'com_reply':
                $model = 'user_post_reply';
                $com_reply = M($model)->where("id=$id")->find();
                dump($com_reply);
                break;
            case 'post_reply':
                $model = 'user_post_reply';
                $post_reply = M($model)->where("id=$id")->find();
                dump($post_reply);
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
        //dump($cache);
        $result = $this->clearToken($uid);//删除数据库中的token
        //$aa = S(I('server.HTTP_TOKEN'),null);
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
        //dump($newpwd);
        if($result !== false){
            $this->apiReturn("密码修改成功",'200',"密码修改成功");
        }else{
            $this->apiReturn("密码修改失败",'401',"密码修改失败");
        }
    }

}