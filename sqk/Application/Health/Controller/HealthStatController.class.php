<?php

/**
 * @name HealthStatController
 * @info 描述：体检信息统计
 * @author Hellbao <1036157505@qq.com>
 * @datetime '.$year.'-3-27 15:01:51
 */

namespace Health\Controller;

use Think\Controller;

class HealthStatController extends BaseDBController {

    /**
     * 健康统计数据
     */
    public function healthStat() {
        if ($_GET['year'] == null) {
            $year = date('Y', time());
        } else {
            $year = $_GET['year'];
        }
        $vModel = M('VHealth');
        $yearArr = $vModel->group('left(time,4)')->select();
        if (!empty($yearArr)) {
            foreach ($yearArr as $value) {
                $yArr[] = substr($value['time'], 0, 4);
            }
        } else {
            $yArr[] = date('Y', time());
        }
//        总数
        $return['sumCount'] = $vModel->count();
        $userArr = $vModel->group('idcard')->select();
        $return['userCount'] = count($userArr);
//        按分类
        $return['catArr']['su'] = count($vModel->where('type=6 and time like "' . $year . '-%"')->select());
        $return['catArr']['bs'] = count($vModel->where('type=5 and time like "' . $year . '-%"')->select());
        $return['catArr']['bp'] = count($vModel->where('type=7 and time like "' . $year . '-%"')->select());
        $return['catArr']['we'] = count($vModel->where('type=9 and time like "' . $year . '-%"')->select());
        $return['catArr']['te'] = count($vModel->where('type=3 and time like "' . $year . '-%"')->select());
//        $return['catArr']['he'] = count($vModel->where('type=0 and time like "' . $year . '-%"')->select());//身高体重
//       按月份
        for ($i = 1; $i < 13; $i++) {
            if ($i < 10) {
                $return['mArr']['m' . $i] = count($vModel->where('time like "' . $year . '-0' . $i . '-%"')->select());
            } else {
                $return['mArr']['m' . $i] = count($vModel->where('time like "' . $year . '-' . $i . '-%"')->select());
            }
        }
        $return['mArr']['count'] = count($vModel->where('time like "' . $year . '-%"')->select());
//        按分类按月
        for ($i = 1; $i < 13; $i++) {
            if ($i < 10) {
                $return['mcArr']['sum' . $i] = count($vModel->where('time like "' . $year . '-0' . $i . '-%" and type=6')->select());
            } else {
                $return['mcArr']['sum' . $i] = count($vModel->where('time like "' . $year . '-' . $i . '-%" and type=6')->select());
            }
        }
        for ($i = 1; $i < 13; $i++) {
            if ($i < 10) {
                $return['mcArr']['bsm' . $i] = count($vModel->where('time like "' . $year . '-0' . $i . '-%" and type=5')->select());
            } else {
                $return['mcArr']['bsm' . $i] = count($vModel->where('time like "' . $year . '-' . $i . '-%" and type=5')->select());
            }
        }
        for ($i = 1; $i < 13; $i++) {
            if ($i < 10) {
                $return['mcArr']['bpm' . $i] = count($vModel->where('time like "' . $year . '-0' . $i . '-%" and type=7')->select());
            } else {
                $return['mcArr']['bpm' . $i] = count($vModel->where('time like "' . $year . '-' . $i . '-%" and type=7')->select());
            }
        }
        for ($i = 1; $i < 13; $i++) {
            if ($i < 10) {
                $return['mcArr']['wem' . $i] = count($vModel->where('time like "' . $year . '-0' . $i . '-%" and type=9')->select());
            } else {
                $return['mcArr']['wem' . $i] = count($vModel->where('time like "' . $year . '-' . $i . '-%" and type=9')->select());
            }
        }
        for ($i = 1; $i < 13; $i++) {
            if ($i < 10) {
                $return['mcArr']['tem' . $i] = count($vModel->where('time like "' . $year . '-0' . $i . '-%" and type=3')->select());
            } else {
                $return['mcArr']['tem' . $i] = count($vModel->where('time like "' . $year . '-' . $i . '-%" and type=3')->select());
            }
        }
        
        
//        for ($i = 1; $i < 13; $i++) {
//            if ($i < 10) {
//                $return['mcArr']['hem' . $i] = count($vModel->where('time like "' . $year . '-0' . $i . '-%" and type=0')->select());
//            } else {
//                $return['mcArr']['hem' . $i] = count($vModel->where('time like "' . $year . '-' . $i . '-%" and type=0')->select());
//            }
//        }
        $this->assign('yArr', $yArr);
        $this->assign('year', $year);
        $this->assign('nowtime', date('Y年m月d日 H:i:s', time()));
        $this->assign('return', $return);
        $this->display();
    }

}
