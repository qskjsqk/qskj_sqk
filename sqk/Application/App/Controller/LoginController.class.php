<?php

/**
 * @name LoginController
 * @info 描述：登录，注册，找回密码，登出等操作控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace App\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class LoginController extends Controller {
//------------------------------------------------------------------------------

    /**
     * 入口页面
     */
    public function index() {
        $this->assign();
        $this->display();
    }

    /**
     * 个人中心页面
     */
    public function setting() {
        $this->assign();
        $this->display();
    }

    /**
     * 注册页面
     */
    public function register() {
        $this->assign();
        $this->display();
    }

    /**
     * 找回密码
     */
    public function findpwd() {
        $this->assign();
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
        if ($_POST['username'] == '') {
            $errorMsg['username'] = '请输入用户名！';
        } else if ($_POST['password'] == '') {
            $errorMsg['password'] = '请输入密码！';
        } else {
            $userModel = M(C('DB_USER_INFO'));
            $userInfo = $userModel
                    ->join('u left join qs_gryj_sys_user_group g on u.cat_id=g.id')
                    ->field('u.id,u.usr,u.pwd,u.pwd,g.sys_name')
                    ->where('binary u.usr="' . $_POST['username'] . '" and u.pwd="' . $this->EncriptPWD($_POST['password']) . '" and g.sys_name="appUser"')
                    ->find();
            if (isset($userInfo)) {
                cookie('pwd', $_POST['password'], 3600 * 24 * 30);
                cookie('cookie_user', $_POST['username'], 3600 * 24 * 30);
                cookie('user_id', $userInfo['id'], 3600 * 24 * 30);
                $errorMsg['is_success'] = '';
            } else {
                $errorMsg['is_success'] = '用户名或密码错误！';
            }
        }
        $this->ajaxReturn($errorMsg);
    }

    /**
     * 检测用户是否登录
     */
    public function checkIsLogin() {
        $json['user_id'] = cookie('user_id');
        if ($json['user_id'] == null) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = $json['user_id'];
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 注册用户
     */
    public function registerUser() {
        if ($_POST['username'] == '') {
            $errorMsg['username'] = '请输入用户名！';
        } else if ($_POST['password'] == '') {
            $errorMsg['password'] = '请输入密码！';
        } else if ($_POST['passworda'] == '') {
            $errorMsg['passworda'] = '请再次输入密码！';
        } else if ($_POST['password'] != $_POST['passworda']) {
            $errorMsg['checkpwda'] = '两次密码不一致！';
        } else {
            $userModel = M(C('DB_USER_INFO'));
            $userArr = $userModel->where('binary usr="' . $_POST['username'] . '"')->select();
            if (empty($userArr)) {
                $createArr['usr'] = $_POST['username'];
                $createArr['pwd'] = $this->EncriptPWD($_POST['password']);
                $createArr['cat_id'] = $this->getInfoBySysName(M(C('DB_USER_GROUP')), 'appUser');
                $createFlag = $userModel->add($createArr);

                $errorMsg['is_success'] = 1;
            } else {
                $errorMsg['is_success'] = 0;
                $errorMsg['msg'] = '该用户已存在！';
            }
        }
        $this->ajaxReturn($errorMsg);
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
        $this->redirect('App/login/index');
    }

    /**
     * 找回密码-用户验证修改密码(通过电子邮箱验证)
     */
    public function forget() {
        $userModel = M(C('DB_USER_INFO'));
        if (IS_POST) {
            if ($_POST['usr'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '请输入用户名！');
            } else if ($_POST['email'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '你还没有输入验证邮箱！');
            } else {
                $userInfo = $userModel->where('binary usr="' . $_POST['usr'] . '" and email="' . $_POST['email'] . '"')->find();
                if (!empty($userInfo)) {
                    $keycode = make_char('m');
                    $msg = $this->sendEmail($userInfo['email'], $userInfo['id'], $userInfo['realname'], $keycode);
                    if ($msg == TRUE) {
                        $errorMsg['is_success'] = array('flag' => 'success', 'id' => $userInfo['id'], 'msg' => '恭喜您：邮件发送成功，请注意查收！');
                        $updateFlog = $userModel->where('id=' . $userInfo['id'])->setField('keycode', $keycode);
                    } else {
                        $errorMsg['is_success'] = array('flag' => 0, 'msg' => '邮件发送失败，请重新验证邮箱！');
                    }
                } else {
                    $errorMsg['is_success'] = array('flag' => 0, 'msg' => '用户名与邮箱不匹配！');
                }
            }
            $this->ajaxReturn($errorMsg);
        }
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
     * function:外部找回密码---修改密码
     */
    public function editPwd() {
        $userModel = M(C('DB_USER_INFO'));
        $user_id = $_POST['user_id'];
        if (IS_POST) {
            if ($_POST['newPwd'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '请输入新密码！');
            } else if ($_POST['confirmPwd'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '请输入确认密码！');
            } else if ($_POST['newPwd'] != $_POST['confirmPwd']) {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '两次密码不一致！');
            } else {
                $update['pwd'] = $this->EncriptPWD($_POST['newPwd']);
                $update['keycode'] = make_char('m');
                $result = $userModel->where(array('id' => $user_id))->save($update);
                if ($result !== false) {
                    $errorMsg['is_success'] = array('flag' => 1, 'msg' => '修改密码成功!');
                } else {
                    $errorMsg['is_success'] = array('flag' => 0, 'msg' => '修改密码失败!');
                }
            }
            $this->ajaxReturn($errorMsg);
        }
    }

    /**
     * function:内部个人中心---修改密码
     */
    public function nEditPwd() {
        $userModel = M(C('DB_USER_INFO'));
        $user_id = cookie('user_id');
        if (IS_POST) {
            if ($_POST['oldPwd'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '请输入原密码！');
            } else if ($_POST['newPwd'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '请输入新密码！');
            } else if ($_POST['confirmPwd'] == '') {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '请输入确认密码！');
            } else if ($_POST['newPwd'] != $_POST['confirmPwd']) {
                $errorMsg['is_success'] = array('flag' => 0, 'msg' => '两次密码不一致！');
            } else {
                $findFlag = $userModel->where('id=' . $user_id . ' and pwd="' . $this->EncriptPWD($_POST['oldPwd']) . '"')->find();
                if (empty($findFlag)) {
                    $errorMsg['is_success'] = array('flag' => 0, 'msg' => '原密码不正确!');
                } else {
                    $update['pwd'] = $this->EncriptPWD($_POST['newPwd']);
                    $update['keycode'] = make_char('m');
                    $result = $userModel->where(array('id' => $user_id))->save($update);
                    if ($result !== false) {
                        $errorMsg['is_success'] = array('flag' => 1, 'msg' => '修改密码成功!');
                    } else {
                        $errorMsg['is_success'] = array('flag' => 0, 'msg' => '修改密码失败!');
                    }
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
            $userModel->where(array('id' => $user_id))->save(array('idcard_num'=>''));
            $saveArr['realname'] = $_POST['realname'];
            $saveArr['idcard_num'] = $_POST['idcard_num'];
        } elseif ($userInfo['rns_type'] == 1) {

        } else {
            $userModel->where(array('id' => $user_id))->save(array('idcard_num'=>''));
            $saveArr['realname'] = $_POST['realname'];
            $saveArr['idcard_num'] = $_POST['idcard_num'];
            $saveArr['rns_type'] = 0;
        }
//        if ($userInfo['rns_type'] != 1) {
//            if ($userInfo['rns_type'] == 2) {
//                $saveArr['rns_type'] = 0;
//            }
//            $saveArr['realname'] = $_POST['realname'];
//            $saveArr['idcard_num'] = $_POST['idcard_num'];
//        }
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
