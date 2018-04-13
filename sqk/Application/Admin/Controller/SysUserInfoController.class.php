<?php

/**
 * @name SysUserInfoController
 * @info 描述：用户信息控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class SysUserInfoController extends BaseDBController {

    protected $groupModel;
    protected $userInfoModel;
    protected $privCatModel;
    protected $privInfoModel;
    protected $sellerInfoModel;
    protected $orderInfoModel;
    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);

        $this->groupModel = D('SysUserGroup');
        $this->userInfoModel = D('SysUserInfo');
        $this->privCatModel = D('SysPrivCat');
        $this->privInfoModel = D('SysPrivInfo');
        $this->sellerInfoModel = D('SellerInfo');
        $this->orderInfoModel = D('SellerOrderInfo');
    }

    /**
     * function:显示管理员用户列表
     */
    public function showList() {
        if (!empty($_GET['usr'])) {
            $where['usr'] = array('LIKE', '%' . urldecode($_GET['usr']) . '%');
            $pageCondition['usr'] = urldecode($_GET['usr']);
        }
        if (!empty($_GET['cat_id'])) {
            $where['cat_id'] = array('EQ', $_GET['cat_id']);
            $pageCondition['category_name'] = urldecode($_GET['category_name']);
            $pageCondition['cat_id'] = $_GET['cat_id'];
        }
        $fieldStr = $this->config['db_fix'] . 'sys_user_info.*,' . $this->config['db_fix'] . 'sys_user_group.cat_name';
        $joinStr = 'LEFT JOIN __SYS_USER_GROUP__ ON __SYS_USER_INFO__.cat_id=__SYS_USER_GROUP__.id';
        parent::showData($this->userInfoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:显示居民用户列表
     */
    public function showAppUserList() {
        if (!empty($_GET['usr'])) {
            $where['usr'] = array('LIKE', '%' . urldecode($_GET['usr']) . '%');
            $pageCondition['usr'] = urldecode($_GET['usr']);
        }
        $res = parent::getDataByWhere($this->groupModel, 'sys_name="appUser"');
        if ($res['code'] == 500) {
            $where["cat_id"] = array('EQ', $res['data'][0]['id']);
            $fieldStr = $this->config['db_fix'] . 'sys_user_info.*,' . $this->config['db_fix'] . 'sys_user_group.cat_name';
            $joinStr = 'LEFT JOIN __SYS_USER_GROUP__ ON __SYS_USER_INFO__.cat_id=__SYS_USER_GROUP__.id';
            parent::showData($this->userInfoModel, $where, $pageCondition, $joinStr, $fieldStr);
        }
    }

    /**
     * function:保存用户信息
     */
    public function saveUserInfo() {
        if (IS_POST) {
            $param_arr = array();
            $form_data = $_POST['form_data'];
            parse_str($form_data, $param_arr); //转换数组
            $param_arr['pwd'] = R('Login/EncriptPWD', array($param_arr['pwd'])); //密码加密
            $param_arr['repwd'] = R('Login/EncriptPWD', array($param_arr['repwd'])); //密码加密
            $returnData = parent::saveData($this->userInfoModel, $param_arr);
            $logC = A('Actionlog')->addLog('SysUserInfo', 'saveUserInfo', '添加/编辑用户信息');
            $this->ajaxReturn($returnData, 'JSON');
            exit;
        } else {
            dump($_GET['catName']);
            switch ($_GET['catName']) {
                case 'appUser':

                    break;
                case 'sellerUser':

                    break;

                default:
                    break;
            }
            $this->assign('priv', $this->getPriviledges());
            $this->display();
        }
    }

    /**
     * function:保存用户信息
     */
    public function saveUserMyInfo() {
        if (IS_POST) {
            $param_arr = array();
            $form_data = $_POST['form_data'];
            parse_str($form_data, $param_arr); //转换数组
            foreach ($param_arr as $k => $v) {
                if ($param_arr[$k] == null) {
                    unset($param_arr[$k]);
                }
            }
            $returnData = parent::saveData($this->userInfoModel, $param_arr);
            $this->ajaxReturn($returnData, 'JSON');
            exit;
        } else {
            $userInfo = M('SysUserInfo')->where('id=' . $_SESSION['user_id'])->find();
            $this->assign('userInfo', $userInfo);
            $this->display();
        }
    }

    /**
     * function:跳转编辑页面
     */
    public function edit() {
        $this->getUserInfo($_GET['id']);
        $this->display('editUserInfo');
    }

    public function editUserInfo() {
        if (IS_POST) {
            $param_arr = array();
            $form_data = $_POST['form_data'];
            parse_str($form_data, $param_arr); //转换数组
            $returnData = parent::saveData($this->userInfoModel, $param_arr);
            $this->ajaxReturn($returnData, 'JSON');
            exit;
        }
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delUserInfo($id) {
        $successFlag = true;
        if (!$this->isSellerUser($id)) {//非商家用户
            $returnData = parent::delData($this->userInfoModel, $id);
        } else {
            $sellerCondition['user_id'] = array('EQ', $id);
            $sellerInfo = $this->sellerInfoModel->where($sellerCondition)->find();
            if (isset($sellerInfo)) {
                $condition['seller_id'] = array('EQ', $sellerInfo['id']);
                $orderInfo = $this->$this->orderInfoModel->where($condition)->select();
                foreach ($orderInfo as $value1) {
                    if ($value1['deal_type'] == 1 || $value1['deal_type'] == 2) {
                        $dealFlag = false;
                    }
                }
            }
        }

        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        } else {
            $sellerCondition['user_id'] = array('EQ', $id);
            $sellerInfo = $this->sellerInfoModel->where($sellerCondition)->find();
            if (isset($sellerInfo)) {
                $condition['id'] = array('EQ', $sellerInfo['id']);
                $data = array('user_id' => 0);
                $this->sellerInfoModel->where($condition)->setField($data);
            }
        }
        return $successFlag;
    }

    /**
     * function:批量删除数据
     */
    public function delArrUserInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delUserInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('SysUserInfo', 'delArrUserInfo', '删除用户信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:是否为商家用户
     * @param $id
     * @return bool
     */
    public function isSellerUser($id) {
        $condition['sys_name'] = array('EQ', 'sellerUser');
        $groupInfo = $this->groupModel->where($condition)->find();
        $userCondition['id'] = array('EQ', $id);
        $userInfo = $this->userInfoModel->where($userCondition)->find();
        if ($userInfo['cat_id'] == $groupInfo['id']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * function:获取信息
     */
    public function getData() {
        $returnData = parent::getData($this->userInfoModel, $_POST['id']);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:实名认证
     */
    public function rnsUser() {
        $condition['id'] = array('EQ', $_POST['id']);
        $data = array('rns_type' => $_POST['flag']);
        $result = $this->userInfoModel->where($condition)->setField($data);
        if ($result !== false) {
            $userInfo = $this->userInfoModel->where($condition)->find();
            if ($_POST['flag'] == '1') {
                $healthCondition['idcard'] = array('EQ', $userInfo['idcard_num']);
                $data = array('user_id' => $_POST['id']);
            } else {
                $healthCondition['idcard'] = array('EQ', $userInfo['idcard_num']);
                $data = array('user_id' => 0);
            }
            $this->bloodpressModel->where($healthCondition)->setField($data);
            $this->bloodsaturModel->where($healthCondition)->setField($data);
            $this->sugarModel->where($healthCondition)->setField($data);
            $this->temptrModel->where($healthCondition)->setField($data);
            $this->weightModel->where($healthCondition)->setField($data);
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取用户信息
     * @param $id
     */
    public function getUserInfo($id) {
        $returnData = parent::getData($this->userInfoModel, $id);
        if ($returnData['code'] == '500') {
            $returnData['data']['category_name'] = $this->getCatName($returnData['data']['cat_id']);
            $this->assign('priv', $this->getPriviledges());
            $this->assign('userInfo', $returnData['data']);
        } else {
            $this->assign();
        }
    }

    /**
     * function:返回权限信息
     * @return mixed
     */
    public function getPriviledges() {
        $condition['parent_id'] = array('EQ', 0);
        $result = $this->privCatModel->where($condition)->select();
        foreach ($result as $key => $value) {
            $childrenResult = $this->privCatModel->where(array('parent_id' => $value['id']))->select();
            foreach ($childrenResult as $key1 => $value1) {
                $childrenResult[$key1]['children'] = $this->privInfoModel->where(array('cat_id' => $value1['id']))->select();
            }
            $result[$key]['children'] = $childrenResult;
        }
        return $result;
    }

    /**
     * function:添加用户时，返回初始化选择用户组权限值
     */
    public function getGroupPrivInfo() {
        $returnData = parent::getData($this->groupModel, $_POST['id']);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取通知列表彈出框中（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->groupModel);
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
            $res = $this->groupModel->field(array('cat_name' => 'category_name'))->where(array('id' => $cat_id))->find();
            $category_name = $res['category_name'];
        } else {
            $category_name = '所有分类';
        }
        return $category_name;
    }

    /**
     * 通过分类id获取分类信息
     * @param type $cat_id
     * @return int
     */
    public function getCatInfoByCid($cat_id) {
        $userModel = M(C('DB_USER_GROUP'));
        $catArr = $userModel->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr;
        }
    }

}
