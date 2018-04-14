<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:41:"./application/admin/view/system\smtp.html";i:1499575362;s:43:"./application/admin/view/public\layout.html";i:1499577477;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/main.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/page.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/perfect-scrollbar.min.css">
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/layer/layer.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/admin.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/flexigrid.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/myFormValidate.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/myAjax2.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/global.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
//   						layer.closeAll();
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }   
    
    function get_help(obj){
        layer.open({
            type: 2,
            title: '帮助手册',
            shadeClose: true,
            shade: 0.3,
            area: ['70%', '80%'],
            content: $(obj).attr('data-url'), 
        });
    }
    
    function delAll(obj,name){
    	var a = [];
    	$('input[name*='+name+']').each(function(i,o){
    		if($(o).is(':checked')){
    			a.push($(o).val());
    		}
    	})
    	if(a.length == 0){
    		layer.alert('请选择删除项', {icon: 2});
    		return;
    	}
    	layer.confirm('确认删除？', {btn: ['确定','取消'] }, function(){
    			$.ajax({
    				type : 'get',
    				url : $(obj).attr('data-url'),
    				data : {act:'del',del_id:a},
    				dataType : 'json',
    				success : function(data){
    					if(data == 1){
    						layer.msg('操作成功', {icon: 1});
    						$('input[name*='+name+']').each(function(i,o){
    							if($(o).is(':checked')){
    								$(o).parent().parent().remove();
    							}
    						})
    					}else{
    						layer.msg(data, {icon: 2,time: 2000});
    					}
    					layer.closeAll();
    				}
    			})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);	
    }
</script>  

</head>
<body style="background-color: #FFF; overflow: auto;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>商城设置</h3>
                <h5>网站全局内容基本选项设置</h5>
            </div>
            <ul class="tab-base nc-row">
                <li><a href="<?php echo U('System/index'); ?>"><span>商城信息</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'basic')); ?>"><span>基本设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'shopping')); ?>"><span>购物流程</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'sms')); ?>"><span>短信设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'smtp')); ?>" class="current"><span>邮件设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'water')); ?>"><span>水印设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'distribut')); ?>" ><span>分销设置</span></a></li>
                <!--<li><a href="<?php echo U('System/index',array('inc_type'=>'wap')); ?>"><span>WAP设置</span></a></li>-->
                <!--<li><a href="<?php echo U('System/index',array('inc_type'=>'extend')); ?>"><span>扩展设置</span></a></li>-->
            </ul>
        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span></div>
        <ul>
            <li>系统平台全局设置,包括基础设置、购物、短信、邮件、水印和分销等相关模块。</li>
        </ul>
    </div>
    <form method="post" id="handlepost" action="<?php echo U('System/handle'); ?>">
        <input type="hidden" name="inc_type" value="<?php echo $inc_type; ?>">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="smtp_server">邮件发送服务器(SMTP)</label>
                </dt>
                <dd class="opt">
                    <input id="smtp_server" name="smtp_server" value="<?php echo $config['smtp_server']; ?>" class="input-txt" type="text"/>
                    <p class="notic">发送邮箱的smtp地址。如: smtp.gmail.com或smtp.qq.com</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="smtp_port">服务器(SMTP)端口</label>
                </dt>
                <dd class="opt">
                    <input id="smtp_port" name="smtp_port" value="<?php echo (isset($config['smtp_port']) && ($config['smtp_port'] !== '')?$config['smtp_port']:25); ?>" class="input-txt" type="text"/>
                    <p class="notic">smtp的端口。默认为25。具体请参看各STMP服务商的设置说明 （如果使用Gmail，请将端口设为465）</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="smtp_user">邮箱账号</label>
                </dt>
                <dd class="opt">
                    <input id="smtp_user" name="smtp_user" value="<?php echo $config['smtp_user']; ?>" class="input-txt" type="text"/>
                    <p class="notic">使用发送邮件的邮箱账号</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="smtp_pwd">邮箱密码/授权码</label>
                </dt>
                <dd class="opt">
                    <input id="smtp_pwd"  name="smtp_pwd" value="<?php echo $config['smtp_pwd']; ?>" class="input-txt" type="text"/>
                    <p class="notic">使用发送邮件的邮箱密码,或者授权码。具体请参看各STMP服务商的设置说明</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">注册启用邮箱</dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="regis_smtp_enable1" class="cb-enable <?php if($config[regis_smtp_enable] == 1): ?>selected<?php endif; ?>">开启</label>
                        <label for="regis_smtp_enable0" class="cb-disable <?php if($config[regis_smtp_enable] == 0): ?>selected<?php endif; ?>">关闭</label>
                        <input id="regis_smtp_enable1" name="regis_smtp_enable" <?php if($config['regis_smtp_enable'] == 1): ?>checked="checked"<?php endif; ?> value="1" type="radio">
                        <input id="regis_smtp_enable0" name="regis_smtp_enable" <?php if($config['regis_smtp_enable'] == 0): ?>checked="checked"<?php endif; ?> value="0" type="radio">
                    </div>
                    <p class="notic">用户注册时使用邮箱验证</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">测试接收的邮件地址</dt>
                <dd class="opt">
                    <input value="<?php echo $config['test_eamil']; ?>" name="test_eamil" id="test_eamil" class="input-txt" type="text">
                    <input value="测试" class="input-btn" onclick="sendEmail()" type="button">
                    <p class="notic">首次请先保存配置再测试</p>
                </dd>
            </dl>
            <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="adsubmit();">确认提交</a></div>
        </div>
    </form>
</div>
<div id="goTop"><a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
<script>
    var flag = true;
    function adsubmit(){
        check_form();
        if(flag){
            $('#handlepost').submit();
        }
    }

    function check_form(){
        if($('input[name="smtp_server"]').val() == ''){
            alert('请填写邮件发送服务器地址');
            flag = false;
            return;
        }
        if($('input[name="smtp_user"]').val() == '' || !checkEmail($('input[name="smtp_user"]').val())){
            alert('请填写正确的邮箱账号');
            flag = false;
            return;
        }
        if($('input[name="smtp_pwd"]').val() == ''){
            alert('请填写发送邮箱密码');
            flag = false;
            return;
        }
    }
    function sendEmail() {
        var email = $('#test_eamil').val();
        if (email == '') {
            alert('请填写正确的测试邮箱账号');
            return;
        } else {
            $.ajax({
                type: "post",
                data: $('#handlepost').serialize(),
                dataType: 'json',
                url: "<?php echo U('System/send_email'); ?>",
                success: function (res) {
                    if (res == 1) {
                        layer.msg('发送成功', {icon: 1});
                    } else {
                        layer.msg('发送失败', {icon: 2, time: 2000});
                    }
                }
            })
        }
    }
</script>
</body>
</html>