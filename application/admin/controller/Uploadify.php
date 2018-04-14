<?php
namespace app\admin\controller;
use think\Controller;
use think\File;


class Uploadify extends Controller{

    /**
     * 图片上传方法
     * @param  string $rootpath 根目录文件夹
     * @param  string $savepath 子目录文件夹
     * @param  int    $type     上传类型1单图2多图
     * @return array           图片全地址或报错
     */
	public function imgUpload($rootpath,$savepath,$type=1){
		//上传规则
		$path =  '/public/upload/'.$rootpath.'/'.$savepath;
	    $validate = array(
	    	'size' => 10485760,
	    	'ext'  => 'jpg,png,gif',
	    	);
	    if ($type == 1) {  //单文件上传

	    	$file = request()->file('image');
          	if ($file == null) {
                return $file;
            }
	    	// 移动url到/public/uploads/$urlInfo 目录下
		    $info = $file->validate($validate)->move(ROOT_PATH . 'public' . DS . 'upload' . DS . $rootpath . DS . $savepath);
		    if($info){
		    	//$http = "http://";//http协议
		    	//$webpath = UPLOAD_URL;//网站域名
		    	//$picture_url = $http.$webpath.__ROOT__.'/uploads/'.$info->getSaveName();
		    	$saveName = '/'.$info->getSaveName();
		    	$picture_url = __ROOT__.$path.$saveName;//图片绝对地址,/jraz/public/uploads/forum_image/house/20170721\123.jpg
		    	$pic_info = $info->getInfo();
		    	$return_result['relative_path'] = $picture_url;
		    	$return_result['filename'] = $pic_info['name'];
		    	$return_result['size'] = $pic_info['size'];
            	$result['code'] = true;  //将数组放入二维数组
            	$result['fileinfo'][] = $return_result;
		    }else{
		    	//上传失败获取错误信息
		    	$result['code'] = false; 
            	$result['fileinfo'] = $file->getError();
		    }

	    }else{  //多文件上传

	    	$files = request()->file('image');
          	if ($files == null) {
                return $files;
            }
          	//return $files;
	    	foreach($files as $k => $v){
		        // 移动到框架应用根目录/public/uploads/ 目录下
		        $info = $v->validate($validate)->move(ROOT_PATH . 'public' . DS . 'upload' . DS . $rootpath . DS . $savepath);
		        if($info){
			    	$saveName = '/'.$info->getSaveName();
		    		$picture_url = __ROOT__.$path.$saveName;//图片绝对地址,/jraz/public/uploads/forum_image/house/20170721\123.jpg
			    	$pic_info = $info->getInfo();
			    	$return_result[$k]['relative_path'] = $picture_url;
			    	$return_result[$k]['filename'] = $pic_info['name'];
			    	$return_result[$k]['size'] = $pic_info['size'];
			    	$result['code'] = true;
	            	$result['fileinfo'] = $return_result;
		        }else{
		            //上传失败获取错误信息
			    	$result['code'] = false; 
	            	$result['fileinfo'] = $file->getError();
		        }    
		    }
	    }
	    return $result;
	}
   
    public function upload(){
        $func = I('func');
        $path = I('path','temp');
        $info = array(
        	'num'=> I('num/d'),
            'title' => '',       	
            'upload' =>U('admin/Uploadify/imageUp',array('savepath'=>$path,'pictitle'=>'banner','dir'=>'images')),
            'size' => '4M',
            'type' =>'jpg,png,gif,jpeg',
            'input' => I('input'),
            'func' => empty($func) ? 'undefined' : $func,
        );
        //dump($info);
        $this->assign('info',$info);
        return $this->fetch();
    }
    
    /*
              删除上传的图片
     */
    public function delupload(){
        $action = I('action');                
        $filename= I('filename');
        $filename= str_replace('../','',$filename);
        $filename= trim($filename,'.');
        $filename= trim($filename,'/');
		if($action=='del' && !empty($filename) && file_exists($filename)){
            $size = getimagesize($filename);
            $filetype = explode('/',$size['mime']);
            if($filetype[0]!='image'){
                return false;
                exit;
            }
            unlink($filename);
            exit;
        }
    }

    public function imageUp()
    {       
        // 上传图片框中的描述表单名称，
        $pictitle = I('pictitle');
        $dir = I('dir');
        $title = htmlspecialchars($pictitle , ENT_QUOTES);        
        $path = htmlspecialchars($dir, ENT_QUOTES);
       
        //$input_file           ['upfile'] = $info['Filedata'];  一个是上传插件里面来的, 另外一个是 文章编辑器里面来的
        // 获取表单上传文件
        $file = request()->file('Filedata');
        
        if(empty($file))
            $file = request()->file('upfile');    
        
        $result = $this->validate(
            ['file2' => $file], 
            ['file2'=>'image','file2'=>'fileSize:20000000'],
            ['file2.image' => '上传文件必须为图片','file2.fileSize' => '上传文件过大']                
           );        
        if(true !== $result){            
            $state = "ERROR" . $result;
        }else{
            // 移动到框架应用根目录/public/uploads/ 目录下
            $this->savePath = $this->savePath.date('Y').'/'.date('m-d').'/';
            $info = $file->rule(function ($file) {    
            return  md5(mt_rand()); // 使用自定义的文件保存规则
            })->move('public/upload/'.$this->savePath);        
           //echo print_r($info,true);              
            if ($info) 
                $state = "SUCCESS";                         
            else 
                $state = "ERROR" . $file->getError();                
            $return_data['url'] = '/public/upload/'.$this->savePath.$info->getSaveName();            
        }
        
        
        $return_data['title'] = $title;
        $return_data['original'] = ''; // 这里好像没啥用 暂时注释起来
        $return_data['state'] = $state;
        $return_data['path'] = $path;        
        //print_r($return_data);
        $this->ajaxReturn($return_data,'json');
    }

}