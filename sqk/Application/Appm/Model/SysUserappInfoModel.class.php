<?php
/**
 * @name SysUserappInfoModel
 * @info 描述：居民用户model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 16:29:48
 */

namespace Appm\Model;
use Think\Model;

class SysUserappInfoModel extends Model {
    public $tableName  = 'sys_userapp_info';
    protected $_validate = array(
        array('realname', '0,50', '真实姓名长度应在0-50之间！', 0, 'length'),
    );
}
