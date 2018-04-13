<?php

/**
 * @name SysUserInfoController
 * @info 描述：用户信息控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class SysAppUserInfoController extends BaseDBController {

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
//        dump($_SESSION);
    }

    /**
     * function:显示用户列表
     */
    public function showList() {
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

        $this->assign('address_id', $_SESSION['address_id']);

        if (IS_POST) {
            $param_arr = array();
            $form_data = $_POST['form_data'];
            parse_str($form_data, $param_arr); //转换数组
            $param_arr['usr'] = $param_arr['tel'];
            $param_arr['pwd'] = R('Login/EncriptPWD', array($param_arr['pwd'])); //密码加密
            $param_arr['repwd'] = R('Login/EncriptPWD', array($param_arr['repwd'])); //密码加密
            $encriptTel = R('Login/EncriptPWD', array($param_arr['tel'])); //手机号加密
            $param_arr['qrcode_path'] = createQrcode($param_arr['tel'].$encriptTel);
            $returnData = parent::saveData($this->userInfoModel, $param_arr);
            $logC = A('Actionlog')->addLog('SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息');
            $this->ajaxReturn($returnData, 'JSON');
            exit;
        } else {
            $res = parent::getDataByWhere($this->groupModel, 'sys_name="appUser"');
            if ($res['code'] == 500) {
                $this->assign('cat_id', $res['data'][0]['id']);
            }
//            $this->assign('priv', $this->getPriviledges());
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
        $this->assign('address_id', $_SESSION['address_id']);
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
        $returnData = parent::delData($this->userInfoModel, $id);

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

//    /**
//     * function:是否为商家用户
//     * @param $id
//     * @return bool
//     */
//    public function isSellerUser($id) {
//        $condition['sys_name'] = array('EQ', 'sellerUser');
//        $groupInfo = $this->groupModel->where($condition)->find();
//        $userCondition['id'] = array('EQ', $id);
//        $userInfo = $this->userInfoModel->where($userCondition)->find();
//        if ($userInfo['cat_id'] == $groupInfo['id']) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    /**
     * function:获取信息
     */
    public function getData() {
        $returnData = parent::getData($this->userInfoModel, $_POST['id']);
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
            $returnData['data']['address_name'] = $this->getComInfoByCid($returnData['data']['address_id']);
            $returnData['data']['gender_name'] = ($returnData['data']['gender'] == 0) ? '男' : '女';
//            $this->assign('priv', $this->getPriviledges());
            $this->assign('userInfo', $returnData['data']);
        } else {
            $this->assign();
        }
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

    /**
     * 通过社区id获取社区信息
     * @param type $address_id
     * @return int
     */
    public function getComInfoByCid($address_id) {
        $model = M('sys_community_info');
        $comArr = $model->where('address_id=' . $address_id)->find();
        if (empty($comArr)) {
            return 0;
        } else {
            return $comArr['com_name'];
        }
    }

    /**
     * 获取该社区读卡器编码
     */
    public function getCardUfNum() {
        //时间系数
        $Ctime = 3600 * 24 * 0;
        $address_id = $_SESSION['address_id'];
        $userCat = $this->getCatInfoByCid($_SESSION['cat_id']);
        $where['address_id'] = array('EQ', $address_id);
        $where['timestamp'] = array('GT', time() - $Ctime);
        $comInfo = M('sys_community_info')->where($where)->find();
        if (!empty($comInfo)) {
            $returnData['code'] = 500;
            $returnData['uf_num'] = $comInfo['uf_num'];
        } else {
            $returnData['code'] = 502;
        }
        echo json_encode($returnData);
    }

    public function appUserDetail() {
        $this->assign('address_id', $_SESSION['address_id']);
        $this->getUserInfo($_GET['id']);
        $this->display();
    }

}
