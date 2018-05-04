<?php

/**
 * @name BaseController
 * @info 描述：公共控制器
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 12:05:00
 */

namespace Appm\Controller;

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

    /**
     * 去除二维数组中的重复元素
     * @param  array $arr
     * @return array
     */
    protected static function arrayUniqueErwei($arr) {
        $keys = [];
        foreach($arr as $k => $v) {
            if($k == 0) {
                $keys = array_keys($v);
            }
            //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $v = join(',', $v);
            $temp[$k] = $v;
        }
        //去掉重复的字符串,也就是重复的一维数组
        $temp = array_values(array_unique($temp));
        foreach($temp as $k => $v) {
            //再将拆开的数组重新组装
            $array = explode(',', $v);
            //重新配置索引
            for($i = 0; $i < count($array); $i++) {
                $temp2[$k][$keys[$i]] = $array[$i];
            }
        }
        return $temp2;
    }

}
