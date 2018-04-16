<?php

/**
 * @name ApiController
 * @info 描述：API控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:02:04
 */

namespace Admin\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:GET'); //支持的http动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class ApiController extends BaseDBController {

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 设置社区读卡串号
     * 加密待做*******
     */
    public function setCardUfNum() {
        $addressId = $_GET['addressId'];
        $cardUfNum = $_GET['cardUfNum'];
        $where['address_id'] = array('EQ', $addressId);
        $ufInfo = M('sys_community_info')->where($where)->find();
//        dump($ufInfo);
        if (!empty($ufInfo)) {
            $timestamp = time();
            $data['uf_num'] = $cardUfNum;
            $data['timestamp'] = $timestamp;
            $result = M('sys_community_info')->where($where)->setField($data);
            if ($result !== false) {
                $returnData['status'] = 1;
                $returnData['msg'] = 'Success!';
            } else {
                $returnData['status'] = 0;
                $returnData['msg'] = 'The Write Operation Failed!';
            }
        } else {
            $returnData['status'] = 0;
            $returnData['msg'] = 'Not Find AddressId!';
        }
        $returnData['timestamp'] = $timestamp;
        echo json_encode($returnData);
    }

}
