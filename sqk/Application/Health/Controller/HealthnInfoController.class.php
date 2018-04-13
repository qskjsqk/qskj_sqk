<?php

/**
 * @name HealthnInfoController
 * @info 描述：健康知识信息控制器
 * @author Hellbao
 * @datetime 2017-2-15 13:29:13
 */

namespace Health\Controller;

use Think\Controller;

class HealthnInfoController extends BaseDBController {

    protected $catModel;
    protected $infoModel;

    public function _initialize() {
        $this->catModel = D('HealthnCat');
        $this->infoModel = D('HealthnInfo');
    }

    /**
     * function:显示信息列表
     */
    public function showList() {
        if (GET) {
            if (!empty($_GET['title'])) {
                $where['title'] = array('LIKE', '%' . urldecode($_GET['title']) . '%');
                $pageCondition['title'] = urldecode($_GET['title']);
            }
            if (!empty($_GET['cat_id'])) {
                $where['qs_gryj_health_info.cat_id'] = array('EQ', $_GET['cat_id']);
                $pageCondition['category_name'] = urldecode($_GET['category_name']);
                $pageCondition['cat_id'] = $_GET['cat_id'];
            }
        }
        $fieldStr = 'qs_gryj_health_info.*,qs_gryj_health_cat.cat_name,qs_gryj_sys_user_info.usr';
        $joinStr = 'LEFT JOIN __HEALTH_CAT__ ON __HEALTH_INFO__.cat_id=__HEALTH_CAT__.id LEFT JOIN __SYS_USER_INFO__ ON __HEALTH_INFO__.user_id=__SYS_USER_INFO__.id';
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:跳转添加页面
     */
    public function add() {
        $this->assign();
        $this->display();
    }

    /**
     * function:编辑通知信息
     */
    public function edit() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            if (!empty($returnData['data']['cat_id'])) {
                $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $returnData['data']['cat_id']))->find();
                $returnData['data']['category_name'] = $res['category_name'];
            } else {
                $returnData['data']['category_name'] = '所有分类';
            }
            $this->assign('healthInfo', $returnData['data']);
        } else {
            $this->assign();
        }
        $this->display('add');
    }

    /**
     * function:保存信息
     * @return $returnData(501验证未通过 500添加成功 502添加失败)
     */
    public function saveHealthInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['user_id'] = $_SESSION['user_id'];
        $param_arr['read_ids'] = ',';
        $returnData = parent::saveData($this->infoModel, $param_arr);
        $logC = A('Actionlog')->addLog('HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delHealthInfo($id) {
        $successFlag = true;
        $returnData = parent::delData($this->infoModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        }
        $logC = A('Actionlog')->addLog('HealthnInfo', 'delHealthInfo', '删除健康知识信息');
        return $successFlag;
    }

    /**
     * function:批量删除数据
     */
    public function delArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delHealthInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('HealthnInfo', 'delArrayInfo', '批量删除健康知识信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:发布
     */
    public function publHealthInfo() {
        $condition['id'] = array('EQ', $_POST['id']);
        $data = array('is_publish' => '1');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $logC = A('Actionlog')->addLog('HealthnInfo', 'publHealthInfo', '发布健康知识信息');
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:详情
     */
    public function healthDetail() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        $sysUserInfo = D('SysUserInfo')->where(array('id' => $returnData['data']['user_id']))->find();
        $returnData['data']['usr'] = $sysUserInfo['usr'];
        $this->assign('health', $returnData['data']);
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
