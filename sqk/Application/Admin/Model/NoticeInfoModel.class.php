<?php
/**
 * @name NoticeInfoModel
 * @info 描述：通知信息模型
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */
namespace Admin\Model;
use Think\Model;

class NoticeInfoModel extends Model {
    public $tableName  = 'notice_info';
    protected $_validate = array(
        array('title', 'require', '标题为必填项！'),
        array('title', '1,200', '标题长度应在1-200之间！', 0, 'length'),
        array('cat_id', 'require', '类别为必选项！'),
    );
}