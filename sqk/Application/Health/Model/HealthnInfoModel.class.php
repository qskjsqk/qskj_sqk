<?php

/**
 * @name healthnInfoModel
 * @info 描述：活动信息表模型
 * @author Hellbao
 * @datetime 2017-3-24 10:29:13
 */

namespace Health\Model;
use Think\Model;

class HealthnInfoModel extends Model {

    public $tableName = 'health_info';
    protected $_validate = array(
        array('title', 'require', '标题为必填项！'),
        array('title', '1,200', '标题长度应在1-200之间！', 0, 'length'),
        array('cat_id', 'require', '请选择类别！'),
    );

}
