<?php

/**
 * @name TopController
 * @info 描述：排行榜  榜单控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-16 13:23:45
 */

namespace Seller\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class TopController extends BaseController {

//------------------------------------------------------------------------------
    /**
     * 初始化函数
     */
    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 排行榜首页
     */
    public function top_home() {
        $this->assign('address_id', cookie('address_id'));
        $this->assign('data', $this->getTypeFourList());
        $this->display();
    }

    /**
     * 排行榜列表页
     */
    public function top_list() {

        $this->assign('address_id', cookie('address_id'));
        $this->display();
    }

    /**
     * 获取用户排行榜
     * @param type $where
     * @return string
     */
    public function getUserList($where) {
        $Arr = M('ActivSigninInfo')
                ->field('sum(' . $this->dbFix . 'activ_signin_info.sign_integral) as sign_integral,' . $this->dbFix . 'activ_signin_info.user_id,'
                        . $this->dbFix . 'sys_userapp_info.realname,' . $this->dbFix . 'sys_userapp_info.address_id,' . $this->dbFix . 'sys_userapp_info.tx_path')
                ->join('left join ' . $this->dbFix . 'sys_userapp_info on ' . $this->dbFix . 'activ_signin_info.user_id=' . $this->dbFix . 'sys_userapp_info.id')
                ->where($where)->group('user_id')->order('sign_integral desc')->limit(10)
                ->select();
        for ($i = 0; $i < count($Arr); $i++) {
            $Arr[$i]['sql'] = M('ActivSigninInfo')->getLastSql();
            $Arr[$i]['top'] = $Arr[$i]['realname'];
            $Arr[$i]['bottom'] = getConameById($Arr[$i]['address_id']);
            $Arr[$i]['right'] = '累计' . $Arr[$i]['sign_integral'] . '分';
            if (strpos($Arr[$i]['tx_path'], 'http') === FALSE) {
                $Arr[$i]['tx_icon'] = '<img src="../../../' . $Arr[$i]['tx_path'] . '">';
            } else {
                $Arr[$i]['tx_icon'] = '<img src="' . $Arr[$i]['tx_path'] . '">';
            }
        }
        return $Arr;
    }

    /**
     * 获取商家排行榜
     * @param type $where
     * @return string
     */
    public function getSellerList($where) {
        $Arr = M('IntegralTradingRecord')
                ->field('sum(' . $this->dbFix . 'integral_trading_record.trading_integral) as exchange_integral,'
                        . $this->dbFix . 'seller_info.name,' 
                        . $this->dbFix . 'seller_info.tx_path,' 
                        . $this->dbFix . 'seller_info.address_id')
                ->join('left join ' . $this->dbFix . 'seller_info on ' . $this->dbFix . 'integral_trading_record.income_id=' . $this->dbFix . 'seller_info.id')
                ->where($where.' and ' . $this->dbFix . 'integral_trading_record.income_type=2')->group('income_id')->order('exchange_integral desc')->limit(10)
                ->select();
        for ($i = 0; $i < count($Arr); $i++) {
            $Arr[$i]['sql'] = M('IntegralTradingRecord')->getLastSql();
            $Arr[$i]['top'] = $Arr[$i]['name'];
            $Arr[$i]['bottom'] = getConameById($Arr[$i]['address_id']);
            $Arr[$i]['right'] = '累计' . $Arr[$i]['exchange_integral'] . '分';
            $Arr[$i]['tx_icon'] = '<img src="../../../' . $Arr[$i]['tx_path'] . '">';
        }
        return $Arr;
    }

