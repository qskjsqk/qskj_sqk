<?php
/**
 * @name TradingRecordModel
 * @info 描述：交易记录总表 Model
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-05-10 17:29:00
 */

namespace Seller\Model;
use Think\Model;
use Admin\Model\BaseModel;
use Admin\Model\SysUserappInfoModel;
use Seller\Model\SellerInfoModel;

class TradingRecordModel extends BaseModel {

    public $tableName  = 'integral_trading_record';


    public function addRecord($param) {
        $appUserModel = new SysUserappInfoModel();
        $sellerModel = new SellerInfoModel();

        $appUserInfo = $appUserModel->where(['id' => $param['user_id']])->find();
        $sellerInfo = $sellerModel->where(['id' => $param['seller_id']])->find();

        if(empty($appUserInfo) || empty($sellerInfo)) {
            return syncData(-2, '用户或商家信息有误');
        } elseif($appUserInfo['integral_num'] < $param['trading_integral']) {
            return syncData(-3, '用户积分不足以支付');
        }

        $tradingTime = date("Y-m-d H:i:s", time());
        $tradingNumber = \Think\Tool\GenerateUnique::generateExchangeNumber();

        $this->startTrans(); // 开启事务
        //入交易总表
        $addTradingRes = $this->add([
            'income_id' => $param['seller_id'],
            'payment_id' => $param['user_id'],
            'income_type' => 2,
            'payment_type' => 3,
            'trading_integral' => $param['trading_integral'],
            'trading_time' => $tradingTime,
            'exchange_method_id' => 2,  //商家扫码扣分交易
            'trading_number' => $tradingNumber,
            'status' => 1,
        ]);

        //更新用户积分
        $appUserReduceRes = $appUserModel->where(['id' => $param['user_id']])->setDec('integral_num', $param['trading_integral']);

        //更新商家积分和经验值
        $sellerAddRes = $sellerModel->where(['id' => $param['seller_id']])
            ->save([
                'integral_num' => $sellerInfo['integral_num'] + $param['trading_integral'],
                'exp_num' => $sellerInfo['exp_num'] + $param['trading_integral'],
            ]);

        if($addTradingRes && $appUserReduceRes && $sellerAddRes) {
            $this->commit(); // 成功则提交事务
            $data = [
                'tradingNumber' => $tradingNumber,
                'sellerName' => $sellerInfo['name'],
                'appUserName' => $appUserInfo['realname'],
                'tradingIntegral' => $param['trading_integral'],
                'tradingTime' => $tradingTime,
            ];
            return syncData(0, '交易成功', $data);
        } else {
            $this->rollback(); // 否则将事务回滚
            return syncData(-4, '交易失败');
        }
    }

}
