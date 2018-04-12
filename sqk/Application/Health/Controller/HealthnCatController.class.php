<?php

/**
 * @name HealthnCatController
 * @info 描述：健康知识分类控制器
 * @author Hellbao
 * @datetime 2017-2-15 13:29:13
 */

namespace Health\Controller;

use Think\Controller;

class HealthnCatController extends BaseDBController {

    protected $catModel;
    protected $infoModel;

    public function _initialize() {
        $this->catModel = D('HealthnCat');
        $this->infoModel = M('HealthInfo');
    }

    /**
     * function:显示分类列表
     */
    public function showList() {
        parent::showData($this->catModel, [], [], '', '');
    }

    /**
     * function:获取列表（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

    /**
     * function:添加/编辑分类
     * @return code(501验证未通过 500成功 502失败)
     */
    public function saveHealthCat() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        if (!$this->catModel->create($param_arr)) {
            $returnData['code'] = '501'; //验证未通过
            $returnData['msgError'] = $this->catModel->getError();
        } else {
            if (empty($param_arr['id'])) {
                $result = $this->catModel->add($param_arr); //数据写入
            } else {
                $result = $this->catModel->save($param_arr); //数据更新
            }
            if ($result !== false) {
                $logC = A('Actionlog')->addLog('HealthnCat', 'saveHealthCat', '添加/编辑健康知识分类');
                $returnData['code'] = '500';
            } else {
                $returnData['code'] = '502';
            }
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
     * function:删除分类及分类下的信息
     */
    public function delHealthCat() {
        $condition['id'] = array('EQ', $_POST['id']);
        $catInfo = $this->catModel->where($condition)->find(); //获取某条分类信息(ID)
        $childCatArray = $this->catModel->where(array('parent_id_path' => array('LIKE', $catInfo['parent_id_path'] . $catInfo['id'] . '.%')))->select();
        if (count($childCatArray) > 0) {
            foreach ($childCatArray as $value) {
                $healthInfoList = $this->infoModel->where(array('cat_id' => $value['id']))->select();
            }
        }
        if (false !== $this->catModel->where($condition)->delete()) {
            if (count($childCatArray) > 0) {
                foreach ($childCatArray as $value) {
                    $this->catModel->where(array('id' => $value['id']))->delete();
                }
            }
            if (count($healthInfoList) > 0) {
                foreach ($healthInfoList as $value) {
                    $this->catModel->where(array('id' => $value['id']))->save();
                }
            }
            $logC = A('Actionlog')->addLog('HealthnCat', 'delHealthCat', '删除健康知识分类');
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 批量删除
     */
    public function delArrayCat() {
        $logC = A('Actionlog')->addLog('HealthnCat', 'delArrayCat', '批量删除健康知识分类');
        $this->catModel->delete(rtrim($_POST['ids'], ",")); // 删除主键为ids的数据
    }

}
