<?php
/**
 * @name SellerIntegralGoodsModel
 * @info 描述：商家积分 Model
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 10:59:00
 */

namespace Seller\Model;
use Think\Model;
use Admin\Model\BaseModel;
use Seller\Model\SellerInfoModel;
use Think\Tool\GenerateUnique;

class SellerIntegralGoodsModel extends BaseModel {

    public $tableName  = 'seller_integral_goods';

    protected $catId = [0, 1, 2, 3];

    //积分商品状态配置
    public static $statusMap = [
        0 => ['name' => 'not_publish', 'desc' => '未发布'],
        1 => ['name' => 'already_publish', 'desc' => '已发布'],
        2 => ['name' => 'lower_frame', 'desc' => '已下架'],
    ];

    /**
     * 根据积分商品状态status获取状态描述
     * @param  integer   $status  状态值
     * @return array
     */
    public static function translateGoodsStatus($status) {
        foreach(self::$statusMap as $key => $val) {
            if($key == $status) {
                return $val;
            }
        }
    }

    /**
     * 根据积分商品状态name反向获取status
     * @param  integer   $name  状态name
     * @return integer
     */
    public static function getGoodsStatusByName($name) {
        foreach(self::$statusMap as $key => $val) {
            if($val['name'] == $name) {
                return $key;
            }
        }
    }

    /**
     * 获取商家积分商品数量
     * @param integer   $seller_id  商家id
     * @return integer
     */
    public function getGoodsCount($seller_id) {
        $where = ['seller_id' => $seller_id];
        $catCount = [];
        foreach($this->catId as $val) {
            if($val != 0) {
                $where['cat_id'] = $val;
            }
            $catCount[$val] = $this->where($where)->count();
        }
        $data =  [
            'allCount' => $catCount[0],
            'jiajiaGouCount' => $catCount[1],
            'jifenHuanCount' => $catCount[2],
            'juanMaCount' => $catCount[3],
        ];
        return $data;
    }

    /**
     * 获取商家兑换次数
     * @param integer   $seller_id  商家id
     * @return integer
     */
    public function getSellerExchangeCount($seller_id) {
        return $this->where(['seller_id' => $seller_id])->sum('exchange_times');
    }

    /**
     * 商家添加积分商品
     * @param   array   $param  入参
     * @return boolean
     */
    public function addGoods($param) {
        $sellerModel = new SellerInfoModel();
        $attachModel = M(C('DB_ALL_ATTACH'));

        $this->goods_name = urldecode($param['goods_name']);
        $this->cat_id = $param['cat_id'];
        //选择劵码:手动填写编号
        if($param['cat_id'] == 3) {
            $this->goods_number = $param['goods_number'];
        } else {
            //系统自动生成编号
            $this->goods_number = GenerateUnique::generateGoodsNumber();
        }
        //积分换不需要支付价
        if($param['cat_id'] != 2) {
            $this->payment_amount = $param['payment_amount'];
        }
        $this->stock = $param['stock'];
        $this->required_integral = $param['required_integral'];
        $this->original_price = $param['original_price'];
        $this->exchange_limit_number = !empty($param['exchange_limit_number']) ? $param['exchange_limit_number'] : 0;
        $this->user_exchange_limit = !empty($param['user_exchange_limit']) ? $param['user_exchange_limit'] : 0;
        $this->goods_detail = !empty($param['goods_detail']) ? urldecode($param['goods_detail']) : '';
        $this->use_of_knowledge = !empty($param['use_of_knowledge']) ? urldecode($param['use_of_knowledge']) : '';
        $this->goods_pic = $attachModel->where(['id' => $param['goods_pic']])->getField('file_path');   //从附件表获取路径

        $this->address_id = $sellerModel->find(cookie('seller_id'))['address_id'];
        $this->seller_id = cookie('seller_id');
        $this->creater_id = cookie('seller_id');
        $this->add_time = date("Y-m-d H:i:s", time());

        //选中发布
        if($param['is_publish'] == 'yes') {
            $this->public_time = date("Y-m-d H:i:s", time());
            $this->status = 1;
        }

        if($this->add()) {
            //删除附件表中数据
            $attachModel->where(['id' => $param['goods_pic']])->delete();
            return true;
        } else {
            return false;
        }
    }

    /**
     * 商家修改积分商品
     * @param   array   $param  入参
     * @return boolean
     */
    public function editGoods($param) {
        $sellerModel = new SellerInfoModel();
        $attachModel = M(C('DB_ALL_ATTACH'));

        $goodsInfo = $this->find($param['goods_id']);

        $data['goods_name'] = urldecode($param['goods_name']);
        $data['cat_id'] = $param['cat_id'];
        //积分换不需要支付价
        if($param['cat_id'] != 2) {
            $data['payment_amount'] = $param['payment_amount'];
        } else {
            $data['payment_amount'] = 0;
        }
        $data['stock'] = $param['stock'];
        $data['required_integral'] = $param['required_integral'];
        $data['original_price'] = $param['original_price'];
        $data['exchange_limit_number'] = !empty($param['exchange_limit_number']) ? $param['exchange_limit_number'] : 0;
        $data['user_exchange_limit'] = !empty($param['user_exchange_limit']) ? $param['user_exchange_limit'] : 0;
        $data['goods_detail'] = !empty($param['goods_detail']) ? urldecode($param['goods_detail']) : '';
        $data['use_of_knowledge'] = !empty($param['use_of_knowledge']) ? urldecode($param['use_of_knowledge']) : '';

        $isNewPic = $attachModel->where(['id' => $param['goods_pic']])->getField('file_path');
        $data['goods_pic'] = !empty($isNewPic) ? $isNewPic : $goodsInfo['goods_pic'];

        //修改状态
        if(!empty($param['status'])) {
            if($param['status'] == 'already_publish') {
                $data['status'] = 1;
            } elseif($param['status'] == 'lower_frame') {
                $data['status'] = 2;
            }
        }

        if($this->where(['id' => $param['goods_id']])->save($data)) {
            //删除附件表中数据
            if(!empty($isNewPic))  $attachModel->where(['id' => $param['goods_pic']])->delete();
            return true;
        } else {
            return false;
        }
    }


}
