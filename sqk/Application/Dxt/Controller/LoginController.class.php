<?php

/**
 * @name LoginController
 * @info 描述：登录，注册，找回密码，登出等操作控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Dxt\Controller;

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
        $user_id = cookie('user_id');
        $info = M('sys_userapp_info')->field('id,address_id')->where('id=' . $user_id)->find();
        cookie('user_id', $info['id'], 3600 * 24 * 30);
        cookie('address_id',$info['address_id'], 3600 * 24 * 30);
        $this->redirect('Activity/activity_list');
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
        $address_id = cookie('address_id');
        if ($user_id == null) {
            $returnData['flag'] = 0;
        } else {
            //通知条数
            $noticeC = A('Notice');
            $isEnableNoticeCat = $noticeC->getEnableCatIds();
            $data['notice_num'] = M('NoticeInfo')->where('is_publish=1 and read_ids not like "%,' . $user_id . ',%" and cat_id in (' . $isEnableNoticeCat . ') and address_id in (0,'.$address_id.')')->count();
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
     * 找回密码-验证验证码
     */
    public function checkKeyCode() {
        $userModel = M(C('DB_USER_INFO'));
        if (IS_POST) {
            if ($_POST['usr'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '请输入用户名！');
            } else if ($_POST['email'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '你还没有输入验证邮箱！');
            } else if ($_POST['keycode'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '你还没有输入验证码！');
            } else {
                $userInfo = $userModel->where('binary usr="' . $_POST['usr'] . '" and email="' . $_POST['email'] . '" and keycode="' . $_POST['keycode'] . '"')->find();
                if (empty($userInfo)) {
                    $errorMsg['is_success'] = array('flag' => 0, 'msg' => '验证信息不匹配！', 'sql' => $userModel->getLastSql());
                } else {
                    $errorMsg['is_success'] = array('flag' => 1, 'msg' => '验证信息正确,请修改密码', 'user_id' => $userInfo['id']);
                }
            }
            $this->ajaxReturn($errorMsg);
        }
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

    /**
     * 保存用户信息
     */
    public function saveUserInfo() {
        $userModel = D('SysUserInfo');
        $user_id = cookie('user_id');
        $userInfo = $userModel->where(array('id' => $user_id))->find();
        $saveArr['tel'] = $_POST['tel'];
        $saveArr['phone'] = $_POST['phone'];
        $saveArr['qq'] = $_POST['qq'];
        $saveArr['email'] = $_POST['email'];
        $saveArr['address'] = $_POST['address'];
        if ($userInfo['rns_type'] == 0) {
            $userModel->where(array('id' => $user_id))->save(array('idcard_num' => ''));
            $saveArr['realname'] = $_POST['realname'];
            $saveArr['idcard_num'] = $_POST['idcard_num'];
        } elseif ($userInfo['rns_type'] == 1) {
            
        } else {
            $userModel->where(array('id' => $user_id))->save(array('idcard_num' => ''));
            $saveArr['realname'] = $_POST['realname'];
            $saveArr['idcard_num'] = $_POST['idcard_num'];
            $saveArr['rns_type'] = 0;
        }
        if ($saveArr['idcard_num'] == '') {
            unset($saveArr['idcard_num']);
        }
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
     * 发送邮件
     * @param type $emailAddress
     * @param type $userName
     * @param type $keycode
     */
    public function sendEmail($emailAddress, $user_id, $userName, $keycode) {
        $msg = think_send_mail($emailAddress, $userName, '找回密码', '尊敬的' . $userName . ',您的验证码是' . $keycode . ',有效期为一个小时请在页面中提交验证码完成验证。');
        return $msg;
    }

}
