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

class SellerIntegralGoodsModel extends BaseModel {

    public $tableName  = 'seller_integral_goods';

    protected $_validate = [

    ];

    /**
     * 获取商家积分商品数量
     * @param integer   $seller_id  商家id
     * @param integer   $cat_type   积分商品类型id
     * @return integer
     */
    public function getGoodsCount($seller_id, $cat_type = 0) {
        $where = ['seller_id' => $seller_id];
        if(!empty($cat_type)) {
            $where['cat_id'] = $cat_type;
        }
        return $this->where($where)->count();

    }

}
