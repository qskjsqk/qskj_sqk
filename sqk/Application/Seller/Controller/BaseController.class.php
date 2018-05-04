<?php

/**
 * @name BaseController
 * @info 描述：公共控制器
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 11:07:00
 */

namespace Seller\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class BaseController extends Controller {

//------------------------------------------------------------------------------
    protected $config;

    protected $dbFix;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Admin/Configdef');
        $this->config = $configdefC->getAllDef();
        $this->dbFix = $this->config['db_fix'];
        $this->assign('config', $this->config);
    }
}
