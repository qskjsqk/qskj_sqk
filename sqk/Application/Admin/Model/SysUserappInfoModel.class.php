<?php

/**
 * @name SysUserappInfoModel
 * @info 描述：居民信息表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class SysUserappInfoModel extends Model {

    public $tableName = 'sys_userapp_info';
    protected $_validate = array(
        array('realname', 'require', '姓名为必填项！'),
        array('realname', '0,50', '姓名长度应在0-50之间！', 0, 'length'),
        array('birthday', 'require', '出生日期为必填项！'),
        array('tel', 'require', '手机号码为必填项！'),
        array('tel', '', '手机号码已被注册！', 1, 'unique', 1),
        array('tel', '/^1[0-9]{10}$/', '手机格式不正确！', 2),
    );

}
