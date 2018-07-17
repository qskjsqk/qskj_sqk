<?php

/**
 * @name SellerController
 * @info 描述：商家用户版 主控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-5-4 10:19:16
 */

namespace Seller\Controller;

use Think\Controller;
use Seller\Controller\BaseController;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class SellerController extends BaseController {

    /**
     * 初始化
     */
    public function _initialize() {
        parent::_initialize();
    }

//    视图======================================================================
//    ==========================================================================
    /**
     * 商家版首页
     */
    public function seller_home() {
        $this->assign('sellerInfo', $this->getSellerInfo());
        $this->display();
    }

    /**
     * 我的通知消息
     */
    public function my_notice() {
        $this->display();
    }

    /**
     * 商家版我的资料
     */
    public function my_info() {
        $this->assign('sellerInfo', $this->getSellerInfo());
        $this->display();
    }

    /**
     * 商家版我的资料
     */
    public function tx_upload() {
        $this->assign('sellerInfo', $this->getSellerInfo());
        $this->display();
    }

    /**
     * 商家版我的资料
     */
    public function zz_upload() {
        $this->assign('sellerInfo', $this->getSellerInfo());
        $this->display();
    }

    /**
     * 商家二维码
     */
    public function my_qrcode() {
        $sellerInfo = $this->getSellerInfo();
        if ($sellerInfo['detail_qrcode_path'] == "0") {
            $url = $this->config['system_ymurl'] . '/index.php/Appm/Qrcodeurl/seller_detail/id/' . $sellerInfo['id'] . '/';
            $url = $this->config['wx_token_p'] . $url . $this->config['wx_token_a'];
            $data['detail_qrcode_path'] = createQrcode($url);
            $this->setFieldData(M('seller_info'), $sellerInfo['id'], $data);
            $sellerInfo['detail_qrcode_path'] = $data['detail_qrcode_path'];
        }
        $this->assign('sellerInfo', $sellerInfo);
        $this->display();
    }

    /**
     * 收款二维码
     */
    public function transfer_qrcode() {
        $sellerInfo = $this->getSellerInfo();
        if ($sellerInfo['detail_qrcode_path'] == "0") {
            $url = $this->config['system_ymurl'] . '/index.php/Appm/Qrcodeurl/transfer_qrcode/id/' . $sellerInfo['id'] . '/';
            $url = $this->config['wx_token_p'] . $url . $this->config['wx_token_a'];
            $data['transfer_qrcode_path'] = createQrcode($url);
            $this->setFieldData(M('seller_info'), $sellerInfo['id'], $data);
            $sellerInfo['transfer_qrcode_path'] = $data['transfer_qrcode_path'];
        }
        $this->assign('sellerInfo', $sellerInfo);
        $this->display();
    }

//    视图end===================================================================
//    ==========================================================================

    /**
     * 获取商家资料
     */
    public function getSellerInfo() {
        $sellerModel = M('seller_info');
        $seller_id = cookie('seller_id');
        $result = $sellerModel->where(array('id' => $seller_id))->find();
        $result['address_name'] = getConameById($result['address_id']);

        $condition['module_info_id'] = $seller_id;
        $condition['module_name'] = array('EQ', 'zz_seller');
        $zzPic = M('sys_all_attach')->where($condition)->order('id desc')->select();
        $this->assign('zzPic', $zzPic);
        $this->assign('allattch', json_encode($zzPic));

//        $result['dd'] = $seller_id;

        if ($_GET['type'] == 'api') {
            $this->ajaxReturn($result);
        } else {
            return $result;
        }
    }

    /**
     * 保存用户信息
     */
    public function saveSellerInfo() {
        $sellerModel = M('seller_info');
        $seller_id = cookie('seller_id');
        $saveArr['tel'] = $_POST['tel'];
        $saveArr['address_id'] = $_POST['address_id'];
        $saveArr['business_license'] = $_POST['business_license'];
        $saveArr['address'] = $_POST['address'];
        $saveArr['name'] = $_POST['name'];
        $saveArr['address_api_url'] = $_POST['address_api_url'];
        $saveArr['contacts'] = $_POST['contacts'];
        $saveArr['status'] = 0;

//        dump($saveArr);
        if (!$sellerModel->create($saveArr)) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => $sellerModel->getError());
        } else {
            $result = $sellerModel->where('id=' . $seller_id)->save($saveArr); //数据更新
            if ($result === FALSE) {
                $returnData['is_success'] = array('flag' => 0, 'msg' => '修改资料失败!');
            } else {
                $returnData['is_success'] = array('flag' => 1, 'msg' => '修改资料成功!');
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 保存商家头像
     */
    public function saveTxInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $condition['id'] = array('EQ', $param_arr['files'][0]);
        $data = array('module_info_id' => cookie('seller_id'));
        M('sys_all_attach')->where($condition)->setField($data);
        $txPath = parent::getDataKey(M('sys_all_attach'), $param_arr['files'][0], 'file_path');
        $sellerData = array('tx_path' => $txPath);
        $result = M('seller_info')->where('id=' . cookie('seller_id'))->setField($sellerData);

        if ($result === FALSE) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => '修改头像失败!');
        } else {
            $returnData['is_success'] = array('flag' => 1, 'msg' => '修改头像成功!');
        }

        $this->ajaxReturn($returnData);
    }

    /**
     * 保存资质照片
     */
    public function saveZzInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        foreach ($param_arr['files'] as $value) {
            $condition['id'] = array('EQ', $value);
            $data = array('module_info_id' => cookie('seller_id'));
            $result = M('sys_all_attach')->where($condition)->setField($data);
        }
        if ($result === FALSE) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => '修改失败!');
        } else {
            $returnData['is_success'] = array('flag' => 1, 'msg' => '修改成功!');
        }

        $this->ajaxReturn($returnData);
    }

}
