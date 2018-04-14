<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
//数据分页数
define('PAGES','5');
//网站根目录
define('WEB_PATH','/jraz');
//图片根目录
define('IMAGE_PATH','jraz/');
//图片服务器地址,包含端口
define('UPLOAD_URL','106.15.199.8');
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
//加载build.php文件
// $build = include './build.php';
// \think\Build::run($build);
// \think\Build::module('admin');
