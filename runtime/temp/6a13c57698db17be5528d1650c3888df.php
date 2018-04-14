<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:50:"./application/admin/view/public/dispatch_jump.html";i:1501312810;}*/ ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>小蚂蚁 | 后台登陆</title>
    <!-- 告诉浏览器响应屏幕宽度 -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="__PUBLIC__/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="__PUBLIC__/static/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="__PUBLIC__/static/css/blue.css" rel="stylesheet" type="text/css" />
    <style>#imgVerify{width: 120px;margin: 0 auto; text-align: center;display: block;}	</style>
  </head>
  <body class="login-page">
    <div class="login-box ma_t_cm">
    
<?php if($code == 1) {?>    
      <!--处理成功-->
      <div class="login-box-body">
        <h4 class="login-box-msg ver_cm"><span class="glyphicon glyphicon-ok ver_cm"></span> <?php echo(strip_tags($msg)); ?></h4>
          <div style="text-align: center">页面自动 <a id="href" href="<?php echo($url); ?>">　跳转</a> 　等待时间： <b id="wait"><?php echo($wait); ?></b><br /><br /></div>
          <p style="text-align: center"><a href="" target="">小蚂蚁管理员后台</a></p>
      </div>      
<?php }else{?>     
      <!--处理失败-->
       <div class="login-box-body">
        <h4 class="login-box-msg ver_cm"><span class="glyphicon glyphicon-remove ver_cm"></span> <?php echo(strip_tags($msg)); ?></h4>
        <div style="text-align: center">页面自动 <a id="href" href="<?php echo($url); ?>">　跳转</a> 　等待时间： <b id="wait"><?php echo($wait); ?></b><br /><br /></div>
          <p style="text-align: center"><a href="" target="">小蚂蚁管理员后台</a></p>
      </div>
<?php }?>      
	    <div class="margin text-center">
	        <div class="copyright">
	            2017-<?php echo date('Y'); ?> &copy; <a href="">小蚂蚁 v1.0.1</a>
	            <br/>
	            <a href="">北美小蚂蚁微传媒</a>出品
	        </div>
	    </div>
    </div><!-- /.login-box -->

<script type="text/javascript">

(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 750);
})();

</script>    
  </body>
</html>