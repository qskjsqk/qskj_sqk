<?php

/**
 * @name TradingController
 * @info 描述：交易记录控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-5-4 10:21:24
 */

namespace Seller\Controller;

use Think\Controller;
use Seller\Controller\BaseController;
use Think\Tool\Request;
use Seller\Model\ExchangeRecordModel;
use Seller\Model\SellerInfoModel;
use Admin\Model\SysCommunityInfoModel;

class TradingController extends BaseController {

    public function _initialize() {
        parent::_initialize();
    }

    public function trading_detail() {
        $request = Request::all();
        $exchangeModel = new ExchangeRecordModel();
        $join = [
            ['sys_userapp_info', 'id', 'goods_exchange_record', 'user_id'],
            ['seller_integral_goods', 'id', 'goods_exchange_record', 'goods_id'],
        ];
        $field = ['goods_exchange_record.*', 'sys_userapp_info.realname', 'sys_userapp_info.usr', 'seller_integral_goods.goods_name'];
        $where[$this->dbFix . 'goods_exchange_record.id'] = $request['exchange_id'];

        $exchangeLists = $exchangeModel->joinFieldDB($join, $field, $where)->find();
        $exchangeLists['exchange_method'] = getExchangeMethodById($exchangeLists['exchange_method_id'])['name'];
        $this->assign('data', $exchangeLists);
        if(!empty($request['fromUrl'])) {
            $this->assign('fromUrl', $request['fromUrl']);
        }
        $this->display();
    }

    public function trading_list() {
        $request = Request::all();
        $seller_id = cookie('seller_id');
        $exchangeModel = new ExchangeRecordModel();
        $sellerInfo = (new SellerInfoModel())->find($seller_id);
        $sellerInfo['com_name'] = (new SysCommunityInfoModel())->where(['id' => $sellerInfo['address_id']])->getField('com_name');

        $join = [
            ['sys_userapp_info', 'id', 'goods_exchange_record', 'user_id'],
        ];
        $field = ['goods_exchange_record.*', 'sys_userapp_info.realname'];
        $where[$this->dbFix . 'goods_exchange_record.seller_id'] = $seller_id;
        $exchangeLists = $exchangeModel->joinFieldDB($join, $field, $where)
            ->order($this->dbFix . "goods_exchange_record.id desc")
            ->select();
        $data = [
            'sellerInfo' => $sellerInfo,
            'exchangeLists' => $exchangeLists,
        ];
        $this->assign('data', $data);
        $this->display();

    }


}
