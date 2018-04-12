<?php

/**
 * @name HelpinfoController
 * @info 描述：应急服务信息控制器
 * @author Hellbao
 * @datetime 2017-4-10 10:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class HelpInfoController extends BaseDBController {

    protected $Model;

    public function _initialize() {
        $this->Model = D('HelpInfo');
    }

    /**
     * function:显示社区列表
     */
    public function showList() {
        $where['cat_id'] = 0;
        parent::showData($this->Model, $where, $where, '', '');
    }

    /**
     * function:显示紧急联系人列表
     */
    public function showHelpList() {
        if(!empty($_GET['keyword'])){
            $where['realname|tel|department|phone|comment']=array('LIKE','%'.urldecode($_GET['keyword']).'%');
            $pageCondition['keyword']=urldecode($_GET['keyword']);
        }
        $where['cat_id'] = 1;
        parent::showData($this->Model, $where, $pageCondition, '', '');
    }

    /**
     * function:添加/编辑社区电话
     * @return code(501验证未通过 500成功 502失败)
     */
    public function saveHelpInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['cat_id'] = 0;
        $returnData = parent::saveData($this->Model, $param_arr);
        if ($returnData['code'] == '500') {
            $logC = A('Actionlog')->addLog('HelpInfo', 'saveHelpInfo', '添加/编辑联系人信息');
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:添加/编辑紧急联系人
     * @return code(501验证未通过 500成功 502失败)
     */
    public function saveMyHelpInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['cat_id'] = 1;
        $returnData = parent::saveData($this->Model, $param_arr);
        if ($returnData['code'] == '500') {
            $logC = A('Actionlog')->addLog('HelpInfo', 'saveHelpInfo', '添加/编辑联系人信息');
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:根据ID查询某一条数据
     */
    public function findInfoById() {
        $condition['id'] = array('EQ', $_POST['id']);
        $result = $this->Model->where($condition)->find();
        if (isset($result)) {
            $returnData['code'] = '500';
            $returnData['data'] = $result;
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除信息
     */
    public function delHelpInfo() {
        $condition['id'] = array('EQ', $_POST['id']);
        $catInfo = $this->Model->where($condition)->find(); //获取某条分类信息(ID)

        if (false !== $this->Model->where($condition)->delete()) {
            $returnData['code'] = '500';
            $logC = A('Actionlog')->addLog('HelpInfo', 'delHelpInfo', '批量删除联系人');
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    public function delArrayCat() {
        $this->Model->delete(rtrim($_POST['ids'], ",")); // 删除主键为ids的数据
        $logC = A('Actionlog')->addLog('HelpInfo', 'delArrayCat', '批量删除联系人');
    }

}
