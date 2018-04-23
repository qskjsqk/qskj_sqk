<?php

/**
 * @name SellerController
 * @info 描述：商家服务模块
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 16:29:48
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class SellerController extends Controller {

//------------------------------------------------------------------------------
    public function seller_home() {
        $this->assign();
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
    public function getSellerList() {

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
                $str.=',' . $value['id'];
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
     * 获取主营分类字串
     * @param type $seller_id
     * @return string
     */
    public function getItemCatStr($seller_id) {
        $selectArr = M('SellerItemsInfo')->where('seller_id=' . $seller_id . ' and is_checked=1')->select();
        if (empty($selectArr)) {
            return '尚未添加商品';
        } else {
            foreach ($selectArr as $value) {
                $str.=',' . $this->getItemCatNameById($value['cat_id']);
            }
            $str = ltrim($str, ',');
            $newstrArr = explode(',', trim($str, ','));
            $str = implode(',', array_unique($newstrArr));
            return $str;
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
     * 获取商品列表通过item_ids
     * @param type $item_ids
     * @return type
     */
    public function getItemListByIds($item_ids) {
        if ($item_ids == ',' || $item_ids == null) {
            $item_ids = '0,0';
        } else {
            $item_ids = '0' . rtrim($item_ids, ',');
        }
        $selectArr = M('SellerItemsInfo')->where('id in (' . $item_ids . ') and is_checked=1')->order('id desc')->select();
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
     * 生成订单号
     * @param type $order_id
     * @return type
     */
    function createOrderNo($order_id) {
        return 'D' . number_format(microtime(true), 2, '', '') . $order_id;
    }

    /**
     * 生成订单
     */
    public function createOrder() {
        $user_id = cookie('user_id');

        $addArr['buyer_id'] = $user_id;
        $addArr['seller_id'] = $_POST['seller_id'];
        $addArr['pay_type'] = $_POST['sendType'];
        $addArr['send_type'] = $_POST['sendType'];
        $addArr['buyer_note'] = $_POST['buyer_note'];
        $addArr['order_no'] = 0;
        $addFlag = M('SellerOrderInfo')->add($addArr);

        if ($addFlag > 0) {
            $updFlag = M('SellerOrderInfo')->where('id=' . $addFlag)->setField('order_no', $this->createOrderNo($addFlag));
            if ($updFlag === FALSE) {
                $returnData['flag'] = 0;
                $returnData['msg'] = "生成订单号失败！";
            } else {
                $itemArr = explode(',', trim($_POST['itemStr'], ','));
                for ($i = 0; $i < count($itemArr); $i++) {
                    $infoArr = explode('-', $itemArr[$i]);
                    $addrelArr['order_id'] = $addFlag;
                    $addrelArr['item_id'] = $infoArr[0];
                    $addrelArr['item_num'] = $infoArr[1];
//                    M('SellerItemsInfo')->where('id=' . $infoArr[0])->setInc('sold_num', intval($infoArr[1]));
                    $addrelArr['item_price'] = $infoArr[2];
                    $relFlag = M('SellerOrderItemRel')->add($addrelArr);
                }
                $returnData['flag'] = 1;
            }
        } else {
            $returnData['flag'] = 0;
            $returnData['msg'] = "生成订单失败！";
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取购买者地址信息
     */
    public function getBuyerAddr() {
        $user_id = cookie('user_id');
//        $findArr=
        $userModel = M(C('DB_USER_INFO'));
        $findArr = $userModel->where('id=' . $user_id)->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            $findArr['realname'] = $this->getRealnameById($findArr['id']);
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
     * 获取订单信息
     */
    public function getOrderList() {
        $user_id = cookie('user_id');
        $num = C('PAGE_NUM')['order'] * $_GET['page'];
        $keyword = $_GET['keyword'];
        $selectArr = M('SellerOrderInfo')->where('buyer_id=' . $user_id . ' and (order_no like "%' . $keyword . '%" or buyer_note like "%' . $keyword . '%")')->order('id desc')->limit($num)->select();
        $count = M('SellerOrderInfo')->where('buyer_id=' . $user_id . ' and (order_no like "%' . $keyword . '%" or buyer_note like "%' . $keyword . '%")')->count();

        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_GET['page'];

        if (empty($selectArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '暂无订单！';
        } else {
            $returnData['flag'] = 1;
            for ($i = 0; $i < count($selectArr); $i++) {
                $relInfo = $this->getItemListAndCountSum($selectArr[$i]['id']);
                $selectArr[$i]['item_count'] = $relInfo['item_count'];
                $selectArr[$i]['price_sum'] = $relInfo['price_sum'];
                $selectArr[$i]['data'] = $relInfo['data'];
                $selectArr[$i]['add_time'] = tranTime($selectArr[$i]['add_time']);
                $selectArr[$i]['send_type'] = $selectArr[$i]['send_type'] == 0 ? '（自提）' : '（送货上门）';
                $selectArr[$i]['deal_type1'] = $selectArr[$i]['deal_type'];
                $selectArr[$i]['deal_type'] = $this->getOrderDealType($selectArr[$i]['deal_type']);
                $sellerInfo = $this->getSellerInfoById($selectArr[$i]['seller_id']);
                $selectArr[$i]['name'] = $sellerInfo['name'];

                $selectArr[$i]['order_no'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['order_no']);
                $selectArr[$i]['buyer_note'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['buyer_note']);
            }
            $returnData['data'] = $selectArr;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取商品表及商品总数及总价
     * @param type $order_id
     * @return type
     */
    public function getItemListAndCountSum($order_id) {
        $selectArr = M('SellerOrderItemRel')->where('order_id=' . $order_id)->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $itemCount = 0;
            $priceSum = 0;
            for ($i = 0; $i < count($selectArr); $i++) {
                $itemCount = (int) $itemCount + (int) $selectArr[$i]['item_num'];
                $priceSum = (float) $priceSum + (float) $selectArr[$i]['item_price'] * (int) $selectArr[$i]['item_num'];
                $itemInfo = $this->getItemInfoById($selectArr[$i]['item_id']);
                $selectArr[$i]['name'] = $itemInfo['name'];
                $selectArr[$i]['logo_img'] = $itemInfo['logo_img'];
            }

            $returnData['flag'] = 1;
            $returnData['item_count'] = $itemCount;
            $returnData['price_sum'] = $priceSum;
            $returnData['data'] = $selectArr;
        }
        return $returnData;
    }

    /**
     * 获取订单处理状态
     * @param type $deal_type
     * @return string
     */
    public function getOrderDealType($deal_type) {
        switch ($deal_type) {
            case 0:
                return '已取消';
                break;
            case 1:
                return '已提交';
                break;
            case 2:
                return '处理中';
                break;
            case 3:
                return '交易完成';
                break;
            default:
                break;
        }
    }

    /**
     * 通过seller_id 获取商家信息
     * @param type $seller_id
     * @return int
     */
    public function getSellerInfoById($seller_id) {
        $findArr = M('SellerInfo')->where('id=' . $seller_id)->field('id,name,logo_icon')->find();
        if (empty($findArr)) {
            return 0;
        } else {
            return $findArr;
        }
    }

    /**
     * 通过item_id 获取商品信息
     * @param type $seller_id
     * @return int
     */
    public function getItemInfoById($item_id) {
        $findArr = M('SellerItemsInfo')->where('id=' . $item_id)->find();
        if (empty($findArr)) {
            return 0;
        } else {
            return $findArr;
        }
    }

    /**
     * 获取一个商家的总销量
     * @param type $seller_id
     * @return int
     */
    public function getSellerSumSoldNum($seller_id) {
        $selectItemArr = M('SellerItemsInfo')->where('seller_id=' . $seller_id . ' and is_checked')->select();
        if (empty($selectItemArr)) {
            $sqlIn = '0,0';
        } else {
            foreach ($selectItemArr as $value) {
                $sqlIn.= ',' . $value['id'];
            }
            $sqlIn = '0' . $sqlIn;
        }
        $selectRelArr = M('SellerOrderItemRel')
                ->join('r left join qs_gryj_seller_order_info o on r.order_id=o.id')
                ->field('r.*,o.deal_type')
                ->where('r.item_id in (' . $sqlIn . ') and o.deal_type=3')->select();
        if (!empty($selectRelArr)) {
            $SumNUm = 0;
            foreach ($selectRelArr as $value) {
                $SumNUm = $SumNUm + (int) $value['item_num'];
            }
            return $SumNUm;
        } else {
            return 0;
        }
    }

    /**
     * 改变订单状态
     */
    public function changeDealType() {
        $updFlag = M('SellerOrderInfo')->where('id=' . $_GET['id'])->setField('deal_type', $_GET['type']);
        if ($updFlag > 0) {
            $return['flag'] = 1;
            if ($_GET['type'] == 0) {
                $return['msg'] = "取消订单成功！";
            } elseif ($_GET['type'] == 1) {
                $return['msg'] = "重新提交订单成功！";
            } else {
                $this->changeSoldNum($_GET['id']);
                $return['msg'] = "订单交易完成！";
            }
        } else {
            $return['flag'] = 0;
            $return['msg'] = "操作失败！";
        }
        $this->ajaxReturn($return);
    }

    /**
     * 改变销量
     * @param type $order_id
     * @return int
     */
    public function changeSoldNum($order_id) {
        $selectArr = M('SellerOrderItemRel')
                ->join('r left join qs_gryj_seller_order_info o on r.order_id=o.id left join qs_gryj_seller_items_info i on r.item_id=i.id')
                ->field('r.item_id,r.order_id,r.item_num,o.deal_type,i.sold_num')
                ->where('r.order_id=' . $order_id)
                ->select();
        if (empty($selectArr)) {
            return 0;
        } else {
            foreach ($selectArr as $value) {
                M('SellerItemsInfo')->where('id=' . $value['item_id'])->setInc('sold_num', intval($value['item_num']));
            }
        }
    }
    
    
    /**
     * 获取首页轮播图
     * @return type
     */
    public function getSlider() {
            $selectArr = M('SellerPromInfo')->where('1=1')->select();
            if (empty($selectArr)) {
                $returnData = 0;
            } else {
                foreach ($selectArr as $value) {
                    $str.=',' . $value['id'];
                }
                $str = ltrim($str,',');
                $model = M(C('DB_ALL_ATTACH'));
                $attachArr = $model->where('module_name="sellerProm" and module_info_id in (' . $str . ')')->order('id desc')->select();
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
