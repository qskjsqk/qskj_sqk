<?php
/**
 * @name SellerComplaintModel
 * @info 描述：商家反馈信息表模型
 * @author xiaohuihui
 * @datetime 2018-4-21 19:56:13
 */
namespace Admin\Model;
use Think\Model;
use Admin\Model\BaseModel;

class SellerComplaintModel extends BaseModel {

    public $tableName = 'seller_complaint' ;

    protected $patchValidate = true;

    //获取未处理反馈信息数量
    public function getSellerComplaintCount() {
        //未处理状态的反馈信息
        $where['status'] = 0;
        if (session('sys_name') == 'sqAdmin') {
            $where['address_id'] = session('address_id');
        }
        return $this->where($where)->count();
    }

    //根据商家id获取未处理反馈信息数量
    public function getSellerComplaintCountById($seller_id) {
        $where = [
            'status' => 0,
            'seller_id' => $seller_id,
        ];
        return $this->where($where)->count();
    }


}