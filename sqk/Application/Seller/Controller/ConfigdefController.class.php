<?php

/**
 * @name ConfigdefController
 * @info 描述：系统配置字典控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:53:29
 */

namespace Seller\Controller;

use Think\Controller;

class ConfigdefController extends Controller {
    /**
     * 获取所有配置字典
     */
    public function getAllDef() {
        $model = M(C('DB_CONFIG_DEF')); //实例化模型
        $defList = $model->select();
        if(empty($defList)){
            return FALSE;
        }else{
            foreach ($defList as $key => $value) {
                $returnArr[$value['set_key']]=$value['set_value'];
            }
            return $returnArr;
        }
    }

}
