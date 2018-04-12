<?php

/**
 * @name DevicedataController
 * @info 描述：体检数据控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-24 13:32:02
 */

namespace Health\Controller;

use Think\Controller;

class DeviceDataController extends BaseDBController {

    /**
     * function:显示分类列表
     */
    public function showList() {
        switch ($_GET['table_num']) {
            case 6:
                $model = M('DeviceSugar');
                $returnData['table_name'] = "血糖";
                $returnData['table_num'] = 6;
                $modelName = "qs_gryj_device_sugar";
                break;
            case 5:
                $model = M('DeviceBloodsatur');
                $returnData['table_name'] = "血氧";
                $returnData['table_num'] = 5;
                $modelName = "qs_gryj_device_bloodsatur";
                break;
            case 7:
                $model = M('DeviceBloodpress');
                $returnData['table_name'] = "血压";
                $returnData['table_num'] = 7;
                $modelName = "qs_gryj_device_bloodpress";
                break;
            case 9:
                $model = M('DeviceWeight');
                $returnData['table_name'] = "身高体重";
                $returnData['table_num'] = 9;
                $modelName = "qs_gryj_device_weight";
                break;
            case 3:
                $model = M('DeviceTemptr');
                $returnData['table_name'] = "体温";
                $returnData['table_num'] = 3;
                $modelName = "qs_gryj_device_temptr";
                break;
            default:
                $model = M('DeviceSugar');
                $returnData['table_name'] = "血糖";
                $returnData['table_num'] = 6;
                $modelName = "qs_gryj_device_sugar";
                break;
        }
        $pageCondition['table_num'] = $_GET['table_num'];
        if (GET) {
            if (!empty($_GET['keyword'])) {
                $where['_string'] = '(' . $modelName . '.time like binary "%' . $_GET['keyword'] . '%" or ' . $modelName . '.idcard like "%' . $_GET['keyword'] . '%" or ' . $modelName . '.tel like "%' . $_GET['keyword'] . '%" or '
                        . 'qs_gryj_sys_user_info.realname like "%' . $_GET['keyword'] . '%"  or qs_gryj_device_info.name like "%' . $_GET['keyword'] . '%")';
                $pageCondition['keyword'] = $_GET['keyword'];
            }
            if (empty($_GET['start_time'])) {
                $start_time = '1970-01-01 00:00:00';
            } else {
                $start_time = $_GET['start_time'];
                $pageCondition['start_time'] = $_GET['start_time'];
            }
            if (empty($_GET['end_time'])) {
                $end_time = '3000-01-01 00:00:00';
            } else {
                $end_time = $_GET['end_time'];
                $pageCondition['end_time'] = $_GET['end_time'];
            }
            $where[$modelName . '.time'] = array('BETWEEN', $start_time . ',' . $end_time);
        }

        $fieldStr = $modelName . '.*,qs_gryj_sys_user_info.realname,qs_gryj_device_info.name';
        $joinStr = 'LEFT JOIN __SYS_USER_INFO__ ON ' . $modelName . '.user_id=__SYS_USER_INFO__.id left join qs_gryj_device_info on ' . $modelName . '.device_id=qs_gryj_device_info.id';
        $page = getPage($model->join($joinStr)->field($fieldStr), $where, $pageCondition, C('PAGE_SIZE'));
        $infoList = $model->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
//        echo $model->getLastSql();
        for ($i = 0; $i < count($infoList); $i++) {
//            数据信息
            $infoList[$i]['table_name'] = $returnData['table_name'];
            $infoList[$i]['table_num'] = $returnData['table_num'];
//            数据处理
            $deviceInfo = $this->getDeviceById($infoList[$i]['device_id']);
            if ($infoList[$i]['name'] == null) {
                $infoList[$i]['name'] = '未知设备';
            }
            if ($infoList[$i]['realname'] == null) {
                $infoList[$i]['realname'] = '未认证';
            }
        }
        $page = $page->show();
        $this->assign('page', $page);
        $this->assign('searchInfo', $pageCondition);
        $this->assign('infoList', $infoList);
//        额外回显赋值
        $this->assign('be_table_num', $returnData['table_num']);
        $catArr[] = array('table_num' => 6, 't_name' => '血糖');
        $catArr[] = array('table_num' => 5, 't_name' => '血氧');
        $catArr[] = array('table_num' => 7, 't_name' => '血压');
        $catArr[] = array('table_num' => 9, 't_name' => '身高体重');
        $catArr[] = array('table_num' => 3, 't_name' => '体温');
        $this->assign('catArr', $catArr);
//        dump($model->getLastSql());
        $this->display();
    }

