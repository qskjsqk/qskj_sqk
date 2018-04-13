<?php

/**
 * @name SellerInfoModel
 * @info 描述：商家信息表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class SellerInfoModel extends Model {

    public $tableName = 'seller_info';
    protected $patchValidate = true;
    protected $_validate = array(
        array('name', 'require', '商家名称为必填项！'),
        array('name', '1,50', '商家名称长度应在1-50之间！', 0, 'length'), //cat_id
        array('cat_id', 'require', '分类为必选项！'),
        array('address', 'require', '商家地址为必填项！'),
        array('address', '1,300', '商家地址长度应在1-300之间！', 0, 'length'),
        array('tel', 'require', '商家电话为必填项！'),
        array('tel', '/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/', '号码格式不正确！'),
    );

}
