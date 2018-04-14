<?php
use think\Request;
/*
图片以逗号拆分成数组
 */
function pic_change($data){
	return $data;
	if ($data) {
		return 1;
		foreach ($data as $k => $v) {
			$res = explode(',',$v['picture']);
			return $res;
		}
	}
}
/*
时间转换函数，几小时前几天前
 */
function time_change($time){  
    $t=time()-$time;
    $f=array(  
        '31536000'=>'年',  
        '2592000'=>'个月',  
        '604800'=>'星期',  
        '86400'=>'天',  
        '3600'=>'小时',  
        '60'=>'分钟',  
        '1'=>'秒'  
    );  
    foreach ($f as $k=>$v)    {  
        if (0 !=$c=floor($t/(int)$k)) {  
            return $c.$v.'前';  
        }  
    }  
}  



