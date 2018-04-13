<?php

/**
 * @name SellerOrderInfoController
 * @info 描述：商家订单信息控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerOrderInfoController extends BaseDBController {

    protected $infoModel;
    protected $userInfoModel;
    protected $sellerInfoModel;
    protected $sellerOrderItemModel;
    protected $sellerItemsModel;

    public function _initialize() {
        $this->infoModel = D('SellerOrderInfo');
        $this->userInfoModel = D('SellerUserInfo');
        $this->sellerInfoModel = D('SellerInfo');
        $this->sellerOrderItemModel = D('SellerOrderItemRel');
        $this->sellerItemsModel = D('SellerItemsInfo');
    }

    /**
     * function:显示商家订单信息列表
     */
    public function showList() {
        if (!empty($_SESSION['user_type'])) {//商家用户
            if (!empty($_SESSION['seller_id'])) {
                $this->showOrderInfo();
            } else {
                $this->redirect('Index/sellerError');
            }
        } else {
            $this->showOrderInfo();
        }
    }

    public function showOrderInfo() {
        if (GET) {
            if (!empty($_GET['order_no'])) {
                $where['order_no'] = array('LIKE', '%' . $_GET['order_no'] . '%');
                $pageCondition['order_no'] = $_GET['order_no'];
            }
            if (!empty($_GET['add_time'])) {
                $where['qs_gryj_seller_order_info.add_time'] = array(array('GT', $_GET['add_time'] . ' 00:00:00'), array('ELT', $_GET['add_time'] . ' 23:59:59'), 'and');
                $pageCondition['add_time'] = $_GET['add_time'];
            }
            if ($_GET['deal_type'] != '') {
                $where['deal_type'] = array('EQ', $_GET['deal_type']);
                $pageCondition['deal_type'] = $_GET['deal_type'];
            }
        }
        $fieldStr = 'qs_gryj_seller_order_info.*,qs_gryj_sys_user_info.usr,qs_gryj_sys_user_info.address,qs_gryj_sys_user_info.tel,qs_gryj_sys_user_info.realname,qs_gryj_seller_info.name';
        $joinStr = 'LEFT JOIN __SYS_USER_INFO__ ON __SELLER_ORDER_INFO__.buyer_id=__SYS_USER_INFO__.id LEFT JOIN __SELLER_INFO__ ON __SELLER_ORDER_INFO__.seller_id=__SELLER_INFO__.id';
        $where['seller_id'] = array('EQ', $_GET['seller_id']);
        if (!empty($_SESSION['seller_id'])) {
            $where['seller_id'] = array('EQ', $_SESSION['seller_id']);
            $pageCondition['seller_id'] = $_SESSION['seller_id'];
            $pageCondition['seller_name'] = urldecode($_SESSION['seller_name']);
        } else {
            $where['seller_id'] = array('EQ', $_GET['seller_id']);
            $pageCondition['seller_id'] = $_GET['seller_id'];
            $pageCondition['seller_name'] = urldecode($_GET['seller_name']);
        }
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:返回商家信息
     * @param $seller_id
     */
    public function showSellerInfo($seller_id) {
        $returnData = parent::getData($this->sellerInfoModel, $seller_id);
        $this->assign('sellerInfo', $returnData['data']);
        $this->display('showList');
    }

    /**
     * function:返回商家订单服务项目列表
     */
    public function showOrderItemsList() {
        $where['order_id'] = $_POST['order_id'];
        $fieldStr = 'qs_gryj_seller_order_item_rel.*,qs_gryj_seller_items_info.name,qs_gryj_seller_items_info.logo_img';
        $joinStr = 'LEFT JOIN __SELLER_ITEMS_INFO__ ON __SELLER_ORDER_ITEM_REL__.item_id=__SELLER_ITEMS_INFO__.id';
        $itemsInfoList = $this->sellerOrderItemModel->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->select();
        foreach ($itemsInfoList as $key => $value) {//sprintf("%.2f",$num)
            $itemsInfoList[$key]['price'] = sprintf('%.1f', $value['item_num'] * $value['item_price']);
        }
        echo json_encode($itemsInfoList);
    }

    /**
     * function:处理商家订单
     */
    public function dealSellerOrderInfo() {
        $condition['id'] = array('EQ', $_POST['id']);
        $data = array('deal_type' => $_POST['deal_type']);
        $returnData = parent::setFieldData($condition, $data);
        if ($returnData['code'] == '500') {
            if ($_POST['deal_type'] == 3) {
                $itemsCondition['order_id'] = array('EQ', $_POST['id']);
                $itemsList = $this->sellerOrderItemModel->where($itemsCondition)->select();
                foreach ($itemsList as $key => $value) {
                    $where['id'] = array('EQ', $value['item_id']);
                    $this->sellerItemsModel->where($where)->setInc('sold_num', $value['item_num']);
                }
            }
        }
        $logC = A('Actionlog')->addLog('SellerOrderInfo', 'dealSellerOrderInfo', '处理商家订单');
        $this->ajaxReturn($returnData, 'JSON');
    }

}
