<?php

/**
 * @name DeviceinfoController
 * @info 描述：设备信息管理控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-24 13:29:11
 */

namespace Health\Controller;

use Think\Controller;

class DeviceInfoController extends BaseDBController {
    //put your code here
    protected $Model;

    public function _initialize() {
        $this->Model = D('DeviceInfo');
    }
    
    /**
     * function:显示分类列表
     */
    public function showList() {
        parent::showData($this->Model, [], [], '', '');
    }

    /**
     * function:添加/编辑
     * @return code(501验证未通过 500成功 502失败)
     */
    public function saveDeviceInfoCat() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        if (!$this->Model->create($param_arr)) {
            $returnData['code'] = '501'; //验证未通过
            $returnData['msgError'] = $this->Model->getError();
        } else {
            if (empty($param_arr['id'])) {
                $result = $this->Model->add($param_arr); //数据写入
            } else {
                $result = $this->Model->save($param_arr); //数据更新
            }
            if ($result !== false) {
                $logC = A('Actionlog')->addLog('DeviceInfo', 'saveDeviceInfoCat', '添加/编辑体检设备');
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
     * 删除体检设备
     */
    public function delDeviceInfo() {
        $condition['id'] = array('EQ', $_POST['id']);
        if (false !== $this->Model->where($condition)->delete()) {
            $logC = A('Actionlog')->addLog('DeviceInfo', 'delDeviceInfo', '删除体检设备');
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 批量删除体检设备
     */
    public function delArrayCat() {
        $logC = A('Actionlog')->addLog('DeviceInfo', 'delArrayCat', '批量删除体检设备');
        $this->Model->delete(rtrim($_POST['ids'], ",")); // 删除主键为ids的数据
    }
}
