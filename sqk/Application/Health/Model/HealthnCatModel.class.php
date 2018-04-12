<?php

/**
 * @name healthncatModel
 * @info 描述：活动分类表模型
 * @author Hellbao
 * @datetime 2017-3-24 10:29:13
 */

namespace Health\Model;

use Think\Model;

class HealthnCatModel extends Model {

    public $tableName = 'health_cat';
//    protected $patchValidate = true;//批量验证
    protected $_validate = array(
        array('cat_name', 'require', '分类名称为必填项！'),
        array('cat_name', '1,50', '分类名称长度应在1-50之间！', 0, 'length'),
        array('sys_name', '0,50', '系统名称长度应在0-50之间！', 0, 'length'),
    );

}
