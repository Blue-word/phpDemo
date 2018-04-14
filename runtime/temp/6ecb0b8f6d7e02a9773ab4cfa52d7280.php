<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:43:"./application/admin/view/news/category.html";i:1499574098;s:43:"./application/admin/view/public/layout.html";i:1499577478;}*/ ?>
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
        <h3>新闻分类</h3>
        <h5>网站新闻分类添加与管理</h5>
      </div>
    </div>
  </div>
	<form action="<?php echo U('News/categoryHandle'); ?>" method="post" class="form-horizontal">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="ac_name"><em>*</em>分类名称</label>
        </dt>
        <dd class="opt">
          <input type="text" placeholder="名称" class="input-txt" name="name" value="<?php echo $cate['name']; ?>">           
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="parent_id">上级分类</label>
        </dt>
        <dd class="opt">
            <select class="small form-control"  style="width:140px"  tabindex="1" name="pid">
                <option value="0">顶级分类</option>
                <?php if(is_array($cate_list) || $cate_list instanceof \think\Collection || $cate_list instanceof \think\Paginator): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $vo['id']; ?>" <?php if($cate['pid'] == $vo['id']): ?>selected<?php endif; ?>><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>                               
            </select>        
          <span class="err"></span>
          <p class="notic">如果选择上级分类，那么新增的分类则为被选择上级分类的子分类</p>
        </dd>
      </dl>		       
      <dl class="row">
        <dt class="tit">
          <label for="ac_sort">排序</label>
        </dt>
        <dd class="opt">
          <input type="text" placeholder="排序" name="sort" value="<?php echo $cate['sort']; ?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
	    <dl class="row">
        <dt class="tit">
          <label for="ac_sort">分类描述</label>
        </dt>
        <dd class="opt">
          <textarea placeholder="分类描述" style="height:120px; width:280px;" name="description"><?php echo $cate['description']; ?></textarea> 
          <span class="err"></span>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <?php if($act != detail): ?>
        <div class="bot"><a href="JavaScript:void(0);" onClick="$('.form-horizontal').submit();" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
      <?php endif; ?>
    </div>
            <input type="hidden" name="act" value="<?php echo $act; ?>">
            <input type="hidden" name="id" value="<?php echo $cate['id']; ?>">    
  </form>
</div>
<script>

    <!-- 系统保留分类 start-->
    var article_top_system_id = <?php echo json_encode($article_top_system_id); ?>;
    $("#parent_id").change(function(){
        var v = parseInt($(this).val());
        if(jQuery.inArray(v, article_top_system_id) != -1){
            alert("系统保留分类，不允许在该分类添加新分类");
            $(this).val(0);
        }

    });
    <!-- 系统保留分类 end -->

</script>
</body>
</html>