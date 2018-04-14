<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"./application/admin/view/system\water.html";i:1499575363;s:43:"./application/admin/view/public\layout.html";i:1499577477;}*/ ?>
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
<style>
    .span_1 {
        float: left;
        margin-left: 0px;
        height: 130px;
        line-height: 130px;
    }

    .span_1 ul {
        list-style: none;
        padding: 0px;
    }

    .span_1 ul li {
        border: 1px solid #CCC;
        height: 40px;
        padding: 0px 10px;
        margin-left: -1px;
        margin-top: -1px;
        line-height: 40px;
    }
</style>
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
                <li><a href="<?php echo U('System/index',array('inc_type'=>'shopping')); ?>" ><span>购物流程</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'sms')); ?>" ><span>短信设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'smtp')); ?>" ><span>邮件设置</span></a></li>
                <li><a href="<?php echo U('System/index',array('inc_type'=>'water')); ?>" class="current"><span>水印设置</span></a></li>
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
    <form method="post" id="handlepost" action="<?php echo U('System/handle'); ?>">
        <input type="hidden" name="inc_type" value="<?php echo $inc_type; ?>">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">商品图片添加水印</dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="is_mark1" class="cb-enable <?php if($config[is_mark] == 1): ?>selected<?php endif; ?>" >开启</label>
                        <label for="is_mark0" class="cb-disable <?php if($config[is_mark] == 0): ?>selected<?php endif; ?>" >关闭</label>
                        <input id="is_mark1" name="is_mark" value="1" <?php if($config['is_mark'] == 1): ?>checked<?php endif; ?> type="radio">
                        <input id="is_mark0" name="is_mark" value="0" <?php if($config['is_mark'] == 0): ?>checked<?php endif; ?> type="radio">
                    </div>
                    <p class="notic">商品图片添加水印</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">水印类型<?php echo $config['mark_type']; ?></dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="mark_type1" class="cb-enable <?php if($config['mark_type'] == 'text'): ?>selected<?php endif; ?>" >文字</label>
                        <label for="mark_type0" class="cb-disable <?php if($config['mark_type'] == 'img'): ?>selected<?php endif; ?>" >图片</label>
                        <input id="mark_type1" onclick="setwarter('text')" name="mark_type" value="text" <?php if($config['mark_type'] == 'text'): ?>checked<?php endif; ?> type="radio">
                        <input id="mark_type0" onclick="setwarter('img')" name="mark_type"  value="img" <?php if($config['mark_type'] == 'img'): ?>checked<?php endif; ?> type="radio">
                    </div>
                    <p class="notic">水印类型</p>
                </dd>
            </dl>
            <dl class="row" id="texttr" style="display:none;">
                <dt class="tit">
                    <label for="mark_txt">水印文字</label>
                </dt>
                <dd class="opt">
                    <input name="mark_txt" id="mark_txt" value="<?php echo $config['mark_txt']; ?>" class="input-txt" type="text" />
                    <p class="notic">水印文字</p>
                </dd>
            </dl>
            <dl class="row" id="imgtr" >
                <dt class="tit">
                    <label for="mark_img">水印图片</label>
                </dt>
                <dd class="opt">
                    <div class="input-file-show">
                        <span class="show">
                            <a id="img_a" class="nyroModal" rel="gal" href="<?php echo $config['mark_img']; ?>">
                                <i id="img_i" class="fa fa-picture-o" onmouseover="layer.tips('<img src=<?php echo $config['mark_img']; ?>>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></i>
                            </a>
                        </span>
           	            <span class="type-file-box">
                            <input type="text"  name="mark_img" id="mark_img" value="<?php echo $config['mark_img']; ?>" class="type-file-text">
                            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button">
                            <input class="type-file-file" onClick="GetUploadify(1,'','Public','call_back');" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
                        </span>
                    </div>
                    <span class="err"></span>
                    <p class="notic">默认网站LOGO,通用头部显示，最佳显示尺寸为240*60像素</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">水印添加条件</dt>
                <dd class="opt">
                    <ul class="nofloat">
                        <li>
                            <input pattern="^\d{1,}$" value="<?php echo $config['mark_width']; ?>" name="mark_width" id="mark_width" checked="checked" type="text">
                            <span class="err">只能输入整数</span>
                            <label for="mark_width">图片宽度 单位像素(px)</label>
                        </li>
                        <li>
                            <input pattern="^\d{1,}$" value="<?php echo $config['mark_height']; ?>" name="mark_height" id="mark_height" checked="checked" type="text">
                            <label for="mark_height">图片高度 单位像素(px)</label>
                        </li>
                    </ul>
                    <p class="notic">水印的宽度和高度</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="mark_degree">水印透明度</label>
                </dt>
                <dd class="opt">
                    <input pattern="^\d{1,}$" onChange="$('#mark_degree2').empty().html(this.value);" name="mark_degree" id="mark_degree" value="<?php echo $config['mark_degree']; ?>" class="input-txt" type="range" min="0" step="2" max="100">
                    <span class="err" id="mark_degree2"><?php echo $config['mark_degree']; ?></span>
                    <p class="notic">0代表完全透明，100代表不透明</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="mark_degree">JPEG 水印质量</label>
                </dt>
                <dd class="opt">
                    <input pattern="^\d{1,}$" onChange="$('#mark_quality2').empty().html(this.value);" name="mark_quality" id="mark_quality" value="<?php echo $config['mark_quality']; ?>" class="input-txt" type="range" min="0" step="2" max="100">
                    <span class="err" id="mark_quality2"><?php echo $config['mark_quality']; ?></span>
                    <p class="notic">水印质量请设置为0-100之间的数字,决定 jpg 格式图片的质量</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="mark_degree">JPEG 水印质量</label>
                </dt>
                <dd class="opt">
                    <div style="height:124px; background:#fff">
                                                <span class="span_1">
                                                        <ul>
                                                            <li><input type="radio" name="sel" value="1"
                                                                <?php if($config['sel'] == '1'): ?>checked<?php endif; ?>
                                                                >&nbsp;顶部居左
                                                            </li>
                                                            <li><input type="radio" name="sel" value="2"
                                                                <?php if($config['sel'] == '2'): ?>checked<?php endif; ?>
                                                                >&nbsp;中部居左
                                                            </li>
                                                            <li><input type="radio" name="sel" value="3"
                                                                <?php if($config['sel'] == '3'): ?>checked<?php endif; ?>
                                                                >&nbsp;底部居左
                                                            </li>
                                                        </ul>
                                                </span>
                                                <span class="span_1">
                                                        <ul>
                                                            <li><input type="radio" name="sel" value="4"
                                                                <?php if($config['sel'] == '4'): ?>checked<?php endif; ?>
                                                                >&nbsp;顶部居中
                                                            </li>
                                                            <li><input type="radio" name="sel" value="5"
                                                                <?php if($config['sel'] == '5'): ?>checked<?php endif; ?>
                                                                >&nbsp;中部居中
                                                            </li>
                                                            <li><input type="radio" name="sel" value="6"
                                                                <?php if($config['sel'] == '6'): ?>checked<?php endif; ?>
                                                                >&nbsp;底部居中
                                                            </li>
                                                        </ul>
                                                </span>
                                                <span class="span_1">
                                                        <ul>
                                                            <li><input type="radio" name="sel" value="7"
                                                                <?php if($config['sel'] == '7'): ?>checked<?php endif; ?>
                                                                >&nbsp;顶部居右
                                                            </li>
                                                            <li><input type="radio" name="sel" value="8"
                                                                <?php if($config['sel'] == '8'): ?>checked<?php endif; ?>
                                                                >&nbsp;中部居右
                                                            </li>
                                                            <li><input type="radio" name="sel" value="9"
                                                                <?php if($config['sel'] == '9'): ?>checked<?php endif; ?>
                                                                >&nbsp;底部居右
                                                            </li>
                                                        </ul>
                                                </span>
                        <div style="clear:both;"></div>
                    </div>
                </dd>
            </dl>
            <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="$('#handlepost').submit()">确认提交</a></div>
        </div>
    </form>
</div>
<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
<script>
    function adsubmit(){
        $('#handlepost').submit();
    }

    $(document).ready(function(){
        get_province();
        var marktype = "<?php echo $config['mark_type']; ?>";
        if(marktype == 'text'){
            $('#texttr').show();
        }else{
            $('#imgtr').show();
        }
    });


    // 上传水印图片成功回调函数
    function call_back(fileurl_tmp){
        $("#mark_img").val(fileurl_tmp);
        $("#img_a").attr('href', fileurl_tmp);
        $("#img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }

    function setwarter(marktype){
        if(marktype == 'text'){
            $('#texttr').show();
            $('#imgtr').hide();
        }else{
            $('#texttr').hide();
            $('#imgtr').show();
        }
    }
</script>
</html>