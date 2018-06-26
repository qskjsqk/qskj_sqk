<?php

/**
 * @name SellerController
 * @info 描述：商家服务模块
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 16:29:48
 */

namespace Dxt\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class SellerController extends Controller {

//------------------------------------------------------------------------------
    protected $config;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Admin/Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);
    }

    public function item_list() {
        $this->assign('address_id', cookie('address_id'));
        $sliderData = $this->getSlider();
        $this->assign('sliderData', $sliderData);
        $this->display();
    }

    public function seller_info() {
        $this->assign();
        $this->display();
    }

    public function seller_prom() {
        $this->assign();
        $this->display();
    }

    public function order_manage() {
        $this->assign();
        $this->display();
    }

//------------------------------------------------------------------------------    
    /**
     * 获取商家列表
     */
    public function getList() {

        $keyword = $_GET['keyword'];
        $num = C('PAGE_NUM')['seller'] * $_GET['page'];

        $selectArr = M('SellerInfo')
                ->where('is_checked=1 and cat_id=' . $_GET['cat_id'] . ' and (name like "%' . $keyword . '%" or address like "%' . $keyword . '%" or tel like "%' . $keyword . '%" or introduction like "%' . $keyword . '%" ) and user_id<>0')
                ->Field('id,name,introduction,logo_icon,is_rest,work_start,work_end,tel,address')
                ->limit($num)
                ->select();
        $count = M('SellerInfo')
                ->where('is_checked=1 and cat_id=' . $_GET['cat_id'] . ' and (name like "%' . $keyword . '%" or address like "%' . $keyword . '%" or tel like "%' . $keyword . '%" or introduction like "%' . $keyword . '%" ) and user_id<>0')
                ->count();
//动态加载----------------------------------------------------        
        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_GET['page'];
//-------------------------------------------------------------        
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            $returnData['title'] = $this->getCatNameById($_GET['cat_id']);
            for ($i = 0; $i < count($selectArr); $i++) {
                $data[$i]['id'] = $selectArr[$i]['id'];
                $data[$i]['name'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['name']);
                $data[$i]['introduction'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['introduction']);
                $data[$i]['logo_icon'] = $selectArr[$i]['logo_icon'];
                $data[$i]['tel'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['tel']);
                $data[$i]['address'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['address']);
                $data[$i]['is_rest'] = $this->getWorkState($selectArr[$i]['is_rest'], $selectArr[$i]['work_start'], $selectArr[$i]['work_end']);
                $data[$i]['item_cat'] = $this->getItemCatStr($selectArr[$i]['id']);
                $data[$i]['sum_num'] = $this->getSellerSumSoldNum($selectArr[$i]['id']);
            }
            $returnData['data'] = $data;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取商家促销列表
     */
    public function getPromList() {
        $keyword = $_GET['keyword'];
        $num = C('PAGE_NUM')['seller'] * $_GET['page'];

        $sellerIds = $this->getSellerByCatId($_GET['cat_id']);
        $selectArr = M('SellerPromInfo')
                ->join('as p left join qs_gryj_seller_info as s on p.seller_id=s.id')
                ->field('p.*,s.user_id')
                ->where('p.seller_id in (' . $sellerIds . ') and (p.title like "%' . $keyword . '%" or p.content like "%' . $keyword . '%") and s.user_id<>0')
                ->limit($num)
                ->select();
        $count = M('SellerPromInfo')
                ->join('as p left join qs_gryj_seller_info as s on p.seller_id=s.id')
                ->field('p.*,s.user_id')
                ->where('p.seller_id in (' . $sellerIds . ') and (p.title like "%' . $keyword . '%" or p.content like "%' . $keyword . '%") and s.user_id<>0')
                ->count();
//        $returnData['sql']=M('SellerPromInfo')->getLastSql();
        //动态加载----------------------------------------------------        
        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_GET['page'];
//-------------------------------------------------------------  

        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            $returnData['title'] = $this->getCatNameById($_GET['cat_id']);
            for ($i = 0; $i < count($selectArr); $i++) {
                $sellerInfo = $this->getSellerInfoById($selectArr[$i]['seller_id']);
                $selectArr[$i]['name'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $sellerInfo['name']);
                $selectArr[$i]['title'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['title']);
                $selectArr[$i]['content'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['content']);
                $selectArr[$i]['logo_icon'] = $sellerInfo['logo_icon'];
                $selectArr[$i]['add_time'] = tranTime($selectArr[$i]['add_time']);
                $selectArr[$i]['ad_time'] = '（' . substr($selectArr[$i]['start_time'], 0, 10) . '&nbsp;至&nbsp;' . substr($selectArr[$i]['end_time'], 0, 10) . '）';
                $selectArr[$i]['sum_num'] = $this->getSellerSumSoldNum($selectArr[$i]['seller_id']);
            }
            $returnData['data'] = $selectArr;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取商家分类列表
     */
    public function getSellerCat() {
        $selectArr = M('SellerCat')->where('is_enable=1')->Field('id,sys_name,cat_name')->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            $returnData['data'] = $selectArr;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取商家分类名称
     * @param type $cat_id
     * @return int
     */
    public function getCatNameById($cat_id) {
        $catArr = M('SellerCat')->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr['cat_name'];
        }
    }

    /**
     * 获取商品分类名称
     * @param type $cat_id
     * @return int
     */
    public function getItemCatNameById($cat_id) {
        $catArr = M('SellerItemsCat')->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr['cat_name'];
        }
    }

    /**
     * 通过分类下商家id字串
     * @param type $cat_id
     * @return string
     */
    public function getSellerByCatId($cat_id) {
        $selectArr = M('SellerInfo')->where('cat_id=' . $cat_id . ' and is_checked=1')->select();
        if (empty($selectArr)) {
            return '0,0';
        } else {
            foreach ($selectArr as $value) {
                $str .= ',' . $value['id'];
            }
            return ltrim($str, ',');
        }
    }

    /**
     * 判断营业歇业状态
     * @param type $isRest
     * @param type $workStart
     * @param type $workEnd
     * @return string
     */
    public function getWorkState($isRest, $workStart, $workEnd) {

        if ($isRest == 1) {
            if ($workStart != '' && $workStart != null && $workEnd != '' && $workEnd != null) {
                $workStart = date('H:i', strtotime($workStart));
                $workEnd = date('H:i', strtotime($workEnd));
                return "歇业中（" . $workStart . "--" . $workEnd . "）";
            } else {
                return "歇业中（未设置营业时间）";
            }
        } else {
            if ($workStart != '' && $workStart != null && $workEnd != '' && $workEnd != null) {
                $workStart = date('H:i', strtotime($workStart));
                $workEnd = date('H:i', strtotime($workEnd));
                if ($workStart < $workEnd) {
                    if ($workStart <= date('H:i:s', time()) && date('H:i:s', time()) <= $workEnd) {
                        return '<font color="red">营业中</font>（' . $workStart . '--' . $workEnd . '）';
                    } else {
                        return "歇业中（" . $workStart . "--" . $workEnd . "）";
                    }
                } else {
                    if ($workStart <= date('H:i:s', time()) || date('H:i:s', time()) <= $workEnd) {
                        return '<font color="red">营业中</font>（' . $workStart . '--' . $workEnd . '）';
                    } else {
                        return "歇业中（" . $workStart . "--" . $workEnd . "）";
                    }
                }
            } else {
                return '<font color="red">营业中</font>（未设置营业时间）';
            }
        }
    }

    /**
     * 获取商家详情页
     */
    public function getSellerDetail() {
        $findArr = M('SellerInfo')->where('id=' . $_GET['id'])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '操作失败,请重新操作';
        } else {
            $returnData['flag'] = 1;
            $returnData['is_rest'] = $this->getWorkState($findArr['is_rest'], $findArr['work_start'], $findArr['work_end']);
            $returnData['name'] = $findArr['name'];
            $returnData['address'] = $findArr['address'];
            $returnData['introduction'] = $findArr['introduction'];
            $returnData['tel'] = $findArr['tel'];
            $returnData['logo_icon'] = $findArr['logo_icon'];
            $returnData['item'] = $this->getItemList($_GET['id']);
//            $returnData['buyer'] = $this->getBuyerAddr();
            if ($returnData['buyer']['realname'] == null) {
                $returnData['buyer']['realname'] = "未填写";
            }
            if ($returnData['buyer']['tel'] == null) {
                $returnData['buyer']['tel'] = "未填写";
            }
            if ($returnData['buyer']['address'] == null) {
                $returnData['buyer']['address'] = "未填写";
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取促销详情页
     */
    public function getPromDetail() {
        $findArr = M('SellerPromInfo')->where('id=' . $_GET['id'])->find();
//        dump($findArr);exit;
        if (empty($findArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '操作失败,请重新操作';
        } else {
            $returnData['flag'] = 1;
            $returnData['title'] = $findArr['title'];
            $sellerInfo = $this->getSellerInfoById($findArr['seller_id']);
            $returnData['name'] = $sellerInfo['name'];
            $returnData['ftitle'] = '（<b class="fontorder">' . substr($findArr['start_time'], 0, 10) . '</b>&nbsp;至&nbsp;<b class="fontorder">' . substr($findArr['end_time'], 0, 10) . '</b>）';
            $returnData['content'] = $findArr['content'];
            $returnData['read_num'] = $findArr['read_num'];
            M('SellerPromInfo')->where('id=' . $_GET['id'])->setInc('read_num');
            $returnData['item'] = $this->getItemListByIds($findArr['item_ids']);
//            $returnData['buyer'] = $this->getBuyerAddr();
            if ($returnData['buyer']['realname'] == null) {
                $returnData['buyer']['realname'] = "未填写";
            }
            if ($returnData['buyer']['tel'] == null) {
                $returnData['buyer']['tel'] = "未填写";
            }
            if ($returnData['buyer']['address'] == null) {
                $returnData['buyer']['address'] = "未填写";
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取一个商家的所有商品列表
     * @param type $seller_id
     * @return type
     */
    public function getItemList($seller_id) {
        $selectArr = M('SellerItemsInfo')->where('seller_id=' . $seller_id . ' and is_checked=1')->order('id desc')->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            for ($i = 0; $i < count($selectArr); $i++) {
                $selectArr[$i]['cat_name'] = $this->getItemCatNameById($selectArr[$i]['cat_id']);
            }
            $returnData['data'] = $selectArr;
        }
        return $returnData;
    }

    /**
     * 获取首页轮播图
     * @return type
     */
    public function getSlider() {
        $selectArr = M('SellerPromInfo')->where('status=1')->select();
        if (empty($selectArr)) {
            $returnData = 0;
        } else {
            foreach ($selectArr as $value) {
                $str .= ',' . $value['id'];
            }
            $str = ltrim($str, ',');
            $model = M(C('DB_ALL_ATTACH'));
            $attachArr = $model->where('module_name="sellerProm" and module_info_id in (' . $str . ')')->order('RAND()')->limit(5)->select();
            if (empty($attachArr)) {
                $returnData = 0;
            } else {
                for ($i = 0; $i < count($attachArr); $i++) {
                    $data[$i]['url'] = $attachArr[$i]['file_path'];
                    $data[$i]['sql'] = $model->getLastSql();
                }
                $returnData = $data;
            }
        }
        return $returnData;
//        $this->ajaxReturn($returnData, 'JSON');
    }

}
