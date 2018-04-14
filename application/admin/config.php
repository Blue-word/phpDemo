<?php
  return   [           
            'template'               => [
            // 模板引擎类型 支持 php think 支持扩展
            'type'         => 'Think',
            // 模板路径
            'view_path'    => './application/admin/view/',
            // 模板后缀
            'view_suffix'  => 'html',
            // 模板文件名分隔符
            'view_depr'    => DS,
            // 模板引擎普通标签开始标记
            'tpl_begin'    => '{',
            // 模板引擎普通标签结束标记
            'tpl_end'      => '}',
            // 标签库标签开始标记
            'taglib_begin' => '<',
            // 标签库标签结束标记
            'taglib_end'   => '>',
        ],
    
    //默认错误跳转对应的模板文件
    'dispatch_error_tmpl' => 'public:dispatch_jump',
    //默认成功跳转对应的模板文件
    'dispatch_success_tmpl' => 'public:dispatch_jump',

    'HOUSE_STATUS' =>[
        2 => '审核不通过',
        0 => '待审核',
        1 => '审核通过',
    ],

    'HOUSE_TYPE' =>[
        0 => '出租',
        1 => '求租',
    ],

    'JOB_TYPE' =>[
        1 => '求职',
        2 => '招聘',
    ],

    'CAR_TYPE' =>[
        1 => '汽车',
        2 => '买卖',
    ],




    
    ]
?>