<?php

/**
 * @name NoticeInfoController
 * @info 描述：通知信息控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Config;

class NoticeInfoController extends BaseDBController {

    protected $catModel;
    protected $infoModel;
    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);

        $this->catModel = D('NoticeCat');
        $this->infoModel = D('NoticeInfo');
    }

    /**
     * function:显示通知信息列表
     */
    public function showList() {
        $this->assign('address_id', $_SESSION['address_id']);
        if ($_SESSION['address_id'] != 0) {
            $where[$this->config['db_fix'] . 'notice_info.address_id'] = array('IN','0,'.$_SESSION['address_id']);
        }
        if (!empty($_GET['title'])) {
            $where['title'] = array('LIKE', '%' . urldecode($_GET['title']) . '%');
            $pageCondition['title'] = urldecode($_GET['title']);
        }
        if (!empty($_GET['cat_id'])) {
            $where[$this->config['db_fix'] . 'notice_info.cat_id'] = array('EQ', $_GET['cat_id']);
            $pageCondition['category_name'] = urldecode($_GET['category_name']);
            $pageCondition['cat_id'] = $_GET['cat_id'];
        }
        $fieldStr = $this->config['db_fix'] . 'notice_info.*,' . $this->config['db_fix'] . 'notice_cat.cat_name,' . $this->config['db_fix'] . 'sys_user_info.usr,' . $this->config['db_fix'] . 'sys_user_info.realname';
        $joinStr = 'LEFT JOIN __NOTICE_CAT__ ON __NOTICE_INFO__.cat_id=__NOTICE_CAT__.id LEFT JOIN __SYS_USER_INFO__ ON __NOTICE_INFO__.user_id=__SYS_USER_INFO__.id';
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:跳转添加页面
     */
    public function add() {
        $this->assign('address_id', $_SESSION['address_id']);
        $this->display();
    }

    /**
     * function:编辑通知信息
     */
    public function edit() {
        $this->assign('address_id', $_SESSION['address_id']);
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            if (!empty($returnData['data']['cat_id'])) {
                $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $returnData['data']['cat_id']))->find();
                $returnData['data']['category_name'] = $res['category_name'];
            } else {
                $returnData['data']['category_name'] = '所有分类';
            }
            $this->assign('noticeInfo', $returnData['data']);
        } else {
            $this->assign();
        }
        $this->display('add');
    }

    /**
     * function:保存通知信息
     * @return $returnData(501验证未通过 500添加成功 502添加失败)
     */
    public function saveNoticeInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['user_id'] = $_SESSION['user_id'];
        $param_arr['read_ids'] = ',';
        $returnData = parent::saveData($this->infoModel, $param_arr);
        if ($returnData['code'] == '500') {
            $logC = A('Actionlog')->addLog('NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息');
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delNoticeInfo($id) {
        $successFlag = true;
        $returnData = parent::delData($this->infoModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        }
        return $successFlag;
    }

    /**
     * function:批量删除数据
     */
    public function delArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delNoticeInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('NoticeInfo', 'delArrayInfo', '删除通知信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:发布
     */
    public function publNoticeInfo() {
        $condition['id'] = array('EQ', $_POST['id']);
        $data = array('is_publish' => '1');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
            $logC = A('Actionlog')->addLog('NoticeInfo', 'publNoticeInfo', '发布通知信息');
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:通知详情
     */
    public function noticeDetail() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        $sysUserInfo = D('SysUserInfo')->where(array('id' => $returnData['data']['user_id']))->find();
        $returnData['data']['usr'] = (!empty($sysUserInfo['realname']) ? $sysUserInfo['realname'] : $sysUserInfo['usr']);
        $this->assign('notice', $returnData['data']);
        $this->display();
    }

    /**
     * function:获取通知列表彈出框中（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

}
