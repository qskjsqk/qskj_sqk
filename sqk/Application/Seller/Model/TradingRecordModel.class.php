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
        if(empty($appUserInfo)) {
            return syncData(-4, '用户信息有误');
        } elseif($appUserInfo['integral_num'] < $param['trading_integral']) {
            return syncData(-2, '用户积分不足以支付');
        }

        $this->startTrans(); // 开启事务

        if(!empty($param) && is_array($param)) {
            $this->income_id = $param['seller_id'];
            $this->payment_id = $param['user_id'];
            $this->income_type = 2;
            $this->payment_type = 3;
            $this->trading_integral = $param['trading_integral'];
            $this->trading_time = date("Y-m-d H:i:s", time());
            $this->exchange_method_id = $param['exchange_method_id'];
            $this->trading_number = \Think\Tool\GenerateUnique::generateExchangeNumber();
            //入交易总表
            $addTradingRes = $this->add();
            //用户扣积分
            $appUserReduceRes = $appUserModel->where(['id' => $param['user_id']])->setDec('integral_num', $param['trading_integral']);
            //商家加积分
            $sellerAddIntRes = $sellerModel->where(['id' => $param['seller_id']])->setInc('integral_num', $param['trading_integral']);
            //商家经验值增加
            $sellerAddNumRes = $sellerModel->where(['id' => $param['seller_id']])->setInc('exp_num', $param['trading_integral']);
            //修改交易状态:成功
            $changeStatusRes = $this->where(['id' => $addTradingRes])->save(['status' => 1]);
            if($addTradingRes && $appUserReduceRes && $sellerAddIntRes && $changeStatusRes && $sellerAddNumRes) {
                $this->commit(); // 成功则提交事务
                return syncData(0, '交易成功');
            } else {
                $this->rollback(); // 否则将事务回滚
                return syncData(-3, '交易失败');
            }
        } else {
            return syncData(-3, '交易失败');
        }
        return $res;
    }

}
