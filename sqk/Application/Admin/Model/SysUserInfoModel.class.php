<?php
/**
 * User: Gao Xue
 * Date: 2016-07-05
 */
namespace Admin\Model;
use Think\Model;

class SysUserInfoModel extends Model {
    public $tableName  = 'sys_user_info';
    protected $_validate = array(
        array('tel', 'require', '手机号码为必填项！'),
        array('usr', 'require', '用户名称为必填项！'),
        array('usr','','该用户已存在！',0,'unique'),
        array('usr', '1,50', '用户组名称长度应在1-50之间！', 0, 'length'),
        array('cat_id', 'require', '请选择用户组！'),
        array('realname', 'require', '真实姓名为必填项！'),
        array('realname', '0,50', '真实姓名长度应在0-50之间！', 0, 'length'),
        array('email','/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/','邮箱格式不正确！',2),
        array('tel','/^1[3|5|7|8|][0-9]{9}$/','手机格式不正确！',2),
        array('phone','/^(?:(?:0\d{2,3})-)?(?:\d{6,8})(-(?:\d{3,}))?$/','座机格式不正确！',2),
        array('qq','/^\d+$/','QQ格式不正确！',2),
        array('idcard_num','','身份证号已存在！',0,'unique'),
        array('idcard_num','/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/','身份证号不正确！'),
    );
}
