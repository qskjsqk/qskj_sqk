<?php

return array(
    //'配置项'=>'配置值'
    //'TMPL_EXCEPTION_FILE'=>THINK_PATH.'Tpl/404.tpl',// 异常页面的模板文件
    'URL_MODEL' => '1',
    'DEFAULT_MODULE' => 'Admin', // 默认模块
    /* 数据库设置 */
    'DB_TYPE' => 'mysql', // 数据库类型
    /*'DB_HOST' => '111.204.78.45', // 服务器地址
    'DB_NAME' => 'qs_sqk_db_debug', // 数据库名
    'DB_USER' => 'db', // 用户名
    'DB_PWD' => 'qs-db', // 密码
    'DB_PORT' => '33060', // 端口*/

    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'qs_sqk_db_debug', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '', // 密码
    'DB_PORT' => '3306', // 端口

    'DB_PREFIX' => 'qs_sqk_', // 数据库表前缀
    'DB_PARAMS' => array(), // 数据库连接参数    
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE' => true, // 启用字段缓存
    'DB_CHARSET' => 'utf8', // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE' => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE' => false, // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM' => 1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO' => '', // 指定从服务器序号
    //系统
    'SYSTEM_TOKEN'=>'qs_sqk',//识别码

    'SHOW_PAGE_TRACE' => true, //开发过程中开启页面Trace
);
