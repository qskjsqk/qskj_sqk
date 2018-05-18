<?php

/**
 * @name IndexController
 * @info 描述：后台模块入口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 13:35:49
 */

namespace Admin\Controller;

use Think\Controller;

class IndexController extends BaseDBController {

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 首页入口
     */
    public function index() {
        if ($_SESSION['user_id'] == null) {
            $this->redirect('Login/login');
        } elseif ($_SESSION['sys_token'] == $this->config['system_token']) {
//            显示左上角用户
            if ($_SESSION['realname'] == NULL || $_SESSION['realname'] == '') {
                $this->assign('realname', $_SESSION['usr']);
            } else {
                $this->assign('realname', $_SESSION['realname']);
            }
//            判断提醒按钮显示状态
            if ($_SESSION['sys_name'] == 'sysAdmin' || $_SESSION['sys_name'] == 'sqAdmin') {
                $this->assign('tixing', 'block');
            } else {
                $this->assign('tixing', 'none');
            }
//            判断消息按钮显示状态
            if ($_SESSION['sys_name'] == 'sysAdmin' || $_SESSION['sys_name'] == 'sqAdmin') {
                $this->assign('xiaoxi', 'block');
            } else {
                $this->assign('xiaoxi', 'none');
            }
            $this->display();
        } else {
            $this->redirect('Login/login');
        }
    }

    /**
     * 后台主页
     */
    public function main() {
        $this->assign('nowTime', date('Y年m月d日 H:i:s', time()));
        $this->assign('mainNum', $this->getMainNum());
        $this->assign('noticeArr', $this->getNoticeArr());
        $this->assign('activArr', $this->getActivArr());
        $this->display();
    }

    /**
     * 获取启用分类字串
     * @param type $model
     * @param type $type
     * @return string
     */
    public function getEnableCatIds($model, $type) {
        if ($type == 0) {
            $selectArr = $model->where('is_enable=1')->select();
        }

        if (empty($selectArr)) {
            return '0,0';
        } else {
            foreach ($selectArr as $value) {
                $str .= ',' . $value['id'];
            }
            return '0' . $str;
        }
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
     * @param type $model
     * @param type $cat_id
     * @return int
     */
    public function getCatNameById($model, $cat_id) {
        $catArr = $model->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr['cat_name'];
        }
    }

    /**
     * 获取图标
     * @param type $id
     * @return string
     */
    public function getTitleIcon($id) {
        switch (intval($id % 3)) {
            case 0:
                return '<i class="glyphicon glyphicon-bell b-icon-style b-icon-title0"></i>';
                break;
            case 1:
                return '<i class="glyphicon glyphicon-bullhorn b-icon-style b-icon-title1"></i>';
                break;
            case 2:
                return '<i class="glyphicon glyphicon-send b-icon-style b-icon-title2"></i>';
                break;
            default:
                break;
        }
    }

    public function getNoticeArr() {
        $address_id = $_SESSION['address_id'];
        $noticeEnable = $this->getEnableCatIds(M('NoticeCat'), 0);
        if ($address_id == 0) {
            $noticeArr = M('NoticeInfo')->field('id,title,add_time,cat_id,user_id,address_id')->where('cat_id in (' . $noticeEnable . ') and is_publish=1')->order('id desc')->limit(10)->select();
        } else {
            $noticeArr = M('NoticeInfo')->field('id,title,add_time,cat_id,user_id,address_id')->where('cat_id in (' . $noticeEnable . ') and is_publish=1 and address_id in (0,' . $address_id . ')')->order('id desc')->limit(10)->select();
        }
        for ($i = 0; $i < count($noticeArr); $i++) {
            $noticeArr[$i]['realname'] = $this->getRealnameById($noticeArr[$i]['user_id']);
            $noticeArr[$i]['cat_name'] = $this->getCatNameById(M('NoticeCat'), $noticeArr[$i]['cat_id']);
            $noticeArr[$i]['add_time'] = tranTime($noticeArr[$i]['add_time']);
            $noticeArr[$i]['icon'] = $this->getTitleIcon($noticeArr[$i]['id']);
        }
        return $noticeArr;
    }

    public function getActivArr() {
        $address_id = $_SESSION['address_id'];
        $activEnable = $this->getEnableCatIds(M('ActivCat'), 0);

        if ($address_id == 0) {
            $activArr = M('ActivInfo')->where('cat_id in (' . $activEnable . ') and is_publish=1')->order('id desc')->limit(10)->select();
        } else {
            $activArr = M('ActivInfo')->where('cat_id in (' . $activEnable . ') and is_publish=1 and address_id in (0,' . $address_id . ')')->order('id desc')->limit(10)->select();
        }
        for ($i = 0; $i < count($activArr); $i++) {
            $activArr[$i]['cat_name'] = $this->getCatNameById(M('NoticeCat'), $activArr[$i]['cat_id']);
            $activArr[$i]['add_time'] = tranTime($activArr[$i]['add_time']);
            $activArr[$i]['icon'] = $this->getTitleIcon($activArr[$i]['id']);
            $activArr[$i]['start_time'] = tranTimeToCom($activArr[$i]['start_time']);
        }
        return $activArr;
    }

    /**
     * 获取提醒消息接口
     */
    public function getTxNum() {

        $address_id = $_SESSION['address_id'];
        if ($address_id == 0) {
            $txNum['seller'] = M('seller_info')->where('status=0')->count();
            $txNum['prom'] = M('seller_prom_info')->where('status=0')->count();
            $txNum['complaint'] = M('seller_complaint')->where('status=0')->count();
            $txNum['all'] = $txNum['seller'] + $txNum['prom'] + $txNum['complaint'];
        } else {
            $txNum['seller'] = M('seller_info')->where('status=0 and address_id=' . $address_id)->count();
            $txNum['prom'] = M('seller_prom_info')->where('status=0 and address_id=' . $address_id)->count();

            $txNum['complaint'] = M('seller_complaint')->field($this->dbFix.'seller_complaint.status,'.$this->dbFix.'seller_info.address_id')
                    ->join('left join '.$this->dbFix.'seller_info on '.$this->dbFix
                    .'seller_complaint.seller_id='.$this->dbFix.'seller_info.id')->where($this->dbFix.'seller_complaint.status=0 and '
                            .$this->dbFix.'seller_info.address_id='.$address_id)->count();
            $txNum['all'] = $txNum['seller'] + $txNum['prom'] + $txNum['complaint'];
        }
        $this->ajaxReturn($txNum, 'JSON');
    }

    /**
     * 获取首页四个标签
     * @return type
     */
    public function getMainNum() {
        $address_id = $_SESSION['address_id'];
        if ($address_id == 0) {
            $return['notice'] = M('NoticeInfo')->where('1=1')->count();
            $return['activity'] = M('ActivInfo')->where('1=1')->count();
            $return['appuser'] = M('sys_userapp_info')->where('1=1')->count();
            $return['seller'] = M('SellerInfo')->where('1=1')->count();
        } else {
            $return['notice'] = M('NoticeInfo')->where('address_id in(0,' . $address_id . ')')->count();
            $return['activity'] = M('ActivInfo')->where('address_id in(0,' . $address_id . ')')->count();
            $return['appuser'] = M('sys_userapp_info')->where('address_id in(0,' . $address_id . ')')->count();
            $return['seller'] = M('SellerInfo')->where('address_id in(0,' . $address_id . ')')->count();
        }

        return $return;
    }

}
