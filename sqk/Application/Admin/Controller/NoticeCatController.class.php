<?php

/**
 * @name NoticeCatController
 * @info 描述：通知分类控制器
 * @author Gao Xue
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class NoticeCatController extends BaseDBController {

    protected $catModel;
    protected $infoModel;
    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);

        $this->catModel = D('NoticeCat');
        $this->infoModel = M('NoticeInfo');
    }

    /**
     * function:显示通知分类列表
     */
    public function showList() {
        parent::showData($this->catModel, [], [], '', '');
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
     * function:添加/编辑通知分类
     * @return code(501验证未通过 500成功 502失败)
     */
    public function saveNoticeCat() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $returnData = parent::saveData($this->catModel, $param_arr);
        if ($returnData['code'] == '500') {
            if (!empty($param_arr['id'])) {//编辑分类是否禁用
                $condition['parent_id_path'] = array('LIKE', $param_arr['parent_id_path'] . $param_arr['id'] . '.%');
                $catInfo = $this->catModel->where($condition)->select();
                if (is_array($catInfo) && count($catInfo) > 0) {
                    foreach ($catInfo as $key => $value) {
                        $where['id'] = $value['id'];
                        $data['is_enable'] = $param_arr['is_enable'];
                        $this->catModel->where($where)->setField($data);
                    }
                }
            }
            $logC = A('Actionlog')->addLog('NoticeCat', 'saveNoticeCat', '添加/编辑通知分类');
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:根据ID查询某一条数据
     */
    public function findInfoById() {
        $condition['id'] = array('EQ', $_POST['id']);
        $result = $this->catModel->where($condition)->find();
        if (isset($result)) {
            if (!empty($result['parent_id'])) {
                $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $result['parent_id']))->find();
                $result['category_name'] = $res['category_name'];
            } else {
                $result['category_name'] = '所有分类';
            }
            $returnData['code'] = '500';
            $returnData['data'] = $result;
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除通知分类及分类下的通知信息
     */
    public function delNoticeCat() {
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
            $logC = A('Actionlog')->addLog('NoticeCat', 'delNoticeCat', '删除通知分类');
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    public function delArrayCat() {
        $this->catModel->delete(rtrim($_POST['ids'], ",")); // 删除主键为ids的数据
        $logC = A('Actionlog')->addLog('NoticeCat', 'delArrayCat', '删除通知分类');
    }

}
