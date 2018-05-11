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
use Admin\Model\SysUserappInfoModel;
use Seller\Model\SellerInfoModel;
use Seller\Model\TradingRecordModel;
use Seller\Model\SellerIntegralGoodsModel;

class ExchangeRecordModel extends BaseModel {

    public $tableName  = 'goods_exchange_record';


    public function addRecord($param) {
        $appUserModel = new SysUserappInfoModel();
        $sellerModel = new SellerInfoModel();
        $tradingModel = new TradingRecordModel();
        $goodsModel = new SellerIntegralGoodsModel();

        $appUserInfo = $appUserModel->where(['id' => $param['user_id']])->find();
        $sellerInfo = $sellerModel->where(['id' => $param['seller_id']])->find();
        $goodsInfo = $goodsModel->where(['id' => $param['goods_id']])->find();

        //验证商家信息和用户信息
        if(empty($appUserInfo) || empty($sellerInfo)) {
            return syncData(-2, '用户或商家信息有误');
        } elseif($appUserInfo['integral_num'] < $param['exchange_integral']) {
            return syncData(-3, '用户积分不足,仅剩' . $appUserInfo['integral_num'] . '积分');
        }

        //验证库存是否足够
        if($goodsInfo['stock'] < $param['book_num']) {
            return syncData(-4, '库存不足,还有' . $goodsInfo['stock'] . '件');
        }

        //验证(如果本商品有用户兑换限制数)当前用户是否已经超过兑换限制数
        if($goodsInfo['user_exchange_limit'] > 0) {
            $userExchangeGoodsCount = $this->where(['user_id' => $param['user_id']])->count();
            if($goodsInfo['user_exchange_limit'] <= $userExchangeGoodsCount) {
                return syncData(-5, '该用户兑换本商品次数已满');
            }
        }

        $this->startTrans(); // 开启事务

        $time = date("Y-m-d H:i:s" ,time());
        $uniqueNum = \Think\Tool\GenerateUnique::generateExchangeNumber();

        //积分商品交易表入库
        $insertGoodsId = $this->add([
            'seller_id' => $param['seller_id'],
            'goods_id' => $param['goods_id'],
            'user_id' => $param['user_id'],
            'exchange_integral' => $param['exchange_integral'],
            'exchange_time' => $time,
            'exchange_number' => $uniqueNum,
            'exchange_method_id' => 3,
            'status' => 1,
        ]);

        //交易主表入库
        $tradingInsertRes = $tradingModel->add([
            'income_id' => $param['seller_id'],
            'payment_id' => $param['user_id'],
            'income_type' => 2,
            'payment_type' => 3,
            'trading_integral' => $param['exchange_integral'],
            'trading_time' => $time,
            'exchange_method_id' => 3,  //商家扫码兑换交易
            'relation_id' => $insertGoodsId,
            'trading_number' => $uniqueNum,
            'status' => 1,
        ]);

        //商品表更新库存和交易次数
        $goodsUpdateRes = $goodsModel->where(['id' => $param['goods_id']])
            ->save([
                'stock' =>  $goodsInfo['stock'] - $param['book_num'],
                'exchange_times' => $goodsInfo['exchange_times'] + 1,
            ]);

        //商家更新积分和经验值
        $sellerAddRes = $sellerModel->where(['id' => $param['seller_id']])
            ->save([
                'integral_num' => $sellerInfo['integral_num'] + $param['exchange_integral'],
                'exp_num' => $sellerInfo['exp_num'] + $param['exchange_integral'],
            ]);

        //用户更新积分
        $appUserUpdateRes = $appUserModel->where(['id' => $param['user_id']])->setDec('integral_num', $param['exchange_integral']);

        if($insertGoodsId && $tradingInsertRes && $goodsUpdateRes && $sellerAddRes && $appUserUpdateRes) {
            $this->commit(); // 成功则提交事务
            $data = [
                'tradingNumber' => $uniqueNum,
                'sellerName' => $sellerInfo['name'],
                'appUserName' => $appUserInfo['realname'],
                'tradingIntegral' => $param['exchange_integral'],
                'tradingTime' => $time,
            ];
            return syncData(0, '交易成功', $data);
        } else {
            $this->rollback(); // 否则将事务回滚
            return syncData(-6, '交易失败');
        }

    }


}
