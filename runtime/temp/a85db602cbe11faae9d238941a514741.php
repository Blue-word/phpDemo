<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"./application/admin/view/system\distribut.html";i:1499575377;s:43:"./application/admin/view/public\layout.html";i:1499577477;}*/ ?>
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
                <li><a href="<?php echo U('System/index',array('inc_type'=>'basic')); ?>" ><span>基本设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'shopping')); ?>"><span>购物流程</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'sms')); ?>" ><span>短信设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'smtp')); ?>" ><span>邮件设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'water')); ?>" ><span>水印设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'distribut')); ?>" class="current"><span>分销设置</span></a></li>
                <!--<li><a href="<?php echo U('System/index',array('inc_type'=>'wap')); ?>" ><span>WAP设置</span></a></li>-->
                <!--<li><a href="<?php echo U('System/index',array('inc_type'=>'extend')); ?>" ><span>扩展设置</span></a></li>-->
            </ul>
        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span> </div>
        <ul>
            <li>系统平台全局设置,包括基础设置、购物、短信、邮件、水印和分销等相关模块。</li>
        </ul>
    </div>
    <form method="post" enctype="multipart/form-data" id="handlepost" action="<?php echo U('System/handle'); ?>">
        <input type="hidden" name="form_submit" value="ok" />
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">分销开关</dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="switch1" class="cb-enable  <?php if($config['switch'] == 1): ?>selected<?php endif; ?>">开启</label>
                        <label for="switch0" class="cb-disable <?php if($config['switch'] == 0): ?>selected<?php endif; ?>">关闭</label>
                        <input type="radio" id="switch1"  name="switch" value="1" <?php if($config['switch'] == 1): ?>checked="checked"<?php endif; ?>>
                        <input type="radio" id="switch0" name="switch" value="0" <?php if($config['switch'] == 0): ?>checked="checked"<?php endif; ?> >
                    </div>
                    <p class="notic">分销开关</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>成为分销商条件</label>
                </dt>
                <dd class="opt">
                    <input type="radio" name="condition" value="0" <?php if($config[condition] == 0): ?>checked="checked"<?php endif; ?>>直接成为分销商:  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="condition" value="1" <?php if($config[condition] == 1): ?>checked="checked"<?php endif; ?>>成功购买商品后成为分销商:  &nbsp;&nbsp;&nbsp;&nbsp;
                    <p class="notic">分销商条件</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>分销名称</label>
                </dt>
                <dd class="opt">
                    <input name="name" value="<?php echo $config['name']; ?>" class="input-txt" type="text">
                    <p class="notic">分销名称</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="distribut_date">分销模式</label>
                </dt>
                <dd class="opt">
                    <select name="pattern" id="distribut_pattern">
                        <option value="0" <?php if($config['pattern'] == 0): ?>selected="selected"<?php endif; ?>>按商品设置的分成金额</option>
                        <option value="1" <?php if($config['pattern'] == 1): ?>selected="selected"<?php endif; ?>>按订单设置的分成比例</option>
                    </select>
                    <p class="notic">分销模式</p>
                </dd>
            </dl>
            <dl class="row" <?php if($config['pattern'] == 0): ?>style="display:none"<?php endif; ?>>
                <dt class="tit">
                    <label>订单默认分成比例</label>
                </dt>
                <dd class="opt">
                    <input name="order_rate" value="<?php echo $config['order_rate']; ?>" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-txt" type="text">
                    <p class="notic">订单默认分成比例</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>一级分销商名称</label>
                </dt>
                <dd class="opt">
                    <input name="first_name" value="<?php echo $config['first_name']; ?>" class="input-txt" type="text">
                    <p class="notic">一级分销商名称</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>一级分销商比例</label>
                </dt>
                <dd class="opt">
                    <input name="first_rate" id="distribut_first_rate" value="<?php echo $config['first_rate']; ?>"onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-txt" type="text">
                    <p class="notic">单位：%</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>二级分销商名称</label>
                </dt>
                <dd class="opt">
                    <input name="second_name" value="<?php echo $config['second_name']; ?>" class="input-txt" type="text">
                    <p class="notic">二级分销商名称</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>二级分销商比例</label>
                </dt>
                <dd class="opt">
                    <input name="second_rate" id="distribut_second_rate" value="<?php echo $config['second_rate']; ?>"onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-txt" type="text">
                    <p class="notic">单位：%</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>三级分销商名称</label>
                </dt>
                <dd class="opt">
                    <input name="third_name" value="<?php echo $config['third_name']; ?>" class="input-txt" type="text">
                    <p class="notic">三级分销商名称</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>三级分销商比例</label>
                </dt>
                <dd class="opt">
                    <input name="third_rate" id="distribut_third_rate" value="<?php echo $config['third_rate']; ?>"onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-txt" type="text">
                    <p class="notic">单位：%</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="distribut_date">分成时间</label>
                </dt>
                <dd class="opt">
                    <select name="date" id="distribut_date">
                        <?php $__FOR_START_22599__=1;$__FOR_END_22599__=31;for($i=$__FOR_START_22599__;$i < $__FOR_END_22599__;$i+=1){ ?>
                            <option value="<?php echo $i; ?>" <?php if($config[date] == $i): ?>selected="selected"<?php endif; ?>><?php echo $i; ?>天</option>
                        <?php } ?>
                    </select>
                    <p class="notic">订单收货确认后多少天可以分成</p>
                </dd>
            </dl>
            <div class="bot">
                <input type="hidden" name="inc_type" value="<?php echo $inc_type; ?>">
                <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="adsubmit()">确认提交</a>
            </div>
        </div>
    </form>
</div>
<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
<script>
    $('#distribut_pattern').change(function(){
        if($(this).val() == 1)
            $('#distribut_order_rate').show();
        else
            $('#distribut_order_rate').hide();
    });

    function adsubmit(){
        var distribut_first_rate  = $.trim($('#distribut_first_rate').val());
        var distribut_second_rate = $.trim($('#distribut_second_rate').val());
        var distribut_third_rate  = $.trim($('#distribut_third_rate').val());

        var rate = parseInt(distribut_first_rate) + parseInt(distribut_second_rate) + parseInt(distribut_third_rate);
        if(rate > 100)
        {
            layer.msg('三个分销商比例总和不得超过100%', {icon: 2,time: 2000});//alert('少年，邮箱不能为空！');
            // alert('三个分销商比例总和不得超过100%');
            return false;
        }

        $('#handlepost').submit();
    }
</script>
</body>
</html>