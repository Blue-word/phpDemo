<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"./application/admin/view/forum\carService.html";i:1500804161;s:43:"./application/admin/view/public\layout.html";i:1499577477;}*/ ?>
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
<body style="background-color: rgb(255, 255, 255); overflow: auto; cursor: default; -moz-user-select: inherit;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>房屋出租◆求租</h3>
        <h5>出租求租房屋索引与管理</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div id="explanation" class="explanation" style="color: rgb(44, 188, 163); background-color: rgb(237, 251, 248); width: 99%; height: 100%;">
    <div id="checkZoom" class="title"><i class="fa fa-lightbulb-o"></i>
      <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
      <span title="收起提示" id="explanationZoom" style="display: block;"></span>
    </div>
    <ul>
      <li>出租求租房屋管理～完成房屋信息的 审核、删除、查看</li>
    </ul>
  </div>
  <div class="flexigrid">
    <div class="mDiv">
      <div class="ftitle">
        <h3>房屋出租求租列表</h3>
        <h5>(共<?php echo $pager->totalRows; ?>条记录)</h5>
      </div>
      <div title="刷新数据" class="pReload"><i class="fa fa-refresh"></i></div>
    <form class="navbar-form form-inline" action="<?php echo U('Admin/Life/houseRent'); ?>" method="post">      
      <div class="sDiv">
        <div class="sDiv2">
          <select  name="type" class="select">
            <option value="">选择搜索类型</option>
            <option value="1">求租</option>
            <option value="0">出租</option>
                     
          </select>
          <select  name="status" class="select">
            <option value="">选择审核状态</option>
            <option value="1">审核通过</option>
            <option value="0">待审核</option>
            <option value="-1">审核不通过</option>          
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
              <th align="left">
                <div style="text-align: left; width: 220px;">标题</div>
              </th>
              <th align="center">
                <div style="text-align: center; width: 100px;">户型</div>
              </th>
              <th align="center">
                <div style="text-align: center; width: 60px;">出租方式</div>
              </th>
              <th align="center">
                <div style="text-align: center; width: 120px;">空出时间</div>
              </th>
              <th align="center">
                <div style="text-align: center; width: 60px;">房屋来源</div>
              </th>
              <th align="center">
                <div style="text-align: center; width: 60px;">类型</div>
              </th>
              <th align="center">
                <div style="text-align: center; width: 100px;">状态</div>
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
    <div class="bDiv" style="height: auto;">
      <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
        <table>
          <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $k=>$vo): ?>
              <tr>
                <td class="sign">
                  <div style="width: 24px;"><i class="ico-check"></i></div>
                </td>
                <td align="left">
                  <div style="text-align: left; width: 220px;"><?php echo getSubstr($vo['title'],0,33); ?></div>
                </td>
                <td align="center">
                  <div style="text-align: center; width: 100px;"><?php echo $vo['house_type']; ?></div>
                </td>
                <td align="center">
                  <div style="text-align: center; width: 60px;"><?php echo $vo['rent_way']; ?></div>
                </td>
                <td align="center">
                  <div style="text-align: center; width: 120px;"><?php echo $vo['empty_time']; ?></div>
                </td>
                <td align="center">
                  <div style="text-align: center; width: 60px;"><?php echo $vo['house_source']; ?></div>
                </td>
                <td align="center">
                  <?php if($vo['type'] == '出租'): ?>
                    <div style="text-align: center; width: 60px; color: darkorange;"><?php echo $vo['type']; ?></div>
                  <?php else: ?>
                    <div style="text-align: center; width: 60px; color: green;"><?php echo $vo['type']; ?></div>
                  <?php endif; ?>
                </td>
                <td align="center">
                  <?php if($vo['status'] == '待审核'): ?>
                    <div style="text-align: center; width: 100px; color: red;"><?php echo $vo['status']; ?></div>
                  <?php else: ?>
                    <div style="text-align: center; width: 100px;"><?php echo $vo['status']; ?></div>
                  <?php endif; ?>
                </td>
                <td align="center" class="handle">
                  <div style="text-align: center; width: 150px; max-width:170px;">
                  <a class="btn blue"  href="<?php echo U('Life/houseHandel',array('act'=>'detail','id'=>$vo['id'])); ?>"><i class="fa fa-search"></i>审核</a>
                  <a class="btn red"  href="javascript:void(0)" data-url="<?php echo U('Life/newsHandle'); ?>" data-id="<?php echo $vo['id']; ?>" onClick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                    
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
    <!--分页位置--> 
    <$pager->show()> </div>
</div>
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
            if (data) {
              $(obj).parent().parent().parent().remove();
              layer.closeAll();
            } else {
              layer.alert('删除失败', {icon: 2});  //alert('删除失败');
            }
          }
        })
      }, function () {
        layer.closeAll();
      });
    }
</script>
</body>
</html>