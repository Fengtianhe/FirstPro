<?php
return array(
	//数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'zt', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'zt_', // 数据库表前缀 
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

    //加载配置文件
    'LOAD_EXT_CONFIG' => array('EMAIL'=>'email'), 
);
/*return array(
    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'qdm157806313.my3w.com', // 服务器地址
    'DB_NAME'   => 'qdm157806313_db', // 数据库名
    'DB_USER'   => 'qdm157806313', // 用户名
    'DB_PWD'    => '1234qwer', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'zt_', // 数据库表前缀 
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

    //加载配置文件
    'LOAD_EXT_CONFIG' => array('EMAIL'=>'email'),
);*/