<?php
/**
 * @name SellerIntegralGoodsModel
 * @info 描述：积分商品表模型
 * @author xiaohuihui
 * @datetime 2018-4-24 17:59:13
 */
namespace Admin\Model;
use Think\Model;
use Admin\Model\BaseModel;

class SellerIntegralGoodsModel extends BaseModel {

    public $tableName = 'seller_integral_goods' ;

    protected $patchValidate = true;

    public function getIntegralGoodsCount($isAll = true) {
        //未发布商品后台管理员看不到
        $where['status'] = ['neq', 0];
        if($isAll == false && !empty(session('address_id'))) {
            $where['address_id'] = session('address_id');
        }
        return $this->where($where)->count();
    }


}