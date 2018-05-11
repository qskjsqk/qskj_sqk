<?php

/**
 * @name SelleruserController
 * @info 描述：商家版控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-05-03 13:35:49
 */

namespace Dxt\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class SelleruserController extends Controller {

    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Admin/Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);
    }

//    --------------------------------------------------------------------------
    public function seller_home() {
        $this->display();
    }

    public function item_manage() {
        $this->display();
    }
    
    public function item_detail() {
        $this->display();
    }
    
    public function trading_detail() {
        $this->display();
    }
}
