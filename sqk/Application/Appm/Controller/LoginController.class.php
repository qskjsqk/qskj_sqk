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
        //获取微信信息
        $wxInfo = cookie('wxInfo');
        //验证用户是否存在
        $where['wx_num'] = ['EQ', $wxInfo['openid']];
        $userInfo = M('sys_userapp_info')->where($where)->find();

        if (!empty($userInfo)) {
            cookie('realname', $userInfo['realname'], 3600 * 24 * 30);
            cookie('user_id', $userInfo['id'], 3600 * 24 * 30);
            cookie('address_id', $userInfo['address_id'], 3600 * 24 * 30);
            //直接进入主界面
            $this->redirect('activity/activity_list');
        } else {
            $this->assign('headimgurl', $wxInfo['headimgurl']);
            $this->assign('nickname', $wxInfo['nickname']);
            $this->display();
        }
    }

    /**
     * 申请页
     */
    public function apply() {

        $this->display();
    }

    /**
     * 微信绑定页面
     */
    public function wechat_binding() {
        //获取微信信息
        $wxInfo = cookie('wxInfo');
//        测试数据
//        $wxInfo = array(
//            'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKHRoX9H0IXWmiaxlXzb3O9ILcicFoZqRjRZWe0xKk0bdPqiag4shDYyXw94TL6pDRiaV4svlVlKraBnw/132',
//            'openid' => 'oadwq03_g0B0lvOGQG6Id5vUIwNQ',
//            'nickname' => '忘忧草',
//        );
        $this->assign('wxInfo', $wxInfo);
        $this->display();
    }

    /**
     * 完善信息页
     */
    public function perfect_info() {
        //获取微信信息
        $wxInfo = cookie('wxInfo');
//        //测试数据
//        $wxInfo = array(
//            'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKHRoX9H0IXWmiaxlXzb3O9ILcicFoZqRjRZWe0xKk0bdPqiag4shDYyXw94TL6pDRiaV4svlVlKraBnw/132',
//            'openid' => 'oadwq03_g0B0lvOGQG6Id5vUIwNQ',
//            'nickname' => '忘忧草',
//        );
        $this->assign('wxInfo', $wxInfo);
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
        $this->ajaxReturn($errorMsg);
    }

    /**
     * 获取手机验证码 验证手机是否存在
     */
    public function getApplyKeyCodeCheckExist() {
        $tel = $_POST['tel'];
        $findArr = M('sys_userapp_info')->where('tel="' . $tel . '"')->find();
        if (!empty($findArr)) {
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
        } else {
            $returnData['status'] = 0;
            $returnData['msg'] = "该手机号码尚未注册!";
            $returnData['keycode'] = 0;
        }

        $returnData['dd'] = $flag;
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 获取手机验证码 验证手机是否存在
     */
    public function getApplyKeyCode() {
        $tel = $_POST['tel'];
        $findArr = M('sys_userapp_info')->where('tel="' . $tel . '"')->find();
        if (empty($findArr)) {
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
        } else {
            $returnData['status'] = 0;
            $returnData['msg'] = "该手机号码已注册!";
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

        $saveArr['tx_path'] = $_POST['tx_path'];
        $saveArr['nickname'] = $_POST['nickname'];
        $saveArr['wx_num'] = $_POST['wx_num'];
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
     * 绑定微信和用户信息
     */
    public function bindingUserappInfo() {
        $userModel = D('SysUserappInfo');
        $saveArr['tel'] = $_POST['tel'];

        $saveArr['tx_path'] = $_POST['tx_path'];
        $saveArr['nickname'] = $_POST['nickname'];
        $saveArr['wx_num'] = $_POST['wx_num'];

        $where['tel'] = ['EQ', $saveArr['tel']];
        $result = $userModel->where($where)->save($saveArr); //数据更新

        if ($result === FALSE) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => '用户绑定失败!');
        } else {
            $returnData['is_success'] = array('flag' => 1, 'msg' => '用户绑定成功!');
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

    public function ys() {
        cookie('user_id', 129, 3600 * 24 * 30);
        cookie('address_id', 3, 3600 * 24 * 30);
        //直接进入主界面
        $this->redirect('activity/activity_list');
    }

}
