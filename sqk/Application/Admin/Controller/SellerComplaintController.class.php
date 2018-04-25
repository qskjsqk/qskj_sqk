<?php

/**
 * @name SellerComplaintController
 * @info 描述：用户投诉商家信息控制器
 * @author xiaohuihui <2768083386@qq.com>
 * @datetime 2018-4-21 19:59:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerComplaintController extends BaseDBController {

    protected $infoModel;
    protected $communityInfoModel;
    protected $sysUserappInfoModel;
    protected $sellerInfoModel;
    protected $sellerComplaintCatModel;

    public function _initialize() {
        parent::_initialize();

        $this->infoModel = D('SellerComplaint');
        $this->communityInfoModel = D('SysCommunityInfo');
        $this->sysUserappInfoModel = D('SysUserappInfo');
        $this->sellerInfoModel = D('SellerInfo');
        $this->sellerComplaintCatModel = D('SellerComplaintCat');
    }

    /**
     * 显示投诉信息列表
     */
    public function showList() {
        if (GET) {
            if (!empty(I('name'))) {
                $map[$this->dbFix . 'seller_info.name'] = array('LIKE', '%' . urldecode(I('name')) . '%');
                $map[$this->dbFix . 'seller_info.tel'] = array('LIKE', '%' . urldecode(I('name')) . '%');
                $map['_logic'] = 'or';
                $pageCondition['name'] = urldecode(I('name'));
                $where['_complex'] = $map;
            }
            if (!empty(I('address_id'))) {
                $where[$this->dbFix . 'seller_complaint.address_id'] = intval(I('address_id'));
                $pageCondition['address_id'] = intval(I('address_id'));
            }
        }

        if (session('sys_name') == 'sqAdmin') {
            $where[$this->dbFix . 'seller_complaint.address_id'] = session('address_id');
        }

        list($join, $field) = self::createJoinAndField();
        list($page, $pageCondition, $infoList) = $this->infoModel->listPage($where, $pageCondition, $join, $field);
        $data = [
            'page' => $page,
            'searchInfo' => $pageCondition,
            'infoList' => $infoList,
            'communitys' => $this->communityInfoModel->getLists(),
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 批量删除数据
     */
    public function delBatchSellerComplaint() {
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            $this->infoModel->where(['id' => $value])->delete();
        }
        $logC = A('Actionlog')->addLog('SellerComplaint', 'delBatchSellerComplaint', '删除商家反馈信息');
        $this->ajaxReturn(syncData(0, '已批量删除'));
    }

    /**
     * 标记为已处理
     */
    public function markedAsProcessed() {
        if($this->infoModel->where(['id' => I('id')])->save(['status' => 1]) == true) {
            $this->ajaxReturn(syncData(0, '已标记为已处理'));
        } else {
            $this->ajaxReturn(syncData(-1, '标记失败,请重新操作'));
        }
    }

    /**
     * 详情页
     */
    public function detail() {
        if(empty(I('id'))) $this->redirect('/Admin/SellerComplaint/showList');
        $complaintInfo = $this->infoModel->find(I('id'));
        $complaintInfo['userInfo'] = $this->sysUserappInfoModel->where(['id' => $complaintInfo['user_id']])->field('usr,address_id,tel')->find();
        $complaintInfo['userInfo']['com_name'] = self::getComName($complaintInfo['userInfo']['address_id']);
        $complaintInfo['com_name'] = self::getComName($complaintInfo['address_id']);
        $complaintInfo['cat_name'] = $this->sellerComplaintCatModel->where(['id' => $complaintInfo['cat_id']])->getField('cat_name');
        $complaintInfo['sellerInfo'] = $this->sellerInfoModel->where(['id' => $complaintInfo['seller_id']])->field('name,contacts,tel')->find();
        $this->assign('complaintInfo', $complaintInfo);
        if(!empty(I('seller_id'))) $this->assign('seller_id', I('seller_id'));
        $this->display();
    }

    /**
     * 根据社区id获取社区名称
     */
    public function getComName($address_id) {
        return $this->communityInfoModel->where(['id' => $address_id])->getField('com_name');
    }

    /**
     * 显示某商家反馈信息列表
     */
    public function showListById() {
        $where[$this->dbFix . 'seller_complaint.seller_id'] = intval(I('seller_id'));

        list($join, $field) = self::createJoinAndField();
        list($page, $pageCondition, $infoList) = $this->infoModel->listPage($where, [], $join, $field);
        $data = [
            'page' => $page,
            'infoList' => $infoList,
            'seller_id' => I('seller_id'),
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 返回列表页查询时连表信息和查询字段
     */
    public static function createJoinAndField() {
            $join = [
                ['sys_community_info', 'id', 'address_id'],
                ['seller_complaint_cat', 'id', 'cat_id'],
                ['sys_userapp_info', 'id', 'user_id'],
                ['seller_info', 'id', 'seller_id'],
            ];
            $field = [
                'seller_complaint.*',
                'sys_community_info.com_name',
                'seller_complaint_cat.cat_name',
                'sys_userapp_info.usr',
                'seller_info.name',
                'seller_info.contacts',
                'seller_info.tel',
            ];
        return [$join, $field];
    }


}
