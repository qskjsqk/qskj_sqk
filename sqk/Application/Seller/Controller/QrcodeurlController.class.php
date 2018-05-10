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

class QrcodeurlController extends BaseController {

    protected $config;

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 扫描商家二维码
     */
    public function scan_user() {

//        假设这里扫描用户的二维码拿到下面的值

        $iccard_num = '1363783069';

        //判断用户是否存在----------辉总写这里的逻辑


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
        //不管有没有分配上
        $this->assign('user_id', cookie('user_id'));

        $seller_id = $_GET['seller_id'];
        //查询商家信息
        $where['id'] = ['EQ', $id];
        $sellerInfo = M('seller_info')->where($where)->find();
        $sellerInfo['address_name'] = getConameById($sellerInfo['address_id']);
        $this->assign('sellerInfo', $sellerInfo);

        //分配反馈类型信息
        $this->assign('compalintCat', M('seller_complaint_cat')->select());

        //查询产品信息
        $model = D('SellerIntegralGoods');
        $join = [
            ['goods_exchange_record', 'goods_id', 'seller_integral_goods', 'id'],
            ['seller_info', 'id', 'seller_integral_goods', 'seller_id'],
            ['sys_community_info', 'id', 'seller_integral_goods', 'address_id'],
        ];
        $field = ['seller_integral_goods.*', 'seller_info.name as seller_name', 'sys_community_info.com_name'];

        $lists = $where = $data = [];
        //用户只能看到已发布的商品
        $where[$this->dbFix . 'seller_integral_goods.status'] = 1;
        //只查询一个店的商品
        $where[$this->dbFix . 'seller_integral_goods.seller_id'] = $seller_id;

        //设置连表,查询信息
        $lists = $model->joinDB($model, $join)->fieldDB($model, $field);

        $listsObj = $lists->whereDB($lists, $where)->group($this->dbFix . 'seller_integral_goods.id');
        $lists = $listsObj->order($this->dbFix . 'seller_integral_goods.id desc')->select();

        $this->assign('goodsList', $lists);

//        dump($sellerInfo);
        $this->display();
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
