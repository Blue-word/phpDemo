<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"./application/admin/view/news/topic.html";i:1499831804;s:43:"./application/admin/view/public/layout.html";i:1499577478;}*/ ?>
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
        <h3>专题新闻添加</h3>
        <h5>专题新闻添加与管理</h5>
      </div>
    </div>
  </div>
    <form action="<?php echo U('News/topic'); ?>" method="post" class="form-horizontal">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="ac_name"><em>*</em>专题标题</label>
        </dt>
        <dd class="opt">
          <input type="text" placeholder="标题" class="input-txt" name="title" value="<?php echo $topic['title']; ?>">           
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <!-- <dl class="row">
        <dt class="tit">
          <label for="parent_id">添加新闻</label>
        </dt>
        <dd class="opt">
            <select class="small form-control"  style="width:200px"  tabindex="1" name="pid">
                <option value="0">新闻ID</option>
                <?php if(is_array($cate_list) || $cate_list instanceof \think\Collection || $cate_list instanceof \think\Paginator): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $vo['id']; ?>" <?php if($cate['pid'] == $vo['id']): ?>selected<?php endif; ?>><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>                               
            </select>        
          <span class="err"></span>
          <p class="notic">将新闻添加进专题新闻里</p>
        </dd>
      </dl> -->         
      <dl class="row">
        <dt class="tit">
          <label>是否显示</label>
        </dt>
        <dd class="opt">
            <div class="onoff">
              <label for="article_show1" class="cb-enable <?php if($news[is_topic] == 1): ?>selected<?php endif; ?>">是</label>
              <label for="article_show0" class="cb-disable <?php if($news[is_topic] == 0): ?>selected<?php endif; ?>">否</label>
              <input id="article_show1" name="status" value="1" type="radio" <?php if($news[is_topic] == 1): ?> checked="checked"<?php endif; ?>>
              <input id="article_show0" name="status" value="0" type="radio" <?php if($news[is_topic] == 0): ?> checked="checked"<?php endif; ?>>
            </div>
            <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
          <dt class="tit">
              <label for="store_logo">专题封面</label>
          </dt>
          <dd class="opt">
              <div class="input-file-show">
                  <span class="show">
                      <a id="img_a" class="nyroModal" rel="gal" href="<?php echo $config['picture']; ?>">
                          <i id="img_i" class="fa fa-picture-o" onmouseover="layer.tips('<img src=<?php echo $config['picture']; ?>>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></i>
                      </a>
                      <!-- <input type="text" name="" value="<?php echo $config[picture]; ?>" /> -->
                  </span>
                  <span class="type-file-box">
                      <input type="text" id="picture" name="picture" value="<?php echo $config['picture']; ?>" class="type-file-text">
                      <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button">
                      <input class="type-file-file" onClick="GetUploadify(1,'1','topic_picture','img_call_back')" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
                  </span>
              </div>
              <span class="err"></span>
              <p class="notic">专题封面显示，最佳显示尺寸为240*60像素</p>
          </dd>
        </dl>
      <?php if($act != detail): ?>
        <div class="bot"><a href="JavaScript:void(0);" onClick="$('.form-horizontal').submit();" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
      <?php endif; ?>
    </div>
            <input type="hidden" name="act" value="<?php echo $act; ?>">
            <input type="hidden" name="topic_id" value="<?php echo $cate['id']; ?>">    
  </form>
</div>
<script type="text/javascript">
function img_call_back(fileurl_tmp)
    {
        var fileurl_tmp;
        var fileurl_tmp = "<?php echo $web_path; ?>" + fileurl_tmp;


        $("#picture").val(fileurl_tmp);
        $("#img_a").attr('href', fileurl_tmp);
        $("#img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }
</script>
</body>
</html>