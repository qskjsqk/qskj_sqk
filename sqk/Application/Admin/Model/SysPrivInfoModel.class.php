<?php
/**
 * User: Gao Xue
 * Date: 2016-07-05
 */

namespace Admin\Model;
use Think\Model;

class SysPrivInfoModel extends Model {
    public $tableName  = 'sys_priv_info';
    protected $_validate = array(
        array('pri_name', 'require', '权限名称为必填项！'),
        array('pri_name', '1,50', '权限名称长度应在1-50之间！', 0, 'length'),
        array('pri_value', 'require', '权限值为必填项！'),
        array('pri_value', '0,50', '权限值长度应在0-50之间！', 0, 'length'),
    );
}
