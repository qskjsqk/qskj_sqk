<?php

/**
 * @name TradingController
 * @info 描述：交易记录控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-5-4 10:21:24
 */

namespace Seller\Controller;

use Think\Controller;
use Seller\Controller\BaseController; 

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class TradingController extends BaseController {

    //put your code here
    public function _initialize() {
        parent::_initialize();
    }

}
