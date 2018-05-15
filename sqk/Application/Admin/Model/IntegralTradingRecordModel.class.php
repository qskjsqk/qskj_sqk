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

        //从原始数组中获取address_id列表
        $userToAddressId = self::getAddressId($userToAddressList);
        $goodsExchageAddressId = self::getAddressId($goodsExchageTimes);

        //针对二者的address_id列表求交集
        $arrIntersect = array_intersect($userToAddressId, $goodsExchageAddressId);

        $data = [];

        //如果二者有交集
        if(!empty($arrIntersect)) {
            //从原始列表中去除有公共address_id的元素
            $goodsExchageTimesDiff = self::findAndUnsetItemFromArr($arrIntersect, $goodsExchageTimes);
            $userToAddressListDiff = self::findAndUnsetItemFromArr($arrIntersect, $userToAddressList);

            //去除有公共address_id后二者合并
            $listDiffMerge = array_merge($goodsExchageTimesDiff, $userToAddressListDiff);

            //交集部分要分别根据address_id从原始数组中求得count,然后相加得到对应address_id的count
            $arrIntersectList = self::getIntersectListData($arrIntersect, $userToAddressList, $goodsExchageTimes);

            //合并有公共address_id的数据和没有公共address_id的数据
            $data = array_merge($listDiffMerge, $arrIntersectList);
        } else {
            //如果没有交集,直接合并原始数据
            $data = array_merge($userToAddressList, $goodsExchageTimes);
        }

        return $data;

    }

    /**
     * 从原始数组中获取address_id列表
     * @access private
     * @param  array $list   原始数组
     * @return array(一维)
     */
    private static function getAddressId($list) {
        $arr = [];
        foreach($list as $value) {
            $arr[] = $value['address_id'];
        }
        return $arr;
    }

    /**
     * 从原始列表中去除有公共address_id的元素
     * @access private
     * @param  array $arrIntersect   公共address_id数组
     * @param  array $data           原始数组
     * @return array
     */
    private function findAndUnsetItemFromArr($arrIntersect, $data) {
        foreach($arrIntersect as $value) {
            foreach($data as $key => $item) {
                if($value == $item['address_id']) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    /**
     * 根据address_id从原始列表中获取count
     * @access private
     * @param  integer $addressId    社区id
     * @param  array   $lists        原始数组
     * @return integer
     */
    private static function getCountFromArr($addressId, $lists) {
        $count = 0;
        foreach($lists as $item) {
            if($addressId == $item['address_id']) {
                $count = $item['count'];
            }
        }
        return $count;
    }

    /**
     * 交集部分要分别根据address_id从原始数组中求得count,然后相加得到对应address_id的count,最后返回索要数据
     * @access private
     * @param  array   $arrIntersect        address_id交集数据
     * @param  array   $userToAddressList   原始数组
     * @param  array   $goodsExchageTimes   原始数组
     * @return array
     */
    private static function getIntersectListData($arrIntersect, $userToAddressList, $goodsExchageTimes) {
        $arrIntersectList = [];
        foreach($arrIntersect as $value) {
            $count = $count1 = $count2 = 0;
            $count1 = self::getCountFromArr($value, $userToAddressList);
            $count2 = self::getCountFromArr($value, $goodsExchageTimes);
            $count = $count1 + $count2;
            $arrIntersectList[] = ['count' => $count, 'address_id' => $value];
        }
        return $arrIntersectList;
    }



}