    /**
     * 获取社区排行榜
     * @param type $where
     * @return string
     */
    public function getCommList($start, $end) {
        $commArr = M('sys_community_info')->select();
        for ($i = 0; $i < count($commArr); $i++) {
            $Num = $this->getSignNumAActivNum($start, $end, $commArr[$i]['id']);
            $commArr[$i]['signNum'] = $Num['signNum'];
            $commArr[$i]['activNum'] = $Num['activNum'];
        }
        $sort = array(
            'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field' => 'signNum', //排序字段
        );
        $arrSort = array();
        foreach ($commArr AS $uniqid => $row) {
            foreach ($row AS $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if ($sort['direction']) {
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $commArr);
        }
        for ($i = 0; $i < count($commArr); $i++) {
            $commArr[$i]['top'] = $commArr[$i]['com_name'];
            $commArr[$i]['bottom'] = '共举办活动' . $commArr[$i]['activNum'] . '场';
            $commArr[$i]['right'] = '累计签到' . $commArr[$i]['signNum'] . '人次';
            $commArr[$i]['tx_icon'] = '<span class="mui-icon mui-icon-extra mui-icon-extra-hotel" style="font-size: 36px;"></span>';
        }
        return $commArr;
    }

    public function getSignNumAActivNum($start, $end, $id) {
        $return['signNum'] = M('ActivSignin')
                ->field($this->dbFix . 'activ_signin_info.user_id,'
                        . $this->dbFix . 'activ_signin.activity_id,'
                        . $this->dbFix . 'activ_info.address_id')
                ->join('left join ' . $this->dbFix . 'activ_signin_info on ' . $this->dbFix . 'activ_signin_info.sign_id=' . $this->dbFix . 'activ_signin.id '
                        . 'left join ' . $this->dbFix . 'activ_info on ' . $this->dbFix . 'activ_signin.activity_id=' . $this->dbFix . 'activ_info.id')
                ->where($this->dbFix . 'activ_signin_info.add_time < "' . $end . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $start . '"'
                        . ' and ' . $this->dbFix . 'activ_signin_info.user_id>0 and ' . $this->dbFix . 'activ_info.address_id=' . $id)
                ->count();
        $return['activNum'] = M('ActivInfo')
                        ->where('start_time < "' . $end . '" and start_time > "' . $start . '"'
                                . 'and address_id=' . $id)->count();
        return $return;
    }

    /**
     * 获取排行榜列表
     */
    public function getTopList() {
        $type = $_POST['type'];
        $nla = $_POST['nla'];

        $quarter = getQuarter();
        //签到表
        $nWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['nstart'] . '"';
        $lWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['lstart'] . '"';

        //交易表
        $snWhere = $this->dbFix . 'goods_exchange_record.exchange_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'goods_exchange_record.exchange_time > "' . $quarter['nstart'] . '"';
        $slWhere = $this->dbFix . 'goods_exchange_record.exchange_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'goods_exchange_record.exchange_time > "' . $quarter['lstart'] . '"';


        switch ($type) {
            //本社区用户--------------------------------------------------------
            case 0:
                $data['type_name'] = '本社区用户榜单';
                switch ($nla) {
                    //本季度----------------------------------------------------
                    case 0:
                        $data['topList'] = $this->getUserList($nWhere . ' and address_id=' . cookie('address_id'));
                        break;
                    //上季度----------------------------------------------------
                    case 1:
                        $data['topList'] = $this->getUserList($lWhere . ' and address_id=' . cookie('address_id'));
                        break;
                    //总榜------------------------------------------------------
                    case 2:
                        $data['topList'] = $this->getUserList('address_id=' . cookie('address_id'));
                        break;
                }
                break;
            case 1:
                $data['type_name'] = '梨园镇用户榜单';
                switch ($nla) {
                    //本季度----------------------------------------------------
                    case 0:
                        $data['topList'] = $this->getUserList($nWhere);
                        break;
                    //上季度----------------------------------------------------
                    case 1:
                        $data['topList'] = $this->getUserList($lWhere);
                        break;
                    //总榜------------------------------------------------------
                    case 2:
                        $data['topList'] = $this->getUserList('1=1');
                        break;
                }
                break;
            case 2:
                $data['type_name'] = '梨园镇商家榜单';
                switch ($nla) {
                    //本季度----------------------------------------------------
                    case 0:
                        $data['topList'] = $this->getSellerList($snWhere);
                        break;
                    //上季度----------------------------------------------------
                    case 1:
                        $data['topList'] = $this->getSellerList($slWhere);
                        break;
                    //总榜------------------------------------------------------
                    case 2:
                        $data['topList'] = $this->getSellerList('1=1');
                        break;
                }
                break;
            case 3:
                $data['type_name'] = '梨园镇社区榜单';
                switch ($nla) {
                    //本季度----------------------------------------------------
                    case 0:
                        $data['topList'] = $this->getCommList($quarter['nstart'], $quarter['nend']);
                        break;
                    //上季度----------------------------------------------------
                    case 1:
                        $data['topList'] = $this->getCommList($quarter['lstart'], $quarter['lend']);
                        break;
                    //总榜------------------------------------------------------
                    case 2:
                        $data['topList'] = $this->getCommList('1990-01-01 00:00:00', '2999-12-31 23:59:59');
                        break;
                }
                break;
        }
        $this->ajaxReturn($data, 'JSON');
    }

    public function getTypeFourList() {
        $quarter = getQuarter();
        //签到表
        $nWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['nstart'] . '"';
        $lWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['lstart'] . '"';

        //交易表
        $snWhere = $this->dbFix . 'integral_trading_record.trading_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'integral_trading_record.trading_time > "' . $quarter['nstart'] . '"';
        $slWhere = $this->dbFix . 'integral_trading_record.trading_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'integral_trading_record.trading_time > "' . $quarter['lstart'] . '"';


        $data['bUserList'] = $this->getUserList($nWhere . ' and address_id=' . cookie('address_id'));
        $data['allUserList'] = $this->getUserList($nWhere);
        $data['sellerList'] = $this->getSellerList($snWhere);
        $data['commList'] = $this->getCommList($quarter['nstart'], $quarter['nend']);

        $data['bUserList'] = array_slice($data['bUserList'], 0, 3);
        $data['allUserList'] = array_slice($data['allUserList'], 0, 3);
        $data['sellerList'] = array_slice($data['sellerList'], 0, 3);
        $data['commList'] = array_slice($data['commList'], 0, 3);

        return $data;
    }

}
