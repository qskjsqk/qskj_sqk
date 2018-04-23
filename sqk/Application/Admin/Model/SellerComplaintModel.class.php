<?php
/**
 * @name SellerComplaintModel
 * @info 描述：用户商家投诉信息表模型
 * @author xiaohuihui
 * @datetime 2018-4-21 19:56:13
 */
namespace Admin\Model;
use Think\Model;
use Admin\Model\BaseModel;

class SellerComplaintModel extends BaseModel {

    public $tableName = 'seller_complaint' ;

    protected $patchValidate = true;

}