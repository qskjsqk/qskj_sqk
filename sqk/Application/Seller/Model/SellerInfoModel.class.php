<?php

/**
 * @name SellerInfoModel
 * @info 描述：商家信息 Model
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-05-05 16:02:00
 */

namespace Seller\Model;

use Think\Model;
use Admin\Model\BaseModel;

class SellerInfoModel extends BaseModel {

    public $tableName = 'seller_info';
    protected $_validate = array(
        array('name', 'require', '姓名为必填项！'),
        array('name', '0,50', '姓名长度应在0-50之间！', 0, 'length'),
        array('tel', 'require', '手机号码为必填项！'),
        array('tel', '', '手机号码已被注册！', 1, 'unique', 1),
        array('tel', '/^1[0-9]{10}$/', '手机格式不正确！', 2),
    );

}
