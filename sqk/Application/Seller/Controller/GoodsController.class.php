<?php

/**
 * @name GoodsController
 * @info 描述：商家积分商品模块
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 11:06:00
 */

namespace Seller\Controller;

use Think\Controller;
use Seller\Controller\BaseController;
use Think\Tool\Request;
use Seller\Model\SellerIntegralGoodsModel;
use Seller\Model\SellerInfoModel;
use Seller\Model\ExchangeRecordModel;

class GoodsController extends BaseController {

    protected $config;

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 解析url地址中的参数返回数组
     * @access protected
     * @param  string     $paramStr  url地址
     * @return array
     */
    protected static function convertUrlPath($paramStr) {
        $parseUrl = parse_url($paramStr);
        $queryParts = explode('&', $parseUrl['path']);
        $params = [];
        foreach($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

    /**
     * 商家积分商品列表页
     */
    public function goods_manage() {
        $request = Request::all();
        $goodsModel = new SellerIntegralGoodsModel();
        $sellerModel = new SellerInfoModel();
        $seller_id = cookie('seller_id');
        $data = [
            'sellerInfo' => $sellerModel->find($seller_id),
            'exchangeCount' => $goodsModel->getSellerExchangeCount($seller_id),
            'goodsCount' => $goodsModel->getGoodsCount($seller_id),
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 商家积分商品添加页
     */
    public function goods_add() {
        $goodsCatModel = new \Admin\Model\SellerIntegralGoodsCatModel();
        $data = [
            'catLists' => $goodsCatModel->select(),
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 商家积分商品详情页
     */
    public function goods_detail() {
        $request = Request::all();
        $goodsModel = new SellerIntegralGoodsModel();
        $exchangeModel = new ExchangeRecordModel();
        $join = [
            ['sys_userapp_info', 'id', 'goods_exchange_record', 'user_id'],
        ];
        $field = ['goods_exchange_record.*', 'sys_userapp_info.realname'];
        $where[$this->dbFix . 'goods_exchange_record.goods_id'] = $request['goods_id'];

        $exchangeLists = $exchangeModel->joinFieldDB($join, $field, $where)->select();
        $data = [
            'goodsInfo' => $goodsModel->find($request['goods_id']),
            'exchangeLists' => $exchangeLists,
            'exchangeCount' => count($exchangeLists),
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 异步获取商家积分商品列表
     */
    public function getList() {
        $goodsModel = new SellerIntegralGoodsModel();
        $seller_id = cookie('seller_id');
        $request = Request::all();

       $num = C('PAGE_NUM')['goods'] * $request['page'];

        $join = [
            ['goods_exchange_record', 'goods_id', 'seller_integral_goods', 'id'],
            ['seller_info', 'id', 'seller_integral_goods', 'seller_id'],
        ];
        $field = ['seller_integral_goods.*', 'seller_info.name as seller_name'];

        $lists = $where = $data = [];

        //设置连表,查询信息
        $lists = $goodsModel->joinDB($goodsModel, $join)->fieldDB($goodsModel, $field);

        //属于当前商家
        $where[$this->dbFix . 'seller_integral_goods.seller_id'] = $seller_id;

        //关键字搜索:积分商品名称模糊搜索
        if(!empty($request['keyword'])) {
            $map[$this->dbFix . 'seller_integral_goods.goods_name'] = array('LIKE', '%' . urldecode($request['keyword']) . '%');
            $map['_logic'] = 'or';
            $where['_complex'] = $map;
        }

        //积分商品状态
        if(!empty($request['status'])) {
            $where[$this->dbFix . 'seller_integral_goods.status'] = SellerIntegralGoodsModel::getGoodsStatusByName($request['status']);
        }

        //没有任何条件:页面载入
        $lists = $lists->whereDB($lists, $where)
            ->group($this->dbFix .'seller_integral_goods.id')
            ->order($this->dbFix .'seller_integral_goods.id desc')
            ->select();
        //echo $goodsModel->getLastSql();
        $count = count($lists);
        if($num < $count) {
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
        ];
        $this->ajaxReturn(syncData(0, 'success', $data));
    }

    /**
     * 添加积分商品
     */
    public function addGoods() {
        $goodsModel = new SellerIntegralGoodsModel();
        $request = Request::all();
        $param = self::convertUrlPath($request['data']);
        if($goodsModel->addGoods($param)) {
            $this->ajaxReturn(syncData(0, '添加成功'));
        } else {
            $this->ajaxReturn(syncData(-1, '添加失败'));
        }
    }

    /**
     * 验证商家输入的商品编号是否已经存在
     */
    public function checkGoodsNumberIsExist() {
        $request = Request::all();
        $goodsModel = new SellerIntegralGoodsModel();
        $res = $goodsModel->where(['goods_number' => trim($request['goodsNumber'])])->select();
        if(!empty($res)) {
            $this->ajaxReturn(syncData(0, '已经存在'));
        } else {
            $this->ajaxReturn(syncData(-1, '不存在'));
        }
    }

    /**
     * 商家积分商品编辑页
     */
    public function goods_edit() {
        $request = Request::all();
        $goodsInfo = (new SellerIntegralGoodsModel())->find($request['goods_id']);
        $goodsInfo['statusDesc'] = SellerIntegralGoodsModel::translateGoodsStatus($goodsInfo['status'])['desc'];
        $data = [
            'goodsInfo' => $goodsInfo,
            'catLists' => (new \Admin\Model\SellerIntegralGoodsCatModel())->select(),
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 修改积分商品
     */
    public function editGoods() {
        $goodsModel = new SellerIntegralGoodsModel();
        $request = Request::all();
        $param = self::convertUrlPath($request['data']);
        if($goodsModel->editGoods($param)) {
            $this->ajaxReturn(syncData(0, '修改成功'));
        } else {
            $this->ajaxReturn(syncData(-1, '修改失败'));
        }
    }

    /**
     * 商品下架
     */
    public function lowerFrameGoods() {
        $goodsModel = new SellerIntegralGoodsModel();
        $request = Request::all();
        $res = $goodsModel->where(['id' => $request['goods_id']])->save(['status' => $request['type']]);
        if($res) {
            $this->ajaxReturn(syncData(0, '操作成功'));
        } else {
            $this->ajaxReturn(syncData(-1, '操作失败'));
        }
    }



}
