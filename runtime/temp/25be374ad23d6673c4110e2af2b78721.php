<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:43:"./application/admin/view/index\welcome.html";i:1500949365;}*/ ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/index.css">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/purebox.css">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/jquery-ui.min.css">
    <script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
    <script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/static/js/jquery.cookie.js"></script>
    <style>
        .contentWarp_item .section_select .item_comment{
            padding: 83px 0 31px 38px;
        }
        .contentWarp_item .section_select .item {
            padding: 83px 0 38px 38px;
        }
        .contentWarp_item .section_order_select li{
            width: 23%;
        }
    </style>
</head>
<body class="iframe_body">
<div class="warpper">
    <div class="title">〖小蚂蚁〗 TPV5 管理中心</div>
    <div class="content start_content">
        <div class="contentWarp">
            <div class="contentWarp_item clearfix">
                <div class="section_select">
                    <div class="item item_price">
                        <i class="icon"><img src="__PUBLIC__/static/images/1.png" width="71" height="74"></i>
                        <div class="desc">
                            <div class="tit"><?php echo $count['new_order']; ?></div>
                            <span>今日成交金额</span>
                        </div>
                    </div>
                    <div class="item item_order">
                        <i class="icon"><img src="__PUBLIC__/static/images/2.png"></i>
                        <div class="desc">
                            <div class="tit"><?php echo $count['new_users']; ?></div>
                            <span>今日会员总数</span>
                        </div>
                        <i class="icon"></i>
                    </div>
                    <div class="item item_comment">
                        <i class="icon"><img src="__PUBLIC__/static/images/3.png" width="90" height="86"></i>
                        <div class="desc">
                            <div class="tit"><?php echo $count['comment']; ?></div>
                            <span>今待审核新闻</span>
                        </div>
                    </div>
                    <div class="item item_flow">
                        <i class="icon"><img src="__PUBLIC__/static/images/4.png" width="86"></i>
                        <div class="desc">
                            <div class="tit"><?php echo $count['today_login']; ?></div>
                            <span>今日访问量</span>
                        </div>
                        <i class="icon"></i>
                    </div>
                </div>
            </div>
            <div class="contentWarp_item clearfix">
                <div class="section_order_select">
                    <ul>
                        <li>
                            <a style="cursor: default;">
                                <i class="ice ice_w"></i>
                                <div class="t">成交金额</div>
                                <span class="number"><?php echo $count['handle_order']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a style="cursor: default;">
                                <i class="ice ice_y"></i>
                                <div class="t">新闻数量</div>
                                <span class="number"><?php echo $count['goods']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a style="cursor: default;">
                                <i class="ice ice_f"></i>
                                <div class="t">文章数量</div>
                                <span class="number"><?php echo $count['article']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a style="cursor: default;">
                                <i class="ice ice_n"></i>
                                <div class="t">会员总数</div>
                                <span class="number"><?php echo $count['users']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
                <div class="section section_order_count">
                    <div class="sc_title" style="padding: 26px 0 14px;border-bottom: 1px solid #e4eaec;">
                        <i class="sc_icon"></i>
                        <h3>版本信息</h3>
                    </div>
                    <div class="sc_warp" style="padding-bottom: 30px;">
                        <table cellpadding="0" cellspacing="0" class="system_table">
                            <tbody><tr>
                                <td class="gray_bg">程序版本:</td>
                                <td>Ant <?php echo $sys_info['version']; ?></td>
                                <td class="gray_bg">更新时间:</td>
                                <td>2017-06-01</td>
                            </tr>
                            <tr>
                                <td class="gray_bg">程序开发:</td>
                                <td>星创团队-blue</td>
                                <td class="gray_bg">版权所有:</td>
                                <td>南京青吕网络科技有限公司</td>
                            </tr>
                            <tr>
                                <td class="gray_bg">官方授权:</td>
                                <td><a href="http://www.xcteam.com/" target="_blank">商业授权</a></td>
                                <td class="gray_bg">官方论坛:</td>
                                <td><a href="http://www.tp-shop.cn/articleList_cat_id_31.html" target="_blank">星创团队交流论坛</a></td>
                            </tr>
                            </tbody></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="contentWarp">
            <div class="section system_section" style="float: none;width: inherit;">
                <div class="system_section_con">
                    <div class="sc_title" style="padding: 26px 0 14px;border-bottom: 1px solid #e4eaec;">
                        <i class="sc_icon"></i>
                        <h3>系统信息</h3>
                        <!--<span class="stop stop_jia" id="system_section" title="展开详情"></span>-->
                    </div>
                    <div class="sc_warp" id="system_warp" style="display: block;padding-bottom: 30px;">
                        <table cellpadding="0" cellspacing="0" class="system_table">
                            <tbody><tr>
                                <td class="gray_bg">服务器操作系统:</td>
                                <td><?php echo $sys_info['os']; ?></td>
                                <td class="gray_bg">服务器域名/IP:</td>
                                <td><?php echo $sys_info['domain']; ?> [ <?php echo $sys_info['ip']; ?> ]</td>
                            </tr>
                            <tr>
                                <td class="gray_bg">服务器环境:</td>
                                <td><?php echo $sys_info['web_server']; ?></td>
                                <td class="gray_bg">PHP 版本:</td>
                                <td><?php echo $sys_info['phpv']; ?></td>
                            </tr>
                            <tr>
                                <td class="gray_bg">Mysql 版本:</td>
                                <td><?php echo $sys_info['mysql_version']; ?></td>
                                <td class="gray_bg">GD 版本:</td>
                                <td><?php echo $sys_info['gdinfo']; ?></td>
                            </tr>
                            <tr>
                                <td class="gray_bg">文件上传限制:</td>
                                <td><?php echo $sys_info['fileupload']; ?></td>
                                <td class="gray_bg">最大占用内存:</td>
                                <td><?php echo $sys_info['memory_limit']; ?></td>
                            </tr>
                            <tr>
                                <td class="gray_bg">最大执行时间:</td>
                                <td><?php echo $sys_info['max_ex_time']; ?></td>
                                <td class="gray_bg">安全模式:</td>
                                <td><?php echo $sys_info['safe_mode']; ?></td>
                            </tr>
                            <tr>
                                <td class="gray_bg">Zlib支持:</td>
                                <td><?php echo $sys_info['zlib']; ?></td>
                                <td class="gray_bg">Curl支持:</td>
                                <td><?php echo $sys_info['curl']; ?></td>
                            </tr>
                            </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer" style="position: static; bottom: 0px;">
    <p>版权所有 © 2012-2017 深圳搜豹网络科技有限公司，并保留所有权利。</p>
