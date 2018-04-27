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

}
