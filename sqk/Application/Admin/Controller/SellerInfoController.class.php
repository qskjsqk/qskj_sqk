<?php

/**
 * @name SellerInfoController
 * @info 描述：通知信息控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerInfoController extends BaseDBController {

    protected $catModel;
    protected $infoModel;
    protected $userInfoModel;
    protected $itemsInfoModel;
    protected $orderInfoModel;
    protected $promInfoModel;
    protected $attachModel;
    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);

        $this->catModel = D('SellerCat');
        $this->infoModel = D('SellerInfo');
        $this->userInfoModel = D('SellerUserInfo');
        $this->itemsInfoModel = D('SellerItemsInfo');
        $this->orderInfoModel = D('SellerOrderInfo');
        $this->promInfoModel = D('SellerPromInfo');
        $this->attachModel = D('SysAllAttach');
//        dump(__ACTION__);
    }

    /**
     * function:显示商家信息列表
     */
    public function showList() {
        if (GET) {
            if (!empty($_GET['name'])) {
                $where['name'] = array('LIKE', '%' . urldecode($_GET['name']) . '%');
                $pageCondition['name'] = urldecode($_GET['name']);
            }
            if (!empty($_GET['cat_id'])) {
                $where[$this->config['db_fix'] . 'seller_info.cat_id'] = array('EQ', $_GET['cat_id']);
                $pageCondition['category_name'] = $_GET['category_name'];
                $pageCondition['cat_id'] = $_GET['cat_id'];
            }
            if ($_GET['is_checked'] != '') {
                $where['is_checked'] = array('EQ', $_GET['is_checked']);
                $pageCondition['is_checked'] = $_GET['is_checked'];
            }
        }
        $fieldStr = $this->config['db_fix'] . 'seller_info.*,' . $this->config['db_fix'] . 'sys_user_info.usr,' . $this->config['db_fix'] . 'seller_cat.cat_name';
        $joinStr = 'LEFT JOIN __SYS_USER_INFO__ ON __SELLER_INFO__.user_id=__SYS_USER_INFO__.id LEFT JOIN __SELLER_CAT__ ON __SELLER_INFO__.cat_id=__SELLER_CAT__.id';
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:绑定商家用户
     */
    public function saveSellerUser() {
        if (IS_POST) {
            $param_arr = array();
            $form_data = $_POST['form_data'];
            parse_str($form_data, $param_arr); //转换数组
            $param_arr['tel'] = $param_arr['usr'];
            $param_arr['pwd'] = $param_arr['repassword'] = '123';
            $param_arr['cat_id'] = getCatId('sellerUser', D('SysUserGroup'));
            if (!$this->userInfoModel->create($param_arr)) {
                $returnData['code'] = '501'; //验证未通过
                $returnData['msgError'] = $this->userInfoModel->getError();
            } else {
                $param_arr['pwd'] = R('Login/EncriptPWD', array($param_arr['pwd'])); //密码加密
                $param_arr['repassword'] = R('Login/EncriptPWD', array($param_arr['repassword'])); //密码加密
                $returnData = parent::saveData($this->userInfoModel, $param_arr); //添加绑定用户信息
            }
            if ($returnData['code'] == '500') {
                $condition['id'] = array('EQ', $returnData['dataID']);
                $data['realname'] = '商家' . $returnData['dataID'];
                $this->userInfoModel->where($condition)->data($data)->save();
            }
            $this->ajaxReturn($returnData, 'JSON');
            exit;
        }
        $this->assign();
        $this->display();
    }

    /**
     * function:编辑商家信息
     */
    public function edit() {
        $this->assign('address_id', $_SESSION['address_id']);
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            $returnData['data']['category_name'] = $this->getCatName($returnData['data']['cat_id']);
            $info = parent::getData($this->userInfoModel, $returnData['data']['user_id']);
            
            $returnData['data']['address_id'] = $info['data']['address_id'];
            $returnData['data']['usr'] = $info['data']['usr'];
            $returnData['data']['tel'] = $info['data']['tel'];
            
            $condition['module_info_id'] = array('EQ', $returnData['data']['id']);
            $condition['module_name'] = array('EQ', 'sellerInfo');
            $attachList = $this->attachModel->where($condition)->select(); //if(is_array($res) && count($res)>0)
            $this->assign('attachList', json_encode($attachList));
            $this->assign('sellerInfo', $returnData['data']);
        } else {
            $this->assign();
        }
        $this->display('saveSeller');
    }
    /**
     * function:删除附件
     */
    public function delAttach() {
        $returnData = parent::delData($this->attachModel, $_POST['id']);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:完善用户基本信息
     */
    public function perfectInfo() {
        $this->assign('address_id', $_SESSION['address_id']);
        $condition['user_id'] = array('EQ', $_SESSION['user_id']);
        $sellerInfo = $this->infoModel->where($condition)->find();
        if (isset($sellerInfo)) {//商家信息存在--编辑操作
            $sellerInfo['category_name'] = $this->getCatName($sellerInfo['cat_id']);
        } else {//商家信息不存在--新增操作
            $sellerInfo['user_id'] = $_SESSION['user_id'];
        }
        $this->assign('sellerInfo', $sellerInfo);
        $this->display();
    }

    public function savePerfectInfo() {
        if (IS_POST) {
            $sellerInfo = array(
                'id' => $_POST['id'],
                'user_id' => $_POST['user_id'],
                'name' => $_POST['name'],
                'category_name' => $_POST['category_name'],
                'cat_id' => $_POST['cat_id'],
                'tel' => $_POST['tel'],
                'work_start' => $_POST['work_start'],
                'work_end' => $_POST['work_end'],
                'address' => $_POST['address'],
                'is_rest' => $_POST['is_rest'],
                'introduction' => $_POST['introduction']);
            if ($this->infoModel->create($sellerInfo)) {
                if (!empty($_FILES['logo_icon']['name'])) {
                    $AllAtach = A('Allattach');
                    $imgInfo1 = $AllAtach->uploadFile('image', 'seller/logo');
                    if ($imgInfo['flag'] == 'success') {
                        $sellerInfo['logo_icon'] = ltrim($imgInfo['logo_icon']['savepath'] . $imgInfo['logo_icon']['savename'], '.');
                    } else {
                        $this->assign('fileErrorMsg1', $imgInfo['msg']);
                        $this->assign('sellerInfo', $sellerInfo);
                        $this->display('perfectInfo');
                        exit;
                    }
                }
                if (empty($_POST['id'])) {
                    $result = $this->infoModel->add($sellerInfo);
                    session('seller_id', $result);
                    session('seller_name', $_POST['name']);
                } else {
                    $result = $this->infoModel->save($sellerInfo);
                }
                $logC = A('Actionlog')->addLog('SellerInfo', 'savePerfectInfo', '完善商家信息');
                $this->assign('sellerInfo', $sellerInfo);
                $this->display('perfectInfo');
            } else {
                $errorMsg = $this->infoModel->getError();
                $this->assign('errorMsg', $errorMsg);
                $this->assign('sellerInfo', $sellerInfo);
                $this->display('perfectInfo');
            }
            exit;
        }
        $sellerInfo['user_id'] = $_SESSION['user_id'];
        $this->assign('sellerInfo', $sellerInfo);
        $this->display('perfectInfo');
    }

    /**
     * function:保存商家信息
     */
    public function saveSellerInfo() {
        if (IS_POST) {
            $sellerInfo = array(
                'id' => $_POST['id'],
                'user_id' => $_POST['user_id'],
                'name' => $_POST['name'],
                'category_name' => $_POST['category_name'],
                'cat_id' => $_POST['cat_id'],
                'tel' => $_POST['tel'],
                'work_start' => $_POST['work_start'],
                'work_end' => $_POST['work_end'],
                'address' => $_POST['address'],
                'introduction' => $_POST['introduction']);
            if ($this->infoModel->create($sellerInfo)) {
                if (!empty($_FILES['logo_icon']['name'])) {
                    $AllAtach = A('Allattach');
                    $imgInfo = $AllAtach->uploadFile('image', 'seller/logo');
                    if ($imgInfo['flag'] == 'success') {
                        $sellerInfo['logo_icon'] = ltrim($imgInfo['logo_icon']['savepath'] . $imgInfo['logo_icon']['savename'], '.');
                    } else {
                        $this->assign('fileErrorMsg', $imgInfo['msg']);
                        $this->assign('sellerInfo', $sellerInfo);
                        $this->display('saveSeller');
                        exit;
                    }
                }

//                dump($_POST);
//                exit;
                if (empty($_POST['id'])) {
                    $result = $this->infoModel->add($sellerInfo);
                    $res_id = $result;
                } else {
                    $result = $this->infoModel->save($sellerInfo);
                    $res_id = $_POST['id'];
                }

                if ($result !== false) {
                    foreach ($_POST['files'] as $value) {//$this->attachModel
                        $condition['id'] = array('EQ', $value);
                        $data = array('module_info_id' => $res_id);
                        $this->attachModel->where($condition)->setField($data);
                    }
                    $logC = A('Actionlog')->addLog('SellerInfo', 'saveSellerInfo', '添加/编辑商家信息');
                    $this->redirect('/Admin/SellerInfo/showList');
                }
            } else {
                $errorMsg = $this->infoModel->getError();
                $this->assign('errorMsg', $errorMsg);
                $this->assign('sellerInfo', $sellerInfo);
                $this->display('saveSeller');
            }
            exit;
        }
        $sellerInfo['user_id'] = $_GET['user_id'];
        $this->assign('sellerInfo', $sellerInfo);
        $this->display('saveSeller');
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delSellerInfo($id) {
        $successFlag = true;
        $sellerInfo = parent::getData($this->infoModel, $id);
        $returnData = parent::delData($this->infoModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        } else {
            $successFlag = $this->delSellerRel($id);
            if ($successFlag) {
                $userInfo = parent::getData($this->userInfoModel, $sellerInfo['data']['user_id']);
                if (isset($userInfo)) {
                    parent::delData($this->userInfoModel, $sellerInfo['data']['user_id']);
                }
            }
        }
        return $successFlag;
    }

    /**
     * function:删除商家相关信息（服务项目、订单、促销信息）
     * @param $id
     * @return bool
     */
    public function delSellerRel($id) {
        $successFlag = true;
        $condition['seller_id'] = array('EQ', $id);
        $itemsData = $this->delData($condition, $this->itemsInfoModel, $id);
        if ($itemsData['code'] == '502') {
            $successFlag = fasle;
            return $successFlag;
        }
        $orderData = $this->delData($condition, $this->orderInfoModel, $id);
        if ($orderData['code'] == '502') {
            $successFlag = fasle;
            return $successFlag;
        }
        $promData = $this->delData($condition, $this->promInfoModel, $id);
        if ($promData['code'] == '502') {
            $successFlag = fasle;
            return $successFlag;
        }
        return $successFlag;
    }

    public function delData($where, $model, $id) {
        if ($model->where($where)->delete() !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
    }

    /**
     * function:批量删除数据
     */
    public function delArraySellerInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            $dealFlag = true;
            $condition['seller_id'] = array('EQ', $value);
            $orderInfo = $this->orderInfoModel->where($condition)->select();
            foreach ($orderInfo as $value1) {
                if ($value1['deal_type'] == 1 || $value1['deal_type'] == 2) {
                    $dealFlag = false;
                }
            }
            if (!$dealFlag) {
                $returnData['code'] = '503';
                break;
            } else {
                if (!$this->delSellerInfo($value)) {
                    $returnData['code'] = '502';
                }
            }
        }
        $logC = A('Actionlog')->addLog('SellerInfo', 'delArraySellerInfo', '删除商家信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:审核单条商家信息
     */
    public function checkSellerInfo($id) {
        $condition['id'] = array('EQ', $id);
        $data = array('is_checked' => '1');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData['code'];
    }

    /**
     * function:批量审核商家信息
     */
    public function checkArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if ($this->checkSellerInfo($value) == '502') {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('SellerInfo', 'checkArrayInfo', '审核商家信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取商家分类列表彈出框中（返回下拉树中数据）
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

}
