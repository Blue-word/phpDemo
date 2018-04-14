<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:45:"./application/admin/view/system\shopping.html";i:1499575337;s:43:"./application/admin/view/public\layout.html";i:1499577477;}*/ ?>
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
                <li><a href="<?php echo U('System/index',array('inc_type'=>'shopping')); ?>" class="current"><span>购物流程</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'sms')); ?>" ><span>短信设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'smtp')); ?>" ><span>邮件设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'water')); ?>" ><span>水印设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'distribut')); ?>" ><span>分销设置</span></a></li>
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
    <form method="post" enctype="multipart/form-data" name="form1" action="<?php echo U('System/handle'); ?>">
        <input type="hidden" name="form_submit" value="ok" />
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label>全场满多少免运费</label>
                </dt>
                <dd class="opt">
                    <input pattern="^\d{1,}$" name="freight_free" value="<?php echo (isset($config['freight_free']) && ($config['freight_free'] !== '')?$config['freight_free']:'0'); ?>" class="input-txt" type="text">
                    <p class="notic">(0表示不免运费)</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="point_rate">积分换算比例</label>
                </dt>
                <dd class="opt">
                    <input type="radio" id="point_rate" name="point_rate" value="1"  <?php if($config[point_rate] == 1): ?> checked <?php endif; ?> >1元 = 1积分  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="point_rate" value="10" <?php if($config[point_rate] == 10): ?> checked <?php endif; ?> >1元 = 10积分  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="point_rate" value="100"<?php if($config[point_rate] == 100): ?> checked <?php endif; ?> >1元 = 100积分
                    <p class="notic">积分换算比例</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>最低使用限制</label>
                </dt>
                <dd class="opt">
                    <input name="point_min_limit" value="<?php echo (isset($config['point_min_limit']) && ($config['point_min_limit'] !== '')?$config['point_min_limit']:'0'); ?>" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d]/g,'')" type="text">
                    <p class="notic">0表示不限制, 大于0时, 用户积分小于该值将不能使用积分</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>使用比例</label>
                </dt>
                <dd class="opt">
                    <input name="point_use_percent" value="<?php echo (isset($config['point_use_percent']) && ($config['point_use_percent'] !== '')?$config['point_use_percent']:'0'); ?>" onpaste="this.value=this.value.replace(/[^\-?\d.]/g,'')" onKeyUp="this.value=this.value.replace(/[^\-?\d.]/g,'')"  onblur="checkInputNum(this.name,0,100);"  class="input-txt" type="text">
                    <p class="notic">100时不限制, 为0时不能使用积分, 50时积分抵扣金额不能超过该笔订单应付金额的50%</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="distribut_date">发货后多少天自动收货</label>
                </dt>
                <dd class="opt">
                    <select name="auto_confirm_date" id="distribut_date">
                        <?php $__FOR_START_10118__=1;$__FOR_END_10118__=31;for($i=$__FOR_START_10118__;$i < $__FOR_END_10118__;$i+=1){ ?>
                            <option value="<?php echo $i; ?>" <?php if($config[auto_confirm_date] == $i): ?>selected="selected"<?php endif; ?>><?php echo $i; ?>天</option>
                        <?php } ?>
                    </select>
                    <p class="notic">发货后多少天自动收货</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="point_rate">减库存的时机</label>
                </dt>
                <dd class="opt">
                    <input type="radio" name="reduce" value="1" <?php if($config[reduce] == 1): ?> checked <?php endif; ?>>订单支付时  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="reduce" value="2" <?php if($config[reduce] == 2): ?> checked <?php endif; ?>>发货时  &nbsp;&nbsp;&nbsp;&nbsp;
                    <p class="notic">减库存的时机</p>
                </dd>
            </dl>
            <div class="bot">
                <input type="hidden" name="inc_type" value="<?php echo $inc_type; ?>">
                <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()">确认提交</a>
            </div>
        </div>
    </form>
</div>
<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>