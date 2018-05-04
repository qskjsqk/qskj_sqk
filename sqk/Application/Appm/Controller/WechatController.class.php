<?php

/**
 * @name WechatController
 * @info 描述：微信网页授权控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-05-04 11:23:30
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class WechatController extends Controller {

    protected $config;
    public $appid = 'wx7e5a0f04c993739e';                   //微信APPID，公众平台获取  
    public $appsecret = '510fd7ca5fb268fc06502e9861e00b69'; //微信APPSECREC，公众平台获取  
    public $index_url = "http://lyznsq.qmtsc.com/index.php/appm/index/index";  //微信回调地址，要跟公众平台的配置域名相同  
    public $code;
    public $openid;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Admin/Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);

        $this->code = $this->getCode();
        dump($this->code);
//        if (!$_SESSION['openid']) {                             //如果$_SESSION中没有openid，说明用户刚刚登陆，就执行getCode、getOpenId、getUserInfo获取他的信息  
//            $this->code = $this->getCode();
//            $this->access_token = $this->getOpenId();
//            $userInfo = $this->getUserInfo();
//            
//            dump($userInfo);
//            if ($userInfo) {
//                $ins = M('Wechat_user_info');
//                $map['openid'] = $userInfo['openid'];
//                $result = $ins->where($map)->find();            //根据OPENID查找数据库中是否有这个用户，如果没有就写数据库。继承该类的其他类，用户都写入了数据库中。  
//                if (!$result) {
//                    $ins->add($userInfo);
//                }
//                session('openid', $userInfo['openid']);         //写到$_SESSION中。微信缓存很坑爹，调试时请及时清除缓存再试。  
//            }
//        }
    }

    /**
     * @explain 
     * 获取code,用于获取openid和access_token 
     * @remark 
     * code只能使用一次，当获取到之后code失效,再次获取需要重新进入 
     * 不会弹出授权页面，适用于关注公众号后自定义菜单跳转等，如果不关注，那么只能获取openid 
     * */
    public function getCode() {
        if (isset($_GET["code"])) {
            return $_GET["code"];
        } else {
            $str = "location: https://open.weixin.qq.com/connect/oauth2/authorize?appid="
                    . $this->appid
                    . "&redirect_uri="
                    . $this->index_url
                    . "&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
            header($str);
            exit;
        }
    }

    /**
     * @explain 
     * 通过code获取用户openid以及用户的微信号信息 
     * @return 
     * @remark 
     * 获取到用户的openid之后可以判断用户是否有数据，可以直接跳过获取access_token,也可以继续获取access_token 
     * access_token每日获取次数是有限制的，access_token有时间限制，可以存储到数据库7200s. 7200s后access_token失效 
     * */
    public function getUserInfo() {

        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $this->access_token['access_token'] . "&openid=" . $this->access_token['openid'] . "&lang=zh_CN";
        $userinfo_json = $this->https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json, TRUE);
        return $userinfo_array;
    }

    /**
     * @explain 
     * 发送http请求，并返回数据 
     * */
    public function https_request($url, $data = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

}
