<?php

/**
 * @name ActivCatController
 * @info 描述：活动信息控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:02:04
 */

namespace Admin\Controller;

use Think\Controller;

class ActivInfoController extends BaseDBController {

    protected $catModel;
    protected $infoModel;
    protected $commModel;
    protected $attachModel;
    protected $userInfoModel;
    protected $signModel;
    protected $signInfoModel;

    public function _initialize() {
        parent::_initialize();
        $this->catModel = D('ActivCat');
        $this->infoModel = D('ActivInfo');
        $this->commModel = D('ActivComm');
        $this->attachModel = D('SysAllAttach');
        $this->userInfoModel = D('SysUserInfo');
        $this->signModel = M('ActivSignin');
        $this->signInfoModel = M('ActivSigninInfo');
    }

    /**
     * function:显示活动信息列表
     */
    public function showList() {
        $this->assign('address_id', $_SESSION['address_id']);

        if ($_SESSION['address_id'] != 0) {
            $where[$this->dbFix . 'activ_info.address_id'] = array('IN', '0,' . $_SESSION['address_id']);
        }
        if (!empty($_GET['title'])) {
            $where['title'] = array('LIKE', '%' . urldecode($_GET['title']) . '%');
            $pageCondition['title'] = urldecode($_GET['title']);
        }
        if (!empty($_GET['cat_id'])) {
            $where[$this->dbFix . 'activ_info.cat_id'] = array('EQ', $_GET['cat_id']);
            $pageCondition['category_name'] = urldecode($_GET['category_name']);
            $pageCondition['cat_id'] = $_GET['cat_id'];
        }

        $fieldStr = parent::madField('activ_info.*', 'activ_cat.cat_name') . ',' . parent::madField('sys_user_info.realname', 'sys_user_info.usr');
        $joinStr = parent::madJoin('activ_info.cat_id', 'activ_cat.id') . ' ' . parent::madJoin('activ_info.user_id', 'sys_user_info.id');
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:跳转保存活动信息页面
     */
    public function saveActiv() {
        $this->assign('address_id', $_SESSION['address_id']);
        $this->display();
    }

    /**
     * function:编辑活动信息
     */
    public function edit() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            $returnData['data']['category_name'] = $this->getCatName($returnData['data']['cat_id']);
            $condition['module_info_id'] = array('EQ', $returnData['data']['id']);
            $condition['module_name'] = array('EQ', 'activity');
            $attachList = $this->attachModel->where($condition)->select(); //if(is_array($res) && count($res)>0)
            $this->assign('attachList', json_encode($attachList));
            $this->assign('activInfo', $returnData['data']);
        } else {
            $this->assign('address_id', $_SESSION['address_id']);
        }
        $this->assign('address_id', $_SESSION['address_id']);
        $this->display('saveActiv');
    }

    /**
     * function:保存活动信息
     */
    public function saveActivInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['user_id'] = $_SESSION['user_id'];
        $returnData = parent::saveData($this->infoModel, $param_arr); //添加活动信息
        if ($returnData['code'] == '500') {
            foreach ($param_arr['files'] as $value) {
                $condition['id'] = array('EQ', $value);
                if ($returnData['flag'] == 'add') {
                    $data = array('module_info_id' => $returnData['dataID']);
                } else {
                    $data = array('module_info_id' => $param_arr['id']);
                }
                $this->attachModel->where($condition)->setField($data);
            }
            $logC = A('Actionlog')->addLog('ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息');
        }
        $this->ajaxReturn($returnData, 'JSON');
        exit;
    }

    /**
     * function:删除单条社区活动信息
     * @param $id
     * @return bool
     */
    public function delActivInfo($id) {
        $successFlag = true;
        $returnData = parent::delData($this->infoModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        }
        return $successFlag;
    }

    /**
     * function:批量删除社区活动信息
     */
    public function delArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delActivInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('ActivCat', 'delArrayInfo', '删除社区活动信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:发布单条活动信息
     */
    public function publishActivInfo($id) {
        $condition['id'] = array('EQ', $id);
        $acvInfo = $this->infoModel->where($condition)->find();
        $fen = $acvInfo['integral'];
        for ($i = 0; $i < $acvInfo['signin_time']; $i++) {
            $signData['activity_id'] = $acvInfo['id'];
            $signData['sign_ids'] = ',';
            $signData['sign_num'] = $i + 1;
            if (($i + 1) != $acvInfo['signin_time']) {
                $signData['sign_integral'] = round($acvInfo['integral'] / $acvInfo['signin_time']);
                $fen = $fen - $signData['sign_integral'];
            } else {
                $signData['sign_integral'] = $fen;
            }

            //生成签到二维码
            $signData['sign_qrcode_path'] = '0';
            $addId = $this->signModel->add($signData);
            $url = $this->config['system_ymurl'] . '/index.php/Appm/Qrcodeurl/activ_signin/id/' . $addId . '/';
            $url = $this->config['wx_token_p'] . $url . $this->config['wx_token_a'];
            $data['sign_qrcode_path'] = createQrcode($url);
            $where['id']=['EQ',$addId];
            $this->setField($this->signModel, $where, $data);
        }
        $data = array(
            'is_publish' => '1',
            'is_open' => '1'
        );
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData['code'];
    }

    /**
     * function:批量发布活动信息
     */
    public function publishArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if ($this->publishActivInfo($value) == '502') {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('ActivCat', 'publishArrayInfo', '发布社区活动信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:返回参加活动人数列表
     */
    public function showJoinList() {
        $userList = array();
        $returnData = parent::getData($this->infoModel, $_POST['id']);
        $joinArr = explode(",", trim($returnData['data']['join_ids'], ","));
        foreach ($joinArr as $value) {
            $condition['id'] = array('EQ', $value);
            $userInfo = $this->userInfoModel->field('realname,tel,address,usr')->where($condition)->find();
            array_push($userList, $userInfo);
        }
        $logC = A('Actionlog')->addLog('ActivCat', 'showJoinList', '查看参加活动人数');
        echo json_encode($userList);
    }

    /**
     * function:活动详情
     */
    public function activDetail() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        $usrCondition['id'] = array('EQ', $returnData['data']['user_id']);
        $usrInfo = $this->userInfoModel->field('realname,usr')->where($usrCondition)->find();
        $returnData['data']['usr'] = (!empty($usrInfo['realname']) ? $usrInfo['realname'] : $usrInfo['usr']);
        $where['activity_id'] = $returnData['data']['id'];
        $condition['module_info_id'] = $returnData['data']['id'];
        $condition['module_name'] = array('EQ', 'activity');
        $commInfoList = $this->commModel->field($this->dbFix . 'activ_comm.*,' . $this->dbFix . 'sys_userapp_info.realname')->join('LEFT JOIN __SYS_USERAPP_INFO__ ON __ACTIV_COMM__.user_id=__SYS_USERAPP_INFO__.id')->where($where)->order('id desc')->select();
        $imgInfoList = $this->attachModel->where($condition)->order('id desc')->select();
        $this->assign('activ', $returnData['data']);
        $this->assign('imgInfo', $imgInfoList);
        $this->assign('activComm', $commInfoList);
//        dump($commInfoList);
        $this->display();
    }

    /**
     * function:获取活动分类列表彈出框中（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

    /**
     * function:获取信息中所属分类名称
     * @param $cat_id
     * @return string
     */
    public function getCatName($cat_id) {
        if (!empty($cat_id)) {
            $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $cat_id))->find();
            $category_name = $res['category_name'];
        } else {
            $category_name = '所有分类';
        }
        return $category_name;
    }

    /**
     * 结束活动
     */
    public function closeAct() {
        $condition['id'] = array('EQ', $_POST['id']);
        $data = array('is_open' => '0');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
            $returnData['msg'] = '活动关闭失败，请重新操作！';
        }
        echo json_encode($returnData);
    }

    /**
     * 展示活动签到列表
     */
    public function showSignList() {

        $where['id'] = $signWhere['activity_id'] = array('EQ', $_GET['id']);
        $info = $this->infoModel->where($where)->find();
        $this->assign('activInfo', $info);

        $signInfo = $this->signModel->where($signWhere)->select();
        for ($i = 0; $i < count($signInfo); $i++) {
                $signInfo[$i]['data'] = $this->signInfoModel->where('sign_id=' . $signInfo[$i]['id'])->select();
                $signInfo[$i]['sign_sum']=count($signInfo[$i]['data']);
        }
       
        $this->assign('signInfo', $signInfo);
        $this->display();
    }

}
