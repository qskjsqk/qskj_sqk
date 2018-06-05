<?php

/**
 * @name SellerCatController
 * @info 描述：商家分类控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerInfoController extends BaseDBController {

    protected $infoModel;
    protected $attachModel;
    protected $communityInfoModel;
    protected $sellerWechatBindingModel;
    protected $sellerComplaintModel;

    public function _initialize() {
        parent::_initialize();

        $this->infoModel = D('SellerInfo');
        $this->attachModel = D('SysAllAttach');
        $this->communityInfoModel = D('SysCommunityInfo');
        $this->sellerWechatBindingModel = D('SellerWechatBinding');
        $this->sellerComplaintModel = D('SellerComplaint');
    }

    /**
     * function:显示商家信息列表
     */
    public function showList() {
        if (GET) {
            if (!empty(I('name'))) {
                $map['name'] = array('LIKE', '%' . urldecode(I('name')) . '%');
                $map['tel'] = array('LIKE', '%' . urldecode(I('name')) . '%');
                $map['_logic'] = 'or';
                $pageCondition['name'] = urldecode(I('name'));
                $where['_complex'] = $map;
            }
            if (!empty(I('address_id'))) {
                $where['address_id'] = intval(I('address_id'));
                $pageCondition['address_id'] = intval(I('address_id'));
            }
            if (!empty(I('status'))) {
                $where['status'] = intval(I('status')) - 1;     //页面下拉框中状态值比数据库中对应的状态值大1(为避开0)
                $pageCondition['status'] = I('status');
            }
        }

        if (session('sys_name') == 'sqAdmin') {
            $where['address_id'] = session('address_id');
        }
        $fieldStr = parent::madField('seller_info.*', 'sys_community_info.com_name');
        $joinStr = parent::madJoin('seller_info.address_id', 'sys_community_info.id');
        $data = [
            'communitys' => $this->communityInfoModel->getLists(),
            'sellerStatusMap' => $this->infoModel->sellerStatusMap(),
            'allSellerCount' => $this->infoModel->getSellerCount(),
            'currentComSellerCount' => $this->infoModel->getSellerCount(false),
            'complaintCount' => $this->sellerComplaintModel->getSellerComplaintCount(),
        ];
        $this->assign('data', $data);
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * 编辑/新增商家信息视图
     */
    public function edit() {
        $data = $attachList = $sellerInfo = $sellerWechat = [];
        if (!empty(I('id'))) {
            list($attachList, $sellerInfo, $sellerWechat) = self::getInfo(I('id'));
        }
        $data = [
            'communitys' => $this->communityInfoModel->getLists(),
            'community' => $this->communityInfoModel->where(['id' => session('address_id')])->getField('com_name'),
            'sellerInfo' => $sellerInfo,
            'sellerWechat' => $sellerWechat,
        ];
        if (!empty(I('id')))
            $data['attachList'] = $attachList;
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 商家详细信息只读视图
     */
    public function detail() {
        list($attachList, $sellerInfo, $sellerWechat) = self::getInfo(I('id'));
        $sellerInfo['com_name'] = $this->communityInfoModel->where(['id' => $sellerInfo['address_id']])->getField('com_name');
        $data = [
            'attachList' => json_decode($attachList, true),
            'sellerInfo' => $sellerInfo,
            'sellerWechat' => $sellerWechat,
            'sellerComplaintCount' => $this->sellerComplaintModel->getSellerComplaintCountById($sellerInfo['id']),
        ];
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 获取详情
     */
    public function getInfo($id) {
        if (empty($id))
            $this->redirect('/Admin/SellerInfo/showList');

        $attachList = $sellerInfo = $sellerWechat = [];
        $returnData = parent::getData($this->infoModel, $id);
        if ($returnData['code'] == '500') {
            $condition['module_info_id'] = ['EQ', $id];
            $condition['module_name'] = ['IN', "('tx_seller','zz_seller')"];
            $attachList = json_encode($this->attachModel->where($condition)->select());
            $sellerInfo = $returnData['data'];
            $sellerWechat = $this->sellerWechatBindingModel->where(['seller_id' => $id])->select();
        } else {
            $this->redirect('/Admin/SellerInfo/showList');
        }
        return [$attachList, $sellerInfo, $sellerWechat];
    }

    /**
     * 删除附件
     */
    public function delAttach() {
        $returnData = parent::delData($this->attachModel, $_POST['id']);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 解绑商家微信
     */
    public function untieWechat() {
        if ($this->sellerWechatBindingModel->where(['id' => I('id')])->save(['seller_id' => 0]) == true) {
            $this->ajaxReturn(syncData(0, '解绑成功'));
        } else {
            $this->ajaxReturn(syncData(-1, '解绑失败,请重新操作'));
        }
    }

    /**
     * 改变商家状态(审核通过/暂停)
     */
    public function changeSellerStatus() {
        $status['status'] = (I('status') == 0 || I('status') == 2) ? 1 : 2;
        if ($this->infoModel->where(['id' => I('id')])->save($status) == true) {
            $this->ajaxReturn(syncData(0, '操作成功'));
        } else {
            $this->ajaxReturn(syncData(-1, '操作失败,请重新操作'));
        }
    }

    /**
     * 异步删除商家
     */
    public function delSellerSync() {
        if ($this->infoModel->where(['id' => I('id')])->delete() == true) {
            M('seller_wechat_binding')->where(['seller_id' => I('id')])->delete();
            M('seller_complaint')->where(['seller_id' => I('id')])->delete();
            M('seller_integral_goods')->where(['seller_id' => I('id')])->delete();
            M('goods_exchange_record')->where(['seller_id' => I('id')])->delete();
            M('integral_tradint_record')->where('(income_id=' . I('id') . ' and income_type=3) or (payment_id=' . I('id') . ' and payment_type=3)')->delete();
            $this->ajaxReturn(syncData(0, '操作成功'));
        } else {
            $this->ajaxReturn(syncData(-1, '操作失败,请重新操作'));
        }
    }

    /**
     * 保存商家信息
     */
    public function saveSellerInfo() {
        $sellerInfo = [
            'id' => I('id'),
            'name' => I('name'),
            'tel' => I('tel'),
            'address_id' => I('address_id'),
            'contacts' => I('contacts'),
            'business_license' => I('business_license'),
            'address_api_url' => I('address_api_url'),
            'address' => I('address'),
            'address_id' => !empty(I('address_id')) ? I('address_id') : session('address_id'),
            'status' => 0, //默认待审核
            'admin_id' => session('user_id'),
        ];

        if ($this->infoModel->create($sellerInfo)) {
            if (empty(I('id'))) {
                $result = $this->infoModel->add($sellerInfo);
            } else {
                $this->infoModel->save($sellerInfo);
                $result = I('id');
            }
            if ($result !== false) {
                if (!empty(I('files')) && is_array(I('files'))) {
                    foreach (I('files') as $value) {
                        $this->attachModel->where(['id' => $value])->save(['module_info_id' => $result]);
                    }
                }
                A('Actionlog')->addLog('SellerInfo', 'saveSellerInfo', '添加/编辑商家信息');
                $this->redirect('/Admin/SellerInfo/detail/id/' . $result);
            }
        } else {
            $data = [
                'errorMsg' => $this->infoModel->getError(),
                'sellerInfo' => $sellerInfo,
                'communitys' => $this->communityInfoModel->getLists(),
                'community' => $this->communityInfoModel->where(['id' => session('address_id')])->getField('com_name'),
            ];
            $this->assign('data', $data);
            $this->display('edit');
        }
    }

    /**
     * 批量删除数据
     */
    public function delArraySellerInfo() {
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            $this->infoModel->where(['id' => $value])->delete();
        }
        $logC = A('Actionlog')->addLog('SellerInfo', 'delArraySellerInfo', '删除商家信息');
        $this->ajaxReturn(syncData(0, '已批量删除'));
    }

    /**
     * 批量审核商家信息
     */
    public function checkArrayInfo() {
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            $result = $this->infoModel->where(['id' => $value])->save(['status' => 1]);
            M('seller_wechat_binding')->where(['seller_id' => I('id')])->delete();
            M('seller_complaint')->where(['seller_id' => I('id')])->delete();
            M('seller_integral_goods')->where(['seller_id' => I('id')])->delete();
            M('goods_exchange_record')->where(['seller_id' => I('id')])->delete();
            M('integral_tradint_record')->where('(income_id=' . I('id') . ' and income_type=3) or (payment_id=' . I('id') . ' and payment_type=3)')->delete();
        }
        $logC = A('Actionlog')->addLog('SellerInfo', 'checkArrayInfo', '审核商家信息');
        $this->ajaxReturn(syncData(0, '已批量审核'));
    }

    /**
     * 获取商家分类列表彈出框中（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

}
