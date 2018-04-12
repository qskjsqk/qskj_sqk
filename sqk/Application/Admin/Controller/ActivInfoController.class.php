<?php

/**
 * @name ActivInfoController
 * @info 描述：活动信息控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class ActivInfoController extends BaseDBController {

    protected $catModel;
    protected $infoModel;
    protected $commModel;
    protected $attachModel;
    protected $userInfoModel;
    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);

        $this->catModel = D('ActivCat');
        $this->infoModel = D('ActivInfo');
        $this->commModel = D('ActivComm');
        $this->attachModel = D('SysAllAttach');
        $this->userInfoModel = D('SysUserInfo');
    }

    /**
     * function:显示活动信息列表
     */
    public function showList() {

        $this->assign('address_id', $_SESSION['address_id']);
        if ($_SESSION['address_id'] != 0) {
            $where[$this->config['db_fix'] . 'activ_info.address_id'] = array('IN', '0,' . $_SESSION['address_id']);
        }
        if (!empty($_GET['title'])) {
            $where['title'] = array('LIKE', '%' . urldecode($_GET['title']) . '%');
            $pageCondition['title'] = urldecode($_GET['title']);
        }
        if (!empty($_GET['cat_id'])) {
            $where[$this->config['db_fix'] . 'activ_info.cat_id'] = array('EQ', $_GET['cat_id']);
            $pageCondition['category_name'] = urldecode($_GET['category_name']);
            $pageCondition['cat_id'] = $_GET['cat_id'];
        }

        $fieldStr = $this->config['db_fix'] . 'activ_info.*,' . $this->config['db_fix'] . 'activ_cat.cat_name,' . $this->config['db_fix'] . 'sys_user_info.usr,' . $this->config['db_fix'] . 'sys_user_info.realname';
        $joinStr = 'LEFT JOIN __ACTIV_CAT__ ON __ACTIV_INFO__.cat_id=__ACTIV_CAT__.id LEFT JOIN __SYS_USER_INFO__ ON __ACTIV_INFO__.user_id=__SYS_USER_INFO__.id';
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:跳转保存活动信息页面
     */
    public function saveActiv() {
        $this->assign('address_id', $_SESSION['address_id']);
        $this->display();
    }

    /**
     * function:编辑活动信息
     */
    public function edit() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            $returnData['data']['category_name'] = $this->getCatName($returnData['data']['cat_id']);
            $condition['module_info_id'] = array('EQ', $returnData['data']['id']);
            $condition['module_name'] = array('EQ', 'activity');
            $attachList = $this->attachModel->where($condition)->select(); //if(is_array($res) && count($res)>0)
            $this->assign('attachList', json_encode($attachList));
            $this->assign('activInfo', $returnData['data']);
        } else {
            $this->assign('address_id', $_SESSION['address_id']);
        }
        $this->assign('address_id', $_SESSION['address_id']);
        $this->display('saveActiv');
    }

    /**
     * function:保存活动信息
     */
    public function saveActivInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['user_id'] = $_SESSION['user_id'];
        $returnData = parent::saveData($this->infoModel, $param_arr); //添加活动信息
        if ($returnData['code'] == '500') {
            foreach ($param_arr['files'] as $value) {//$this->attachModel
                $condition['id'] = array('EQ', $value);
                if ($returnData['flag'] == 'add') {
                    $data = array('module_info_id' => $returnData['dataID']);
                } else {
                    $data = array('module_info_id' => $param_arr['id']);
                }
                $this->attachModel->where($condition)->setField($data);
            }
            $logC = A('Actionlog')->addLog('ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息');
        }
        $this->ajaxReturn($returnData, 'JSON');
        exit;
    }

    /**
     * function:删除单条社区活动信息
     * @param $id
     * @return bool
     */
    public function delActivInfo($id) {
        $successFlag = true;
        $returnData = parent::delData($this->infoModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        }
        return $successFlag;
    }

    /**
     * function:批量删除社区活动信息
     */
    public function delArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delActivInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('ActivCat', 'delArrayInfo', '删除社区活动信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:发布单条活动信息
     */
    public function publishActivInfo($id) {
        $condition['id'] = array('EQ', $id);
        $data = array('is_publish' => '1');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData['code'];
    }

    /**
     * function:批量发布活动信息
     */
    public function publishArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if ($this->publishActivInfo($value) == '502') {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('ActivCat', 'publishArrayInfo', '发布社区活动信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:返回参加活动人数列表
     */
    public function showJoinList() {
        $userList = array();
        $returnData = parent::getData($this->infoModel, $_POST['id']);
        $joinArr = explode(",", trim($returnData['data']['join_ids'], ",")); //trim($str,"Hed!")
        foreach ($joinArr as $value) {
            $condition['id'] = array('EQ', $value);
            $userInfo = $this->userInfoModel->field('realname,tel,address,usr')->where($condition)->find();
            array_push($userList, $userInfo);
        }
        $logC = A('Actionlog')->addLog('ActivCat', 'showJoinList', '查看参加活动人数');
        echo json_encode($userList);
    }

    /**
     * function:活动详情
     */
    public function activDetail() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        $usrCondition['id'] = array('EQ', $returnData['data']['user_id']);
        $usrInfo = $this->userInfoModel->field('realname,usr')->where($usrCondition)->find();
        $returnData['data']['usr'] = (!empty($usrInfo['realname']) ? $usrInfo['realname'] : $usrInfo['usr']);
        $where['activity_id'] = $returnData['data']['id'];
        $condition['module_info_id'] = $returnData['data']['id'];
        $condition['module_name'] = array('EQ', 'activity');
        $commInfoList = $this->commModel->field($this->config['db_fix'] . 'activ_comm.*,' . $this->config['db_fix'] . 'sys_user_info.usr')->join('LEFT JOIN __SYS_USER_INFO__ ON __ACTIV_COMM__.user_id=__SYS_USER_INFO__.id')->where($where)->order('id desc')->select();
        $imgInfoList = $this->attachModel->where($condition)->order('id desc')->select();
        $this->assign('activ', $returnData['data']);
        $this->assign('imgInfo', $imgInfoList);
        $this->assign('activComm', $commInfoList);
        $this->display();
    }

    /**
     * function:删除附件
     */
    public function delAttach() {
        $returnData = parent::delData($this->attachModel, $_POST['id']);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取活动分类列表彈出框中（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

    /**
     * function:获取信息中所属分类名称
     * @param $cat_id
     * @return string
     */
    public function getCatName($cat_id) {
        if (!empty($cat_id)) {
            $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $cat_id))->find();
            $category_name = $res['category_name'];
        } else {
            $category_name = '所有分类';
        }
        return $category_name;
    }

    /**
     * 开启活动
     * @param type $id
     * @return string
     */
    public function openAct() {

        $condition['id'] = array('EQ', $_POST['id']);
        $res = $this->infoModel->where($condition)->find();

        if ($res['is_publish'] == 0) {
            $returnData['code'] = '502';
            $returnData['msg'] = '请先发布活动，再进行活动开启！';
        } else {
            $data = array('is_open' => '1');
            $result = $this->infoModel->where($condition)->setField($data);
            if ($result !== false) {
                $returnData['code'] = '500';
            } else {
                $returnData['code'] = '502';
                $returnData['msg'] = '活动开启失败，请重新操作！';
            }
        }
        echo json_encode($returnData);
    }

    /**
     * 结束活动
     */
    public function closeAct() {
        $condition['id'] = array('EQ', $_POST['id']);
        $data = array('is_open' => '0');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
            $returnData['msg'] = '活动关闭失败，请重新操作！';
        }
        echo json_encode($returnData);
    }
    
    /**
     * function:结束单条活动信息
     */
    public function overActivInfo($id) {
        $condition['id'] = array('EQ', $id);
        $data = array('is_over' => '1');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData['code'];
    }

    /**
     * function:批量结束活动信息
     */
    public function overArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if ($this->overActivInfo($value) == '502') {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('ActivInfo', 'overArrayInfo', '批量结束活动信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

}
