<?php

/**
 * @name SellerIntegralGoodsController
 * @info 描述：用户端积分商品模块
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 12:07:00
 */

namespace Dxt\Controller;

use Think\Controller;
use Dxt\Controller\BaseController;
use Think\Tool\Request;
use Dxt\Model\SysUserappInfoModel;

class SellerIntegralGoodsController extends BaseController {

    protected $config;

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 积分商城列表页
     */
    public function item_list() {
        $this->assign('address_id', cookie('address_id'));
        //广告轮播图
        $promC = A('Seller');
        $sliderData = $promC->getSlider();
        $this->assign('sliderData', $sliderData);

        $appUserModel = new SysUserappInfoModel;
        $this->assign('userIntegralNum', $appUserModel->where(['id' => cookie('user_id')])->getField('integral_num'));

        $this->display();
    }

    /**
     * 获取列表接口
     */
    public function getList() {
        $model = D('SellerIntegralGoods');
        $user_id = cookie('user_id');
        $address_id = cookie('address_id');
        $request = Request::all();

        $num = C('PAGE_NUM')['goods'] * $request['page'];

        $join = [
            ['seller_info', 'id', 'seller_integral_goods', 'seller_id'],
            ['sys_community_info', 'id', 'seller_integral_goods', 'address_id'],
        ];
        $field = ['seller_integral_goods.*', 'seller_info.name as seller_name', 'sys_community_info.com_name'];

        $lists = $where = $data = [];
        //用户只能看到已发布的商品
        $where[$this->dbFix . 'seller_integral_goods.status'] = 1;

        //设置连表,查询信息
        $lists = $model->joinDB($model, $join)->fieldDB($model, $field);

        //关键字搜索:商家名称或者积分商品名称模糊搜索
        if (!empty($request['keyword'])) {
            $map[$this->dbFix . 'seller_info.name'] = array('LIKE', '%' . urldecode($request['keyword']) . '%');
            $map[$this->dbFix . 'seller_integral_goods.goods_name'] = array('LIKE', '%' . urldecode($request['keyword']) . '%');
            $map['_logic'] = 'or';
            $where['_complex'] = $map;
        }

        //有筛选条件
        if (!empty($request['orderBy']) || !empty($request['address']) || !empty($request['cat_type'])) {

            //积分商品类型
            if (!empty($request['cat_type'])) {
                $where[$this->dbFix . 'seller_integral_goods.cat_id'] = $request['cat_type'];
            }

            //离我最近(默认本社区)和商家地点(本社区)同时选中
            if ($request['orderBy'] == 'distance') {
                $where[$this->dbFix . 'seller_integral_goods.address_id'] = $address_id;
            } elseif ($request['orderBy'] == 'welcome') {    //选中最受欢迎
                if ($request['address'] == 'current') {
                    //当前社区最受欢迎(兑换次数最多的商品)
                    $where[$this->dbFix . 'seller_integral_goods.address_id'] = $address_id;
                }
                $lists = $lists->order($this->dbFix . 'seller_integral_goods.exchange_times desc');
            }else{
                //第一个筛选   不选
                if ($request['address'] == 'current') {
                    //当前社区最受欢迎(兑换次数最多的商品)
                    $where[$this->dbFix . 'seller_integral_goods.address_id'] = $address_id;
                }
                $lists = $lists->order($this->dbFix . 'seller_integral_goods.exchange_times desc');
            }
        }

        //没有任何条件:页面载入
        $lists = $lists->whereDB($lists, $where)
            ->order($this->dbFix . 'seller_integral_goods.id desc')
            ->limit($num)
            ->select();
        //echo $model->getLastSql();
        $count = D('SellerIntegralGoods')->joinFieldDB($join, $field, $where)->count();
        if ($num < $count) {
            $ajaxLoad = '点击加载更多';
            $isEnd = 0;
        } else {
            $ajaxLoad = '已加载全部';
            $isEnd = 1;
        }
        $data = [
            'ajaxLoad' => $ajaxLoad,
            'is_end' => $isEnd,
            'where' => $request,
            'lists' => $lists,
            'isEmpty' => !empty($lists) ? 1 : 0,
            'dd' => $num
        ];
        $this->ajaxReturn(syncData(0, 'success', $data));
    }

    /**
     * 商品详情
     */
    public function goods_detail() {
        $id = $_GET['id'];
        $where['id'] = ['EQ', $id];
        $goodInfo = M('seller_integral_goods')->where($where)->find();
        $sellerInfo = M('seller_info')->where('id=' . $goodInfo['seller_id'])->find();
        $sellerInfo['address_name'] = getConameById($sellerInfo['address_id']);
        $this->assign('goodInfo', $goodInfo);
        $this->assign('sellerInfo', $sellerInfo);
//        dump($goodInfo);
        $this->display();
    }

    /**
     * 商家详情
     */
    public function seller_detail() {
        
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

    /**
     * 提交入库反馈信息
     */
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
