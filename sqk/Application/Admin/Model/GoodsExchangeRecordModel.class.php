<?php

/**
 * @name GoodsExchangeRecordModel
 * @info 描述：积分商品兑换表模型
 * @author xiaohuihui
 * @datetime 2018-4-26 18:55:13
 */

namespace Admin\Model;

use Think\Model;
use Admin\Model\BaseModel;

class GoodsExchangeRecordModel extends BaseModel {

    public $tableName = 'goods_exchange_record';
    protected $patchValidate = true;

    /**
     * 获取全镇/本社区交易次数和交易积分总和
     *
     * @access public
     * @param  boolean  $isAll   是否本镇全部: true:是; false=>否
     * @return array    交易次数和交易积分总和数组
     */
    public function getExchangeCount($isAll = true) {
        $this->dbFix = C('DB_PREFIX');
        if ($isAll == false && !empty(session('address_id'))) {
            $join = [
                ['seller_info', 'id', 'goods_exchange_record', 'seller_id'],
            ];
            $where[$this->dbFix . 'seller_info.address_id'] = session('address_id');
            $count = $this->joinFieldDB($join, [], $where)->count();
            $integral = $this->joinFieldDB($join, [], $where)->sum($this->dbFix .'goods_exchange_record.exchange_integral');
        } else {
            $count = $this->count();
            $integral = $this->sum('exchange_integral');
        }
        return [
            'count' => !empty($count) ? $count : 0, //交易次数
            'integral' => !empty($integral) ? $integral : 0, //交易积分总和
        ];
    }

}
