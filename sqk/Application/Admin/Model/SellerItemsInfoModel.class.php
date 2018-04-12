<?php
/**
 * @name SellerItemsInfoModel
 * @info 描述：商家服务项目信息模型
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */
namespace Admin\Model;
use Think\Model;

class SellerItemsInfoModel extends Model {
    public $tableName  = 'seller_items_info';
    protected $patchValidate = true;
    protected $_validate = array(
        array('name', 'require', '服务项目名称为必填项！'),
        array('name', '1,50', '服务项目名称长度应在1-50之间！', 0, 'length'),
        array('cat_id', 'require', '分类为必选项！'),
//        array('count_num','number','库存量必须为数字！'),
//        array('sold_num','number','销量必须为数字！'),
//        array('address', 'require', '商家地址为必填项！'),
//        array('address', '1,300', '商家地址长度应在1-300之间！', 0, 'length'),
//        array('tel', 'require', '商家电话为必填项！'),
//        array('introduction', '0,2000', '商家介绍应在2000字以内！', 0, 'length'),
    );
}