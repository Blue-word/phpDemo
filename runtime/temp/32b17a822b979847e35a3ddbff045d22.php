<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"./application/admin/view/news\categoryList.html";i:1499159299;s:43:"./application/admin/view/public\layout.html";i:1499577477;}*/ ?>
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
  
<body style="background-color: rgb(255, 255, 255); overflow: auto; cursor: default;">
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>新闻分类</h3>
        <h5>新闻分类添加与管理</h5>
      </div>
    </div>
  </div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
      <span id="explanationZoom" title="收起提示"></span>
    </div>
    <ul>
      <li>新增新闻时，可选择新闻分类。新闻分类将在前台新闻列表页显示</li>
      <li>系统新闻分类不可以删除</li>
    </ul>
  </div>
    <div class="flexigrid">
      <div class="flexigrid">
        <div class="mDiv">
        <div class="ftitle">
          <h3>分类列表</h3>
          <h5>(共<?php echo $pager->totalRows; ?>条记录)</h5>
        </div>
        <div title="刷新数据" class="pReload"><i class="fa fa-refresh"></i></div>
      <form class="navbar-form form-inline" action="<?php echo U('News/categoryList'); ?>" method="post">      
        <div class="sDiv">
          <div class="sDiv2">
            <select  name="cate_id" class="select">
              <option value="">选择搜索类别</option>
              <option value="1">一级分类</option>
              <option value="2">二级分类</option>         
            </select>
            <input type="text" size="30" name="keywords" class="qsbox" placeholder="搜索相关数据...">
            <input type="submit" class="btn" value="搜索">
          </div>
        </div>
       </form>
      </div>
      <div class="hDiv">
        <div class="hDivBox">
        <table cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th class="sign" axis="col0">
                <div style="width: 24px;"><i class="ico-check"></i></div>
              </th>
              <th align="left" abbr="article_title" axis="col3" class="">
                <div style="text-align: left; width: 140px;" class="">名称</div>
              </th>
              <th align="center" abbr="ac_id" axis="col4" class="">
                <div style="text-align: center; width: 140px;" class="">等级分类</div>
              </th>
              <th align="center" abbr="article_show" axis="col5" class="">
                <div style="text-align: center; width: 140px;" class="">父级分类</div>
              </th>
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 140px;" class="">排序</div>
              </th>
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 140px;" class="">描述</div>
              </th>
              <th align="center" axis="col1" class="handle">
                <div style="text-align: center; width: 150px;">操作</div>
              </th>
              <th style="width:100%" axis="col7">
                <div></div>
              </th>
            </tr>
          </thead>
        </table>
        </div>
      </div>
      <div class="tDiv">
        <div class="tDiv2">
         <a href="<?php echo U('News/category',array('act'=>'add')); ?>">
          <div class="fbutton">
            <div class="add" title="新增分类">
              <span><i class="fa fa-plus"></i>新增分类</span>
            </div>
          </div>
         </a> 
        </div>
        <div style="clear:both"></div>
      </div>
      <div class="bDiv" style="height: auto;">
      <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
        <table>
          <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $k=>$vo): ?>
              <tr>
                <td class="sign">
                  <div style="width: 24px;"><i class="ico-check"></i></div>
                </td>
                <td align="left" class="">
                  <div style="text-align: left; width: 140px;"><?php echo getSubstr($vo['name'],0,33); ?></div>
                </td>
                <td align="center" class="">
                  <div style="text-align: center; width: 140px;"><?php echo $vo['cate']; ?></div>
                </td>
                <td align="center" class="">
                  <div style="text-align: center; width: 140px;"><?php echo $vo['pid_name']; ?></div>
                </td>
                <td align="center" class="">
                  <div style="text-align: center; width: 140px;"><?php echo $vo['sort']; ?></div>
                </td>
                <td align="center" class="">
                  <div style="text-align: center; width: 140px;"><?php echo $vo['description']; ?></div>
                </td>
                <td align="center" class="handle">
                  <div style="text-align: center; width: 150px; max-width:170px;">
                  <a class="btn blue"  href="<?php echo U('News/category',array('act'=>'detail','id'=>$vo['id'])); ?>"><i class="fa fa-search"></i>查看</a>

                  <a href="<?php echo U('News/category',array('act'=>'edit','id'=>$vo['id'])); ?>" class="btn blue"><i class="fa fa-pencil-square-o"></i>编辑</a>

                  <a class="btn red"  href="javascript:void(0)" data-url="<?php echo U('News/categoryHandle'); ?>" data-id="<?php echo $vo['id']; ?>" onClick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                    
                  </div>
                </td>
                <td align="" class="" style="width: 100%;">
                  <div>&nbsp;</div>
                </td>
              </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody>
        </table>
      </div>
      <div class="iDiv" style="display: none;"></div>
    </div>
    <!-- 分页位置 -->
    <div><?php echo $pager->show(); ?></div>
      
    </div>
  </form>
  <script>
     $(document).ready(function(){ 
      // 表格行点击选中切换
          $('#flexigrid > table>tbody >tr').click(function(){
            $(this).toggleClass('trSelected');
        });
        
        // 点击刷新数据
        $('.fa-refresh').click(function(){
          location.href = location.href;
        });
        
      });

     function delfun(obj) {
      // 删除按钮
      layer.confirm('确认删除？', {
        btn: ['确定', '取消'] //按钮
      }, function () {
        $.ajax({
          type: 'post',
          url: $(obj).attr('data-url'),
          data: {act: 'del', id: $(obj).attr('data-id')},
          dataType: 'json',
          success: function (data) {
            if (data==1) {
              $(obj).parent().parent().parent().remove();
              layer.closeAll();
            } else {
              layer.alert(data, {icon: 2});  //alert('删除失败');
            }
          }
        })
      }, function () {
        layer.closeAll();
      });
    }
  
  // function delfun(obj){
  //   if(confirm('确认删除')){    
  //     $.ajax({
  //       type : 'post',
  //       url : $(obj).attr('data-url'),
  //       data : {act:'del',id:$(obj).attr('data-id')},
  //       dataType : 'json',
  //       success : function(data){
  //         if(data==1){
  //           $(obj).parent().parent().parent().parent().parent().parent().remove();
  //         }else{
  //           layer.alert(data, {icon: 2});  //alert(data);
  //         }
  //       }
  //     })
  //   }
  //   return false;
  // }  
  </script>
</div>
</body>
</html>