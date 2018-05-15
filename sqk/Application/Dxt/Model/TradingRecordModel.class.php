<?php
/**
 * @name TradingRecordModel
 * @info 描述：交易记录总表 Model
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-05-10 17:29:00
 */

namespace Dxt\Model;
use Think\Model;
use Admin\Model\BaseModel;
use Admin\Model\SysUserappInfoModel;
use Admin\Model\SysUserInfoModel;
use Dxt\Model\SellerInfoModel;

class TradingRecordModel extends BaseModel {

    public $tableName  = 'integral_trading_record';

    /**
     * 获取用户交易记录
     */
    public function getUserTradingList($param) {
        $num = C('PAGE_NUM')['trading'] * $param['page'];
        $where['payment_id'] = $param['user_id'];

        $lists = $this->where($where)->order("id desc")->limit($num)->select();
        $count = $this->where($where)->count();

        foreach($lists as $key => $value) {
            $lists[$key]['tradingName'] = getExchangeMethodById($value['exchange_method_id'])['name'];
            $lists[$key]['title']= self::getIncomeBytype($value);
        }

        if ($num < $count) {
            $ajaxLoad = '点击加载更多';
            $isEnd = 0;
        } else {
            $ajaxLoad = '已加载全部';
            $isEnd = 1;
        }
        $data = [
            'page' => $param['page'],
            'ajaxLoad' => $ajaxLoad,
            'is_end' => $isEnd,
            'isEmpty' => !empty($lists) ? 1 : 0,
            'lists' => $lists,
            'num' => $num,
        ];
        return $data;
    }

    /**
     * 获取用户相关信息
     */
    public function getAppUserInfo($user_id) {
        $appUserModel = new SysUserappInfoModel();
        $appUserInfo = $appUserModel->where(['id' => $user_id])->find();
        return [
            'userName' => $appUserInfo['realname'],
            'comName' => getConameById($appUserInfo['address_id']),
            'consumedIntegral' => $this->where(['payment_id' => $user_id])->sum('trading_integral'),
            'tradingCount' => $this->where(['payment_id' => $user_id])->count(),
            'currentIntegral' => $appUserInfo['integral_num'],
            'txPath' => $appUserInfo['tx_path'],
        ];
    }

    /**
     * 根据收款方类型获取收款方名称
     * @access public
     * @param array     $tradingInfo    交易详情
     * @return string
     */
    public static function getIncomeBytype($tradingInfo) {
        $sellerModel = new SellerInfoModel();
        $appUserModel = new SysUserappInfoModel();
        $userModel = new SysUserInfoModel();

        $income = '';
        switch($tradingInfo['income_type']) {
            //收款方管理员
            case 0:
                $income = $userModel->where(['id' => $tradingInfo['income_id']])->getField('usr');
                break;
            //收款方是社区
            case 1:
                $income = getConameById($tradingInfo['income_id']);
                break;
            //收款方是商家
            case 2:
                $income = $sellerModel->where(['id' => $tradingInfo['income_id']])->getField('name');
                break;
            //收款方是用户
            case 4:
                $income = $appUserModel->where(['id' => $tradingInfo['income_id']])->getField('realname');
                break;
        }
        return $income;
    }

    /**
     * 获取交易详情
     * @param integer   $id      交易id
     * @param integer   $userId  当前用户id
     * @return array
     */
    public function getTradingInfo($id, $userId) {
        $appUserModel = new SysUserappInfoModel();
        $tradingInfo = $this->find($id);
        $tradingInfo['appUserInfo'] = $appUserModel->find($userId);
        $tradingInfo['tradingMethod'] = getExchangeMethodById($tradingInfo['exchange_method_id'])['name'];
        $tradingInfo['title'] = self::getIncomeBytype($tradingInfo);
        return $tradingInfo;
    }


}
