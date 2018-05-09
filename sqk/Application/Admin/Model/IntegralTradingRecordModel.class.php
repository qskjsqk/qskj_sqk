<?php
/**
 * @name IntegralTradingRecordModel
 * @info 描述：交易表模型
 * @author xiaohuihui
 * @datetime 2018-5-9 11:54:08
 */
namespace Admin\Model;
use Think\Model;
use Admin\Model\SysUserappInfoModel;

class IntegralTradingRecordModel extends Model {

    public $tableName  = 'integral_trading_record';

    protected $patchValidate = true;


    /**
     * 社区和用户交易
     * @accesss public
     * @param  string     $iccardNum          卡号
     * @param  integer    $tradingIntegral    交易积分
     * @return integer
     */
    public function addTradingRecord($iccardNum, $tradingIntegral) {
        $appUserModel = new SysUserappInfoModel();
        $appUserInfo = $appUserModel->where(['iccard_num' => $iccardNum])->find();

        //如果当前用户积分比要交易的积分小
        if($appUserInfo['integral_num'] < $tradingIntegral) {
            return -1;
        }

        $trading_time = date("Y-m-d H:i:s", time());
        $this->income_id = $appUserInfo['address_id'];
        $this->payment_id = $appUserInfo['id'];
        $this->income_type = 1;     //收款方用户类型  0管理员  1社区  2商家  3用户
        $this->payment_type = 3;     //付款方用户类型  0管理员  1社区  2商家  3用户
        $this->trading_integral = $tradingIntegral;
        $this->trading_time = $trading_time;
        $this->exchange_method_id = 4;

        //交易入库
        $addTradingRecordRes = $this->add();
        //用户积分减少
        $appUserReduceIntegralRes = $appUserModel->where(['id' => $appUserInfo['id']])->setDec('integral_num', $tradingIntegral);

        if($addTradingRecordRes && $appUserReduceIntegralRes) {
            //修改交易状态为1(交易成功)
            $this->where(['id' => $addTradingRecordRes])->save(['status' => 1]);
            return [
                'id' => $addTradingRecordRes,
                'user' => $appUserInfo['usr'],
                'trading_integral' => $tradingIntegral,
                'trading_time' => $trading_time,
            ];
        } else {
            return -2;
        }

    }
}