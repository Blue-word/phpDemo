<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:41:"./application/admin/view/admin/login.html";i:1501815558;}*/ ?>
<!doctype html>
<meta name="renderer" content="webkit">
<meta http-equiv=”X-UA-Compatible” content=”IE=Edge,chrome=1″ >
<head>
<meta charset="utf-8">
<title>登录页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="shortcut icon" type="image/x-icon" href="__PUBLIC__/static/images/favicon.ico" media="screen"/>
<link href="__PUBLIC__/static/css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.SuperSlide.2.1.2.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.cookie.js"></script>
<script type="text/javascript">
//若cookie值不存在，则跳出iframe框架
// if(!$.cookie('tpshopActionParam') && $.cookie('admin_type') != 1){
// 	$.cookie('admin_type','1' , {expires: 1 ,path:'/'});
// 	//top.location.href = location.href;
// }
</script>
</head>

<body>
	<div class="login-layout">
    	<div class="logo"><img src="__PUBLIC__/static/images/loginImg.png"></div>
        <form action="<?php echo U('Admin/login'); ?>" id="add_post" method="post">
            <div class="login-form" style="position: relative">
                <div class="formContent">
                	<div class="title">管理中心</div>
                    <div class="formInfo">
                    	<div class="formText">
                        	<i class="icon icon-user"></i>
                            <input type="text" name="username" class="input-text" value="" placeholder="用户名" />
                        </div>
                        <div class="formText">
                        	<i class="icon icon-pwd"></i>
                            <input type="password" name="password" class="input-text" value="" placeholder="密  码" />
                        </div>
                        <div class="formText">
                           <span class="span">保存信息</span>
                            <a href="<?php echo U('Admin/forget_pwd'); ?>" class="forget_pwd">忘记密码？</a>
                        </div>
                        <div class="formText submitDiv">        
                            <div class="submit_span">
                                <input type="submit" class="sub" value="登录">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="error" style="position: absolute;left:0px;bottom: 12px;text-align: center;width:1392px;">

                </div>
            </div>
        </form>
    </div>
    <!-- 背景图 -->
    <div id="bannerBox">  
        <ul id="slideBanner" class="slideBanner">
            <li><img src="__PUBLIC__/static/images/banner_1.jpg"></li>
            <li><img src="__PUBLIC__/static/images/banner_2.jpg"></li>
            <li><img src="__PUBLIC__/static/images/banner_3.jpg"></li>
            <li><img src="__PUBLIC__/static/images/banner_4.jpg"></li>
            <li><img src="__PUBLIC__/static/images/banner_5.jpg"></li>
            <li><img src="__PUBLIC__/static/images/banner_6.jpg"></li>
        </ul>
    </div>  
    <script type="text/javascript">
    	//登录背景图切换
    	$("#bannerBox").slide({mainCell:".slideBanner",effect:"fold",interTime:3500,delayTime:500,autoPlay:true,autoPage:true,endFun:function(i,c,s){
			$(window).resize(function(){
				var width = $(window).width();
				var height = $(window).height();
				s.find(".slideBanner,.slideBanner li").css({"width":width,"height":height});
			});
		}});
    </script>
</body>
</html>
