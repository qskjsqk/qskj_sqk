<?php

/**
 * @name DocumentController
 * @info 描述：文档控制器 展示 
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 13:35:49
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class DocumentController extends BaseController {

    public function _initialize() {
        parent::_initialize();
    }
    
    public function userGuide() {
        $this->display();
    }


}
