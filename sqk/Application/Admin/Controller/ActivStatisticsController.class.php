<?php

/**
 * @name ActivStatisticsController
 * @info 描述：活动统计控制器
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */

namespace Admin\Controller;

use Think\Controller;

class ActivStatisticsController extends BaseDBController {

    protected $vActivityModel;

    public function _initialize() {
        $this->vActivityModel = D('VActivity');
    }

    /**
     * function:显示活动信息列表
     */
    public function show() {
        $activityCount = array();
        $activityJoin = array();
        $activityLike = array();
        $yearArray = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        foreach ($yearArray as $kye => $value) {
            $condition['end_time'] = array('EQ', date('Y') . '-' . $value);
            $count = $this->vActivityModel->field('count,join_num,like_num')->where($condition)->find();
            if (!isset($count)) {
                $count['count'] = 0;
                $count['join_num'] = 0;
                $count['like_num'] = 0;
            }
            array_push($activityCount, (int) $count['count']);
            array_push($activityJoin, (int) $count['join_num']);
            array_push($activityLike, (int) $count['like_num']);
        }
        $data = array(array('name' => '每月活动', 'data' => $activityCount), array('name' => '参加人数', 'data' => $activityJoin), array('name' => '喜欢人数', 'data' => $activityLike));
        $this->assign('data', json_encode($data));
        $this->display();
    }

}
