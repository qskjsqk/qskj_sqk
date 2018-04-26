<?php
/**
 * @name BaseModel
 * @info 描述：基础模型
 * @author xiaohuihui
 * @datetime 2018-4-22 12:09:13
 */
namespace Admin\Model;
use Think\Model;

class BaseModel extends Model {

    //表前缀
    public $dbFix;

    /**
     * 模型分页
     *
     * @access public
     * @param array $where  查询条件
     * @param array $map    追加到分页链接中的查询数据参数
     * @param array $join   连表
     * @param array $field  查询字段
     * @param mixed $order  排序(缺省则默认按照主表的id倒序)
     * @return array        分页、分页链接中参数、数据本体组成的数组
     */
    public function listPage($where = [], $map = [], $join = [], $field = [], $order = null) {
        $this->dbFix = C('DB_PREFIX');
        $page = self::getPage($this, $where, $map, C('PAGE_SIZE'), $join);
        $infoList = $this;
        if(!empty($join) && is_array($join)) {
            foreach($join as $val) {
                //$infoList->join($this->dbFix . $val[0] . ' ON ' . $this->dbFix . $val[0] . '.' . $val[1] . '=' . $this->dbFix . $this->tableName . '.' . $val[2], LEFT);
                $infoList->join($this->dbFix . $val[0] . ' ON ' . $this->dbFix . $val[0] . '.' . $val[1] . '=' . $this->dbFix . $val[2] . '.' . $val[3], LEFT);
            }
        }
        $infoList = $infoList->where($where);
        if(!empty($field) && is_array($field)) {
            $fieldStr = '';
            foreach($field as $k => $val) {
                if($k != (count($field) - 1)) {
                    $fieldStr .= $this->dbFix . $val . ',';
                } else {
                    $fieldStr .= $this->dbFix . $val;
                }
            }
            $infoList = $infoList->field($fieldStr);
        }
        if($order != null) {
            $infoList = $infoList->order($this->dbFix . $order);
        } else {
            $infoList = $infoList->order($this->dbFix . $this->tableName . '.id desc');
        }
        $infoList = $infoList->limit($page->firstRow . ',' . $page->listRows)->select();
        $page = $page->show();
        return [$page, $map, $infoList];

    }

    /**
     * 分页
     * @param type $m
     * @param type $where
     * @param type $page_size
     * @return \Think\Page
     */
    function getPage($m, $where, $map, $page_size, $join) {
        $count = $m;
        if(!empty($join) && is_array($join)) {
            foreach($join as $val) {
                //$count->join($this->dbFix . $val[0] . ' ON ' . $this->dbFix . $val[0] . '.' . $val[1] . '=' . $this->dbFix . $this->tableName . '.' . $val[2], LEFT);
                $count->join($this->dbFix . $val[0] . ' ON ' . $this->dbFix . $val[0] . '.' . $val[1] . '=' . $this->dbFix . $val[2] . '.' . $val[3], LEFT);
            }
        }
        $count = $count->where($where)->count();

        $Page = new \Think\Page($count, $page_size);
        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $Page->lastSuffix = false;
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        return $Page;
    }




}