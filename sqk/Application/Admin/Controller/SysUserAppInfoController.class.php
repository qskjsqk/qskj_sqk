<?php

/**
 * @name SysUserAppInfoController
 * @info 描述：居民用户信息控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Controller;

use Think\Controller;

class SysUserAppInfoController extends BaseDBController {

    protected $userappInfoModel;
    protected $sellerInfoModel;

    public function _initialize() {
        parent::_initialize();
        $this->userappInfoModel = D('SysUserappInfo');
        $this->sellerInfoModel = D('SellerInfo');
//        dump($_SESSION);
    }

    /**
     * function:显示用户列表
     */
    public function showList() {
        if (!empty($_GET['keyword'])) {
            $where['tel|realname'] = array('LIKE', '%' . urldecode($_GET['keyword']) . '%');
            $pageCondition['tel'] = urldecode($_GET['tel']);
        }

        $fieldStr = parent::madField('sys_userapp_info.*', 'sys_community_info.com_name');
        $joinStr = parent::madJoin('sys_userapp_info.address_id', 'sys_community_info.address_id');
        parent::showData($this->userappInfoModel, $where, $pageCondition, $joinStr, $fieldStr);
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
            $encriptTel = R('Login/EncriptPWD', array($param_arr['tel'])); //手机号加密
            $param_arr['qrcode_path'] = createQrcode($param_arr['tel'] . $encriptTel);
            $returnData = parent::saveData($this->userappInfoModel, $param_arr);
            $logC = A('Actionlog')->addLog('SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息');
            $this->ajaxReturn($returnData, 'JSON');
        } else {
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
            $returnData = parent::saveData($this->userappInfoModel, $param_arr);
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
        $returnData = parent::delData($this->userappInfoModel, $id);

        if ($returnData['code'] == '502') {
            $successFlag = fasle;
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
     * function:获取信息
     */
    public function getData() {
        $returnData = parent::getData($this->userappInfoModel, $_POST['id']);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取用户信息
     * @param $id
     */
    public function getUserInfo($id) {
        $returnData = parent::getData($this->userappInfoModel, $id);
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
        $Ctime = 3600 * 24 * 1;
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

    /**
     * 查看用户详情
     */
    public function appUserDetail() {
        $this->assign('address_id', $_SESSION['address_id']);
        $this->getUserInfo($_GET['id']);
        $this->display();
    }

    public function setUserAppUfNum() {
        $where['id'] = array('EQ', $_POST['id']);
        $updData['iccard_num'] = $_POST['card_num'];
        $updData['iccard_ufnum'] = $_POST['card_ufnum'];
        $returnData = parent::setField($this->userappInfoModel, $where, $updData);
        $logC = A('Actionlog')->addLog('SysUserInfo', 'setUserAppUfNum', '居民用户绑定实体卡');
        $this->ajaxReturn($returnData, 'JSON');
    }

}
