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
        $sellerInfo = A('Seller')->getSellerInfo();
        $seller_id = cookie('seller_id');
        if ($_POST['type'] != 0) {
            $where['status'] = ['EQ', $_POST['type']];
        }
        $where['seller_id'] = ['EQ', $seller_id];
        $promArr = M('SellerPromInfo')->where($where)->order('id desc')->select();
        //调试sql
        $returnData['sql'] = M('SellerPromInfo')->getLastSql();

        $count = M('SellerPromInfo')->where($where)->count();
        $returnData['count'] = $count;

        $promStat['status1'] = M('SellerPromInfo')->where('seller_id=' . $seller_id . ' and status=1')->count();
        $promStat['status3'] = M('SellerPromInfo')->where('seller_id=' . $seller_id . ' and status=3')->count();
        $promStat['status02'] = M('SellerPromInfo')->where('seller_id=' . $seller_id . ' and (status=0 or status=2)')->count();

        if (empty($promArr)) {
            $returnData['flag'] = 0;
        } else {
            $allReadNum = 0;
            for ($i = 0; $i < count($promArr); $i++) {
                $data[$i]['id'] = $promArr[$i]['id'];
                $data[$i]['title'] = $promArr[$i]['title'];
                $data[$i]['status'] = $promArr[$i]['status'];

                $data[$i]['content'] = strip_tags($promArr[$i]['content']);

                $data[$i]['read_num'] = $promArr[$i]['read_num'];
                $allReadNum += (int) $promArr[$i]['read_num'];

                $picsInfo = parent::getAttachArr('sellerProm', $promArr[$i]['id']);
                if ($picsInfo['flag'] == 1) {
                    $data[$i]['pics'] = $picsInfo['data'];
                } else {
                    $data[$i]['pics'] = 0;
                }
            }
            $returnData['flag'] = 1;
            $returnData['data'] = $data;
            $returnData['promStat'] = $promStat;
            $returnData['allReadNum'] = $allReadNum;
            $returnData['sellerInfo'] = $sellerInfo;
        }
        $this->ajaxReturn($returnData);
    }

    public function prom_detail() {
        $id = $_GET['id'];
        $where['id'] = ['EQ', $id];
        $promInfo = M('seller_prom_info')->where($where)->find();
        $promInfo['pics'] = $this->getAttachArr('sellerProm', $id);
        $this->assign('promInfo', $promInfo);

        $this->display();
    }

    public function prom_add() {
        $this->display();
    }

    public function prom_edit() {
        $id = $_GET['id'];

        $where['id'] = ['EQ', $id];
        $promInfo = M('SellerPromInfo')->where($where)->find();
        $attachList = $this->getAttachArr('sellerProm', $id);
        if($attachList['flag']==1){
            $attachList=$attachList['data'];
            $this->assign('attachList', json_encode($attachList));
        }
        
        $this->assign('promInfo', $promInfo);
        $this->display('prom_add');
    }

    public function savePromInfo() {
        $post = getFormData();

        $post['seller_id'] = cookie('seller_id');
        $post['status'] = 0;

        $returnData = parent::saveData(M('SellerPromInfo'), $post);
        if ($returnData['code'] == '500') {
            foreach ($post['files'] as $value) {
                $condition['id'] = array('EQ', $value);
                if ($returnData['flag'] == 'add') {
                    $data = array('module_info_id' => $returnData['dataID']);
                } else {
                    $data = array('module_info_id' => $post['id']);
                }
                M('SysAllAttach')->where($condition)->setField($data);
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

}
