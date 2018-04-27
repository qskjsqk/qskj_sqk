<?php

/**
 * @name TopStatInfoController
 * @info 描述：榜单统计控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-27 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Config;

class TopStatInfoController extends BaseDBController {

    protected $catModel;

    public function _initialize() {
        parent::_initialize();
        $this->catModel = D('NoticeCat');
    }

    /**
     * function:显示榜单列表
     */
    public function showTopList() {
        $this->assign('address_id', $_SESSION['address_id']);
        $data['type'] = empty($_GET['type']) ? 0 : $_GET['type'];

        $quarter = getQuarter();
        $nWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['nend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['nstart'] . '"';
        $lWhere = $this->dbFix . 'activ_signin_info.add_time < "' . $quarter['lend'] . '" and ' . $this->dbFix . 'activ_signin_info.add_time > "' . $quarter['lstart'] . '"';
        

        switch ($data['type']) {
            case 0:
                $data['type_name'] = '本社区用户榜单';
                //本季度--------------------------------------------------------
                $nowArr = M('ActivSigninInfo')
                        ->field('sum(' . $this->dbFix . 'activ_signin_info.sign_integral) as sign_integral,' . $this->dbFix . 'activ_signin_info.user_id,'
                                . $this->dbFix . 'sys_userapp_info.realname,' . $this->dbFix . 'sys_userapp_info.address_id')
                        ->join('left join ' . $this->dbFix . 'sys_userapp_info on ' . $this->dbFix . 'activ_signin_info.user_id=' . $this->dbFix . 'sys_userapp_info.id')
                        ->where($nWhere)->group('user_id')->order('sign_integral desc')->limit(8)
                        ->select();
                for ($i = 0; $i < count($nowArr); $i++) {
                    $nowArr[$i]['address_name'] = getConameById($nowArr[$i]['address_id']);
                    $nowArr[$i]['tx_icon']='<img src="../../../Public/admin/img/tx_icon/'.($nowArr[$i]['user_id']%13+1).'.jpg">';
                }
                $data['nowList'] = $nowArr;
                //上季度--------------------------------------------------------
                $lastArr = M('ActivSigninInfo')
                        ->field('sum(' . $this->dbFix . 'activ_signin_info.sign_integral) as sign_integral,' . $this->dbFix . 'activ_signin_info.user_id,'
                                . $this->dbFix . 'sys_userapp_info.realname,' . $this->dbFix . 'sys_userapp_info.address_id')
                        ->join('left join ' . $this->dbFix . 'sys_userapp_info on ' . $this->dbFix . 'activ_signin_info.user_id=' . $this->dbFix . 'sys_userapp_info.id')
                        ->where($lWhere)->group('user_id')->order('sign_integral desc')->limit(8)
                        ->select();
                for ($i = 0; $i < count($lastArr); $i++) {
                    $lastArr[$i]['address_name'] = getConameById($lastArr[$i]['address_id']);
                    $lastArr[$i]['tx_icon']='<img src="../../../Public/admin/img/tx_icon/'.($lastArr[$i]['user_id']%13+1).'.jpg">';
                }
                $data['lastList'] = $lastArr;
                dump($nowArr[0]['user_id']%13);
                break;
            case 1:
                $data['type_name'] = '梨园镇用户榜单';
                break;
            case 2:
                $data['type_name'] = '梨园镇商家榜单';
                break;
            case 3:
                $data['type_name'] = '梨园镇社区榜单';
                break;
            default:
                $data['type_name'] = '本社区用户榜单';
                break;
        }
        $this->assign('data', $data);
        $this->display();
//        if ($_SESSION['address_id'] != 0) {
//            $where[$this->dbFix . 'notice_info.address_id'] = array('IN', '0,' . $_SESSION['address_id']);
//        }
//        if (!empty($_GET['title'])) {
//            $where['title'] = array('LIKE', '%' . urldecode($_GET['title']) . '%');
//            $pageCondition['title'] = urldecode($_GET['title']);
//        }
//        if (!empty($_GET['cat_id'])) {
//            $where[$this->dbFix . 'notice_info.cat_id'] = array('EQ', $_GET['cat_id']);
//            $pageCondition['category_name'] = urldecode($_GET['category_name']);
//            $pageCondition['cat_id'] = $_GET['cat_id'];
//        }
//        $fieldStr = parent::madField('notice_info.*', 'notice_cat.cat_name') . ',' . parent::madField('sys_user_info.usr', 'sys_user_info.realname');
//        $joinStr = parent::madJoin('notice_info.cat_id', 'notice_cat.id') . ' ' . parent::madJoin('notice_info.user_id', 'sys_user_info.id');
//        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:跳转添加页面
     */
    public function add() {
        $this->assign('address_id', $_SESSION['address_id']);
        $this->display();
    }

    /**
     * function:编辑通知信息
     */
    public function edit() {
        $this->assign('address_id', $_SESSION['address_id']);
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            if (!empty($returnData['data']['cat_id'])) {
                $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $returnData['data']['cat_id']))->find();
                $returnData['data']['category_name'] = $res['category_name'];
                $condition['module_info_id'] = array('EQ', $returnData['data']['id']);
                $condition['module_name'] = array('EQ', 'notice');
                $attachList = $this->attachModel->where($condition)->select(); //if(is_array($res) && count($res)>0)
                $this->assign('attachList', json_encode($attachList));
//                dump($attachList);
            } else {
                $returnData['data']['category_name'] = '所有分类';
            }
            $this->assign('noticeInfo', $returnData['data']);
        } else {
            $this->assign();
        }
        $this->display('add');
    }

    /**
     * function:保存通知信息
     * @return $returnData(501验证未通过 500添加成功 502添加失败)
     */
    public function saveNoticeInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['user_id'] = $_SESSION['user_id'];
        $param_arr['read_ids'] = ',';
        $returnData = parent::saveData($this->infoModel, $param_arr);
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
            $logC = A('Actionlog')->addLog('NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息');
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delNoticeInfo($id) {
        $successFlag = true;
        $returnData = parent::delData($this->infoModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        }
        return $successFlag;
    }

    /**
     * function:批量删除数据
     */
    public function delArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delNoticeInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('NoticeInfo', 'delArrayInfo', '删除通知信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:发布
     */
    public function publNoticeInfo() {
        $condition['id'] = array('EQ', $_POST['id']);
        $data = array('is_publish' => '1');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
            $logC = A('Actionlog')->addLog('NoticeInfo', 'publNoticeInfo', '发布通知信息');
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:通知详情
     */
    public function noticeDetail() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        $sysUserInfo = D('SysUserInfo')->where(array('id' => $returnData['data']['user_id']))->find();
        $returnData['data']['usr'] = (!empty($sysUserInfo['realname']) ? $sysUserInfo['realname'] : $sysUserInfo['usr']);


        $condition['module_info_id'] = $returnData['data']['id'];
        $condition['module_name'] = array('EQ', 'notice');
        $imgInfoList = $this->attachModel->where($condition)->order('id desc')->select();
        $this->assign('imgInfo', $imgInfoList);


        $this->assign('notice', $returnData['data']);
        $this->display();
    }

    /**
     * function:获取通知列表彈出框中（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

}
