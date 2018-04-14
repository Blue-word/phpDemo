<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"./application/admin/view/news/newsAdd.html";i:1502337328;s:43:"./application/admin/view/public/layout.html";i:1499577478;}*/ ?>
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

<body style="background-color: #FFF; overflow: auto;">
<div class="page">
    <div class="fixed-bar">
        <div class="item-title"><a class="back" href="<?php echo U('News/newsList'); ?>" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
          <div class="subject">
                <h3>发布新闻</h3>
                <h5>APP新闻浏览</h5>
          </div>
            <ul class="tab-base nc-row">
                <li><a href="javascript:void(0);" data-index='1' class="tab current"><span>新闻主体</span></a></li>
                <li><a href="javascript:void(0);" data-index='2' class="tab"><span>新闻相册</span></a></li><!-- 
                <li><a href="javascript:void(0);" data-index='3' class="tab"><span>新闻模型</span></a></li>
                <li><a href="javascript:void(0);" data-index='4' class="tab"><span>新闻类型</span></a></li>  -->               
            </ul>
        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span> </div>
        <ul>
            <li>若是转载文章请务必声明</li>
        </ul>
    </div>
    <form class="form-horizontal" action="<?php echo U('News/newsHandle'); ?>" id="add_post" method="post">
    <!--通用信息-->
        <div class="ncap-form-default tab_div_1">
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">新闻标题</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $news['title']; ?>" name="title" class="input-txt"/>
                    <span class="err" id="err_goods_name" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="statement">搜索词所属类别</label>
                </dt>
                <dd class="opt">
                    <input type="radio" name="statement" value="0"  <?php if($news[statement] == 0): ?> checked <?php endif; ?> > 原 创  &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="statement" value="1" <?php if($news[statement] == 1): ?> checked <?php endif; ?> > 转 载
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">新闻类别</label>
                </dt>
                <dd class="opt">
                    <select class="small form-control"  style="width:200px"  tabindex="1" name="cate">
                        <option value="">所属类别选择</option>
                        <?php echo $cat_select; ?>                              
                    </select>
                </dd>
            </dl>
            <dl class="row" data-name="news">
                <dt class="tit">
                  <label>专题新闻</label>
                </dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="article_show1" class="cb-enable <?php if($news[is_topic] == 1): ?>selected<?php endif; ?>">是</label>
                        <label for="article_show0" class="cb-disable <?php if($news[is_topic] == 0): ?>selected<?php endif; ?>">否</label>
                        <input id="article_show1" name="is_topic" value="1" type="radio" <?php if($news[is_topic] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="article_show0" name="is_topic" value="0" type="radio" <?php if($news[is_topic] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl class="row" data-name="news_title" style="display: none;">
                <dt class="tit">
                    <label for="record_no">专题新闻标题</label>
                </dt>
                <dd class="opt">
                    <select class="small form-control"  style="width:200px"  tabindex="1" name="topic_id">
                        <option value="0">所属专题选择</option>
                        <?php if(is_array($news_topic) || $news_topic instanceof \think\Collection || $news_topic instanceof \think\Paginator): $i = 0; $__LIST__ = $news_topic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                          <option value="<?php echo $vo['topic_id']; ?>" <?php if($news['topic_id'] == $vo['topic_id']): ?>selected<?php endif; ?>><?php echo $vo['title']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>                               
                    </select>
                </dd>
            </dl>
            <?php if($news['url'] != null): ?>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">新闻链接</label>
                </dt>
                <dd class="opt">
                    <input type="hidden" name="url" value="<?php echo $news['url']; ?>">
                    <a href="<?php echo $news['url']; ?>" class="ncap-btn-big ncap-btn-blue" target="_blank"><?php echo $news['url']; ?></a>
                    <!-- <input type="text" value="<?php echo $news['url']; ?>" name="url" class="input-txt"/> -->
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">新闻展示效果</label>
                </dt>
                <dd class="opt">
                    <input type="hidden" name="url" value="<?php echo $news['url']; ?>">
                    <a href="http://localhost/jraz/index.php/admin/news/test/id/<?php echo $id; ?>" class="ncap-btn-big ncap-btn-blue" target="_blank">点击此处进入效果查看界面</a>
                    <p class="notic">将屏幕缩小查看效果，屏幕最小尺寸问</p>
                </dd>
            </dl>
            <?php endif; ?>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">新闻详情描述</label>
                </dt>
                <dd class="opt">
                    <script id="container" name="content" type="text/plain"></script>
                    <!-- <textarea id="container" name="content" type="text/plain"><?php echo $news['content']; ?></textarea> -->                
                </dd>
            </dl>                
        </div>
        <div class="ncap-form-default">
            <?php if($act != detail): ?>
                <div class="bot">
                    <h1>审核：</h1>　　　
                      <input type="radio" name="status" value="1"  <?php if($news[status] == 1): ?> checked <?php endif; ?> > 通 过  　
                      <input type="radio" name="status" value="-1" <?php if($news[status] == -1): ?> checked <?php endif; ?> > 不 通 过
                </div>        
                <div class="bot">    
                	<input type="hidden" name="act" value="<?php echo $act; ?>">
            		<input type="hidden" name="id" value="<?php echo $news['id']; ?>">
                    <div class="bot"><a href="JavaScript:void(0);" onClick="checkForm()" class="ncap-btn-big ncap-btn-green" id="submitBtn">审核提交</a>
        			</div>
                </div>
            <?php endif; ?>
        </div>
    </form>
</div>
<div style="display: none;" id="news_content">
    <?php echo $news['content']; ?>
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
        //console.log(html);
        ue.setContent(html);
    });
    // ue.ready(function(){
    //     ue.setContent("1sss");    
    // });
</script>
<script>
    $(document).ready(function(){
        //插件切换列表
        $('.tab-base').find('.tab').click(function(){
            $('.tab-base').find('.tab').each(function(){
                $(this).removeClass('current');
            });
            $(this).addClass('current');
            var tab_index = $(this).data('index');          
            $(".tab_div_1, .tab_div_2, .tab_div_3, .tab_div_4").hide();         
            $(".tab_div_"+tab_index).show();
        });

        //
        $("dl[data-name='news']").on("click", function() {
            var selected = $(this).find("label.cb-enable.selected").text();
            if(selected === "是") {
                $("dl[data-name='news_title']").show();
            } else {
                $("dl[data-name='news_title']").hide();
            }
        });    
    });
    function checkForm(){
		if($('input[name="title"]').val() == ''){
			alert("请填写新闻标题！");
			return false;
		}
		if($('input[name="original_statement"]').val() == ''){
			alert("请填写原创声明！");
			return false;
		}
		if($('input[name="status"]').val() == ''){
			alert("请填写转载声明！");
			return false;
		}
		if($('#is_topic').val() == ''){
			alert("请选择专题类别！");
			return false;
		}
		// if($('#container').val() == ''){
		// 	alert("请填写文章内容！");
		// 	return false;
		// }
		$('#add_post').submit();
	}

    
</script>
</body>

</html>