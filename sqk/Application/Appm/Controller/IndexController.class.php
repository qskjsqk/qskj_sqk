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

//    视图
//------------------------------------------------------------------------------    
    public function index() {
        if ($_COOKIE['user_id'] == null) {
            $this->redirect('Login/index');
        } else {
            $this->redirect('Activity/activity_list');
        }
    }

    public function setting() {
        $this->display();
    }

    public function my_info() {
        $this->display();
    }

    public function my_notice() {
        $this->display();
    }

    public function my_card() {
        $this->display();
    }

    public function activ_list() {
        $this->display();
    }

    public function signin_list() {
        $this->display();
    }
    
    public function litem_list() {
        $this->display();
    }
    
    public function order_list() {
        $this->display();
    }

    /**
     * 调试代码
     */
    public function zxw() {
        
    }

}
