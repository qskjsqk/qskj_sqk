<?php

/**
 * @name IndexController
 * @info 描述：健康模块入口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-23 9:35:49
 */

namespace Health\Controller;

use Think\Controller;

class IndexController extends Controller {

    public function _initialize() {
//        配置字典信息
        $configdefC = A('Configdef');
        $defArr = $configdefC->getAllDef();
        $this->assign('config', $defArr);
    }

    /**
     * 首页
     */
    public function index() {
        if ($_SESSION['realname'] == NULL || $_SESSION['realname'] == '') {
            $this->assign('realname', $_SESSION['usr']);
        } else {
            $this->assign('realname', $_SESSION['realname']);
        }
        $this->display();
    }

    /**
     * 用户退出
     */
    public function logout() {
        session('[destroy]');
        $this->redirect('Admin/login/login');
    }

    /**
     * 返回平台入口
     */
    public function shome() {
        $this->redirect('Admin/login/main');
    }

    /**
     * 模拟机器发数据（调试）
     */
    public function test() {
        if (!empty($_POST)) {
            $data['device_id'] = 1;
//            $data['user_id'] = 0;
            $data['physicalid'] = 'fakshdfkjahskjdhfka';
            $data['medicid'] = 'sjflkjaslkdjflkasjldf';
            $data['time'] = $_POST['time'];
            $data['idcard'] = $_POST['idcard'];
            $data['user_id']=  $this->getUserIdByIdcard($_POST['idcard']);
            $data['tel'] = $_POST['tel'];
            switch ($_POST['num']) {
                //血糖
                case 6:
                    $data['type'] = $_POST['type'];
                    $data['bloodsugar'] = $_POST['bloodsugar'];
                    $addFlag = M('DeviceSugar')->add($data);
                    break;
                //体重
                case 9:
                    $data['height'] = $_POST['height'];
                    $data['weight'] = $_POST['weight'];
                    $addFlag = M('DeviceWeight')->add($data);
                    break;
                //血氧
                case 5:
                    $data['bloodoxygen'] = $_POST['bloodoxygen'];
                    $data['pulse'] = $_POST['pulse'];

                    $data['sugcommon'] = $_POST['common'];
                    $data['sugsport'] = $_POST['sport'];
                    $data['sugfood'] = $_POST['food'];
                    $data['sugdoctor'] = $_POST['doctor'];

                    $addFlag = M('DeviceBloodsatur')->add($data);
                    break;
                //血压
                case 7:
                    $data['systolic'] = $_POST['systolic'];
                    $data['diastolic'] = $_POST['diastolic'];
                    $data['pulse'] = $_POST['pulse'];
                    $data['sugcommon'] = $_POST['common'];
                    $data['sugsport'] = $_POST['sport'];
                    $data['sugfood'] = $_POST['food'];
                    $data['sugdoctor'] = $_POST['doctor'];
                    $addFlag = M('DeviceBloodpress')->add($data);
                    break;
                //体温
                case 3:
                    $data['temperature'] = $_POST['temperature'];

                    $data['sugcommon'] = $_POST['common'];
                    $data['sugsport'] = $_POST['sport'];
                    $data['sugfood'] = $_POST['food'];
                    $data['sugdoctor'] = $_POST['doctor'];

                    $addFlag = M('DeviceTemptr')->add($data);
                    break;
                default:
                    $addFlag = 0;
                    break;
            }
            
            if($addFlag>0){
                $this->success('添加成功', 'test',3);
            }
        } else {
            $this->display();
        }
    }
    
    /**
     * 通过身份证号获取用户id
     * @param type $idcard
     * @return int
     */
    public function getUserIdByIdcard($idcard) {
        $findArr = M('SysUserInfo')->where('idcard_num='.$idcard.' and rns_type=1')->find();
        if (empty($findArr)) {
            return 0;
        } else {
            return $findArr['id'];
        }
    }

}
