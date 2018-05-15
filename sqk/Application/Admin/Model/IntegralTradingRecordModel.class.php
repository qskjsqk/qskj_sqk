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
use Admin\Model\SellerIntegralGoodsModel;

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

    /**
     * 获取各社区交易量
     * @access public
     * @return array
     */
    public function getTradingCountGroupByAddress() {
        $goodsModel = new SellerIntegralGoodsModel();
        $this->dbFix = C('DB_PREFIX');

        /* 分为两种情况:
         * 情况一: 用户支付,社区收取,以收取方id分组查询
         * 情况二: 用户支付,商家收取,以社区id分组查询
         * 然后二者相同的社区,要求和; 不相同的社区直接合并
         */

        //情况一
        $where = [
            'income_type' => 1,
            'payment_type' => 3,
        ];
        $userToAddressList = $this->where($where)->field("count(id) as count,income_id as address_id")->group("income_id")->select();
        //情况二
        $goodsExchageTimes = $goodsModel->field("sum(exchange_times) as count,address_id")->group("address_id")->select();
        $data = self::getDataFromArr($userToAddressList, $goodsExchageTimes);
        return $data;
    }

    private static function getDataFromArr($arr1 = [], $arr2 = []) {
        $arr = [];
        foreach($arr1 as $key => $value) {
            $count = 0;
            $isExist = false;
            foreach($arr2 as $k => $item) {
                if($value['address_id'] == $item['address_id']) {
                    $isExist = true;
                    $count = $value['count'] + $item['count'];
                    unset($arr2[$k]);
                }
            }
            if($isExist == true) {
                $arr[] = ['count' => $count, 'address_id' => $value['address_id']];
                unset($arr1[$key]);
            }
        }
        return array_merge($arr1, $arr2, $arr);
    }



}