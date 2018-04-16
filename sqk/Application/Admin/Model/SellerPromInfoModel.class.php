<?php
/**
 * @name SellerPromInfoModel
 * @info 描述：商家促销信息模型
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */
namespace Admin\Model;
use Think\Model;

class SellerPromInfoModel extends Model {
    public $tableName  = 'seller_prom_info';
//    protected $patchValidate = true;
    protected $_validate = array(
        array('title', 'require', '标题为必填项！'),
        array('address_id', 'require', '社区必选！'),
        array('seller_id', 'require', '商家必选！'),
        array('title', '1,200', '标题长度应在1-200之间！', 0, 'length'),
        array('start_time', 'require', '请选择开始时间！'),
        array('end_time', 'require', '请选择结束时间！'),
    );

}