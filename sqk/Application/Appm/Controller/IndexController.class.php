<?php

/**
 * @name IndexController
 * @info 描述：Appm入口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 13:35:49
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class IndexController extends BaseController {

    public function _initialize() {
        parent::_initialize();
    }

    public function httpRequest($pUrl, $pData) {
        $tCh = curl_init();
        if ($pData) {
            is_array($pData) && $pData = http_build_query($pData);
            curl_setopt($tCh, CURLOPT_POST, true);
            curl_setopt($tCh, CURLOPT_POSTFIELDS, $pData);
        }
        curl_setopt($tCh, CURLOPT_HTTPHEADER, array("Content-type:application/json;charset=UTF-8"));
        curl_setopt($tCh, CURLOPT_URL, $pUrl);
        curl_setopt($tCh, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($tCh, CURLOPT_TIMEOUT, 10);
        curl_setopt($tCh, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($tCh, CURLOPT_SSL_VERIFYPEER, false);
        $tResult = curl_exec($tCh);
        curl_close($tCh);
        return $tResult;
    }

    public function checkSignature() {
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token = "123456";
        $signature = $_GET['signature'];
        $array = array($timestamp, $nonce, $token);
        sort($array);

//2.将排序后的三个参数拼接后用sha1加密  
        $tmpstr = implode('', $array);
        $tmpstr = sha1($tmpstr);

//3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信  
        if ($tmpstr == $signature) {
            echo $_GET['echostr'];
            exit;
        }
    }

//    视图
//------------------------------------------------------------------------------    
    public function index() {
        //1. 将timestamp , nonce , token 按照字典排序  


        $appid = 'wx7e5a0f04c993739e';
        $secret = '510fd7ca5fb268fc06502e9861e00b69';

        $getAccessToken = $this->httpRequest('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx7e5a0f04c993739e&secret=510fd7ca5fb268fc06502e9861e00b69');
        $wxInfo = json_decode($getAccessToken, true);
//        $a = $this->httpRequest('https://api.weixin.qq.com/sns/userinfo?access_token=9_C8iRW2XTIgt_ulUnVP0efjvjWsM98QyO9Oy7EYppWq4-_8VW4wIIyNjgh_pJFC9ovY2LK5DjmO6rbWmt3JcwxQ&openid=ozF060wIC0F5P5GLlrfw0OEMpeGM', '');
//        $wxInfo = json_decode($a, true);
        dump($wxInfo);
        echo "<img src='" . $wxInfo['headimgurl'] . "'>";
        $this->redirect('Login/index');
//        if ($_COOKIE['user_id'] == null) {
//            $this->redirect('Login/index');
//        } else {
//            $this->redirect('Activity/activity_list');
//        }
    }

    public function getwxinfo() {
//        dump($_GET['code']);
        $a = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx7e5a0f04c993739e&secret=510fd7ca5fb268fc06502e9861e00b69&code=" . $_GET['code'] . "&grant_type=authorization_code";
        $a = $this->httpRequest($a, '');
        $wxInfo = json_decode($a, true);
//        dump($wxInfo);

        $b = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $wxInfo['access_token'] . "&openid=" . $wxInfo['openid'];
        $b = $this->httpRequest($b, '');
        $userInfo = json_decode($b, true);

        echo "<img src='" . $userInfo['headimgurl'] . "'></br><h2>" . $userInfo['nickname'] . "</h2></br><h2>" . $userInfo['province'] . $userInfo['city'] . "</h2>";
//        dump($userInfo);
    }

    /**
     * 我的
     */
    public function setting() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 我的资料
     */
    public function my_info() {
        $this->display();
    }

    /**
     * 我的通知
     */
    public function my_notice() {
        $this->display();
    }

    /**
     * 我的实体卡
     */
    public function my_card() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 我的活动
     */
    public function activ_list() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 我的签到
     */
    public function signin_list() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 劵吗兑换记录
     */
    public function litem_list() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 积分交易记录
     */
    public function order_list() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 商家版我的资料
     */
    public function tx_upload() {
        $this->assign('myInfo', $this->getUserappInfo());
        $this->display();
    }

    /**
     * 获取个人信息
     */
    public function getUserappInfo() {
        $userModel = M(C('DB_USERAPP_INFO'));
        $user_id = cookie('user_id');
        $result = $userModel->where(array('id' => $user_id))->find();
        $result['address_name'] = getConameById($result['address_id']);
        if ($_GET['type'] == 'api') {
            $this->ajaxReturn($result);
        } else {
            return $result;
        }
    }

    /**
     * 保存商家头像
     */
    public function saveTxInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $condition['id'] = array('EQ', $param_arr['files'][0]);
        $data = array('module_info_id' => cookie('user_id'));
        M('sys_all_attach')->where($condition)->setField($data);
        $txPath = parent::getDataKey(M('sys_all_attach'), $param_arr['files'][0], 'file_path');
        $addData = array('tx_path' => $txPath);
        $result = M('sys_userapp_info')->where('id=' . cookie('user_id'))->setField($addData);

        if ($result === FALSE) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => '修改头像失败!');
        } else {
            $returnData['is_success'] = array('flag' => 1, 'msg' => '修改头像成功!');
        }

        $this->ajaxReturn($returnData);
    }

    public function getMyActivList() {
        $user_id = cookie('user_id');

        $activC = A('Activity');
        $num = C('PAGE_NUM')['activity'] * $_POST['page'];
        if ($_POST['type'] == 0) {
            $where['like_ids'] = array('LIKE', '%,' . $user_id . ',%');
        } else {
            $where['join_ids'] = array('LIKE', '%,' . $user_id . ',%');
        }

        $acitvArr = M('ActivInfo')->where($where)->order('id desc')->limit($num)->select();
        //调试sql
        $returnData['sql'] = M('ActivInfo')->getLastSql();

        $count = M('ActivInfo')->where($where)->count();
        $returnData['count'] = $count;



        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_POST['page'];
        $returnData['type'] = $_POST['type'];

        if (empty($acitvArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($acitvArr); $i++) {
                $data[$i]['id'] = $acitvArr[$i]['id'];
                $data[$i]['title'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $acitvArr[$i]['title']);
                $data[$i]['cat_name'] = $activC->getCatNameById($acitvArr[$i]['cat_id']);

                $data[$i]['start_time'] = $acitvArr[$i]['start_time'];

                $data[$i]['like_num'] = $acitvArr[$i]['like_num'];

                $times = strtotime($acitvArr[$i]['start_time']);
                $data[$i]['start_date'] = date('Y.m.d', $times);
                $data[$i]['address_name'] = getConameById($acitvArr[$i]['address_id']);
                $data[$i]['integral'] = $acitvArr[$i]['integral'];

                $data[$i]['like_flag'] = $activC->checkReadLikeJoin($acitvArr[$i]['id'], 'like');

                $data[$i]['is_open'] = $acitvArr[$i]['is_open'];
                $picsInfo = $activC->getAttachArr($acitvArr[$i]['id']);
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

    public function getMySignList() {
        $user_id = cookie('user_id');

        $num = C('PAGE_NUM')['signin'] * $_POST['page'];

        $where['user_id'] = ['EQ', $user_id];

        $signArr = M('ActivSigninInfo')->where($where)->order('id desc')->limit($num)->select();
        //调试sql
        $returnData['sql'] = M('ActivSigninInfo')->getLastSql();

        $count = M('ActivSigninInfo')->where($where)->count();
        $returnData['count'] = $count;

        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_POST['page'];
        $returnData['type'] = $_POST['type'];

        if (empty($signArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($signArr); $i++) {
                $data[$i] = $signArr[$i];
                $signInfo = M('ActivSignin')->field('qs_sqk_activ_signin.*,qs_sqk_activ_info.title,qs_sqk_activ_info.signin_time')
                                ->join('left join qs_sqk_activ_info on qs_sqk_activ_signin.activity_id=qs_sqk_activ_info.id')
                                ->where('qs_sqk_activ_signin.id=' . $signArr[$i]['sign_id'])->find();
                unset($signInfo['add_time']);
                foreach ($signInfo as $key => $value) {
                    $data[$i][$key] = $value;
                }
            }

            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 保存用户信息
     */
    public function saveUserappInfo() {
        $userModel = D('SysUserappInfo');
        $user_id = cookie('user_id');
        $saveArr['tel'] = $_POST['tel'];
        $saveArr['usr'] = $_POST['usr'];
        $saveArr['realname'] = $_POST['realname'];
        $saveArr['gender'] = $_POST['gender'];
        $saveArr['birthday'] = $_POST['birthday'];
        $saveArr['address_id'] = $_POST['address_id'];
//        dump($saveArr);
        if (!$userModel->create($saveArr)) {
            $returnData['is_success'] = array('flag' => 0, 'msg' => $userModel->getError());
        } else {
            $result = $userModel->where('id=' . $user_id)->save($saveArr); //数据更新
            if ($result === FALSE) {
                $returnData['is_success'] = array('flag' => 0, 'msg' => '修改资料失败!');
            } else {
                $returnData['is_success'] = array('flag' => 1, 'msg' => '修改资料成功!');
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 调试代码
     */
    public function zxw() {
        
    }

}
