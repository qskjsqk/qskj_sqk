<?php

/**
 * @name SellerItemsInfoController
 * @info 描述：积分商品信息控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerItemsInfoController extends BaseDBController {

    protected $infoModel;
    protected $sellerInfoModel;

    public function _initialize() {
        parent::_initialize();
        $this->infoModel = D('SellerItemsInfo');
        $this->sellerInfoModel = D('SellerInfo');
    }

    /**
     * function:显示某一积分商品列表
     */
    public function showList() {
        if (!empty($_SESSION['user_type'])) {//商家用户
            if (!empty($_SESSION['seller_id'])) {
                $this->showItemsInfo();
            } else {
                $this->redirect('Index/sellerError');
            }
        } else {
            $this->showItemsInfo();
        }
    }

    public function showItemsInfo() {
        if (GET) {
            if (!empty($_GET['name'])) {
                $where['name'] = array('LIKE', '%' . urldecode($_GET['name']) . '%');
                $pageCondition['name'] = urldecode($_GET['name']);
            }
            if (!empty($_GET['cat_type'])) {
                $where['cat_type'] = array('EQ', $_GET['cat_type']);
                $pageCondition['cat_type'] = $_GET['cat_type'];
            }
            if ($_GET['is_checked'] != '') {
                $where['is_checked'] = array('EQ', $_GET['is_checked']);
                $pageCondition['is_checked'] = $_GET['is_checked'];
            }
            if (empty($_GET['seller_id'])) {
                $where['seller_id'] = array('EQ', $_SESSION['seller_id']);
                $pageCondition['seller_id'] = $_SESSION['seller_id'];
            }
        }
        $fieldStr = 'seller_items_info.*';
        $joinStr ='';
        parent::showData($this->infoModel, $where, $pageCondition, [], $fieldStr);
    }

    /**
     * function:保存积分商品信息
     */
    public function saveSellerItems() {
        if (IS_POST) {
            $sellerItemsInfo = array(
                'id' => $_POST['id'],
                'seller_id' => $_POST['seller_id'],
                'name' => $_POST['name'],
                'category_name' => $_POST['category_name'],
                'cat_id' => $_POST['cat_id'],
                'price' => $_POST['price'],
                'introduction' => $_POST['introduction'],
                'quantifier' => $_POST['quantifier']
            );
            if ($this->infoModel->create($sellerItemsInfo)) {
                if (!empty($_FILES['logo_img']['name'])) {
                    $AllAtach = A('Allattach');
                    $imgInfo = $AllAtach->uploadFile('image', 'seller/logo');
                    if ($imgInfo['flag'] == 'success') {
                        $sellerItemsInfo['logo_img'] = ltrim($imgInfo['logo_img']['savepath'] . $imgInfo['logo_img']['savename'], '.');
                    } else {
                        $this->assign('fileErrorMsg', $imgInfo['msg']);
                        $this->assign('sellerItemsInfo', $sellerItemsInfo);
                        $this->display();
                        exit;
                    }
                }
                if (empty($_POST['id'])) {
                    $result = $this->infoModel->add($sellerItemsInfo);
                } else {
                    $result = $this->infoModel->save($sellerItemsInfo);
                }
                $logC = A('Actionlog')->addLog('SellerItemsInfo', 'saveSellerItems', '添加/编辑积分商品信息');
                if ($result !== false) {
                    $this->redirect('/Admin/SellerItemsInfo/showList/seller_id/' . $sellerItemsInfo['seller_id']);
                }
            } else {
                $errorMsg = $this->infoModel->getError();
                $this->assign('errorMsg', $errorMsg);
                $this->assign('sellerItemsInfo', $sellerItemsInfo);
                $this->display();
            }
            exit;
        }
        $sellerItemsInfo['seller_id'] = $_GET['seller_id'];
        $this->assign('sellerItemsInfo', $sellerItemsInfo);
        $this->display();
    }

    /**
     * function:编辑积分商品信息
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
            $this->assign('sellerItemsInfo', $returnData['data']);
        } else {
            $this->assign();
        }
        $this->display('saveSellerItems');
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delItemsInfo($id) {
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
    public function delArrayItemsInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delItemsInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('SellerItemsInfo', 'delArrayItemsInfo', '删除积分商品信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:审核单条积分商品信息
     */
    public function checkItemsInfo($id) {
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
     * function:批量审核积分商品信息
     */
    public function checkArrayItemsInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if ($this->checkItemsInfo($value) == '502') {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('SellerItemsInfo', 'checkArrayItemsInfo', '审核积分商品信息');
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

}
