<?php

/**
 * @name BaseDBController
 * @info 描述：基础数据库操作控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Health\Controller;

use Think\Controller;

class BaseDBController extends Controller {

    public function _initialize() {
        //初始化do something
    }

    /**
     * 获取列表
     * @param type $model
     * @param type $where
     * @param type $pageCondition
     * @param type $joinStr
     * @param type $fieldStr
     */
    public function showData($model, $where, $pageCondition, $joinStr, $fieldStr) {
        $page = getPage($model, $where, $pageCondition, C('PAGE_SIZE'));
        $infoList = $model->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        $page = $page->show();
        $this->assign('page', $page);
        $this->assign('searchInfo', $pageCondition);
        $this->assign('infoList', $infoList);
        $this->display();
    }

    /**
     * function:保存数据
     * @param $model
     * @param $Array
     * @return mixed
     */
    public function saveData($model, $Array) {
        if (!$model->create($Array)) {
            $returnData['code'] = '501'; //验证未通过
            $returnData['msgError'] = $model->getError();
        } else {
            if (empty($Array['id'])) {
                $result = $model->add($Array); //数据写入
                $returnData['dataID'] = $result;
            } else {
                $result = $model->save($Array); //数据更新
            }
            if ($result !== false) {
                $returnData['code'] = '500';
            } else {
                $returnData['code'] = '502';
            }
        }
        return $returnData;
    }

    /**
     * function:删除单条数据
     * @param $model
     * @param $id
     * @return mixed
     */
    public function delData($model, $id) {
        $condition['id'] = array('EQ', $id);
        if ($model->where($condition)->delete() !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
    }

    /**
     * function:批量删除数据
     * @param $model
     * @param $str
     */
    public function delArrayData($model, $str) {
        $model->delete($str);
    }

    /**
     * function:根据条件设置某个字段的值
     * @param $condition
     * @param $data
     * @return mixed
     */
    public function setFieldData($condition, $data) {
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
    }

    /**
     * function:获取某一条数据By ID
     * @param $model
     * @param $id
     * @return mixed
     */
    public function getData($model, $id) {
        $condition['id'] = array('EQ', $id);
        $result = $model->where($condition)->find();
        if (isset($result)) {
            $returnData['code'] = '500';
            $returnData['data'] = $result;
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
    }

}
