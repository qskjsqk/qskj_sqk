<?php

/**
 * @name ActivInfoModel
 * @info 描述：活动信息表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class ActivInfoModel extends Model {

    public $tableName = 'activ_info';
    protected $_validate = array(
        array('title', 'require', '标题为必填项！'),
        array('title', '1,200', '标题长度应在1-200之间！', 0, 'length'),
        array('cat_id', 'require', '分类为必选项！'),
        array('start_time', 'require', '请选择开始时间！'),
        array('end_time', 'require', '请选择结束时间！'),
        array('link_name', 'require', '活动联系人为必填项！'),
        array('link_tel', 'require', '联系电话为必填项！'),
        array('link_tel', '/^1[3|5|7|8|][0-9]{9}$/', '号码格式不正确！'),
    );

}
