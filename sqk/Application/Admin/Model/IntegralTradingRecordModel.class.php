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
use Admin\Model\SysCommunityInfoModel;

class IntegralTradingRecordModel extends Model {

    public $tableName  = 'integral_trading_record';

    protected $patchValidate = true;


    /**
     * 社区和用户交易
     * @accesss public
     * @param  string     $iccardNum          卡号
     * @param  integer    $tradingIntegral    交易积分
     * @return mixed
     */
    public function addTradingRecord($iccardNum, $tradingIntegral) {
        $appUserModel = new SysUserappInfoModel();
        $communityModel = new SysCommunityInfoModel();
        $appUserInfo = $appUserModel->where(['iccard_num' => $iccardNum])->find();

        //ic卡号没有找到对应用户
        if(empty($appUserInfo)) {
            return -3;
        }

        //如果当前用户积分比要交易的积分小
        if($appUserInfo['integral_num'] < $tradingIntegral) {
            return -1;
        }

        $tradingNumber = \Think\Tool\GenerateUnique::generateExchangeNumber();
        $trading_time = date("Y-m-d H:i:s", time());

        $this->startTrans(); // 开启事务

        //交易入库
        $addTradingRecordRes = $this->add([
            'income_id' => $appUserInfo['address_id'],
            'payment_id' => $appUserInfo['id'],
            'income_type' => 1,     //收款方用户类型  0管理员  1社区  2商家  3用户
            'payment_type' => 3,    //付款方用户类型  0管理员  1社区  2商家  3用户
            'trading_integral' => $tradingIntegral,
            'trading_time' => $trading_time,
            'exchange_method_id' => 4,
            'trading_number' => $tradingNumber,
            'status' => 1,
        ]);

        //用户积分减少
        $appUserReduceIntegralRes = $appUserModel->where(['id' => $appUserInfo['id']])->setDec('integral_num', $tradingIntegral);
        //社区积分增加
        $communityAddIntegralRes = $communityModel->where(['id' => $appUserInfo['address_id']])->setInc('com_integral', $tradingIntegral);

        if($addTradingRecordRes && $appUserReduceIntegralRes && $communityAddIntegralRes) {
            $this->commit(); // 成功则提交事务
            return [
                'id' => $addTradingRecordRes,
                'user' => $appUserInfo['realname'],
                'trading_integral' => $tradingIntegral,
                'trading_time' => $trading_time,
                'trading_number' => $tradingNumber,
            ];
        } else {
            $this->rollback(); // 否则将事务回滚
            return -2;
        }

    }
}