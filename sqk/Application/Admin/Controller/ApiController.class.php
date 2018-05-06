<?php

/**
 * @name ApiController
 * @info 描述：API控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:02:04
 */

namespace Admin\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class ApiController extends BaseDBController {

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 检测管理员登录
     */
    public function checkLoginPos() {
        $input = file_get_contents("php://input"); //接收POST数据
        $inputArr = json_decode($input, true);

        $token_num = $inputArr['token_num'];
        $where['token_num'] = ['EQ', "" . $token_num . ""];
        $where['is_enable'] = ['EQ', 1];
        $findArr = M('sys_user_info')->field('id,realname,address_id')->where($where)->find();
        if (empty($findArr)) {
            $returnData['status'] = 0;
            $returnData['msg'] = '错误的设备识别码！';
            $returnData['timestamp'] = time();
        } else {
            $findArr['address_name'] = getConameById($findArr['id']);
            $returnData['status'] = 1;
            $returnData['msg'] = '成功登录！';
            $returnData['timestamp'] = time();

            $returnData['data'] = $findArr;
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 获取本社区活动列表
     */
    public function getActivListPos() {
        $input = file_get_contents("php://input"); //接收POST数据
        $inputArr = json_decode($input, true);

        $page = $inputArr['page'];
        $address_id = $inputArr['address_id'];

        $pageNum = 8;
        $first = ($page - 1) * $pageNum;

        $where['address_id'] = ['EQ', $address_id];
        $where['is_publish'] = ['EQ', 1];
        $where['is_open'] = ['EQ', 1];


        if (empty($page) || empty($address_id)) {
            $returnData['status'] = 0;
            $returnData['msg'] = '参数错误！';
            $returnData['timestamp'] = time();
        } else {
            $model = M('activ_info');
            $selectArr = $model->field('id,cat_id,title,address_id,start_time,integral,like_num')->where($where)->order('id desc')->limit($first . ',' . $pageNum)->select();
            $count = $model->field('id,cat_id,title,address_id,start_time,integral,like_num')->where($where)->count();

            if (empty($selectArr)) {
                $returnData['status'] = 2;
                $returnData['msg'] = '没有已开启的活动！';
                $returnData['timestamp'] = time();
            } else {
                $returnData['status'] = 1;
                $returnData['msg'] = '加载活动列表成功！';
                $returnData['timestamp'] = time();

                $returnData['page'] = $page;
                $returnData['count'] = $count;

                for ($i = 0; $i < count($selectArr); $i++) {
                    $selectArr[$i]['cat_name'] = parent::getDataKey(M('activ_cat'), $selectArr[$i]['cat_id'], 'cat_name');
                    $selectArr[$i]['address_name'] = getConameById($selectArr[$i]['address_id']);
                    $selectArr[$i]['start_time'] = strtotime($selectArr[$i]['start_time']);
                    $condition['module_info_id'] = $selectArr[$i]['id'];
                    $condition['module_name'] = array('EQ', 'activity');
                    $imgArr = M('sys_all_attach')->where($condition)->order('id desc')->find();
                    $selectArr[$i]['pic_path'] = $imgArr['file_path'];
                }

                $returnData['data'] = $selectArr;
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 获取活动详情
     */
    public function getActivDetailPos() {
        $id = $_GET['id'];

        if (empty($_GET['id'])) {
            $returnData['status'] = 0;
            $returnData['msg'] = '参数错误！';
            $returnData['timestamp'] = time();
        } else {
            $info = parent::getData(M('activ_info'), $_GET['id']);
            if ($info['code'] == '502') {
                $returnData['status'] = 2;
                $returnData['msg'] = '未查到这条数据！';
                $returnData['timestamp'] = time();
            } else {
                $returnData['status'] = 1;
                $returnData['msg'] = '成功打开详情！';
                $returnData['timestamp'] = time();

                $activInfo = $info['data'];
                unset($activInfo['like_ids']);
                unset($activInfo['read_ids']);
                unset($activInfo['is_publish']);
                unset($activInfo['is_open']);
                unset($activInfo['join_ids']);
                unset($activInfo['join_num']);

                $activInfo['add_time'] = strtotime($activInfo['add_time']);
                $activInfo['start_time'] = strtotime($activInfo['start_time']);
                $activInfo['end_time'] = strtotime($activInfo['end_time']);

                $activInfo['cat_name'] = parent::getDataKey(M('activ_cat'), $activInfo['cat_id'], 'cat_name');
                $activInfo['address_name'] = getConameById($activInfo['address_id']);

                $activInfo['user_name'] = parent::getDataKey(M('sys_user_info'), $activInfo['user_id'], 'realname');

                $preg = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i'; //匹配img标签的正则表达式
                preg_match_all($preg, $activInfo['content'], $allImg); //这里匹配所有的img
                $activInfo['content_pics'] = $allImg[1];

                $activInfo['content'] = strip_tags($activInfo['content'], '<p>');
                $activInfo['content'] = str_replace('</p>', "\n", $activInfo['content']);
                $activInfo['content'] = strip_tags($activInfo['content']);
                $activInfo['content'] = str_replace('&nbsp;&nbsp;', "\x20", $activInfo['content']);
                $activInfo['content'] = str_replace('&nbsp;', "", $activInfo['content']);


                $condition['module_info_id'] = $activInfo['id'];
                $condition['module_name'] = array('EQ', 'activity');
                $imgInfoList = M('sys_all_attach')->where($condition)->order('id desc')->select();
                foreach ($imgInfoList as $value) {
                    $activInfo['pic_list'][] = $value['file_path'];
                }

                $where['activity_id'] = $activInfo['id'];

                $returnData['data'] = $activInfo;
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 获取某一次活动的签到信息
     */
    public function getActivSigninPos() {
        $id = $_GET['id'];

        if (empty($_GET['id'])) {
            $returnData['status'] = 0;
            $returnData['msg'] = '参数错误！';
            $returnData['timestamp'] = time();
        } else {
            $where['activity_id'] = ['EQ', $id];
            $signinList = M('activ_signin')->where($where)->select();
            if (empty($signinList)) {
                $returnData['status'] = 2;
                $returnData['msg'] = '未查到这条数据！';
                $returnData['timestamp'] = time();
            } else {
                $returnData['status'] = 1;
                $returnData['msg'] = '成功获取签到！';
                $returnData['timestamp'] = time();

                $returnData['data'] = $signinList;
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    public function setSigninStatusPos() {
        $sign_id = $_GET['sign_id'];
        $status = $_GET['status'];
        if (empty($_GET['sign_id']) || empty($_GET['status'])) {
            $returnData['status'] = 0;
            $returnData['msg'] = '参数错误！';
            $returnData['timestamp'] = time();
        } else {
            $where['id'] = ['EQ', $sign_id];
            $data['status'] = $status;
            $signinFlag = M('activ_signin')->where($where)->setField($data);
            
            if ($signinFlag) {
                $returnData['status'] = 2;
                $returnData['msg'] = '状态置位错误！';
                $returnData['timestamp'] = time();
            } else {
                $returnData['status'] = 1;
                $returnData['msg'] = '成功状态置位！';
                $returnData['timestamp'] = time();
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 获取某一次签到的签到记录
     */
    public function getSigninInfoListPos() {
        $sign_id = $_GET['sign_id'];
        if (empty($_GET['sign_id'])) {
            $returnData['status'] = 0;
            $returnData['msg'] = '参数错误！';
            $returnData['timestamp'] = time();
        } else {
            $where['sign_id'] = ['EQ', $sign_id];
            $signinInfoList = M('activ_signin_info')->where($where)->select();
            if (empty($signinInfoList)) {
                $returnData['status'] = 2;
                $returnData['msg'] = '未查到这条数据！';
                $returnData['timestamp'] = time();
            } else {
                $returnData['status'] = 1;
                $returnData['msg'] = '成功获取签到！';
                $returnData['timestamp'] = time();

                for ($i = 0; $i < count($signinInfoList); $i++) {
                    $signinInfoList[$i]['add_time'] = strtotime($signinInfoList[$i]['add_time']);
                    $signinInfoList[$i]['tx_icon'] = "Public/admin/img/tx_icon/" . ($signinInfoList[$i]['id'] % 13 + 1) . ".jpg";
                }

                $returnData['data'] = $signinInfoList;
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 用户签到
     */
    public function setUserSigninPos() {
        $input = file_get_contents("php://input"); //接收POST数据
        $inputArr = json_decode($input, true);

        $iccard_num = $inputArr['iccard_num'];
        $activity_id = $inputArr['activity_id'];
        $sign_id = $inputArr['sign_id'];

        if (empty($iccard_num) || empty($activity_id) || empty($sign_id)) {
            $returnData['status'] = 0;
            $returnData['msg'] = '参数错误！';
            $returnData['timestamp'] = time();
        } else {
            $where['iccard_num'] = ['EQ', $iccard_num];
            $where['is_enable'] = ['EQ', 1];
            $userInfo = M('sys_userapp_info')->field('realname,id')->where($where)->find();
            if (empty($userInfo)) {
                $returnData['status'] = 2;
                $returnData['msg'] = '无效卡信息！';
                $returnData['timestamp'] = time();
            } else {
                $swhere['sign_id'] = ['EQ', $sign_id];
                $swhere['user_id'] = ['EQ', $userInfo['id']];
                $signInfoInfo = M('activ_signin_info')->where($swhere)->find();

                if (!empty($signInfoInfo)) {
                    $returnData['status'] = 3;
                    $returnData['msg'] = '该用户已签到！';
                    $returnData['timestamp'] = time();
                } else {
                    $returnData['status'] = 1;
                    $returnData['msg'] = '成功签到！';
                    $returnData['timestamp'] = time();

                    $addArr['sign_type'] = 1;
                    $addArr['user_id'] = $userInfo['id'];
                    $addArr['sign_id'] = $sign_id;
                    $addArr['realname'] = $userInfo['realname'];
                    $addArr['sign_integral'] = parent::getDataKey(M('activ_signin'), $sign_id, 'sign_integral');

                    //signinfo表入数据
                    $addFlag = M('activ_signin_info')->add($addArr);
                    $addArr['new_id'] = $addFlag;
                    //更新sign表
                    //更新activ_info表
                    //更新userapp_info表

                    $returnData['data'] = $addArr;
                }
            }
        }
//        $returnData['dd']=$signInfoInfo;
        $this->ajaxReturn($returnData, 'JSON');
    }

    public function getNewUserSigninPos() {
        $input = file_get_contents("php://input"); //接收POST数据
        $inputArr = json_decode($input, true);

        $activity_id = $inputArr['activity_id'];
        $sign_id = $inputArr['sign_id'];
        $new_id = $inputArr['new_id'];

        if (empty($activity_id) || empty($sign_id) || empty($new_id)) {
            $returnData['status'] = 0;
            $returnData['msg'] = '参数错误！';
            $returnData['timestamp'] = time();
        } else {
            $where['sign_id'] = ['EQ', $sign_id];
            $where['id'] = ['GT', $new_id];
            $signInfoList = M('activ_signin_info')->where($where)->order('id desc')->select();
            if (empty($signInfoList)) {
                $returnData['status'] = 2;
                $returnData['msg'] = '没有新的签到！';
                $returnData['timestamp'] = time();
            } else {
                $returnData['status'] = 1;
                $returnData['msg'] = '获取到新的签到！';
                $returnData['timestamp'] = time();

                for ($i = 0; $i < count($signInfoList); $i++) {
                    $signInfoList[$i]['add_time'] = strtotime($signInfoList[$i]['add_time']);
                }
                $returnData['data'] = $signInfoList;
                $returnData['new_id'] = $signInfoList[0]['id'];
            }
        }
//        $returnData['dd'] = M('activ_signin_info')->getLastSql();
        $this->ajaxReturn($returnData, 'JSON');
    }

}
