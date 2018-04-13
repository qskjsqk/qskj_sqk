<?php

/**
 * @name SellerPromInfoModel
 * @info 描述：商家广告信息表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class SellerPromInfoModel extends Model {

    public $tableName = 'seller_prom_info';
//    protected $patchValidate = true;
    protected $_validate = array(
        array('title', 'require', '标题为必填项！'),
        array('title', '1,200', '标题长度应在1-200之间！', 0, 'length'),
        array('start_time', 'require', '请选择开始时间！'),
        array('end_time', 'require', '请选择结束时间！'),
    );

}
