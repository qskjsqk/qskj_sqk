<?php
/**
 * User: Gao Xue
 * Date: 2016-07-05
 */
namespace Appm\Model;
use Think\Model;

class SysUserInfoModel extends Model {
    public $tableName  = 'sys_user_info';
    protected $_validate = array(
        array('realname', '0,50', '真实姓名长度应在0-50之间！', 0, 'length'),
        array('idcard_num','','身份证号已存在！',0,'unique'),
    );
}
