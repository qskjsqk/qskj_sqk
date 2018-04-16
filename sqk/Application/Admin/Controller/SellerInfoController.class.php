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
    protected $attachModel;
    protected $communityInfoModel;

    public function _initialize() {
        parent::_initialize();

        $this->catModel = D('SellerCat');
        $this->infoModel = D('SellerInfo');
        $this->attachModel = D('SysAllAttach');
        $this->communityInfoModel = D('SysCommunityInfo');
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
                $where[$this->dbFix . 'seller_info.cat_id'] = array('EQ', $_GET['cat_id']);
                $pageCondition['category_name'] = $_GET['category_name'];
                $pageCondition['cat_id'] = $_GET['cat_id'];
            }
            if ($_GET['is_checked'] != '') {
                $where['is_checked'] = array('EQ', $_GET['is_checked']);
                $pageCondition['is_checked'] = $_GET['is_checked'];
            }
        }

        if (session('sys_name') == 'sqAdmin') {
            $where['address_id'] = session('address_id');
        }

        $fieldStr = parent::madField('seller_info.*', 'seller_cat.cat_name');

        $joinStr = parent::madJoin('seller_info.cat_id', 'seller_cat.id');
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:编辑商家信息
     */
    public function edit() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            $returnData['data']['category_name'] = $this->getCatName($returnData['data']['cat_id']);
            //$info = parent::getData($this->userInfoModel, $returnData['data']['user_id']);

            $condition['module_info_id'] = array('EQ', $returnData['data']['id']);
            $condition['module_name'] = array('EQ', 'sellerInfo');
            $attachList = $this->attachModel->where($condition)->select(); //if(is_array($res) && count($res)>0)
            $this->assign('attachList', json_encode($attachList));
            $this->assign('sellerInfo', $returnData['data']);
            $this->assign('communitys', $this->communityInfoModel->getLists());
            $this->assign('community', $this->communityInfoModel->where(['id' => session('address_id')])->getField('com_name'));
        } else {
            $this->assign();
        }
        $this->display('saveSeller');
    }

    /**
     * function:添加商家信息页面
     */
    public function add() {
        $this->assign('communitys', $this->communityInfoModel->getLists());
        $this->assign('community', $this->communityInfoModel->where(['id' => session('address_id')])->getField('com_name'));
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
     * function:保存商家信息
     */
    public function saveSellerInfo() {
        if (IS_POST) {
            if (!empty(I('address_id'))) {
                $address_id = I('address_id');
            } else {
                $address_id = session('address_id');
            }
            $sellerInfo = array(
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'address_id' => $address_id,
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
