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
        $a = $this->httpRequest($a, '');
        $wxInfo = json_decode($a, true);

        $b = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $wxInfo['access_token'] . "&openid=" . $wxInfo['openid'];
        $b = $this->httpRequest($b, '');
        $userInfo = json_decode($b, true);

        $wx['headimgurl'] = $userInfo['headimgurl'];
        $wx['openid'] = $userInfo['openid'];
        $wx['nickname'] = $userInfo['nickname'];
        cookie('wxInfo', $wx, 3600 * 24 * 30);

        $this->redirect('Index/index');
    }

    public function index() {
        $mxInfo = cookie('wxInfo');
        
        //先检测是否已有帐号
        
        dump($mxInfo);
        
        $this->assign('headimgurl', $mxInfo['headimgurl']);
        $this->assign('nickname', $mxInfo['nickname']);
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

}
