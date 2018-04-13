<?php

/**
 * User: Gao Xue
 * Date: 2016-07-05
 */

namespace Admin\Model;

use Think\Model;

class HelpInfoModel extends Model {

    public $tableName = 'emer_serv_info';
//    protected $patchValidate = true;//批量验证
    protected $_validate = array(
        array('realname', 'require', '姓名为必填项！'),
        array('realname', '1,50', '姓名长度应在1-50之间！', 0, 'length'),
        array('tel', '/^1[3|5|7|8|][0-9]{9}$/', '手机格式不正确！', 2),
        array('phone', '/^(?:(?:0\d{2,3})-)?(?:\d{6,8})(-(?:\d{3,}))?$/', '座机格式不正确！', 2),
        array('tel','checkTelAPhone','手机和座机至少填写一个！',1,'callback'),
        array('phone','checkTelAPhone','手机和座机至少填写一个！',1,'callback'),
    );

    /**
     * 验证电话手机至少填写一个
     * @return boolean
     */
    protected function checkTelAPhone() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        if (empty($param_arr['tel']) && empty($param_arr['phone'])) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
