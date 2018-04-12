<?php

/**
 * @name IndexController
 * @info 描述：后台模块入口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 13:35:49
 */

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller {

    protected $config;

    public function _initialize() {
//        配置字典信息
        $configdefC = A('Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);
    }

    /**
     * 首页入口
     */
    public function index() {
        if ($_SESSION['user_id'] == null) {
            $this->redirect('Login/login');
        } elseif ($_SESSION['sys_token'] == $this->config['system_token']) {
            $seller_info = $this->isSeller();
            if (!empty($seller_info)) {
                session('seller_id', $seller_info['id']);
                $this->assign('seller_info', $seller_info);
            }
            if ($_SESSION['realname'] == NULL || $_SESSION['realname'] == '') {
                $this->assign('realname', $_SESSION['usr']);
            } else {
                $this->assign('realname', $_SESSION['realname']);
            }
//            判断平台入口按钮显示状态
            if ($_SESSION['sys_name'] == 'sysAdmin' || $_SESSION['sys_name'] == 'sqAdmin') {
                $this->assign('shome', 'block');
            } else {
                $this->assign('shome', 'none');
            }
//            判断提醒按钮显示状态
            if ($_SESSION['sys_name'] == 'sysAdmin' || $_SESSION['sys_name'] == 'sqAdmin' || $_SESSION['sys_name'] == 'wyUser') {
                $this->assign('tixing', 'block');
            } else {
                $this->assign('tixing', 'none');
            }
//            判断消息按钮显示状态
            if ($_SESSION['sys_name'] == 'sysAdmin' || $_SESSION['sys_name'] == 'sqAdmin' || ($_SESSION['sys_name'] == 'sellerUser' && isset($_SESSION['seller_id']))) {
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
//        $this->assign('mainNum', $this->getMainNum());
//        $this->assign('noticeArr', $this->getNoticeArr());
//        $this->assign('activArr', $this->getActivArr());
        $this->display();
    }

    /**
     * 判断是否为商家
     * @return type
     */
    public function isSeller() {
        $cat_id = getCatId('sellerUser', D('SysUserGroup'));
        if ($_SESSION['cat_id'] == $cat_id) {//商家用户
            session('user_type', 'sellerUser');
            $condition['user_id'] = $_SESSION['user_id'];
            $sellerInfo = D('SellerInfo')->field('id,name')->where($condition)->find();
            if (isset($sellerInfo)) {
                return $sellerInfo;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }

    /**
     * 获取启用分类字串
     * @param type $model
     * @param type $type
     * @return string
     */
    public function getEnableCatIds($model, $type) {
        if ($type == 0) {
//            社区活动
            $selectArr = $model->where('is_enable=1 and sys_name<>"slider"')->select();
        } else {
//            其他
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
        $noticeEnable = $this->getEnableCatIds(M('NoticeCat'), 1);
        $noticeArr = M('NoticeInfo')->field('id,title,add_time,cat_id,user_id')->where('cat_id in (' . $noticeEnable . ') and is_publish=1')->order('id desc')->limit(10)->select();
        for ($i = 0; $i < count($noticeArr); $i++) {
            $noticeArr[$i]['realname'] = $this->getRealnameById($noticeArr[$i]['user_id']);
            $noticeArr[$i]['cat_name'] = $this->getCatNameById(M('NoticeCat'), $noticeArr[$i]['cat_id']);
            $noticeArr[$i]['add_time'] = tranTime($noticeArr[$i]['add_time']);
            $noticeArr[$i]['icon'] = $this->getTitleIcon($noticeArr[$i]['id']);
        }
        return $noticeArr;
    }

    public function getActivArr() {
        $activEnable = $this->getEnableCatIds(M('ActivCat'), 0);
        $activArr = M('ActivInfo')->where('cat_id in (' . $activEnable . ') and is_publish=1')->order('id desc')->limit(10)->select();
        for ($i = 0; $i < count($activArr); $i++) {
            $activArr[$i]['cat_name'] = $this->getCatNameById(M('NoticeCat'), $activArr[$i]['cat_id']);
            $activArr[$i]['add_time'] = tranTime($activArr[$i]['add_time']);
            $activArr[$i]['icon'] = $this->getTitleIcon($activArr[$i]['id']);
        }
        return $activArr;
    }

    /**
     * 获取提醒消息接口
     */
    public function getPropNum() {
        $propArr = M('PropProbInfo')->field('id,title')->where('is_deal=0')->order('id desc')->limit(5)->select();
        $dangArr = M('PropDangerInfo')->field('id,title,danger_level')->where('is_deal=0')->order('id desc')->limit(5)->select();

        $return['propArr'] = $propArr;
        $return['propNum'] = M('PropProbInfo')->field('id,title')->where('is_deal=0')->order('id desc')->count();
        $return['dangArr'] = $dangArr;
        $return['dangNum'] = M('PropDangerInfo')->field('id,title,danger_level')->order('id desc')->where('is_deal=0')->count();
        $return['countSum'] = $return['propNum'] + $return['dangNum'];
        $this->ajaxReturn($return);
    }

    /**
     * 获取提醒条数接口
     */
    public function getNewNum() {
        $sellerInfo = $this->isSeller();
        if ($sellerInfo == null) {
//            系统管理员和社区管理员
            $sellerArr = M('SellerInfo')->where('cat_id in (' . $this->getEnableCatIds(M('SellerCat'), 1) . ') and is_checked=0')->order('id desc')->limit(5)->select();
            $return['type'] = 'seller';
            $return['sellerArr'] = $sellerArr;
            $return['sellerNum'] = M('SellerInfo')->where('cat_id in (' . $this->getEnableCatIds(M('SellerCat'), 1) . ') and is_checked=0')->order('id desc')->count();

            $itemArr = M('SellerItemsInfo')->where('cat_id in (' . $this->getEnableCatIds(M('SellerItemsCat'), 1) . ') and is_checked=0')->order('id desc')->limit(5)->select();
            $return['itemArr'] = $itemArr;
            $return['itemNum'] = M('SellerItemsInfo')->where('cat_id in (' . $this->getEnableCatIds(M('SellerItemsCat'), 1) . ') and is_checked=0')->order('id desc')->count();

            $return['Num'] = intval($return['itemNum']) + intval($return['sellerNum']);
        } else {
//            商家
            $orderArr = M('SellerOrderInfo')
                    ->join('as o left join qs_gryj_seller_info as s on o.seller_id=s.id')
                    ->field('o.id,o.order_no,o.buyer_id,o.seller_id,o.send_type,o.deal_type,s.name,s.user_id')
                    ->where('(o.deal_type=1 or o.deal_type=2) and s.user_id=' . $_SESSION['user_id'])
                    ->order('id desc')
                    ->limit(10)
                    ->select();
            for ($i = 0; $i < count($orderArr); $i++) {
                $orderArr[$i]['order_no'] = '订单编号：' . $orderArr[$i]['order_no'];
                $orderArr[$i]['realname'] = '买家：' . $this->getRealnameById($orderArr[$i]['buyer_id']);
                $orderArr[$i]['deal_type'] = $orderArr[$i]['deal_type'] == 1 ? '<span class="label label-warning">待处理</span>' : '<span class="label label-info">处理中</span>';
            }
            $return['type'] = 'order';
            $return['Arr'] = $orderArr;
            $return['Num'] = M('SellerOrderInfo')
                    ->join('as o left join qs_gryj_seller_info as s on o.seller_id=s.id')
                    ->field('o.id,o.order_no,o.buyer_id,o.seller_id,o.send_type,o.deal_type,s.name,s.user_id')
                    ->where('(o.deal_type=1 or o.deal_type=2) and s.user_id=' . $_SESSION['user_id'])
                    ->order('o.id desc')
                    ->count();
        }

        $this->ajaxReturn($return);
    }

    /**
     * 获取首页四个标签
     * @return type
     */
    public function getMainNum() {
        $return['notice'] = M('NoticeInfo')->where('cat_id in (' . $this->getEnableCatIds(M('NoticeCat'), 1) . ') and is_publish=1')->count();
        $return['activity'] = M('ActivInfo')->where('cat_id in (' . $this->getEnableCatIds(M('ActivCat'), 0) . ') and is_publish=1')->count();
        $return['dang'] = M('PropDangerInfo')->where('cat_id in (' . $this->getEnableCatIds(M('PropDangerCat'), 1) . ')')->count();
        $return['prop'] = M('PropProbInfo')->count();
        $return['seller'] = M('SellerInfo')->where('cat_id in (' . $this->getEnableCatIds(M('SellerCat'), 1) . ') and is_checked=1')->count();
        return $return;
    }

}
