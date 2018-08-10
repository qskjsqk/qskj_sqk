<?php

/**
 * @name SellerIntegralGoodsController
 * @info 描述：积分商品控制器
 * @author xiaohuihui <2768083386@qq.com>
 * @datetime 2018-4-24 17:38:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerIntegralGoodsController extends BaseDBController {

    protected $infoModel;
    protected $communityInfoModel;
    protected $sellerInfoModel;
    protected $weChatModel;

    public function _initialize() {
        parent::_initialize();

        $this->infoModel = D('SellerIntegralGoods');
        $this->communityInfoModel = D('SysCommunityInfo');
        $this->sellerInfoModel = D('SellerInfo');
        $this->weChatModel = D('SellerWechatBinding');
    }

    /**
     * 返回列表页查询时连表信息和查询字段
     */
    private static function createJoinAndField() {
        $join = [
            ['sys_community_info', 'id', 'seller_integral_goods', 'address_id'],
            ['seller_integral_goods_cat', 'id', 'seller_integral_goods', 'cat_id'],
            ['seller_info', 'id', 'seller_integral_goods', 'seller_id'],
        ];
        $field = [
            'seller_integral_goods.*',
            'sys_community_info.com_name',
            'seller_integral_goods_cat.cat_name',
            'seller_info.name as seller_name',
        ];
        return [$join, $field];
    }

    /**
     * 显示积分商品列表
     */
    public function showList() {
        if (GET) {
            if (!empty(I('name'))) {
                $map[$this->dbFix . 'seller_info.name'] = array('LIKE', '%' . urldecode(I('name')) . '%');
                $map[$this->dbFix . 'seller_integral_goods.goods_name'] = array('LIKE', '%' . urldecode(I('name')) . '%');
                $map['_logic'] = 'or';
                $pageCondition['name'] = urldecode(I('name'));
                $where['_complex'] = $map;
            }
            if (!empty(I('address_id'))) {
                $where[$this->dbFix . 'seller_integral_goods.address_id'] = intval(I('address_id'));
                $pageCondition['address_id'] = intval(I('address_id'));
            }
        }

        if (session('sys_name') == 'sqAdmin') {
            $where[$this->dbFix . 'seller_integral_goods.address_id'] = session('address_id');
        }

        //管理员不能看到未发布的积分商品
        //$where[$this->dbFix . 'seller_integral_goods.status'] = ['neq', 0];

        list($join, $field) = self::createJoinAndField();
        list($page, $pageCondition, $infoList) = $this->infoModel->listPage($where, $pageCondition, $join, $field);
        $data = [
            'page' => $page,
            'searchInfo' => $pageCondition,
            'infoList' => $infoList,
            'communitys' => $this->communityInfoModel->getLists(),
            'allGoodsCount' => $this->infoModel->getIntegralGoodsCount(true),
            'currentGoodsCount' => session('sys_name') == 'sqAdmin' ? $this->infoModel->getIntegralGoodsCount(false) : null,
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 异步上/下架商品
     */
    public function goodsFrame() {
        $id = I('id');

        if (!isset($id) || empty($id))
            $this->ajaxReturn(syncData(-2, '操作失败,请重新操作'));
        $goodInfo = M('seller_integral_goods')->where(['id' => $id])->find();
        $sellerInfo = M('seller_info')->where(['id' => $id])->find();
        if ($sellerInfo['status'] != 1)
            $this->ajaxReturn(syncData(-2, '该商家尚未通过审核'));
        $toStatus = I('status') == 1 ? 2 : 1;
        if ($this->infoModel->where(['id' => $id])->save(['status' => $toStatus]) == true) {
            $this->ajaxReturn(syncData(0, '操作成功'));
        } else {
            $this->ajaxReturn(syncData(-1, '操作失败,请重新操作'));
        }
    }

    /**
     * 批量删除数据
     */
    public function delBatchSellerIntegralGoods() {
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if ($this->infoModel->where(['id' => $value])->delete()) {
                $this->weChatModel->where(['seller_id' => $value])->delete();
            }
        }
        $logC = A('Actionlog')->addLog('SellerIntegralGoods', 'delBatchSellerIntegralGoods', '删除积分商品');
        $this->ajaxReturn(syncData(0, '已批量删除'));
    }

    /**
     * 异步获取积分商品详情
     */
    public function getGoodsInfoSync() {
        $id = I('id');
        if (!isset($id) || empty($id))
            $this->ajaxReturn(syncData(-1, '获取失败,请重新操作'));
        $info = $this->infoModel->find($id);
        if (!empty($info)) {
            $this->ajaxReturn(syncData(0, '获取数据成功', $info));
        } else {
            $this->ajaxReturn(syncData(-2, '获取失败,请重新操作'));
        }
    }

    /**
     * 显示某一商家下的积分商品列表
     */
    public function showListById() {
        $seller_id = I('seller_id');
        if (!isset($seller_id) || empty($seller_id))
            $this->redirect('/Admin/SellerInfo/showList');

        $where = [
            //$this->dbFix . 'seller_integral_goods.status' => ['neq', 0],     //管理员不能看到未发布的积分商品(本条件可以不设置)
            $this->dbFix . 'seller_integral_goods.seller_id' => $seller_id,
        ];

        list($join, $field) = self::createJoinAndField();
        list($page, $pageCondition, $infoList) = $this->infoModel->listPage($where, [], $join, $field);
        $data = [
            'page' => $page,
            'searchInfo' => $pageCondition,
            'infoList' => $infoList,
            'communitys' => $this->communityInfoModel->getLists(),
            'allGoodsCount' => $this->infoModel->getIntegralGoodsCount(true),
            'currentGoodsCount' => session('sys_name') == 'sqAdmin' ? $this->infoModel->getIntegralGoodsCount(false) : null,
        ];
        $this->assign('data', $data);
        $this->display();
    }

}
