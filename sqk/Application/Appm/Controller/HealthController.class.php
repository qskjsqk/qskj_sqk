<?php

/**
 * @name HealthController
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-16 13:23:45
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class HealthController extends Controller {

//------------------------------------------------------------------------------
    public function health_list() {
        $this->assign();
        $this->display();
    }

    public function health_detail() {
        $this->assign();
        $this->display();
    }

    public function healthn_list() {
        $this->assign();
        $this->display();
    }

    public function healthn_detail() {
        $this->assign();
        $this->display();
    }

    public function health_stat() {
        $this->assign();
        $this->display();
    }

//------------------------------------------------------------------------------

    /**
     * 获取启用分类字串
     * @return string
     */
    public function getEnableCatIds() {
        $selectArr = M('HealthCat')->where('is_enable=1')->select();
        if (empty($selectArr)) {
            return '0,0';
        } else {
            foreach ($selectArr as $value) {
                $str.=',' . $value['id'];
            }
            return '0' . $str;
        }
    }

    /**
     * 获取分类列表
     * @return string
     */
    public function getCatList() {
        $selectArr = M('HealthCat')->where('is_enable=1')->select();
        if (empty($selectArr)) {
            $return['flag'] = 0;
        } else {
            $return['flag'] = 1;
            $return['data'] = $selectArr;
        }
        $this->ajaxReturn($return);
    }

    /**
     * 获取健康知识列表
     */
    public function getHealthnList() {
        $user_id = cookie('user_id');
//        $user_id = 1;
        $num = C('PAGE_NUM')['healthn'] * $_POST['page'];
        $keyword = $_POST['keyword'];
        $cat_id = $_POST['cat_id'];
        $isEnable = $this->getEnableCatIds();
        if ($cat_id == 0) {
            $selectArr = M('HealthInfo')->where('is_publish=1 and cat_id in (' . $isEnable . ') and title like "%' . $keyword . '%"')->order('id desc')->limit($num)->select();
            $count = M('HealthInfo')->where('is_publish=1 and cat_id in (' . $isEnable . ') and title like "%' . $keyword . '%"')->count();
        } else {
            $selectArr = M('HealthInfo')->where('is_publish=1 and cat_id=' . $cat_id . ' and title like "%' . $keyword . '%"')->order('id desc')->limit($num)->select();
            $count = M('HealthInfo')->where('is_publish=1 and cat_id=' . $cat_id . ' and title like "%' . $keyword . '%"')->count();
        }


        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_POST['page'];
        $returnData['cat_id'] = $_POST['cat_id'];

        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($selectArr); $i++) {
                $data[$i]['id'] = $selectArr[$i]['id'];
                $data[$i]['title'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['title']);
                $data[$i]['cat_name'] = $this->getCatNameById($selectArr[$i]['cat_id']);
                $data[$i]['add_time'] = tranTime($selectArr[$i]['add_time']);
                $data[$i]['content'] = $selectArr[$i]['content'];
                $data[$i]['read_num'] = $selectArr[$i]['read_num'];
                $data[$i]['logo_icon'] = $selectArr[$i]['logo_icon'];
                $picsInfo = $this->getAttachArr($selectArr[$i]['id']);
                if ($picsInfo['flag'] == 1) {
                    $data[$i]['pics'] = $picsInfo['data'];
                } else {
                    $data[$i]['pics'] = 0;
                }
            }
            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取健康知识详情
     */
    public function getHealthnDetail() {
        $findArr = M('HealthInfo')->where('id=' . $_GET['id'])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '操作失败,请重新操作';
        } else {
            $updData['read_num'] = $findArr['read_num'] + 1;
            $updArr = M('HealthInfo')->where('id=' . $_GET['id'])->save($updData);
            if ($updArr === FALSE) {
                $returnData['flag'] = 0;
                $returnData['msg'] = '操作失败,请重新操作';
            } else {
                $returnData['flag'] = 1;
                $returnData['msg'] = '操作成功';
//                数据处理
                $findArr['realname'] = $this->getRealnameById($findArr['user_id']);
                $returnData['data'] = $findArr;
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取体检信息列表
     */
    public function getHealthList() {
        $user_id = cookie('user_id');
//        $user_id = 1;
        $num = C('PAGE_NUM')['health'] * $_POST['page'];
        $keyword = $_POST['keyword'];

        switch ($_POST['table_num']) {
            case 6:
                $model = M('DeviceSugar');
                $returnData['table_name'] = "血糖";
                break;
            case 5:
                $model = M('DeviceBloodsatur');
                $returnData['table_name'] = "血氧";
                break;
            case 7:
                $model = M('DeviceBloodpress');
                $returnData['table_name'] = "血压";
                break;
            case 9:
                $model = M('DeviceWeight');
                $returnData['table_name'] = "身高体重";
                break;
            case 3:
                $model = M('DeviceTemptr');
                $returnData['table_name'] = "体温";
                break;
//            case 0:
//                $model = M('DeviceHeight');
//                $returnData['table_name'] = "身高";
//                break;
            default:
                exit;
                break;
        }

        $selectArr = $model->where('time like "%' . $keyword . '%" and user_id=' . $user_id)->order('id desc')->limit($num)->select();
        $count = $model->where('time like "%' . $keyword . '%" and user_id=' . $user_id)->count();
        $returnData['sql'] = $model->getLastSql();

        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_POST['page'];

        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($selectArr); $i++) {
                $data[$i]['id'] = $selectArr[$i]['id'];
                $data[$i]['time'] = $selectArr[$i]['time'];
//              时间转换为中文  
//                $time = tranTimeToCom($selectArr[$i]['time']);
//                $data[$i]['time'] = $time['ymd'] . '&nbsp;' . $time['his'];
            }
            $returnData['table_num'] = $_POST['table_num'];
            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取体检信息详情详情
     */
    public function getHealthDetail() {

        switch ($_GET['table_num']) {
            case 6:
                $model = M('DeviceSugar');
                $returnData['table_name'] = "血糖";
                break;
            case 5:
                $model = M('DeviceBloodsatur');
                $returnData['table_name'] = "血氧";
                break;
            case 7:
                $model = M('DeviceBloodpress');
                $returnData['table_name'] = "血压";
                break;
            case 9:
                $model = M('DeviceWeight');
                $returnData['table_name'] = "身高体重";
                break;
            case 3:
                $model = M('DeviceTemptr');
                $returnData['table_name'] = "体温";
                break;
//            case 0:
//                $model = M('DeviceHeight');
//                $returnData['table_name'] = "身高";
//                break;
            default:
                exit;
                break;
        }
        $findArr = $model->where('id=' . $_GET['id'])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '操作失败,请重新操作';
        } else {
            $returnData['flag'] = 1;
            $returnData['msg'] = '操作成功';
//          数据处理
            if ($this->getRealnameById($findArr['user_id']) == '0') {
                $returnData['12312']=$this->getRealnameById($findArr['user_id']);
                $returnData['realname'] = '未验证' . $findArr['user_id'];
            } else {
                $returnData['realname'] = $this->getRealnameById($findArr['user_id']);
            }

            if ($_GET['table_num'] == 6) {
                $findArr['type'] = $this->getSugarCheckType($findArr['type']);
            } else if ($_GET['table_num'] == 9) {
                $findArr['bmi'] = round($findArr['weight'] / (($findArr['height'] / 100) * ($findArr['height'] / 100)),1);
            }
            $returnData['table_num'] = $_GET['table_num'];
            $returnData['data'] = $findArr;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 通过id获取真实姓名
     * @param type $id
     * @return int
     */
    public function getRealnameById($id) {
        $userModel = M(C('DB_USER_INFO'));
        $findArr = $userModel->where('id=' . $id)->find();
        if (empty($findArr)) {
            return 0;
        } else {
            if ($findArr['realname'] != '' && $findArr['realname'] != null) {
                return $findArr['realname'];
            } else {
                return $findArr['usr'];
            }
        }
    }

    /**
     * 获取分类名称
     * @param type $cat_id
     * @return int
     */
    public function getCatNameById($cat_id) {
        $catArr = M('HealthCat')->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr['cat_name'];
        }
    }

    /**
     * 获取分类名称(前台)
     * @param type $cat_id
     * @return int
     */
    public function getCatName() {
        $catArr = M('HealthCat')->where('id=' . $_GET['cat_id'])->find();
        if (empty($catArr)) {
            $return['flag'] = 0;
        } else {
            $return['flag'] = 1;
            $return['cat_name'] = $catArr['cat_name'];
        }
        $this->ajaxReturn($return);
    }

    /**
     * 获取健康知识附件
     * @param type $healthn_id
     * @return type
     */
    public function getAttachArr($healthn_id) {
        $model = M(C('DB_ALL_ATTACH'));
        $selectArr = $model->where('module_name="healthn" and module_info_id=' . $healthn_id)->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            for ($i = 0; $i < count($selectArr); $i++) {
                $data[$i]['url'] = $selectArr[$i]['file_path'];
            }
            $returnData['data'] = $data;
        }
        return $returnData;
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
     * 获取图表数据
     */
    public function getStatData() {
        $user_id = cookie('user_id');
//        $user_id = 1;
        $pageSize = 10;
        switch ($_POST['table_num']) {
            case 6:
                $model = M('DeviceSugar');
                $returnData['table_name'] = "血糖";
                break;
            case 5:
                $model = M('DeviceBloodsatur');
                $returnData['table_name'] = "血氧";
                break;
            case 7:
                $model = M('DeviceBloodpress');
                $returnData['table_name'] = "血压";
                break;
            case 9:
                $model = M('DeviceWeight');
                $returnData['table_name'] = "身高体重";
                break;
            case 3:
                $model = M('DeviceTemptr');
                $returnData['table_name'] = "体温";
                break;
//            case 0:
//                $model = M('DeviceHeight');
//                $returnData['table_name'] = "身高";
//                break;
            default:
                exit;
                break;
        }
        $count = $model->where('user_id=' . $user_id)->count();
        $pageNum = ceil($count / $pageSize);
        if ($_POST['page'] == $pageNum) {
            $returnData['is_end'] = 1;
        } else {
            $returnData['is_end'] = 0;
        }
        if ($_POST['page'] == 1) {
            $returnData['is_start'] = 1;
        } else {
            $returnData['is_start'] = 0;
        }
        $num = ($_POST['page'] - 1) * $pageSize;
        $selectArr = $model->where('user_id=' . $user_id)->order('time desc')->limit($num, $pageSize)->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['table_num'] = $_POST['table_num'];
            $returnData['page'] = $_POST['page'];
            $returnData['flag'] = 1;
            for ($i = count($selectArr); $i > 0; $i--) {
                $data['y'] = date('Y', strtotime($selectArr[$i - 1]['time']));
                $data['m'] = date('m', strtotime($selectArr[$i - 1]['time'])) - 1;
                $data['d'] = date('d', strtotime($selectArr[$i - 1]['time']));
                switch ($_POST['table_num']) {
                    case 6:
                        $data['bloodsugar'] = $selectArr[$i - 1]['bloodsugar'];
                        break;
                    case 5:
                        $data['bloodoxygen'] = $selectArr[$i - 1]['bloodoxygen'];
                        $data['pulse'] = $selectArr[$i - 1]['pulse'];
                        break;
                    case 7:
                        $data['systolic'] = $selectArr[$i - 1]['systolic'];
                        $data['diastolic'] = $selectArr[$i - 1]['diastolic'];
                        $data['pulse'] = $selectArr[$i - 1]['pulse'];
                        break;
                    case 9:
                        $data['weight'] = $selectArr[$i - 1]['weight'];
                        break;
                    case 3:
                        $data['temperature'] = $selectArr[$i - 1]['temperature'];
                        break;
                    default:
                        exit;
                        break;
                }
                $arr[] = $data;
            }
            $returnData['name'] = $this->getRealnameById($user_id) . ' ' . date('Y-m-d', strtotime($selectArr[count($selectArr) - 1]['time'])) . '至' . date('Y-m-d', strtotime($selectArr[0]['time']));
            $returnData['data'] = $arr;
        }
        $this->ajaxReturn($returnData);
    }

}
