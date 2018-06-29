<?php

/**
 * @name IndexController
 * @info 描述：Dxt入口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 13:35:49
 */

namespace Dxt\Controller;

use Think\Controller;
use Dxt\Model\TradingRecordModel;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class IndexController extends BaseController {

    function _initialize() {
        parent::_initialize();
    }

//    视图
//------------------------------------------------------------------------------ 
    /**
     * 首页
     */
    public function index() {
        if (empty($_GET['address_id'])) {
            $this->assign('address_id', 0);
        } else {
            $this->assign('address_id', $_GET['address_id']);
        }
        $this->assign('sys', 'dxt');
        $this->display();
    }

    /**
     * 详情页
     */
    public function detail() {
        if (empty($_GET['address_id'])) {
            $this->assign('address_id', 0);
        } else {
            $this->assign('address_id', $_GET['address_id']);
        }
        $swhere['id'] = ['EQ', $_GET['id']];
        $sellerInfo = M('seller_info')->where($swhere)->find();
        $sellerInfo['address_name'] = getConameById($sellerInfo['address_id']);

        if (strpos($sellerInfo['tx_path'], 'http') === FALSE) {
            $sellerInfo['tx_path'] = '../../../' . $sellerInfo['tx_path'];
        } else {
            $sellerInfo['tx_path'] = $sellerInfo['tx_path'];
        }

        $adList = M('seller_prom_info')->where('seller_id=' . $_GET['id'] . ' and status=1')->order('id desc')->select();
        for ($i = 0; $i < count($adList); $i++) {
            $adList[$i]['pics'] = $this->getAttachArr('sellerProm', $adList[$i]['id']);
        }
//        dump($sellerInfo);
        $this->assign('sellerInfo', $sellerInfo);
        $this->assign('adList', $adList);
        $this->display();
    }

    /**
     * 获取卡信息接口
     */
    public function getCardUserInfo() {
        $where['iccard_num'] = ['EQ', trim($_POST['iccard_num'])];
        $where['is_enable'] = ['EQ', 1];
        $info = M('sys_userapp_info')->where($where)->find();
        if (empty($info)) {
            $return['flag'] = 0;
            $return['msg'] = "无效的卡，请到管理员处核对！";
        } else {
            $return['flag'] = 1;
            $return['msg'] = "找到这个人！";
            $return['data'] = $info;
        }
        $return['dd'] = M('sys_userapp_info')->getLastSql();
        $this->ajaxReturn($return, 'JSON');
    }

    /**
     * 登录后首页
     */
    public function main() {
        $this->assign('user_id', $_GET['user_id']);
        cookie('user_id', $_GET['user_id'], 3600 * 24 * 3);
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 显示首页
     */
    public function home() {
        $this->display();
    }

    /*
     * 获取广告列表
     */
    public function getAdList() {
        $address_id = $_POST['address_id'];
        if ($address_id != 0) {
            $where['address_id'] = ['EQ', $address_id];
        } else {
            $where['_string'] = "1=1";
        }
        $where['status'] = ['EQ', 1];
        $adList = M('seller_info')->where($where)->order('RAND()')->limit(5)->select();
        for ($i = 0; $i < count($adList); $i++) {
            $adList[$i]['address_name'] = getConameById($adList[$i]['address_id']);

            if (strpos($adList[$i]['tx_path'], 'http') === FALSE) {
                $adList[$i]['tx_path'] = '../../../' . $adList[$i]['tx_path'];
            } else {
                $adList[$i]['tx_path'] = $adList[$i]['tx_path'];
            }
        }
        $this->ajaxReturn($adList, 'JSON');
    }

//    以下为导向台手机内部视图及方法==============================================

    public function login() {
        $this->redirect('Login/login');
    }

    /**
     * 我的
     */
    public function setting() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 我的资料
     */
    public function my_info() {
        $this->display();
    }

    /**
     * 我的实体卡
     */
    public function my_card() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 我的活动
     */
    public function activ_list() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 我的签到
     */
    public function signin_list() {
        $myInfo = $this->getUserappInfo();
        $myInfo['joined_activ_num']=M('activ_info')->where('join_ids like "%,'.$myInfo['id'].',%"')->count();
        $myInfo['signed_activ_num']=M('activ_signin_info')->where('user_id='.$myInfo['id'])->count();
        $this->assign('myInfo', $myInfo);
        $this->display();
    }

    /**
     * 积分交易记录
     */
    public function order_list() {
        $tradingModel = new TradingRecordModel();

        $appUserInfo = $tradingModel->getAppUserInfo(cookie('user_id'));
        $this->assign('appUserInfo', $appUserInfo);

        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 获取个人信息
     */
    public function getUserappInfo() {
        $userModel = M(C('DB_USERAPP_INFO'));
        $user_id = cookie('user_id');
        $result = $userModel->where(array('id' => $user_id))->find();
        $result['address_name'] = getConameById($result['address_id']);
        if (strpos($result['tx_path'], 'http') === FALSE) {
            $result['tx_path'] = '../../../' . $result['tx_path'];
        } else {
            $result['tx_path'] = $result['tx_path'];
        }
        if ($_GET['type'] == 'api') {
            $this->ajaxReturn($result);
        } else {
            return $result;
        }
    }

    /**
     * 获取个人活动列表
     */
    public function getMyActivList() {
        $user_id = cookie('user_id');

        $activC = A('Activity');
        $num = C('PAGE_NUM')['activity'] * $_POST['page'];
        if ($_POST['type'] == 0) {
            $where['like_ids'] = array('LIKE', '%,' . $user_id . ',%');
        } else {
            $where['join_ids'] = array('LIKE', '%,' . $user_id . ',%');
        }

        $acitvArr = M('ActivInfo')->where($where)->order('id desc')->limit($num)->select();
        //调试sql
        $returnData['sql'] = M('ActivInfo')->getLastSql();

        $count = M('ActivInfo')->where($where)->count();
        $returnData['count'] = $count;



        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_POST['page'];
        $returnData['type'] = $_POST['type'];

        if (empty($acitvArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($acitvArr); $i++) {
                $data[$i]['id'] = $acitvArr[$i]['id'];
                $data[$i]['title'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $acitvArr[$i]['title']);
                $data[$i]['cat_name'] = $activC->getCatNameById($acitvArr[$i]['cat_id']);

                $data[$i]['start_time'] = $acitvArr[$i]['start_time'];

                $data[$i]['like_num'] = $acitvArr[$i]['like_num'];

                $times = strtotime($acitvArr[$i]['start_time']);
                $data[$i]['start_date'] = date('Y.m.d', $times);
                $data[$i]['address_name'] = getConameById($acitvArr[$i]['address_id']);
                $data[$i]['integral'] = $acitvArr[$i]['integral'];

                $data[$i]['like_flag'] = $activC->checkReadLikeJoin($acitvArr[$i]['id'], 'like');

                $data[$i]['is_open'] = $acitvArr[$i]['is_open'];
                $picsInfo = $activC->getAttachArr($acitvArr[$i]['id']);
                if ($picsInfo['flag'] == 1) {
                    $data[$i]['pics'] = $picsInfo['data'];
                } else {
                    $data[$i]['pics'] = 0;
                }
            }
            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取个人签到列表
     */
    public function getMySignList() {
        $user_id = cookie('user_id');

        $num = C('PAGE_NUM')['signin'] * $_POST['page'];

        $where['user_id'] = ['EQ', $user_id];

        $signArr = M('ActivSigninInfo')->where($where)->order('id desc')->limit($num)->select();
        //调试sql
        $returnData['sql'] = M('ActivSigninInfo')->getLastSql();

        $count = M('ActivSigninInfo')->where($where)->count();
        $returnData['count'] = $count;

        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_POST['page'];
        $returnData['type'] = $_POST['type'];

        if (empty($signArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($signArr); $i++) {
                $data[$i] = $signArr[$i];
                $signInfo = M('ActivSignin')->field('qs_sqk_activ_signin.*,qs_sqk_activ_info.title,qs_sqk_activ_info.signin_time')
                                ->join('left join qs_sqk_activ_info on qs_sqk_activ_signin.activity_id=qs_sqk_activ_info.id')
                                ->where('qs_sqk_activ_signin.id=' . $signArr[$i]['sign_id'])->find();
                unset($signInfo['add_time']);
                foreach ($signInfo as $key => $value) {
                    $data[$i][$key] = $value;
                }
            }

            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 保存用户信息
     */
    public function saveUserappInfo() {
        $userModel = D('SysUserappInfo');
        $user_id = cookie('user_id');
        $saveArr['tel'] = $_POST['tel'];
        $saveArr['usr'] = $_POST['tel'];
        $saveArr['realname'] = $_POST['realname'];
        $saveArr['gender'] = $_POST['gender'];
        $saveArr['birthday'] = $_POST['birthday'];
        $saveArr['address_id'] = $_POST['address_id'];
//        dump($saveArr);
        if (!$userModel->create($saveArr)) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => $userModel->getError());
        } else {
            $result = $userModel->where('id=' . $user_id)->save($saveArr); //数据更新
            if ($result === FALSE) {
                $returnData['is_success'] = array('flag' => 0, 'msg' => '修改资料失败!');
            } else {
                $returnData['is_success'] = array('flag' => 1, 'msg' => '修改资料成功!');
            }
        }
        $this->ajaxReturn($returnData);
    }

}
