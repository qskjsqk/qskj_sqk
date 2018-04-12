<?php

/**
 * @name deviceinfoModel
 * @info 描述：设备表模型
 * @author Hellbao
 * @datetime 2017-3-24 10:29:13
 */

namespace Health\Model;

use Think\Model;

class DeviceInfoModel extends Model {

    public $tableName = 'device_info';
//    protected $patchValidate = true;//批量验证
    protected $_validate = array(
        array('name', 'require', '设备名称为必填项！'),
        array('dtype', 'require', '设备类型为必填项！'),
        array('did', 'require', '设备编号为必填项！'),
    );

}
