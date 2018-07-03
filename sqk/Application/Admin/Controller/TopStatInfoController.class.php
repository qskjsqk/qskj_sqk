<?php

/**
 * @name TopStatInfoController
 * @info 描述：榜单统计控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-27 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Config;
use Think\Tool\Request;

class TopStatInfoController extends BaseDBController {


    public function _initialize() {
        parent::_initialize();
    }

    /**
     * function:显示榜单列表
     */
    public function showTopList() {
        $this->assign('sys_name', $_SESSION['sys_name']);
        $this->assign('address_id', $_SESSION['address_id']);
        $data['type'] = empty($_GET['type']) ? 0 : $_GET['type'];

        $quarter = getQuarter();
         //签到表
        $nWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['nstart'] . '"';
        $lWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['lstart'] . '"';

        //交易表
        $snWhere = $this->dbFix . 'integral_trading_record.trading_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'integral_trading_record.trading_time > "' . $quarter['nstart'] . '"';
        $slWhere = $this->dbFix . 'integral_trading_record.trading_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'integral_trading_record.trading_time > "' . $quarter['lstart'] . '"';


        switch ($data['type']) {
            case 0:
                $data['type_name'] = '本社区用户榜单';
                //本季度--------------------------------------------------------
                $data['nowList'] = $this->getUserList($nWhere.' and address_id='.$_SESSION['address_id']);
                //上季度--------------------------------------------------------
                $data['lastList'] = $this->getUserList($lWhere.' and address_id='.$_SESSION['address_id']);
                //总榜单
                $data['allList'] = $this->getUserList('address_id='.$_SESSION['address_id']);
                break;
                break;
            case 1:
                $data['type_name'] = '梨园镇用户榜单';
                //本季度--------------------------------------------------------
                $data['nowList'] = $this->getUserList($nWhere);
                //上季度--------------------------------------------------------
                $data['lastList'] = $this->getUserList($lWhere);
                //总榜单
                $data['allList'] = $this->getUserList('1=1');
                break;
            case 2:
                $data['type_name'] = '梨园镇商家榜单';
                //本季度--------------------------------------------------------
                $data['nowList'] = $this->getSellerList($snWhere);
                //上季度--------------------------------------------------------
                $data['lastList'] =$this->getSellerList($slWhere);
                //总榜单
                $data['allList'] = $this->getSellerList('1=1');
                break;
            case 3:
                $data['type_name'] = '梨园镇社区榜单';
                //本季度--------------------------------------------------------
                $data['nowList'] = $this->getCommList($quarter['nstart'], $quarter['nend']);
                //上季度--------------------------------------------------------
                $data['lastList'] =$this->getCommList($quarter['lstart'], $quarter['lend']);
                //总榜单
                $data['allList'] = $this->getCommList('1990-01-01 00:00:00', '2999-12-31 23:59:59');
                break;
        }
        $this->assign('data', $data);
        $this->display();
    }
    
    /**
     * 获取用户列表
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
            $Arr[$i]['top'] = $Arr[$i]['realname'];
            $Arr[$i]['bottom'] = getConameById($Arr[$i]['address_id']);
            $Arr[$i]['right'] = '累计' . $Arr[$i]['sign_integral'] . '分';
            if (strpos($Arr[$i]['tx_path'], 'http') === FALSE) {
                $Arr[$i]['tx_icon'] = '<img src="../../../' . $Arr[$i]['tx_path'] . '">';
            } else {
                $Arr[$i]['tx_icon'] = '<img src="' . $Arr[$i]['tx_path'] . '">';
            }
        }
//        dump(M('ActivSigninInfo')->getLastSql());
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
            if(strpos($Arr[$i]['tx_path'],'http')===FALSE){
                $Arr[$i]['tx_icon'] = '<img src="../../../' . $Arr[$i]['tx_path'] . '">';
            }else{
                $Arr[$i]['tx_icon'] = '<img src="' . $Arr[$i]['tx_path'] . '">';
            }
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
            $commArr[$i]['tx_icon'] = '<span class="glyphicon glyphicon-globe" style="font-size: 36px;"></span>';
        }
        return $commArr;
    }

    /**
     * 内部接口获取签到和活动数
     * @param type $start
     * @param type $end
     * @param type $id
     * @return type
     */
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
     * 用户消费统计
     */
    public function userConsumptionList() {
        $request = Request::all();
        $lists = $title = [];

        if(empty($request['type']) || !in_array($request['type'], [1, 2, 3, 4, 5])) {
            $request['type'] = 1;
        }

        switch($request['type']) {
            case 1:
                //统计: 注册人数
                $appUserModel = new \Admin\Model\SysUserappInfoModel();
                $lists = $appUserModel->field("count(*) as count,address_id")->group("address_id")->select();
                $title = ['xTitle' => '各社区注册人数', 'yTitle' => '注册人数'];
                break;
            case 2:
                //统计: 注册商家数
                $sellerModel = new \Admin\Model\SellerInfoModel();
                $lists = $sellerModel->field("count(*) as count,address_id")->group("address_id")->select();
                $title = ['xTitle' => '各社区注册商家数', 'yTitle' => '注册商家数'];
                break;
            case 3:
                //统计: 活动数
                $activModel = new \Admin\Model\ActivInfoModel();
                $lists = $activModel->field("count(*) as count,address_id")->group("address_id")->select();
                $title = ['xTitle' => '各社区活动数', 'yTitle' => '活动数'];
                break;
            case 4:
                //统计: 签到人次
                $signinModel = new \Admin\Model\ActivSigninInfoModel();
                $lists = $signinModel->getSignInCountGroupByAddress();
                $title = ['xTitle' => '各社区签到人次', 'yTitle' => '签到人次'];
                break;
            case 5:
                //统计: 交易量
                $tradingModel = new \Admin\Model\IntegralTradingRecordModel();
                $lists = $tradingModel->getTradingCountGroupByAddress();
                $title = ['xTitle' => '各社区交易量', 'yTitle' => '交易量'];
                break;
        }

        //加上没有数据的社区
        $lists = self::addHaveNotDataAddress($lists);

        //生成报表数据
        $res = '[';
        foreach($lists as $key => $value) {
            $comName = getConameById($value['address_id']);
            $count = $value['count'];
            if ($key == count($lists) - 1) {
                $res.= "{ name: '$comName', y: $count}]";
            } else {
                $res.= "{ name: '$comName', y: $count},";
            }
        }

        $data = [
            'data' => $res,
            'title' => $title,
            'type' => $request['type'],
        ];

        $this->assign('data', $data);
        $this->display();
    }

    //加上没有数据的社区
    private static function addHaveNotDataAddress($arr) {
        $communityModel = new \Admin\Model\SysCommunityInfoModel();
        $communityIdList = $communityModel->getField('id', true);
        $existAddressIdList = [];
        foreach($arr as $key => $value) {
            $existAddressIdList[] = $value['address_id'];
        }
        $addressIdDiff = array_diff($communityIdList, $existAddressIdList);
        foreach($addressIdDiff as $item) {
            array_push($arr, ['count' => 0, 'address_id' => $item]);
        }
        return $arr;
    }

}
