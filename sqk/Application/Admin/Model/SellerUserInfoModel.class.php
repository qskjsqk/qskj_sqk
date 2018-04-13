<?php
/**
 * @name SellerUserInfoModel
 * @info 描述：商家信息模型
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */
namespace Admin\Model;
use Think\Model;

class SellerUserInfoModel extends Model {
    public $tableName  = 'sys_user_info';
    protected $_validate = array(
        array('usr', 'require', '手机号为必填项！'),
        array('usr','','该手机号已经存在！',0,'unique'),
        array('pwd', 'require', '密码为必填项！'),
        array('repassword','pwd','确认密码不一致！',0,'confirm'),
    );
}