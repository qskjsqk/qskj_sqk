<?php

return array(
    //'配置项'=>'配置值'
    //基础架构模块
    'PAGE_SIZE' => 10,//分页条数
    'DB_ACTION_LOG' => 'Sys_action_log', //配置日志数据库
    'DB_ALL_ATTACH' => 'Sys_all_attach', //配置附件数据库
    'DB_CONFIG_DEF' => 'Sys_config_def', //配置系统字典数据库
    'DB_DB_BACKUP' => 'Sys_db_backup', //配置数据备份数据库
    'BACKUP_MYSQL_PATH' => 'E:/wamp/www/gryj/Public/admin/db_backup/', //配置数据备份数据库
    'DB_USER_INFO' => 'Sys_user_info', //配置用户信息数据库
    'DB_USER_GROUP' => 'Sys_user_group', //配置用户组数据库
    //附件处理模块
    'UPLOAD_SIZE'=>3145728,//上传文件大小限制
    'UPLOAD_ROOT'=>'Public/Upload',//上传文件根目录
    'UPLOAD_EXT'=> array(
        'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
        'photo' => array('jpg', 'jpeg', 'png'),
        'flash' => array('swf', 'flv'),
        'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
        'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2', 'pdf'),
        'excel' => array('xls', 'xlsx')
    ),//上传类型
);
