<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:45:"./application/admin/view/system/news_set.html";i:1499830188;s:43:"./application/admin/view/public/layout.html";i:1499577478;}*/ ?>
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
                <h3>基本设置</h3>
                <h5>网站全局内容基本选项设置</h5>
            </div>
            <ul class="tab-base nc-row">
                <li><a href="<?php echo U('System/index',array('inc_type'=>'news_set')); ?>" class="current"><span>新闻版块</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'basic')); ?>" ><span>基本设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'shopping')); ?>" ><span>购物流程</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'sms')); ?>" ><span>短信设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'smtp')); ?>" ><span>邮件设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'water')); ?>" ><span>水2印设置</span></a></li>
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
            <li>系统平台全局设置，包括基础设置、购物、短信、邮件、水印和分销等相关模块。</li>
        </ul>
    </div>
    <form method="post" id="handlepost" action="<?php echo U('System/handle'); ?>" enctype="multipart/form-data" name="form1">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">原创声明</label>
                </dt>
                <dd class="opt">
                    <textarea rows="3" cols="180" name="original_statement" class="input-txt" placeholder="对新闻权限声明为原创文章"><?php echo $config['original_statement']; ?></textarea>
                    <p class="notic">新闻上传需选择，是否为原创文章</p>                  
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="store_name">转载声明</label>
                </dt>
                <dd class="opt">
                    <textarea rows="3" cols="180" name="reproduit_statement" class="input-txt" placeholder="对新闻权限声明为转载文章"><?php echo $config['reproduit_statement']; ?></textarea>
                    <span id="err_goods_remark" class="err" style="color:#F00; display:none;"></span>
                    <p class="notic">新闻上传需选择，是否为转载文章</p>                  
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="hot_keywords_1">新闻搜索词</label>
                </dt>
                <dd class="opt">
                    <input id="hot_keywords_1" name="hot_keywords_1" value="<?php echo $config['hot_keywords_1']; ?>" class="input-txt" type="text">
                    <span class="err">如: 头条,财经,时尚</span>
                    <p class="notic">首页搜索界面显示的热门关键词，导航查询，以英文逗号隔开</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="hot_keywords_2">论坛搜索词</label>
                </dt>
                <dd class="opt">
                    <input id="hot_keywords_2" name="hot_keywords_2" value="<?php echo $config['hot_keywords_2']; ?>" class="input-txt" type="text">
                    <span class="err">如: 租房,交友,求职</span>
                    <p class="notic">首页搜索界面显示的热门关键词，导航查询，以英文逗号隔开</p>
                </dd>
            </dl>
            <!-- <dl class="row">
                <dt class="tit">
                    <label for="search_cate">搜索词所属类别</label>
                </dt>
                <dd class="opt">
                    <input type="radio" id="search_cate" name="search_cate" value="1"  <?php if($config[search_cate] == 1): ?> checked <?php endif; ?> > 新 闻  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="search_cate" value="10" <?php if($config[search_cate] == 10): ?> checked <?php endif; ?> > 论 坛  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="search_cate" value="100"<?php if($config[search_cate] == 100): ?> checked <?php endif; ?> > 我 的
                    <p class="notic">搜索版块分类</p>
                </dd>
            </dl> -->
            <div class="bot">
                <input type="hidden" name="inc_type" value="<?php echo $inc_type; ?>">
                <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()">确认提交</a>
            </div>
        </div>
    </form>
</div>
<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
<script type="text/javascript">
    function img_call_back(fileurl_tmp)
    {
        $("#store_logo").val(fileurl_tmp);
        $("#img_a").attr('href', fileurl_tmp);
        $("#img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }
</script>
</html>