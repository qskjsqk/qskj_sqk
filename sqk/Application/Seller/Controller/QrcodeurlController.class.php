<?php

/**
 * @name QrcodeurlController
 * @info 描述：二维码地址模块
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 12:07:00
 */

namespace Seller\Controller;

use Think\Controller;
use Think\Tool\GenerateUnique;
use Seller\Controller\BaseController;
use Think\Tool\Request;
use Seller\Model\SellerInfoModel;
use Seller\Model\SellerIntegralGoodsModel;
use Seller\Model\ExchangeRecordModel;
use Seller\Model\TradingRecordModel;
use Admin\Model\SysUserappInfoModel;

class QrcodeurlController extends BaseController {

    protected $config;

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 扫描商家二维码
     */
    public function scan_user() {
        $request = Request::all();

        $iccard_num = $request['iccard_num'];
        //假设这里扫描用户的二维码拿到下面的值
        //$iccard_num = '1362913101';
        //判断用户是否存在
        $appUserInfo = M('sys_userapp_info')->where('iccard_num=' . $iccard_num . ' or tel=' . $iccard_num)->find();
        if (empty($appUserInfo)) {

            $this->error("该用户异常！", U("seller/seller_home"), 3);
        }

        $seller_id = cookie('seller_id');

        $this->redirect('seller_detail?seller_id=' . $seller_id . '&user_id=' . $appUserInfo['id']);
    }

    public function goods_detail() {
        $id = $_GET['id'];
        $where['id'] = ['EQ', $id];
        $goodInfo = M('seller_integral_goods')->where($where)->find();
        $sellerInfo = M('seller_info')->where('id=' . $goodInfo['seller_id'])->find();
        $sellerInfo['address_name'] = getConameById($sellerInfo['address_id']);
        $this->assign('goodInfo', $goodInfo);
        $this->assign('sellerInfo', $sellerInfo);

        $appUserModel = new SysUserappInfoModel();
        $this->assign('app_user_id', $_GET['user_id']);

//        dump($sellerInfo);
        $this->display();
    }

    public function seller_detail() {
//        $request = Request::all();

        $seller_id = $_GET['seller_id'];
        $user_id = $_GET['user_id'];

        if (empty($seller_id) || empty($user_id)) {
            $this->redirect('seller/seller_home');
        }

        $sellerModel = new SellerInfoModel();
        $goodsModel = new SellerIntegralGoodsModel();
        $appUserModel = new SysUserappInfoModel();

        //用户信息
        $appUserInfo = $appUserModel->where(['id' => $user_id])->find();

        //查询商家信息
        $sellerInfo = $sellerModel->where(['id' => $seller_id])->find();
        $sellerInfo['com_name'] = getConameById($sellerInfo['address_id']);

        //查询积分商品信息
        $join = [
            ['seller_info', 'id', 'seller_integral_goods', 'seller_id'],
        ];
        $field = ['seller_integral_goods.*', 'seller_info.name as seller_name'];

        //用户只能看到已发布的商品
        $where[$this->dbFix . 'seller_integral_goods.status'] = 1;
        //只查询一个店的商品
        $where[$this->dbFix . 'seller_integral_goods.seller_id'] = $seller_id;

        //设置连表,查询信息
        $lists = $goodsModel
                ->joinFieldDB($join, $field, $where)
                ->group($this->dbFix . 'seller_integral_goods.id')
                ->order($this->dbFix . 'seller_integral_goods.id desc')
                ->select();

        $data = [
            'sellerInfo' => $sellerInfo,
            'goodsList' => $lists,
            'appUserInfo' => $appUserInfo,
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 商家扫码直接扣分
     */
    public function kouFenExchange() {
        $request = Request::all();
        $tradingModel = new TradingRecordModel();
        $request['seller_id'] = cookie('seller_id');
        $request['user_id'] = $request['app_user_id'];

        if (empty($request['trading_integral']) || empty($request['seller_id']) || empty($request['user_id'])) {
            $this->ajaxReturn(syncData(-1, '提交有误'));
        }

        $res = $tradingModel->addRecord($request);

        if ($res['ret'] == 0) {
            //提醒消息
            $sellerWx = M('seller_wechat_binding')->where('seller_id=' . $request['seller_id'])->find();
            $sellerInfo = M('seller_info')->find($request['seller_id']);
            $incomeInfo = [
                'open_id' => $sellerWx['open_id'],
                'name' => $sellerInfo['name'],
                'type' => '[' . $sellerInfo['name'] . ']扫码直接收取',
                'io' => '收取',
                'exchange_integral' => $request['trading_integral'],
                'integral_num' => $sellerInfo['integral_num']
            ];
            sendTradingMsg($incomeInfo);
            $userWx = M('sys_userapp_info')->find($request['user_id']);
            $paymentInfo = [
                'open_id' => $userWx['wx_num'],
                'name' => $userWx['realname'],
                'type' => '[' . $sellerInfo['name'] . ']扫码直接收取',
                'io' => '消费',
                'exchange_integral' => $request['trading_integral'],
                'integral_num' => $userWx['integral_num']
            ];
            sendTradingMsg($paymentInfo);
        }



        $this->ajaxReturn($res);
    }

    /**
     * 商品交易
     */
    public function exchangeGoods() {
        $request = Request::all();
        $exchangeModel = new ExchangeRecordModel();
        $request['user_id'] = $request['app_user_id'];
        $request['seller_id'] = cookie('seller_id');

        if (empty($request['exchange_integral']) || empty($request['seller_id']) || empty($request['user_id']) || empty($request['goods_id']) || empty($request['book_num'])) {
            $this->ajaxReturn(syncData(-1, '提交有误'));
        }

        $res = $exchangeModel->addRecord($request);

        if ($res['ret'] == 0) {
            //提醒消息
            $sellerWx = M('seller_wechat_binding')->where('seller_id=' . $request['seller_id'])->find();
            $sellerInfo = M('seller_info')->find($request['seller_id']);
            $incomeInfo = [
                'open_id' => $sellerWx['open_id'],
                'name' => $sellerInfo['name'],
                'type' => '[' . $sellerInfo['name'] . ']扫码兑换商品',
                'io' => '收取',
                'exchange_integral' => $request['exchange_integral'],
                'integral_num' => $sellerInfo['integral_num']
            ];
            sendTradingMsg($incomeInfo);
            $userWx = M('sys_userapp_info')->find($request['user_id']);
            $paymentInfo = [
                'open_id' => $userWx['wx_num'],
                'name' => $userWx['realname'],
                'type' => '[' . $sellerInfo['name'] . ']扫码兑换商品',
                'io' => '消费',
                'exchange_integral' => $request['exchange_integral'],
                'integral_num' => $userWx['integral_num']
            ];
            sendTradingMsg($paymentInfo);
        }

//
        $this->ajaxReturn($res);
    }

}
