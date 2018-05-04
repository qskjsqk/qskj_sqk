<?php
/**
 * @name GoodsExchangeRecordModel
 * @info 描述：积分商品兑换表模型
 * @author xiaohuihui
 * @datetime 2018-4-26 18:55:13
 */
namespace Appm\Model;
use Think\Model;
use Admin\Model\BaseModel;

class GoodsExchangeRecordModel extends BaseModel {

    public $tableName = 'goods_exchange_record' ;

    protected $patchValidate = true;

    /**
     * 获取交易次数最多的积分商品
     *
     * @access public
     * @param
     * @return
     */
    public function getMaxExchangeCountOfGoods() {
        $this->dbFix = C('DB_PREFIX');

    }


}