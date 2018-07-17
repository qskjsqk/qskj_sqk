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

        DeleteAllCookies();

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
        //获取微信信息
        $wxInfo = cookie('wxInfo');
        //验证用户是否存在
        $where['open_id'] = ['EQ', $wxInfo['openid']];
        $sellerWx = M('seller_wechat_binding')->where($where)->find();

        if (!empty($sellerWx)) {
            $sellerInfo = M('seller_info')->find($sellerWx['seller_id']);
            cookie('seller_id', $sellerInfo['id'], 3600 * 24 * 30);
            cookie('address_id', $sellerInfo['address_id'], 3600 * 24 * 30);
            $this->redirect('Seller/seller_home');
        } else {
            $this->assign('headimgurl', $wxInfo['headimgurl']);
            $this->assign('nickname', $wxInfo['nickname']);
            $this->display();
        }
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
        //获取微信信息
        $wxInfo = cookie('wxInfo');
        $this->assign('headimgurl', $wxInfo['headimgurl']);
        $this->assign('nickname', $wxInfo['nickname']);
        $this->display();
    }

    /**
     * 完善信息页
     */
    public function perfect_info() {
        //获取微信信息
        $wxInfo = cookie('wxInfo');

////        //测试数据
//        $wxInfo = array(
//            'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKHRoX9H0IXWmiaxlXzb3O9ILcicFoZqRjRZWe0xKk0bdPqiag4shDYyXw94TL6pDRiaV4svlVlKraBnw/132',
//            'openid' => 'oadwq03_g0B0lvOGQG6Id5vUIwNQ',
//            'nickname' => '忘忧草',
//        );
        $this->assign('wxInfo', $wxInfo);
        $this->assign('tel', $_GET['tel']);
        $this->display();
    }

    /**
     * 完善信息页
     */
    public function wechat_binding() {
        //获取微信信息
        $wxInfo = cookie('wxInfo');

////        //测试数据
//        $wxInfo = array(
//            'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKHRoX9H0IXWmiaxlXzb3O9ILcicFoZqRjRZWe0xKk0bdPqiag4shDYyXw94TL6pDRiaV4svlVlKraBnw/132',
//            'openid' => 'oadwq03_g0B0lvOGQG6Id5vUIwNQ',
//            'nickname' => '忘忧草',
//        );
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
        cookie('seller_id', 82, 3600 * 24 * 30);
        cookie('address_id', 1, 3600 * 24 * 30);
        $this->redirect('Seller/seller_home');
    }

    /**
     * 保存新注册商家信息
     */
    public function saveSellerInfo() {
        $sellerModel = D('seller_info');


        $saveArr['tel'] = $_POST['tel'];
        $saveArr['address_id'] = $_POST['address_id'];
        $saveArr['business_license'] = $_POST['business_license'];
        $saveArr['address'] = $_POST['address'];
        $saveArr['name'] = $_POST['name'];
        $saveArr['address_api_url'] = $_POST['address_api_url'];
        $saveArr['contacts'] = $_POST['contacts'];
        $saveArr['tx_path'] = $_POST['headimgurl'];

//        dump($saveArr);
        if (!$sellerModel->create($saveArr)) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => $sellerModel->getError());
        } else {
            $tranModel = M();
            //开启事务  
            $tranModel->startTrans();

            $newSellerId = $tranModel->table($this->dbFix . 'seller_info')->add($saveArr);
            $wxArr['seller_id'] = $newSellerId;
            $wxArr['open_id'] = $_POST['openid'];
            $wxArr['name'] = $_POST['nickname'];
            $wxArr['headimgurl'] = $_POST['headimgurl'];

            $addFlag = $tranModel->table($this->dbFix . 'seller_wechat_binding')->add($wxArr);

            $flag = $newSellerId && $addFlag;

            if ($flag) {
                $tranModel->commit(); // 成功则提交事务  
                $returnData['is_success'] = array('flag' => 1, 'msg' => '注册成功,请完善资质信息!');
            } else {
                $tranModel->rollback(); // 否则将事务回滚  
                $returnData['is_success'] = array('flag' => 0, 'msg' => '注册失败!');
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 微信绑定到已有的商家帐号上
     */
    public function bindingSellerInfo() {
        $sellerInfo = M('seller_info')->where('tel=' . $_POST['tel'])->find();

        $wxArr['seller_id'] = $sellerInfo['id'];
        $wxArr['open_id'] = $_POST['wx_num'];
        $wxArr['name'] = $_POST['nickname'];
        $wxArr['headimgurl'] = $_POST['tx_path'];

        $addFlag = M('seller_wechat_binding')->add($wxArr);

        if ($addFlag) {
            $returnData['is_success'] = array('flag' => 1, 'msg' => '微信绑定成功!');
        } else {
            $returnData['is_success'] = array('flag' => 0, 'msg' => '微信绑定失败!');
        }
        $this->ajaxReturn($returnData);
    }

}
