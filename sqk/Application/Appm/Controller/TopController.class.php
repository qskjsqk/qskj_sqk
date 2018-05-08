<?php

/**
 * @name TopController
 * @info 描述：排行榜  榜单控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-16 13:23:45
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class TopController extends Controller {

//------------------------------------------------------------------------------
    /**
     * 初始化函数
     */
    public function _initialize() {
        $this->dbFix = 'qs_sqk_';
    }

    /**
     * 排行榜首页
     */
    public function top_home() {
        $this->assign('address_id', cookie('address_id'));
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
                        . $this->dbFix . 'sys_userapp_info.realname,' . $this->dbFix . 'sys_userapp_info.address_id')
                ->join('left join ' . $this->dbFix . 'sys_userapp_info on ' . $this->dbFix . 'activ_signin_info.user_id=' . $this->dbFix . 'sys_userapp_info.id')
                ->where($where)->group('user_id')->order('sign_integral desc')->limit(8)
                ->select();
        for ($i = 0; $i < count($Arr); $i++) {
            $Arr[$i]['sql'] = M('ActivSigninInfo')->getLastSql();
            $Arr[$i]['top'] = $Arr[$i]['realname'];
            $Arr[$i]['bottom'] = getConameById($Arr[$i]['address_id']);
            $Arr[$i]['right'] = '累计' . $Arr[$i]['sign_integral'] . '分';
            $Arr[$i]['tx_icon'] = '<img src="../../../Public/admin/img/tx_icon/' . ($Arr[$i]['user_id'] % 13 + 1) . '.jpg">';
        }
        return $Arr;
    }

    /**
     * 获取排行榜列表
     */
    public function getTopList() {
        $type = $_POST['type'];
        $nla = $_POST['nla'];

        $quarter = getQuarter();
        $nWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['nstart'] . '"';
        $lWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['lstart'] . '"';


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
                break;
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
            case 3:
                $data['type_name'] = '梨园镇社区榜单';
                break;
        }
        $this->ajaxReturn($data, 'JSON');
    }

}