</div>
<script type="text/javascript">
    $(function(){
        $("*[data-toggle='tooltip']").tooltip({
            position: {
                my: "left top+5",
                at: "left bottom"
            }
        });
    });
</script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.purebox.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/echarts.min.js"></script>
<script type="text/javascript">
    set_statistical_chart(".section_order_count .filter_date a:first", "order", "week"); //初始设置
    set_statistical_chart(".section_total_count .filter_date a:first", "sale", "week"); //初始设置
    function set_statistical_chart(obj, type, date)
    {
        var obj = $(obj);
        obj.addClass("active");
        obj.siblings().removeClass("active");

        $.ajax({
            type:'get',
            url:'index.php',
            data:'act=set_statistical_chart&type='+type+'&date='+date,
            dataType:'json',
            success:function(data){
                if(type == 'order'){
                    var div_id = "order_main";
                }
                if(type == 'sale'){
                    var div_id = "total_main";
                }
                var myChart = echarts.init(document.getElementById(div_id));
                myChart.setOption(data);
            }
        })
    }

    var option = {
        title : {
            text: ''
        },
        tooltip : {
            trigger: 'axis',
            backgroundColor:"#f5fdff",
            borderColor:"#8cdbf6",
            borderRadius:"4",
            borderWidth:"1",
            padding:"10",
            textStyle:{
                color:"#272727",
            },
            axisPointer:{
                lineStyle:{
                    color:"#6cbd40",
                }
            }
        },
        toolbox: {
            show : true,
            orient:"vertical",
            x:"right",
            y:"60",
            feature : {
                magicType : {show: true, type: ['line', 'bar']},
                saveAsImage : {show: true}
            },
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                axisLine:{
                    lineStyle:{
                        color:"#ccc",
                        width:"0",
                    }
                },
                data : ['07-01','07-02','07-03','07-04','07-05','07-06','07-07']
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLine:{
                    lineStyle:{
                        color:"#ccc",
                        width:"0",
                    }
                },
                axisLabel : {
                    formatter: '{value}个',
                }
            }
        ],
        series : [
            {
                name:'订单个数',
                type:'line',
                itemStyle:{
                    normal:{
                        color:"#6cbd40",
                        lineStyle:{
                            color:"#6cbd40",
                        }
                    }
                },
                data:[0, 5, 8, 3, 10, 15, 2],
                markPoint : {
                    itemStyle:{
                        normal:{
                            color:"#6cbd40"
                        }
                    },
                    data : [
                        {type : 'max', name: '最大值'},
                        {type : 'min', name: '最小值'}
                    ]
                }
            }

        ]
    }
//    $("#system_section").click(function(){
//        $("#system_warp").slideDown();
//    });
</script>
</body>

</html>