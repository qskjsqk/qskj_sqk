<?php
/**
 * @name ExchangeRecordModel
 * @info 描述：积分商品兑换记录 Model
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-05-05 16:02:00
 */

namespace Seller\Model;
use Think\Model;
use Admin\Model\BaseModel;

class ExchangeRecordModel extends BaseModel {

    public $tableName  = 'goods_exchange_record';

    protected static $exchangeMethodMap = [
        ['method_id' => 1, 'name' => '商家扫码兑换' , 'desc' => '用户扫码商家二维码，进到商家，展示商家发布的积分商品，用户点击兑换，商家接到消息，交易成功'],
        ['method_id' => 2, 'name' => '用户扫码扣分' , 'desc' => '商家扫码用户二维码，跳转到输入扣分金额，点击扣分，用户接到消息，交易完成'],
        ['method_id' => 3, 'name' => '用户扫码兑换' , 'desc' => '商家扫码用户二维码，扣分框下面 有本商家的积分商品，点击兑换，用户接到消息，交易成功'],
    ];

    //根据数据库存的交易方式id字段获取交易方式
    public static function getExchangeMethodById($exchangeMethodId) {
        foreach(self::$exchangeMethodMap as $val) {
            if($val['method_id'] == $exchangeMethodId) {
                return $val['name'];
            }
        }
    }

}
