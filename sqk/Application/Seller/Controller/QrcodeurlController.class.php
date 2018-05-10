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
        //假设这里扫描用户的二维码拿到下面的值
        $iccard_num = $request['iccard_num'];
        $iccard_num = '1362913101';

        //判断用户是否存在
        $appUserModel = new SysUserappInfoModel();
        if(empty($appUserModel->where(['iccard_num' => $iccard_num])->find())) {
            $this->redirect('goods/goods_manage');
        }

        $seller_id = cookie('seller_id');
        $this->redirect('seller_detail?seller_id=' . $seller_id . '&iccard_num=' . $iccard_num);
    }

    public function goods_detail() {
        $id = $_GET['id'];
        $where['id'] = ['EQ', $id];
        $goodInfo = M('seller_integral_goods')->where($where)->find();
        $sellerInfo = M('seller_info')->where('id=' . $goodInfo['seller_id'])->find();
        $sellerInfo['address_name'] = getConameById($sellerInfo['address_id']);
        $this->assign('goodInfo', $goodInfo);
        $this->assign('sellerInfo', $sellerInfo);
//        dump($sellerInfo);
        $this->display();
    }

    public function seller_detail() {
        $request = Request::all();

        $seller_id = $request['seller_id'];
        $iccard_num = $request['iccard_num'];

        if(empty($seller_id) || empty($iccard_num)) {
            $this->redirect('goods/goods_manage');
        }

        $sellerModel = new SellerInfoModel();
        $goodsModel = new SellerIntegralGoodsModel();
        $appUserModel = new SysUserappInfoModel();

        //用户信息
        $appUserInfo = $appUserModel->where(['iccard_num' => $iccard_num])->find();

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

    public function kouFenExchange() {
        $request = Request::all();
        $request['seller_id'] = cookie('seller_id');

        $request['user_id'] = $request['app_user_id'];

        if(empty($request['trading_integral'])|| empty($request['seller_id']) || empty($request['user_id'])) {
            $this->ajaxReturn(syncData(-1, '提交有误'));
        }

        //交易方式
        $request['exchange_method_id'] = 2;
        $tradingModel = new TradingRecordModel();
        $res = $tradingModel->addRecord($request);
        $this->ajaxReturn($res);

    }

    /**
     * 商品交易   方法未写完-----------------------------------------------------
     */
    public function exchangeGoods() {
        //入库商品交易表
        $addArr = $_POST;
        $addArr['user_id'] = cookie('user_id');
        $addArr['exchange_number'] = \Think\Tool\GenerateUnique::generateExchangeNumber();
        $addArr['exchange_method_id'] = 2;
        $addArr['status'] = 1;

        $tranModel = M();

        $tranModel->startTrans(); // 开启事务  

        if ($flag) {
            $tranModel->commit(); // 成功则提交事务  
        } else {
            $tranModel->rollback(); // 否则将事务回滚  
        }



//        $relation_id = M('goods_exchange_record')->add($addArr);
//        if ($relation_id) {
//            //入库交易总表
//            $trandingData = [
//                'income_id' => $_POST['seller_id'],
//            ];
//            //用户积分减值
//            //商家用户增值
//        } else {
//            
//        }


        $this->ajaxReturn($relation_id, "JSON");
    }

}
