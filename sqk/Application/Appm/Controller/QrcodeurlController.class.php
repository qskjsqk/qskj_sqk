<?php

/**
 * @name QrcodeurlController
 * @info 描述：二维码地址模块
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 12:07:00
 */

namespace Appm\Controller;

use Think\Controller;
use Appm\Controller\BaseController;

class QrcodeurlController extends BaseController {

    protected $config;

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 扫描商家二维码
     */
    public function scan_seller() {
        $wx['headimgurl'] = "http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKpN65upRlsfibjY7Lia7l1v99lf7kOAp6tNe2Oa0X07yR0Pqun2tLcwGXyrrR08tMavSIBVblnOhLA/132";
        $wx['openid'] = "ozF060wIC0F5P5GLlrfw0OEMpeGM";
        $wx['nickname'] = "忘忧草";
        cookie('wxInfo', $wx, 3600 * 24 * 30);

        //判断用户是否存在

        $seller_id = $_GET['id'];

        $this->redirect('seller_detail?id=' . $seller_id);
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

        $id = $_GET['id'];
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
        $where[$this->dbFix . 'seller_integral_goods.seller_id'] = $id;

        //设置连表,查询信息
        $lists = $model->joinDB($model, $join)->fieldDB($model, $field);

        $listsObj = $lists->whereDB($lists, $where)->group($this->dbFix . 'seller_integral_goods.id');
        $lists = $listsObj->order($this->dbFix . 'seller_integral_goods.id desc')->select();

        $this->assign('goodsList', $lists);

//        dump($sellerInfo);
        $this->display();
    }

    public function InsertComplaint() {
        $post = getFormData();
        if ($post['user_id'] != 0) {
            $returnData['flag'] = 1;
            $flag = M('seller_complaint')->add($post);
            if ($flag) {
                $returnData['flag'] = 1;
                $returnData['msg'] = '已经收到您的反馈！';
            } else {
                $returnData['flag'] = 0;
                $returnData['msg'] = '提交失败，请重试！';
            }
        } else {
            $returnData['flag'] = 0;
            $returnData['msg'] = '用户未登录！';
        }
//        dump($);
        $this->ajaxReturn($returnData, 'JSON');
    }

}
