<?php

/**
 * @name LoginController
 * @info 描述：登录，注册，找回密码，登出等操作控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class LoginController extends Controller {

//------------------------------------------------------------------------------
    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Admin/Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);
    }

    /**
     * 入口页面
     */
    public function index() {
        $mxInfo = cookie('wxInfo');
        $this->assign('headimgurl', $mxInfo['headimgurl']);
        $this->assign('nickname', $mxInfo['nickname']);
        $this->display();
    }

    public function apply() {
        $this->display();
    }

    public function perfect_info() {
        $this->assign('tel', $_GET['tel']);
        $this->display();
    }

//------------------------------------------------------------------------------
    /**
     * 密码sha1加密
     */
    public function EncriptPWD($pwd) {
        $a = 'lee';
        $b = 'hawking';
        return sha1(sha1($a) . sha1($pwd) . sha1($b));
    }

    /**
     * 用户登录
     */
    public function login() {

        cookie('pwd', '123', 3600 * 24 * 30);
        cookie('cookie_user', '张晓炜', 3600 * 24 * 30);
        cookie('user_id', 106, 3600 * 24 * 30);
        cookie('address_id', 1, 3600 * 24 * 30);
        $errorMsg['is_success'] = '';



//        if ($_POST['username'] == '') {
//            $errorMsg['username'] = '请输入用户名！';
//        } else if ($_POST['password'] == '') {
//            $errorMsg['password'] = '请输入密码！';
//        } else {
//            $userModel = M(C('DB_USER_INFO'));
//            $userInfo = $userModel
//                    ->join('u left join ' . $this->config['db_fix'] . 'sys_user_group g on u.cat_id=g.id')
//                    ->field('u.id,u.usr,u.pwd,u.pwd,g.sys_name')
//                    ->where('binary u.usr="' . $_POST['username'] . '" and u.pwd="' . $this->EncriptPWD($_POST['password']) . '" and g.sys_name="appUser"')
//                    ->find();
//            if (isset($userInfo)) {
//                cookie('pwd', $_POST['password'], 3600 * 24 * 30);
//                cookie('cookie_user', $_POST['username'], 3600 * 24 * 30);
//                cookie('user_id', $userInfo['id'], 3600 * 24 * 30);
////                session('usr', $userInfo['usr']);
////                session('pwd', $userInfo['pwd']);
////                session('user_id', $userInfo['id']);
////                session('realname', $userInfo['realname']);
////                session('user_cat_id', $userInfo['cat_id']);
//                $errorMsg['is_success'] = '';
//            } else {
//                $errorMsg['is_success'] = '用户名或密码错误！';
//            }
//        }
        $this->ajaxReturn($errorMsg);
    }

    public function getApplyKeyCode() {
        $tel = $_POST['tel'];
        $keycode = make_char('m');
        $smsC = A('Sms');
        $flag = $smsC->sendCode($tel, $keycode);
        $flag = json_decode($flag, TRUE);
        if ($flag['errmsg'] == "OK") {
            $returnData['status'] = 1;
            $returnData['msg'] = "成功获取验证码!";
            $returnData['keycode'] = $keycode;
        } else {
            $returnData['status'] = 0;
            $returnData['msg'] = "获取验证码失败，请30秒后重试!";
            $returnData['keycode'] = 0;
        }
        $returnData['dd'] = $flag;
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 检测用户是否登录
     */
    public function checkIsLogin() {
        $user_id = cookie('user_id');
        if ($user_id == null) {
            $returnData['flag'] = 0;
        } else {
            //通知条数
            $noticeC = A('Notice');
            $isEnableNoticeCat = $noticeC->getEnableCatIds();
            $data['notice_num'] = M('NoticeInfo')->where('is_publish=1 and read_ids not like "%,' . $user_id . ',%" and cat_id in (' . $isEnableNoticeCat . ')')->count();
            //活动条数
            $activityC = A('Activity');
            $isEnableActivityCat = $activityC->getEnableCatIds();
            $data['activity_num'] = M('ActivInfo')->where('is_publish=1 and read_ids not like "%,' . $user_id . ',%" and cat_id in (' . $isEnableActivityCat . ')')->count();

            $returnData['data'] = $data;
            $returnData['flag'] = $user_id;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 保存用户信息
     */
    public function addUserappInfo() {
        $userModel = D('SysUserappInfo');
        $saveArr['tel'] = $_POST['tel'];
        $saveArr['realname'] = $_POST['realname'];
        $saveArr['gender'] = $_POST['gender'];
        $saveArr['birthday'] = $_POST['birthday'];
        $saveArr['address_id'] = $_POST['address_id'];
//        dump($saveArr);
        if (!$userModel->create($saveArr)) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => $userModel->getError());
        } else {
            $saveArr['usr'] = $saveArr['tel'];
            $encriptTel = R('Login/EncriptPWD', array($saveArr['tel'])); //手机号加密
            $saveArr['qrcode_path'] = createQrcode($saveArr['tel'] . $encriptTel);
            $result = $userModel->add($saveArr); //数据更新
            if ($result === FALSE) {
                $returnData['is_success'] = array('flag' => 0, 'msg' => '添加用户失败!');
            } else {
                $returnData['is_success'] = array('flag' => 1, 'msg' => '添加用户成功!');
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取分类id
     * @param type $model
     * @param type $sysName
     * @return int
     */
    public function getInfoBySysName($model, $sysName) {
        $findArr = $model->where('sys_name="' . $sysName . '"')->find();
        if (empty($findArr)) {
            return 0;
        } else {
            return $findArr['id'];
        }
    }

    /**
     * 用户退出
     */
    public function logout() {
        foreach ($_COOKIE as $key => $val) {
            cookie($key, null);
        };
        $this->redirect('Appm/login/index');
    }


    /**
     * 获取个人信息
     */
    public function getUserInfo() {
        $userModel = M(C('DB_USER_INFO'));
        $user_id = cookie('user_id');
        $result = $userModel->where(array('id' => $user_id))->find();
        $this->ajaxReturn($result);
    }



}
