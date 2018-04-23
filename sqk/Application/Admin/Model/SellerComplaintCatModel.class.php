<?php
/**
 * @name SellerComplaintCatModel
 * @info 描述 投诉类型表模型
 * @author xiaohuihui
 * @datetime 2018-4-21 19:53:13
 */
namespace Admin\Model;
use Think\Model;

class SellerComplaintCatModel extends Model {

    public $tableName = 'seller_complaint_cat';

    protected $patchValidate = true;

    protected $_validate = [
        ['cat_name', 'require', '投诉类型为必填项！'],
    ];


}