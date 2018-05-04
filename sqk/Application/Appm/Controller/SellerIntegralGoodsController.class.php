<?php

/**
 * @name SellerIntegralGoodsController
 * @info 描述：用户端积分商品模块
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 12:07:00
 */

namespace Appm\Controller;

use Think\Controller;
use Appm\Controller\BaseController;
use Think\Tool\Request;
use Admin\Model\SysUserappInfoModel;

class SellerIntegralGoodsController extends BaseController {

    protected $config;

    public function _initialize() {
        parent::_initialize();
    }

    public function item_list() {
        $this->assign('address_id', cookie('address_id'));
        $appUserModel = new SysUserappInfoModel;
        $this->assign('userIntegralNum', $appUserModel->where(['id' => cookie('user_id')])->getField('integral_num'));

        $this->display();
    }

    public function activity_detail() {
        $this->display();
    }

    /**
     * 获取列表
     */
    public function getList() {
        $user_id = cookie('user_id');
        $address_id = cookie('address_id');
        $request = Request::all();

        $num = C('PAGE_NUM')['goods'] * $request['page'];

        $join = [
            ['goods_exchange_record', 'goods_id', 'seller_integral_goods', 'id'],
            ['seller_info', 'id', 'seller_integral_goods', 'seller_id'],
            ['sys_community_info', 'id', 'seller_integral_goods', 'address_id'],
        ];
        $field = ['seller_integral_goods.*', 'seller_info.name as seller_name', 'sys_community_info.com_name'];

        $model = D('SellerIntegralGoods');
        $lists = $where = $data = [];

        //关键字搜索:商家名称或者积分商品名称模糊搜索
        if(!empty($request['keyword'])) {
            $map[$this->dbFix . 'seller_info.name'] = array('LIKE', '%' . urldecode($request['keyword']) . '%');
            $map[$this->dbFix . 'seller_integral_goods.goods_name'] = array('LIKE', '%' . urldecode($request['keyword']) . '%');
            $map['_logic'] = 'or';
            $where['_complex'] = $map;
        }

        //有筛选条件
        if(!empty($request['orderBy']) || !empty($request['address']) || !empty($request['cat_type'])) {

            //积分商品类型
            if(!empty($request['cat_type'])) {
                $where[$this->dbFix . 'seller_integral_goods.cat_id'] = $request['cat_type'];
            }

            //离我最近(默认本社区)和商家地点(本社区)同时选中
            if($request['orderBy'] == 'distance') {
                $where[$this->dbFix . 'seller_integral_goods.address_id'] = $address_id;
                $lists = $model->joinFieldDB($join, $field, $where)->limit($num)->select();
            } elseif($request['orderBy'] == 'welcome') {
                if($request['address'] == 'current') {
                    //当前社区最受欢迎(兑换次数最多的商品)
                    $where[$this->dbFix . 'seller_integral_goods.address_id'] = $address_id;
                }
                $lists = $model->joinFieldDB($join, $field, $where)->order($this->dbFix .'seller_integral_goods.exchange_times desc')->limit($num)->select();
            }
        } else {
            //没有任何条件:页面载入
            $lists = $model->joinFieldDB($join, $field, $where)->limit($num)->select();
        }
        //echo $model->getLastSql();
        $count = $model->joinFieldDB($join, $field, $where)->count();
        if($num < $count) {
            $ajaxLoad = '点击加载更多';
            $isEnd = 0;
        } else {
            $ajaxLoad = '已加载全部';
            $isEnd = 1;
        }
        $lists = arrayUniqueErwei($lists);
        $data = [
            'ajaxLoad' => $ajaxLoad,
            'is_end' => $isEnd,
            'where' => $request,
            'lists' => $lists,
            'isEmpty' => !empty($lists) ? 1 : 0,
        ];

        $this->ajaxReturn(syncData(0, 'success', $data));
    }

}
