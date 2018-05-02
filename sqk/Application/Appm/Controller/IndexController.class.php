<?php

/**
 * @name IndexController
 * @info 描述：Appm入口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 13:35:49
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class IndexController extends Controller {

    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Admin/Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);
    }

//    --------------------------------------------------------------------------
    public function seller_home() {
        $this->display();
    }

    public function item_manage() {
        $this->display();
    }

//    视图
//------------------------------------------------------------------------------    
    public function index() {
        if ($_COOKIE['user_id'] == null) {
            $this->redirect('Login/index');
        } else {
            $this->redirect('Activity/activity_list');
        }
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
     * 我的通知
     */
    public function my_notice() {
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
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 劵吗兑换记录
     */
    public function litem_list() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 积分交易记录
     */
    public function order_list() {
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
        if ($_GET['type'] == 'api') {
            $this->ajaxReturn($result);
        } else {
            return $result;
        }
    }

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

    /**
     * 调试代码
     */
    public function zxw() {
        
    }

}
