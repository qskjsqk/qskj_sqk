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
        cookie('pwd', '123', 3600 * 24 * 30);
        cookie('cookie_user', '商家5', 3600 * 24 * 30);
        cookie('seller_id', 38, 3600 * 24 * 30);
        cookie('address_id', 1, 3600 * 24 * 30);
        $this->redirect('seller/seller_home');
    }

    public function index() {
        //        模拟微信授权数据
        $wx['headimgurl'] = "http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKpN65upRlsfibjY7Lia7l1v99lf7kOAp6tNe2Oa0X07yR0Pqun2tLcwGXyrrR08tMavSIBVblnOhLA/132";
        $wx['openid'] = "ozF060wIC0F5P5GLlrfw0OEMpeGM";
        $wx['nickname'] = "忘忧草";
        cookie('wxInfo', $wx, 3600 * 24 * 30);
        
        
        
        $mxInfo = cookie('wxInfo');
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
//            //通知条数
//            $noticeC = A('Notice');
//            $isEnableNoticeCat = $noticeC->getEnableCatIds();
//            $data['notice_num'] = M('NoticeInfo')->where('is_publish=1 and read_ids not like "%,' . $user_id . ',%" and cat_id in (' . $isEnableNoticeCat . ')')->count();
//            //活动条数
//            $activityC = A('Activity');
//            $isEnableActivityCat = $activityC->getEnableCatIds();
//            $data['activity_num'] = M('ActivInfo')->where('is_publish=1 and read_ids not like "%,' . $user_id . ',%" and cat_id in (' . $isEnableActivityCat . ')')->count();

            $returnData['data'] = $data;
            $returnData['flag'] = $seller_id;
        }
        $this->ajaxReturn($returnData);
    }

}
