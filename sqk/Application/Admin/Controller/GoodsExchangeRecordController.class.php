<?php

/**
 * @name GoodsExchangeRecordController
 * @info 描述：积分商品兑换记录控制器
 * @author xiaohuihui <2768083386@qq.com>
 * @datetime 2018-4-26 18:54:13
 */

namespace Admin\Controller;

use Think\Controller;

class GoodsExchangeRecordController extends BaseDBController {

    protected $infoModel;
    protected $communityInfoModel;
    protected $sellerInfoModel;
    protected $appUserModel;
    protected $goodsModel;

    public function _initialize() {
        parent::_initialize();

        $this->infoModel = D('GoodsExchangeRecord');
        $this->communityInfoModel = D('SysCommunityInfo');
        $this->sellerInfoModel = D('SellerInfo');
        $this->appUserModel = D('SysUserappInfo');
        $this->goodsModel = D('SellerIntegralGoods');
    }

    /**
     * 返回列表页查询时连表信息和查询字段
     */
    private static function createJoinAndField()
    {
        $join = [
            ['seller_integral_goods', 'id', 'goods_exchange_record', 'goods_id'],
            ['seller_info', 'id', 'goods_exchange_record', 'seller_id'],
            ['sys_userapp_info', 'id', 'goods_exchange_record', 'user_id'],
            ['sys_community_info', 'id', 'seller_info', 'address_id'],
        ];
        $field = [
            'goods_exchange_record.*',
            'seller_info.name as seller_name',
            'sys_userapp_info.usr',
            'seller_integral_goods.goods_name',
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
                $map[$this->dbFix . 'sys_userapp_info.usr'] = array('LIKE', '%' . urldecode(I('name')) . '%');
                $map['_logic'] = 'or';
                $pageCondition['name'] = urldecode(I('name'));
                $where['_complex'] = $map;
            }
            if (!empty(I('address_id'))) {
                $where[$this->dbFix . 'seller_info.address_id'] = intval(I('address_id'));
                $pageCondition['address_id'] = intval(I('address_id'));
            }
        }

        if (session('sys_name') == 'sqAdmin') {
            $where[$this->dbFix . 'seller_info.address_id'] = session('address_id');
        }

        //管理员不能看到未发布的积分商品
        $where[$this->dbFix . 'seller_integral_goods.status'] = ['neq', 0];

        list($join, $field) = self::createJoinAndField();
        list($page, $pageCondition, $infoList) = $this->infoModel->listPage($where, $pageCondition, $join, $field);
        $data = [
            'page' => $page,
            'searchInfo' => $pageCondition,
            'infoList' => $infoList,
            'communitys' => $this->communityInfoModel->getLists(),
        ];
        $this->assign('data', $data);
        //dd($data, false);
        $this->display();
    }

    /**
     * 异步上/下架商品
     */
    public function goodsFrame() {
        $id = I('id');
        if(!isset($id) || empty($id)) $this->ajaxReturn(syncData(-2, '操作失败,请重新操作'));
        $toStatus = I('status') == 1 ? 2: 1;
        if($this->infoModel->where(['id' => $id])->save(['status' => $toStatus]) == true) {
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
            $this->infoModel->where(['id' => $value])->delete();
        }
        $logC = A('Actionlog')->addLog('SellerIntegralGoods', 'delBatchSellerIntegralGoods', '删除积分商品');
        $this->ajaxReturn(syncData(0, '已批量删除'));
    }

    /**
     * 积分商品详情页
     */
    public function getGoodsInfoSync() {
        $id = I('id');
        if(!isset($id) || empty($id)) $this->ajaxReturn(syncData(-1, '获取失败,请重新操作'));
        $info = $this->infoModel->find($id);
        $this->ajaxReturn(syncData(0, '获取数据成功', $info));
    }

}
