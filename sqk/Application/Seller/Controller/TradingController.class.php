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
        $exchangeLists['exchange_method'] = ExchangeRecordModel::getExchangeMethodById($exchangeLists['exchange_method_id']);
        $this->assign('data', $exchangeLists);
        //dd($exchangeLists);
        $this->display();
    }

}
