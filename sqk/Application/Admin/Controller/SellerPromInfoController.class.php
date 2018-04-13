<?php

/**
 * @name SellerPromInfoController
 * @info 描述：商家广告控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerPromInfoController extends BaseDBController {

    protected $infoModel;
    protected $sellerItemsModel;

    public function _initialize() {
        $this->infoModel = D('SellerPromInfo');
        $this->sellerItemsModel = D('SellerItemsInfo');
    }

    /**
     * function:显示某一商家促销信息列表
     */
    public function showList() {
        if (!empty($_SESSION['user_type'])) {//商家用户
            if (!empty($_SESSION['seller_id'])) {
                $this->showPromInfo();
            } else {
                $this->redirect('Index/sellerError');
            }
        } else {
            $this->showPromInfo();
        }
    }

    public function showPromInfo() {
        if (empty($_GET['seller_id'])) {
            $where['seller_id'] = $_SESSION['seller_id'];
        } else {
            $where['seller_id'] = $_GET['seller_id'];
        }
        $this->assign('seller_id', $where['seller_id']);
//        $fieldStr='qs_gryj_seller_info.*,qs_gryj_sys_user_info.usr';
//        $joinStr='LEFT JOIN __SYS_USER_INFO__ ON __SELLER_INFO__.user_id=__SYS_USER_INFO__.id';
        parent::showData($this->infoModel, $where, [], '', '');
    }

    /**
     * function:跳转新增商家促销信息页面
     */
    public function saveSellerProm() {
        $sellerPromInfo['seller_id'] = $_GET['seller_id'];
        $this->assign('sellerPromInfo', $sellerPromInfo);
        $this->display();
    }

    /**
     * function:保存商家促销信息
     */
    public function saveSellerPromInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['read_ids'] = ',';
        $returnData = parent::saveData($this->infoModel, $param_arr);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:返回某一商家服务项目列表
     */
    public function showItemsList() {
        $where['seller_id'] = $_POST['seller_id'];
        $fieldStr = 'qs_gryj_seller_items_info.*,qs_gryj_seller_items_cat.cat_name';
        $joinStr = 'LEFT JOIN __SELLER_ITEMS_CAT__ ON __SELLER_ITEMS_INFO__.cat_id=__SELLER_ITEMS_CAT__.id';
        $sellerInfoList = $this->sellerItemsModel->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->select();
        echo json_encode($sellerInfoList);
    }

    /**
     * function:编辑商家促销项目信息
     */
    public function edit() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            $this->assign('sellerPromInfo', $returnData['data']);
        } else {
            $this->assign();
        }
        $this->display('saveSellerProm');
    }

    /**
     * function:促销详情
     */
    public function promDetail() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        $where['qs_gryj_seller_items_info.id'] = array('IN', trim($returnData['data']['item_ids'], ",")); //trim($str,"Hed!")
        $fieldStr = 'qs_gryj_seller_items_info.*,qs_gryj_seller_items_cat.cat_name';
        $joinStr = 'LEFT JOIN __SELLER_ITEMS_CAT__ ON __SELLER_ITEMS_INFO__.cat_id=__SELLER_ITEMS_CAT__.id';
        $sellerItemsInfoList = $this->sellerItemsModel->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->select();
        $this->assign('prom', $returnData['data']);
        $this->assign('itemsList', $sellerItemsInfoList);
        $this->display();
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delPromInfo($id) {
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
    public function delArrPromInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delPromInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:返回被选择的服务项目列表
     */
    public function showSelectItems() {
        $where['qs_gryj_seller_items_info.id'] = array('IN', trim($_POST['selected_id'], ",")); //trim($str,"Hed!")
        $fieldStr = 'qs_gryj_seller_items_info.*,qs_gryj_seller_items_cat.cat_name';
        $joinStr = 'LEFT JOIN __SELLER_ITEMS_CAT__ ON __SELLER_ITEMS_INFO__.cat_id=__SELLER_ITEMS_CAT__.id';
        $sellerPromInfoList = $this->sellerItemsModel->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->select();
        echo json_encode($sellerPromInfoList);
    }

}