    /**
     * function:删除信息
     */
    public function delDeviceInfo() {
        switch ($_POST['table_num']) {
            case 6:
                $model = M('DeviceSugar');
                break;
            case 5:
                $model = M('DeviceBloodsatur');
                break;
            case 7:
                $model = M('DeviceBloodpress');
                break;
            case 9:
                $model = M('DeviceWeight');
                break;
            case 3:
                $model = M('DeviceTemptr');
                break;
            default:
                $model = M('DeviceSugar');
                break;
        }
        $condition['id'] = array('EQ', $_POST['id']);
        if (false !== $model->where($condition)->delete()) {
            $logC = A('Actionlog')->addLog('DeviceData', 'delDeviceInfo', '删除体检信息');
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 批量删除信息
     */
    public function delArrayCat() {
        switch ($_POST['table_num']) {
            case 6:
                $model = M('DeviceSugar');
                break;
            case 5:
                $model = M('DeviceBloodsatur');
                break;
            case 7:
                $model = M('DeviceBloodpress');
                break;
            case 9:
                $model = M('DeviceWeight');
                break;
            case 3:
                $model = M('DeviceTemptr');
                break;
            default:
                $model = M('DeviceSugar');
                break;
        }
        $logC = A('Actionlog')->addLog('DeviceData', 'delArrayCat', '批量删除体检信息');
        $model->delete(rtrim($_POST['ids'], ",")); // 删除主键为ids的数据
    }

    /**
     * 通过设备id获取设备信息
     * @param type $id
     * @return int
     */
    public function getDeviceById($id) {
        $findArr = M('DeviceInfo')->where('id=' . $id)->find();
        if (empty($findArr)) {
            return 0;
        } else {
            return $findArr;
        }
    }

    /**
     * 通过用户id获取用户信息
     * @param type $id
     * @return int
     */
    public function getUserById($id) {
        $findArr = M(C('DB_USER_INFO'))->where('id=' . $id)->find();
        if (empty($findArr)) {
            return 0;
        } else {
            return $findArr;
        }
    }

    /**
     * 获取血糖测试状态
     * @param type $type
     * @return string
     */
    public function getSugarCheckType($type) {
        switch ($type) {
            case 0:
                return '未知';
                break;
            case 1:
                return '空腹';
                break;
            case 2:
                return '餐前';
                break;
            case 3:
                return '餐后';
                break;
            default:
                break;
        }
    }

    /**
     * 数据详情
     */
    public function dataDetail() {
        switch ($_GET['table_num']) {
            case 6:
                $model = M('DeviceSugar');
                $returnData['table_name'] = "血糖";
                $returnData['table_num'] = 6;
                break;
            case 5:
                $model = M('DeviceBloodsatur');
                $returnData['table_name'] = "血氧";
                $returnData['table_num'] = 5;
                break;
            case 7:
                $model = M('DeviceBloodpress');
                $returnData['table_name'] = "血压";
                $returnData['table_num'] = 7;
                break;
            case 9:
                $model = M('DeviceWeight');
                $returnData['table_name'] = "身高体重";
                $returnData['table_num'] = 9;
                break;
            case 3:
                $model = M('DeviceTemptr');
                $returnData['table_name'] = "体温";
                $returnData['table_num'] = 3;
                break;
            default:
                $model = M('DeviceSugar');
                $returnData['table_name'] = "血糖";
                $returnData['table_num'] = 6;
                break;
        }
        $findArr = $model->where('id=' . $_GET['id'])->find();

        if ($findArr['user_id'] == 0) {
            $findArr['realname'] = '未认证';
        } else {
            $userInfo = $this->getUserById($findArr['user_id']);
            $findArr['realname'] = $userInfo['realname'];
        }

        $deviceInfo = $this->getDeviceById($findArr['device_id']);
        if ($deviceInfo != 0) {
            $findArr['device_name'] = $deviceInfo['name'];
        } else {
            $findArr['device_name'] = '未知设备';
        }
        switch ($_GET['table_num']) {
            case 6:
                $findArr['result'] = '血糖值：<font color="#c00000" style="font-size:26px;">' . $findArr['bloodsugar'] . '</font>mmol/L&#12288;类型：<font color="#c00000" style="font-size:26px;">' . $this->getSugarCheckType($findArr['type']) . '</font>';
                $findArr['sug'] = '&#12288;&#12288;血液中的葡萄糖称为血糖。体内各组织细胞活动所需的能量大部分来自葡萄糖，所以血糖必须保持一定的水平才能维持体内各器官和组织的需要。正常人在清晨空腹血糖浓度为80～120毫克%。空腹血糖浓度超过130毫克%称为高血糖。如果血糖浓度超过160～180毫克%，就有一部分葡萄糖随尿排出，这就是糖尿。血糖浓度低于70毫克%称为低血糖。小粒径负离子，则有良好的生物活性，易于透过人体血脑屏障， 进入人体发挥其生物效应。对于降糖有良好的疗效。同时建议患者对血同（血同型半胱氨酸）进行检测。较低的血同值能大幅降低糖尿病并发症的发病风险。';
                break;
            case 5:
                $findArr['result'] = '血氧值：<font color="#c00000" style="font-size:26px;">' . $findArr['bloodoxygen'] . '</font>%&#12288;脉搏：<font color="#c00000" style="font-size:26px;">' . $findArr['pulse'] . '</font>次/min';
                $findArr['sug'] = '<p>常规：' . $findArr['sugcommon'] . '</p>' .
                        '<p>医疗：' . $findArr['sugdoctor'] . '</p>' .
                        '<p>运动：' . $findArr['sugsport'] . '</p>' .
                        '<p>饮食：' . $findArr['sugfood'] . '</p>';
                break;
            case 7:
                $findArr['result'] = '收缩压：<font color="#c00000" style="font-size:26px;">' . $findArr['systolic'] . '</font>mmHg&#12288;收缩压：<font color="#c00000" style="font-size:26px;">' . $findArr['diastolic'] .
                        '</font>mmHg&#12288;脉搏：<font color="#c00000" style="font-size:26px;">' . $findArr['pulse'] . '</font>次/min';
                $findArr['sug'] = '<p>常规：' . $findArr['sugcommon'] . '</p>' .
                        '<p>医疗：' . $findArr['sugdoctor'] . '</p>' .
                        '<p>运动：' . $findArr['sugsport'] . '</p>' .
                        '<p>饮食：' . $findArr['sugfood'] . '</p>';
                break;
            case 9:
                if ($findArr['height'] == 0) {
                    $findArr['result'] = '体重值：<font color="#c00000" style="font-size:26px;">' . $findArr['weight'] . '</font>Kg';
                } else {
                    $findArr['bmi'] = round((floatval($findArr['weight']) * 10000) / (floatval($findArr['height']) * floatval($findArr['height'])), 1);
                    $findArr['result'] = '体重值：<font color="#c00000" style="font-size:26px;">' . $findArr['weight'] . '</font>Kg' . '&#12288;身高值：<font color="#c00000" style="font-size:26px;">' . $findArr['height'] . '</font>Cm&#12288;BMI：<font color="#c00000" style="font-size:26px;">' . $findArr['bmi'] . '</font>';
                }
                $findArr['sug'] = 'BMI是与体内脂肪总量密切相关的指标,该指标考虑了体重和身高两个因素。BMI简单、实用、可反映全身性超重和肥胖。 在测量身体因超重而面临心脏病、高血压等风险时，比单纯的以体重来认定，更具准确性。成人的BMI数值：过轻：低于18.5,正常：18.5-24.99,过重：25-28,肥胖：28-32,非常肥胖：高于32。</br>&#12288;&#12288;肥胖症患者更易发生高血压、高血脂和葡萄糖代谢异常；肥胖是影响冠心病发病和死亡的一个独立危险因素。</br>&#12288;&#12288;体重过低影响未成年人身体和智力发育，影响成年人体力，还与免疫力低下、月经不调或闭经、骨质疏松、贫血、抑郁等病症有关，最终影响寿命。';
                break;
            case 3:
                $findArr['result'] = '体温值：<font color="#c00000" style="font-size:26px;">' . $findArr['temperature'] . '</font>度（摄氏）';
                $findArr['sug'] = '<p>常规：' . $findArr['sugcommon'] . '</p>' .
                        '<p>医疗：' . $findArr['sugdoctor'] . '</p>' .
                        '<p>运动：' . $findArr['sugsport'] . '</p>' .
                        '<p>饮食：' . $findArr['sugfood'] . '</p>';
                break;
            default:
                $findArr['result'] = '血糖值：<font color="#c00000" style="font-size:26px;">' . $findArr['bloodsugar'] . '</font>mmol/L&#12288;类型：<font color="#c00000" style="font-size:26px;">' . $this->getSugarCheckType($findArr['type']) . '</font>';
                $findArr['sug'] = '&#12288;&#12288;血液中的葡萄糖称为血糖。体内各组织细胞活动所需的能量大部分来自葡萄糖，所以血糖必须保持一定的水平才能维持体内各器官和组织的需要。正常人在清晨空腹血糖浓度为80～120毫克%。空腹血糖浓度超过130毫克%称为高血糖。如果血糖浓度超过160～180毫克%，就有一部分葡萄糖随尿排出，这就是糖尿。血糖浓度低于70毫克%称为低血糖。小粒径负离子，则有良好的生物活性，易于透过人体血脑屏障， 进入人体发挥其生物效应。对于降糖有良好的疗效。同时建议患者对血同（血同型半胱氨酸）进行检测。较低的血同值能大幅降低糖尿病并发症的发病风险。';
                break;
        }
//        dump($findArr);
        $this->assign('info', $findArr);
        $this->display();
    }

}
