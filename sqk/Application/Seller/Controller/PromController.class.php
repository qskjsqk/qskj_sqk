<?php

/**
 * @name PromController
 * @info 描述：广告管理控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-5-4 10:15:40
 */

namespace Seller\Controller;

use Think\Controller;
use Seller\Controller\BaseController;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class PromController extends BaseController {

    //put your code here

    public function _initialize() {
        parent::_initialize();
    }

    public function getMyPromList() {
        $seller_id = cookie('seller_id');

        $num = C('PAGE_NUM')['prom'] * $_POST['page'];

        if ($_POST['type'] != 0) {
            $where['status'] = ['EQ', $_POST['type']];
        }

        $where['seller_id'] = ['EQ', $seller_id];

        $promArr = M('SellerPromInfo')->where($where)->order('id desc')->limit($num)->select();
        //调试sql
        $returnData['sql'] = M('SellerPromInfo')->getLastSql();

        $count = M('SellerPromInfo')->where($where)->count();
        $returnData['count'] = $count;



        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_POST['page'];
        $returnData['type'] = $_POST['type'];

        if (empty($promArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($promArr); $i++) {
                $data[$i]['id'] = $promArr[$i]['id'];
                $data[$i]['title'] = $promArr[$i]['title'];

                $data[$i]['content'] = strip_tags($promArr[$i]['content']);

                $data[$i]['read_num'] = $promArr[$i]['read_num'];


                $picsInfo = parent::getAttachArr('sellerProm', $promArr[$i]['id']);
                if ($picsInfo['flag'] == 1) {
                    $data[$i]['pics'] = $picsInfo['data'];
                } else {
                    $data[$i]['pics'] = 0;
                }
            }
            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        $this->ajaxReturn($returnData);
    }

}
