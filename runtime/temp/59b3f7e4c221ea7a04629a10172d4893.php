<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"./application/admin/view/life\houseRentDet.html";i:1501148490;s:43:"./application/admin/view/public\layout.html";i:1499577477;}*/ ?>
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
<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="javascript:history.back();" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>房屋出租审核</h3>
        <h5>出租房屋信息审核与管理</h5>
      </div>
    </div>
  </div>
	<form action="<?php echo U('Life/houseHandel',array('act'=>'check')); ?>" method="post" class="form-horizontal">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">标题</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="title" value="<?php echo $list['title']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">详细描述</label>
        </dt>
        <dd class="opt">
          <textarea style="height:120px; width:280px;" name="content" disabled="disabled"><?php echo $list['content']; ?></textarea>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">区域</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="area" value="<?php echo $list['area']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">户型</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="house_type" value="<?php echo $list['house_type']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">出租方式</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="rent_way" value="<?php echo $list['rent_way']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">空出时间</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="empty_time" value="<?php echo $list['empty_time']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">房屋来源</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="house_source" value="<?php echo $list['house_source']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">出租价格</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="price" value="<?php echo $list['title']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">联系人名字</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="contact_name" value="<?php echo $list['contact_name']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">联系人电话</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="contact_phone" value="<?php echo $list['contact_phone']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">微信</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="weixin" value="<?php echo $list['weixin']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">QQ</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="qq" value="<?php echo $list['qq']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">邮箱</label>
        </dt>
        <dd class="opt">
          <input type="email" class="input-txt" name="email" value="<?php echo $list['email']; ?>" disabled="disabled">
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="ac_name">标签</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="label" value="<?php echo $list['label']; ?>" disabled="disabled">
        </dd>
      </dl>
      <div class="bot">
        <h3>审核：</h3>　　　
          <input type="radio" name="status" value="1"  <?php if($list[status] == 1): ?> checked <?php endif; ?> > 通 过  　
          <input type="radio" name="status" value="2" <?php if($list[status] == -1): ?> checked <?php endif; ?> > 不 通 过
      </div>
      <div class="bot"><a href="JavaScript:void(0);" onClick="$('.form-horizontal').submit();" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
    </div>
        <input type="hidden" name="id" value="<?php echo $list['id']; ?>">    
  </form>
</div>
<script>

</script>
</body>
</html>