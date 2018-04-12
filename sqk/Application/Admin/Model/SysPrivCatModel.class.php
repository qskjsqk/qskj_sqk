<?php
/**
 * User: Gao Xue
 * Date: 2016-07-05
 */

namespace Admin\Model;
use Think\Model;

class SysPrivCatModel extends Model {
    public $tableName  = 'sys_priv_cat';
    protected $_validate = array(
        array('parent_id', 'require', '所属分类为必选项！'),
        array('cat_name', 'require', '分类名称为必填项！'),
        array('cat_name','','分类名称已存在！',0,'unique'),
        array('cat_name', '1,50', '分类名称长度应在1-50之间！', 0, 'length'),
        array('sys_name', '0,50', '系统名称长度应在0-50之间！', 0, 'length'),
    );
}
