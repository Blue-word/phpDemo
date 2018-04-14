<?php
return	array(	
	'system'=>array('name'=>'系统','child'=>array(
				array('name' => '设置','child' => array(
						array('name'=>'基本设置','act'=>'index','op'=>'System'),
						//array('name'=>'支付方式','act'=>'index1','op'=>'System'),
						array('name'=>'清除缓存','act'=>'cleanCache','op'=>'System'),
				)),
				array('name' => '权限','child'=>array(
						array('name' => '管理员列表', 'act'=>'index', 'op'=>'Admin'),
						array('name' => '角色管理', 'act'=>'role', 'op'=>'Admin'),
						array('name'=>'权限资源列表','act'=>'right_list','op'=>'System'),
						array('name' => '管理员日志', 'act'=>'log', 'op'=>'Admin'),
						array('name' => '供应商列表', 'act'=>'supplier', 'op'=>'Admin'),
				)),
				array('name' => '会员','child'=>array(
						array('name'=>'会员列表','act'=>'index','op'=>'User'),
						array('name'=>'会员等级','act'=>'levelList','op'=>'User'),
						array('name'=>'充值记录','act'=>'recharge','op'=>'User'),
						array('name'=>'提现申请','act'=>'withdrawals','op'=>'User'),
						array('name'=>'汇款记录','act'=>'remittance','op'=>'User'),
						//array('name'=>'会员整合','act'=>'integrate','op'=>'User'),
				)),
				
				array('name' => '新闻','child'=>array(
						array('name' => '获取新闻', 'act'=>'getNews', 'op'=>'News'),
						array('name' => '新闻列表', 'act'=>'newsList', 'op'=>'News'),
						array('name' => '新闻添加', 'act'=>'newsAdd', 'op'=>'News'),
						array('name' => '新闻分类', 'act'=>'categoryList', 'op'=>'News'),
						array('name' => '新闻分类添加', 'act'=>'category', 'op'=>'News'),
						array('name' => '新闻轮播图', 'act'=>'rotation_imgList', 'op'=>'News'),
						//array('name'=>'友情链接','act'=>'linkList','op'=>'Article'),
						//array('name' => '公告管理', 'act'=>'notice_list', 'op'=>'Article'),
						array('name' => '专题列表', 'act'=>'topicList', 'op'=>'News'),
						array('name' => '专题添加', 'act'=>'topic', 'op'=>'News'),
				)),
				array('name' => '生活','child'=>array(
						array('name' => '房屋出租', 'act'=>'houseRent', 'op'=>'Life'),
						//array('name' => '房屋求租', 'act'=>'houseSeek', 'op'=>'Life'),
						array('name' => '求职招聘', 'act'=>'jobSearch', 'op'=>'Life'),
						array('name' => '汽车买卖', 'act'=>'carService', 'op'=>'Life'),
						array('name' => '二手市场', 'act'=>'secondMarket', 'op'=>'Life'),
						array('name' => '同城交友', 'act'=>'cityFriends', 'op'=>'Life'),
						array('name' => '招聘行业', 'act'=>'industry', 'op'=>'Life'),
				)),
				array('name' => '论坛','child'=>array(
						array('name' => '汽车服务', 'act'=>'carService', 'op'=>'Forum'),
						array('name'=>  '技能服务', 'act'=>'skillService','op'=>'Forum'),
						array('name' => '电子通讯', 'act'=>'electronicCom', 'op'=>'Forum'),
						array('name' => '装修建材', 'act'=>'decorationMater', 'op'=>'Forum'),
						array('name' => '教育培训', 'act'=>'educationTrain', 'op'=>'Forum'),
						array('name' => '宠物服务', 'act'=>'petService', 'op'=>'Forum'),
						array('name' => '家政服务', 'act'=>'housekeep', 'op'=>'Forum'),
						array('name' => '美食广场', 'act'=>'foodCourt', 'op'=>'Forum'),
						array('name' => '旅游服务', 'act'=>'travelService', 'op'=>'Forum'),
				)),
				array('name' => '广告','child' => array(
						array('name'=>'广告列表','act'=>'adList','op'=>'Ad'),
						array('name'=>'广告位置','act'=>'position','op'=>'Ad'),
				)),
				array('name' => '数据','child'=>array(
						array('name' => '数据备份', 'act'=>'index', 'op'=>'Tools'),
						array('name' => '数据还原', 'act'=>'restore', 'op'=>'Tools'),
						array('name' => '数据恢复', 'act'=>'log', 'op'=>'Admin'),
						array('name' => 'SQL查询', 'act'=>'log', 'op'=>'Admin'),
				))
	)),
		
	'shop'=>array('name'=>'商城','child'=>array(
				array('name' => '商品','child' => array(
					array('name' => '商品分类', 'act'=>'categoryList', 'op'=>'Goods'),
					array('name' => '商品列表', 'act'=>'goodsList', 'op'=>'Goods'),
				//	array('name' => '库存日志', 'act'=>'stock_list', 'op'=>'Goods'),
					array('name' => '商品模型', 'act'=>'goodsTypeList', 'op'=>'Goods'),
					array('name' => '商品规格', 'act' =>'specList', 'op' => 'Goods'),
					array('name' => '品牌列表', 'act'=>'brandList', 'op'=>'Goods'),
					array('name' => '商品属性', 'act'=>'goodsAttributeList', 'op'=>'Goods'),
					array('name' => '评论列表', 'act'=>'index', 'op'=>'Comment'),
					array('name' => '商品咨询', 'act'=>'ask_list', 'op'=>'Comment'),
                                    
			)),
			array('name' => '订单','child'=>array(
					array('name' => '订单列表', 'act'=>'index', 'op'=>'Order'),
					array('name' => '发货单', 'act'=>'delivery_list', 'op'=>'Order'),
					array('name' => '退货单', 'act'=>'return_list', 'op'=>'Order'),
					array('name' => '添加订单', 'act'=>'add_order', 'op'=>'Order'),
			        array('name' => '订单日志','act'=>'order_log','op'=>'Order'),
			)),
			
			array('name' => '促销','child' => array(
					array('name' => '抢购管理', 'act'=>'flash_sale', 'op'=>'Promotion'),
					array('name' => '团购管理', 'act'=>'group_buy_list', 'op'=>'Promotion'),
					array('name' => '优惠促销', 'act'=>'prom_goods_list', 'op'=>'Promotion'),
					array('name' => '订单促销', 'act'=>'prom_order_list', 'op'=>'Promotion'),
					array('name' => '优惠券','act'=>'index', 'op'=>'Coupon'),
					//array('name' => '预售管理','act'=>'pre_sell_list', 'op'=>'Promotion'),
			)),
/*			
			array('name' => '分销','child' => array(
					array('name' => '分销商品列表', 'act'=>'goods_list', 'op'=>'Distribut'),
					array('name' => '分销商列表', 'act'=>'distributor_list', 'op'=>'Distribut'),
					array('name' => '分销关系', 'act'=>'tree', 'op'=>'Distribut'),
					array('name' => '分销设置', 'act'=>'set', 'op'=>'Distribut'),
					array('name' => '分成日志', 'act'=>'rebate_log', 'op'=>'Distribut'),
			)),
*/	     
    	    array('name' => '微信','child' => array(
    	        array('name' => '公众号配置', 'act'=>'index', 'op'=>'Wechat'),
    	        array('name' => '微信菜单管理', 'act'=>'menu', 'op'=>'Wechat'),
    	        array('name' => '文本回复', 'act'=>'text', 'op'=>'Wechat'),
    	        array('name' => '图文回复', 'act'=>'img', 'op'=>'Wechat'),
    	    )),

			
			array('name' => '统计','child' => array(
					array('name' => '销售概况', 'act'=>'index', 'op'=>'Report'),
					array('name' => '销售排行', 'act'=>'saleTop', 'op'=>'Report'),
					array('name' => '会员排行', 'act'=>'userTop', 'op'=>'Report'),
					array('name' => '销售明细', 'act'=>'saleList', 'op'=>'Report'),
					array('name' => '会员统计', 'act'=>'user', 'op'=>'Report'),
					array('name' => '运营概览', 'act'=>'finance', 'op'=>'Report'),
			)),
	)),
		
	'mobile'=>array('name'=>'模板','child'=>array(
			array('name' => '设置','child' => array(
					array('name' => '模板设置', 'act'=>'templateList', 'op'=>'Template'),
					array('name' => '手机支付', 'act'=>'templateList', 'op'=>'Template'),
					array('name' => '微信二维码', 'act'=>'templateList', 'op'=>'Template'),
					array('name' => '第三方登录', 'act'=>'templateList', 'op'=>'Template'),
					array('name' => '导航管理', 'act'=>'finance', 'op'=>'Report'),
					array('name' => '广告管理', 'act'=>'finance', 'op'=>'Report'),
					array('name' => '广告位管理', 'act'=>'finance', 'op'=>'Report'),
			)),
	)),
		
	'resource'=>array('name'=>'插件','child'=>array(
			array('name' => '云服务','child' => array(
				array('name' => '插件库', 'act'=>'index', 'op'=>'Plugin'),
				//array('name' => '数据备份', 'act'=>'index', 'op'=>'Tools'),
				//array('name' => '数据还原', 'act'=>'restore', 'op'=>'Tools'),
			)),
	)),
);