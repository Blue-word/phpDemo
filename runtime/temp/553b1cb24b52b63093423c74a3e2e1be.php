<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:35:"./application/admin/view/ad\ad.html";i:1501656743;s:43:"./application/admin/view/public\layout.html";i:1499577477;}*/ ?>
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
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/static/ueditor/ueditor.parse.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/static/ueditor/ueditor.all.js"></script>

<script src="__PUBLIC__/static/js/layer1/laydate/laydate.js"></script>

<body style="background-color: #FFF; overflow: auto;">
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
                <div class="subject">
                    <h3>发布广告</h3>
                    <h5>APP广告栏目</h5>
                </div>
            <ul class="tab-base nc-row">
                <li><a href="javascript:void(0);" data-index='1' class="tab current"><span>广告主体</span></a></li>        
            </ul>
        </div> 
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span> </div>
        <ul>
            <li>广告形式分为：网站链接、图片、文章</li>
        </ul>
    </div>
    <form class="form-horizontal" action="<?php echo U('Ad/adHandle'); ?>" id="add_post" method="post">
    <!--通用信息-->
        <div class="ncap-form-default tab_div_1">
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">广告标题</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $ad['title']; ?>" name="title" class="input-txt"  placeholder="标题"/>
                    <span class="err" id="err_goods_name" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="cate">广告类别</label>
                </dt>
                <dd class="opt">
                    <input type="radio" name="cate" value="0"  <?php if($ad[cate] == 0): ?> checked <?php endif; ?> > 文 章  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="cate" value="1" <?php if($ad[cate] == 1): ?> checked <?php endif; ?> > 链 接  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="cate" value="2" <?php if($ad[cate] == 2): ?> checked <?php endif; ?> > 图 片
                </dd>
            </dl>
            <dl class="row" data-name="news">
                <dt class="tit">
                  <label>是否显示</label>
                </dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="article_show1" class="cb-enable <?php if($ad[status] == 1): ?>selected<?php endif; ?>">是</label>
                        <label for="article_show0" class="cb-disable <?php if($ad[status] == 0): ?>selected<?php endif; ?>">否</label>
                        <input id="article_show1" name="status" value="1" type="radio" <?php if($ad[status] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="article_show0" name="status" value="0" type="radio" <?php if($ad[status] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                    <p class="notic"></p>
                </dd>
            </dl>
             <dl class="row">
                <dt class="tit">
                    <label for="record_no">广告位置</label>
                </dt>
                <dd class="opt">
                    <select class="small form-control"  style="width:200px"  tabindex="1" name="topic_id">
                        <option value="">添加显示位置</option>
                        <?php if(is_array($position) || $position instanceof \think\Collection || $position instanceof \think\Paginator): $i = 0; $__LIST__ = $position;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                          <option value="<?php echo $vo['id']; ?>" <?php if($info['position'] == $vo['id']): ?>selected<?php endif; ?>><?php echo $vo['position']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>                               
                    </select>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                  <label for="articleForm">开始日期：</label>
                </dt>
                <dd class="opt">
                    <input type="text" class="input-txt" id="begin_time" name="begin_time"  value="<?php echo (isset($info['begin_time']) && ($info['begin_time'] !== '')?$info['begin_time']:"2016-01-01"); ?>"/> 
                  <span class="err"></span>
                </dd>
            </dl>    
            <dl class="row">
                <dt class="tit">
                  <label for="articleForm">结束时间：：</label>
                </dt>
                <dd class="opt">
                    <input type="text" class="input-txt" id="end_time" name="end_time"  value="<?php echo (isset($info['end_time']) && ($info['end_time'] !== '')?$info['end_time']:"2019-01-01"); ?>"/>
                  <span class="err"></span>
                </dd>
            </dl> 
            <dl class="row">
                <dt class="tit">
                  <label for="ac_sort">默认排序：</label>
                </dt>
                <dd class="opt">
                  <input type="text" placeholder="排序" name="sort" value="<?php echo $info['orderby']; ?>" class="input-txt">
                  <span class="err"></span>
                  <p class="notic"></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">广告详情</label>
                </dt>
                <dd class="opt">
                    <script id="container" name="content" type="text/plain"></script>                 
                </dd>
            </dl>                
        </div>
        <div class="ncap-form-default">        
            <div class="bot">    
              <input type="hidden" name="act" value="<?php echo $act; ?>">
                <?php if($act != detail): ?>
                    <div class="bot"><a href="JavaScript:void(0);" onClick="checkForm()" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a>
              </div>
                <?php endif; ?>
          
            </div>
        </div>
    </form>
</div>
<div style="display: none;" id="news_content">
    <?php echo $info['content']; ?>
</div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/static/ueditor/ueditor.parse.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/static/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    uParse('.content', {
        rootPath: '../'
    });
    ue.ready(function() {
        var html = $('#news_content').html();
        console.log(html);
        ue.setContent(html);
    });
    // ue.ready(function(){
    //     ue.setContent("1sss");    
    // });
</script>
<script>
    $(document).ready(function(){
        $('#begin_time').layDate();
        $('#end_time').layDate();
    });

    
</script>
</body>

</html>