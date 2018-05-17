<?php

/**
 * @name IndexController
 * @info 描述：入口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-5-4 10:23:24
 */

namespace Seller\Controller;

use Think\Controller;
use Seller\Controller\BaseController;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class IndexController extends BaseController {

    public function _initialize() {
        parent::_initialize();
    }

    public function login() {
        $appid = WXAPPID;
        $secret = WXSECRET;
        $a = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid
                . "&secret=" . $secret
                . "&code=" . $_GET['code'] . "&grant_type=authorization_code";
        $a = httpRequest($a, '');
        $wxInfo = json_decode($a, true);

        $b = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $wxInfo['access_token'] . "&openid=" . $wxInfo['openid'];
        $b = httpRequest($b, '');
        $userInfo = json_decode($b, true);

        $wx['headimgurl'] = $userInfo['headimgurl'];
        $wx['openid'] = $userInfo['openid'];
        $wx['nickname'] = $userInfo['nickname'];
        cookie('wxInfo', $wx, 3600 * 24 * 30);

        $this->redirect('Index/index');
    }

    public function index() {
        $wxInfo = cookie('wxInfo');

        //测试数据
        $wxInfo = array(
            'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKHRoX9H0IXWmiaxlXzb3O9ILcicFoZqRjRZWe0xKk0bdPqiag4shDYyXw94TL6pDRiaV4svlVlKraBnw/132',
            'openid' => 'oadwq03_g0B0lvOGQG6Id5vUIwNQ',
            'nickname' => '忘忧草',
        );

        //先检测是否已有帐号
        $this->assign('headimgurl', $wxInfo['headimgurl']);
        $this->assign('nickname', $wxInfo['nickname']);
        $this->display();
    }

    /**
     * 检测用户是否登录
     */
    public function checkIsLogin() {
        $seller_id = cookie('seller_id');
        if ($seller_id == null) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = $seller_id;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 申请页面
     */
    public function apply() {
        $this->display();
    }

    /**
     * 完善信息页
     */
    public function perfect_info() {
        //获取微信信息
        $wxInfo = cookie('wxInfo');
        //测试数据
        $wxInfo = array(
            'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKHRoX9H0IXWmiaxlXzb3O9ILcicFoZqRjRZWe0xKk0bdPqiag4shDYyXw94TL6pDRiaV4svlVlKraBnw/132',
            'openid' => 'oadwq03_g0B0lvOGQG6Id5vUIwNQ',
            'nickname' => '忘忧草',
        );
        $this->assign('wxInfo', $wxInfo);
        $this->assign('tel', $_GET['tel']);
        $this->display();
    }

    /**
     * 获取手机验证码 验证手机是否存在
     */
    public function getApplyKeyCodeCheckExist() {
        $tel = $_POST['tel'];
        $findArr = M('sellerInfo')->where('tel="' . $tel . '"')->find();
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
        $findArr = M('sellerInfo')->where('tel="' . $tel . '"')->find();
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
     * 演示帐号
     */
    public function ys() {
        cookie('seller_id', 43, 3600 * 24 * 30);
        cookie('address_id', 1, 3600 * 24 * 30);
        $this->redirect('Seller/seller_home');
    }

}
