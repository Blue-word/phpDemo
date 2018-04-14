<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 获取缓存或者更新缓存
 * @param string $config_key 缓存文件名称
 * @param array $data 缓存数据  array('k1'=>'v1','k2'=>'v3')
 * @return array or string or bool
 */
function tpCache($config_key,$data = array()){
    $param = explode('.', $config_key);
    if(empty($data)){
        //如$config_key=shop_info则获取网站信息数组
        //如$config_key=shop_info.logo则获取网站logo字符串
        $config = F($param[0],'',TEMP_PATH);//直接获取缓存文件
        if(empty($config)){
            //缓存文件不存在就读取数据库
            $res = D('config')->where("inc_type",$param[0])->select();
            if($res){
                foreach($res as $k=>$val){
                    $config[$val['name']] = $val['value'];
                }
                F($param[0],$config,TEMP_PATH);
            }
        }
        if(count($param)>1){
            return $config[$param[1]];
        }else{
            return $config;
        }
    }else{
        //更新缓存
        $result =  D('config')->where("inc_type", $param[0])->select();
        if($result){
            foreach($result as $val){
                $temp[$val['name']] = $val['value'];
            }
            foreach ($data as $k=>$v){
                $newArr = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
                if(!isset($temp[$k])){
                    M('config')->add($newArr);//新key数据插入数据库
                }else{
                    if($v!=$temp[$k])
                        M('config')->where("name", $k)->save($newArr);//缓存key存在且值有变更新此项
                }
            }
            //更新后的数据库记录
            $newRes = D('config')->where("inc_type", $param[0])->select();
            foreach ($newRes as $rs){
                $newData[$rs['name']] = $rs['value'];
            }
        }else{
            foreach($data as $k=>$v){
                $newArr[] = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
            }
            M('config')->insertAll($newArr);
            $newData = $data;
        }
        return F($param[0],$newData,TEMP_PATH);
    }
}

/**
 * phpquery爬虫html中的div
 */
function divQuery1($url){
    header("Content-Type: text/html; charset=UTF-8");
    require("./public/plugins/phpQuery1.php");
    $html = file_get_contents($url);
    phpQuery::newDocumentHtml($url);
    //$arr = array();
    $res = pq(".news-body");
    $result = (string)$res;
    return $result;
    // if ($type == 1) {
    //     $res = pq(".news-body");
    //     $result = (string)$res;
    //     return $result;
    // }else{
    //     $res = pq(".news-body img");
    //     foreach ($res as $v) {
    //         $arr[] = pq($v)->attr('src');
    //     }
    //     $result = (string)$arr;
    //     return $result;
    // }  
}

function divQuery2($url){
    header("Content-Type: text/html; charset=UTF-8");
    require("./public/plugins/phpQuery1.php");
    $html = file_get_contents($url);
    phpQuery::newDocumentHtml($html);
    $res = pq("#content");
    $result = (string)$res;
    return $result; 
}

function http_request($url){
        //$url='http://sydney.jinriaozhou.com/content-101731433269015';
        $ch = curl_init();
        $timeout = 5;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        header("Content-Type: text/html; charset=UTF-8");
        require("./public/plugins/phpQuery1.php");
        //$html = file_get_contents($url);
        phpQuery::newDocumentHtml($file_contents);
        //$arr = array();
        $res = pq(".news-body");
        //$res = pq("#content");
        $result = (string)$res;

        return $result;
        //function_exists()替换
        // if(function_exists('file_get_contents')) {
        // $file_contents = file_get_contents($url);
        // } else {
        // $ch = curl_init();
        // $timeout = 5;
        // curl_setopt ($ch, CURLOPT_URL, $url);
        // curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        // $file_contents = curl_exec($ch);
        // curl_close($ch);
        // }
        // return $file_contents;   
}





/**
 * 实现中文字串截取无乱码的方法
 */
function getSubstr($string, $start, $length) {
      if(mb_strlen($string,'utf-8')>$length){
          $str = mb_substr($string, $start, $length,'utf-8');
          return $str.'...';
      }else{
          return $string;
      }
}
/**
 * 图片地址转换
 * @param   $url  图片地址
 * @param   $type 转换类型
 * @return        转换后地址
 */
function img_url_transform($url,$type){
    $http = "http://";//http协议
    $website = UPLOAD_URL;//网站域名
    if ($url == '') {
        return $url;
    }

    if($type == 'absolute'){    //补充成全地址
        if(is_array($url)){   //看是否是数组
            foreach($url as $v){
                $result[] = $http.$website.$v;
            } 
        }else{
            $result = $http.$website.$url;
        }  
    }
    if($type == 'relative'){    //删减为相对地址
        if(is_array($url)){
            foreach($url as $v){
                $result[] = str_replace($http.$website,'',$v);
            }
        }else{
            $result = str_replace($http.$website,'',$url);
        }     
    }
    return $result;
}

 /**
 * @param $arr
 * @param $key_name
 * @return array
 * 将数据库中查出的列表以指定的 id 作为数组的键名 
 */
function convert_arr_key($arr, $key_name)
{
  $arr2 = array();
  foreach($arr as $key => $val){
    $arr2[$val[$key_name]] = $val;        
  }
  return $arr2;
}

function encrypt($str){
   return md5(C("AUTH_CODE").$str);
}

 // 定义一个函数getIP() 客户端IP，
function getIP(){ 
    global $ip;           
    if (getenv("HTTP_CLIENT_IP"))
         $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
         $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
    
    // if(preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip))          
    //     return $ip;
    // else
    //     return '';
}

// 服务器端IP
 function serverIP(){
  return gethostbyname($_SERVER["SERVER_NAME"]);   
 }
 /**
 * 模拟post进行url请求
 */
function request_post($url = '') {
    if (empty($url)) {
        return false;
    }
    $postUrl = $url;
    // $curlPost = $param;
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    return $data;
}

function request_post1($url = ''){
    if (empty($url)) {
        return false;
    }
    $postUrl = $url;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $postUrl);
    //curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
