<?php

/**
 * @name SellerCatController
 * @info 描述：商家分类控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;

class SellerCatController extends BaseDBController {

    protected $catModel;
    protected $infoModel;

    public function _initialize() {
        $this->catModel = D('SellerCat');
        $this->infoModel = M('SellerInfo');
    }

    /**
     * function:显示商家分类列表
     */
    public function showList() {
        parent::showData($this->catModel, [], [], '', '');
    }

    /**
     * function:添加/编辑商家分类
     * @return code(501验证未通过 500成功 502失败)
     */
    public function saveSellerCat() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $returnData = parent::saveData($this->catModel, $param_arr);
        if ($returnData['code'] == '500') {
            $logC = A('Actionlog')->addLog('SellerCat', 'saveSellerCat', '添加/编辑商家分类');
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取通知列表（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

    /**
     * function:根据ID查询某一条数据
     */
    public function findInfoById() {
        $returnData = parent::getData($this->catModel, $_POST['id']);
        if ($returnData['code'] == '500') {
            if (!empty($returnData['data']['parent_id'])) {
                $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $returnData['data']['parent_id']))->find();
                $returnData['data']['category_name'] = $res['category_name'];
            } else {
                $returnData['data']['category_name'] = '所有分类';
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除通知分类及分类下的通知信息
     */
    public function delSellerCat() {
        $condition['id'] = array('EQ', $_POST['id']);
        $catInfo = $this->catModel->where($condition)->find(); //获取某条分类信息(ID)
        $childCatArray = $this->catModel->where(array('parent_id_path' => array('LIKE', $catInfo['parent_id_path'] . $catInfo['id'] . '.%')))->select();
        if (count($childCatArray) > 0) {
            foreach ($childCatArray as $value) {
                $noticeInfoList = $this->infoModel->where(array('cat_id' => $value['id']))->select();
            }
        }
        if (false !== $this->catModel->where($condition)->delete()) {
            if (count($childCatArray) > 0) {
                foreach ($childCatArray as $value) {
                    $this->catModel->where(array('id' => $value['id']))->delete();
                }
            }
            if (count($noticeInfoList) > 0) {
                foreach ($noticeInfoList as $value) {
                    $this->catModel->where(array('id' => $value['id']))->delete();
                }
            }
            $returnData['code'] = '500';
            $logC = A('Actionlog')->addLog('SellerCat', 'delSellerCat', '删除商家分类');
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:批量删除
     */
    public function delArrayCat() {
        $this->catModel->delete(rtrim($_POST['ids'], ",")); // 删除主键为ids的数据
        $logC = A('Actionlog')->addLog('SellerCat', 'delSellerCat', '删除商家分类');
    }

}
