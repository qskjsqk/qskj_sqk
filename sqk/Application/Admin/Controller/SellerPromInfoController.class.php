<?php

/**
 * @name SellerPromInfoController
 * @info 描述：商家广告信息控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerPromInfoController extends BaseDBController {

    protected $infoModel;
    protected $sellerPromModel;
    protected $userGroupModel;
    protected $userInfoModel;
    protected $communityInfoModel;
    protected $sellerInfoModel;
    protected $attachModel;

    public function _initialize() {
        parent::_initialize();
        $this->infoModel = D('SellerPromInfo');
        $this->sellerPromModel = D('SellerPromInfo');
        $this->userGroupModel = D('SysUserGroup');
        $this->userInfoModel = D('SysUserInfo');
        $this->communityInfoModel = D('SysCommunityInfo');
        $this->sellerInfoModel = D('SellerInfo');
        $this->attachModel = D('SysAllAttach');
    }

    /**
     * function:根据权限显示广告信息列表
     */
    public function showList() {
        $sysName = session('sys_name');
        if (!empty($sysName)) {
            if (empty(I('seller_id'))) {
                $userGroups = $this->userGroupModel->where(['is_enable' => 1])->getField('sys_name', true);
                if (in_array($sysName, $userGroups)) {
                    $this->showPromInfo($sysName, null);
                }
            } else {
                $this->assign('from', I('from'));
                $this->assign('seller_id', I('seller_id'));
                $this->showPromInfo('', I('seller_id'));
            }
        }
    }

    public function showPromInfo($role, $seller_id = null) {
        if ($role == 'sqAdmin' && empty($seller_id)) {
            $address = $this->userInfoModel->find(session('user_id'));
            $where['address_id'] = $address['address_id'];
        } elseif (empty($role) && !empty($seller_id)) {
            $where['seller_id'] = $seller_id;
        }
        parent::showData($this->infoModel, $where, [], '', '');
    }

    /**
     * function:跳转新增商家广告信息页面
     */
    public function saveSellerProm() {
        $sellerPromInfo['seller_id'] = $_GET['seller_id'];
        $this->assign('sellerPromInfo', $sellerPromInfo);
        $this->assign('communitys', $this->communityInfoModel->getLists());
        $this->assign('community', $this->communityInfoModel->where(['id' => session('address_id')])->getField('com_name'));
        $this->assign('sellers', $this->sellerInfoModel->getSellerListByAddressId(session('address_id')));
        if (!empty(I('from'))) {
            $this->assign('from', I('from'));
        }

        $this->display();
    }

    /**
     * 异步通过社区id获取商家列表并返回
     */
    public function getSellerListSync() {
        $sellers = $this->sellerInfoModel->getSellerListByAddressId(I('address_id'));
        if (!empty($sellers)) {
            $data = ['code' => 0, 'sellers' => $sellers];
        } else {
            $data = ['code' => -1, 'sellers' => ''];
        }
        $this->ajaxReturn($data, 'JSON');
    }

    /**
     * function:保存商家广告信息
     */
    public function saveSellerPromInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        if (empty($param_arr['seller_id'])) {
            $this->ajaxReturn(['code' => '501', 'msgError' => '商家必选'], 'JSON');
        }
        if (empty($param_arr['address_id'])) {
            $param_arr['address_id'] = session('address_id');
        }
        $param_arr['read_ids'] = ',';
        $returnData = parent::saveData($this->infoModel, $param_arr);
        if ($returnData['code'] == '500') {
            foreach ($param_arr['files'] as $value) {
                $condition['id'] = array('EQ', $value);
                if ($returnData['flag'] == 'add') {
                    $data = array('module_info_id' => $returnData['dataID']);
                } else {
                    $data = array('module_info_id' => $param_arr['id']);
                }
                $this->attachModel->where($condition)->setField($data);
            }
            $logC = A('Actionlog')->addLog('ActivInfo', 'saveSellerPromInfo', '添加/编辑广告信息');
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:返回某一商家服务项目列表
     */
    public function showItemsList() {
        $where['seller_id'] = $_POST['seller_id'];
        $fieldStr = 'qs_gryj_seller_items_info.*,qs_gryj_seller_items_cat.cat_name';
        $joinStr = 'LEFT JOIN __SELLER_ITEMS_CAT__ ON __SELLER_ITEMS_INFO__.cat_id=__SELLER_ITEMS_CAT__.id';
        $sellerInfoList = $this->sellerItemsModel->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->select();
        echo json_encode($sellerInfoList);
    }

    /**
     * function:编辑商家广告项目信息
     */
    public function edit() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        
        $condition['module_info_id'] = array('EQ', $returnData['data']['id']);
        $condition['module_name'] = array('EQ', 'sellerProm');
        $attachList = $this->attachModel->where($condition)->select(); //if(is_array($res) && count($res)>0)
        $this->assign('attachList', json_encode($attachList));
        
        $this->assign('sellerPromInfo', $returnData['data']);
        $this->assign('communitys', $this->communityInfoModel->getLists());
        $this->assign('community', $this->communityInfoModel->where(['id' => session('address_id')])->getField('com_name'));
        $this->assign('sellers', $this->sellerInfoModel->getSellerListByAddressId(session('address_id')));
        if (!empty(I('from'))) {
            $this->assign('from', I('from'));
        }
        $this->display('saveSellerProm');
    }

    /**
     * function:广告详情
     */
    public function promDetail() {
        
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        $usrCondition['id'] = array('EQ', $returnData['data']['user_id']);
        $usrInfo = $this->userInfoModel->field('realname,usr')->where($usrCondition)->find();
        $returnData['data']['usr'] = (!empty($usrInfo['realname']) ? $usrInfo['realname'] : $usrInfo['usr']);
        $condition['module_info_id'] = $returnData['data']['id'];
        $condition['module_name'] = array('EQ', 'sellerProm');
        $imgInfoList = $this->attachModel->where($condition)->order('id desc')->select();
        $this->assign('prom', $returnData['data']);
        $this->assign('imgInfo', $imgInfoList);

        $this->display();
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delPromInfo($id) {
        $successFlag = true;
        $returnData = parent::delData($this->infoModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        }
        return $successFlag;
    }

    /**
     * function:批量删除数据
     */
    public function delArrPromInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delPromInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:返回被选择的服务项目列表
     */
    public function showSelectItems() {
        $where['qs_gryj_seller_items_info.id'] = array('IN', trim($_POST['selected_id'], ",")); //trim($str,"Hed!")
        $fieldStr = 'qs_gryj_seller_items_info.*,qs_gryj_seller_items_cat.cat_name';
        $joinStr = 'LEFT JOIN __SELLER_ITEMS_CAT__ ON __SELLER_ITEMS_INFO__.cat_id=__SELLER_ITEMS_CAT__.id';
        $sellerPromInfoList = $this->sellerItemsModel->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->select();
        echo json_encode($sellerPromInfoList);
    }

}
