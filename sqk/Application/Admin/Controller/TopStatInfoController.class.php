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

    protected $catModel;

    public function _initialize() {
        parent::_initialize();
        $this->catModel = D('NoticeCat');
    }

    /**
     * function:显示榜单列表
     */
    public function showTopList() {
        $this->assign('address_id', $_SESSION['address_id']);
        $data['type'] = empty($_GET['type']) ? 0 : $_GET['type'];

        $quarter = getQuarter();
        $nWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['nstart'] . '"';
        $lWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['lstart'] . '"';


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
                break;
            case 3:
                $data['type_name'] = '梨园镇社区榜单';
                break;
        }
        $this->assign('data', $data);
        $this->display();
    }
    
    public function getUserList($where) {
        $Arr = M('ActivSigninInfo')
                ->field('sum(' . $this->dbFix . 'activ_signin_info.sign_integral) as sign_integral,' . $this->dbFix . 'activ_signin_info.user_id,'
                        . $this->dbFix . 'sys_userapp_info.realname,' . $this->dbFix . 'sys_userapp_info.address_id')
                ->join('left join ' . $this->dbFix . 'sys_userapp_info on ' . $this->dbFix . 'activ_signin_info.user_id=' . $this->dbFix . 'sys_userapp_info.id')
                ->where($where)->group('user_id')->order('sign_integral desc')->limit(8)
                ->select();
        for ($i = 0; $i < count($Arr); $i++) {
            $Arr[$i]['top'] = $Arr[$i]['realname'];
            $Arr[$i]['bottom'] = getConameById($Arr[$i]['address_id']);
            $Arr[$i]['right'] = '累计' . $Arr[$i]['sign_integral'] . '分';
            $Arr[$i]['tx_icon'] = '<img src="../../../Public/admin/img/tx_icon/' . ($Arr[$i]['user_id'] % 13 + 1) . '.jpg">';
        }
        return $Arr;
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
                $title = ['xTitle' => '各社区交易量', 'yTitle' => '签到交易量'];
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
