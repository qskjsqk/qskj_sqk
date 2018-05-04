<?php

/**
 * @name SellerIntegralGoodsController
 * @info 描述：用户端积分商品模块
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 12:07:00
 */

namespace Appm\Controller;

use Think\Controller;
use Appm\Controller\BaseController;
use Think\Tool\Request;

class SellerIntegralGoodsController extends BaseController {

    protected $config;

    public function _initialize() {
        parent::_initialize();
    }

    public function item_list() {
        $this->assign('address_id', cookie('address_id'));
        $this->display();
    }

    public function activity_detail() {
        $this->display();
    }

    /**
     * 获取列表
     */
    public function getList() {
        $user_id = cookie('user_id');
        $address_id = cookie('address_id');
        $request = Request::all();

        $where = [];

        if(!empty($request['cat_type'])) {
            $where[$this->dbFix . 'seller_integral_goods'] = $request['cat_type'];
        }

        $join = [
            ['goods_exchange_record', 'goods_id', 'seller_integral_goods', 'id'],
            ['seller_info', 'id', 'seller_integral_goods', 'seller_id'],
        ];
        $field = ['seller_integral_goods.*', 'seller_info.name as seller_name'];

        if(!empty($request['orderBy']) && !empty($request['address'])) {
            //离我最近(默认本社区)和商家地点(本社区)同时选中
            if($request['orderBy'] == 'distance') {
                $where[$this->dbFix . 'seller_integral_goods'] = $address_id;
            } elseif($request['orderBy'] == 'welcome' && $request['address'] == 'current') {
                //当前社区最受欢迎(兑换次数最多的商品)

            }
        }

        $info = M('SellerIntegralGoods')->joinFieldDB($join, $field, $where)->find();

        $this->ajaxReturn(syncData(0, 'success'));
    }

    /**
     * 获取分类名称
     * @param type $cat_id
     * @return int
     */
    public function getCatNameById($cat_id) {
        $catArr = M('ActivCat')->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr['cat_name'];
        }
    }

    /**
     * 置位已读，点收藏，参加
     * @param type $type
     */
    public function setReadLikeJoin($id, $type) {
        $user_id = cookie('user_id');
        $findArr = M('ActivInfo')->where('id=' . $id)->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '操作失败,请重新操作';
        } else {
            $newstr = $findArr[$type . '_ids'] . $user_id;
            $newstrArr = explode(',', trim($newstr, ','));
            $newstr = implode(',', array_unique($newstrArr));
            $newstr = ',' . $newstr . ',';

            $updData[$type . '_ids'] = $newstr;
            $updData[$type . '_num'] = $findArr[$type . '_num'] + 1;
            $updArr = M('ActivInfo')->where('id=' . $id)->save($updData);

            if ($updArr === FALSE) {
                $returnData['flag'] = 0;
                $returnData['msg'] = '操作失败,请重新操作';
            } else {
                $returnData['flag'] = 1;
                $returnData['msg'] = '操作成功';
            }
        }
        return $returnData;
    }

    /**
     * 获取活动详情
     */
    public function getActivDetail() {
        $user_id = cookie('user_id');
        $findArr = M('ActivInfo')->where('id=' . $_GET['id'])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '操作失败,请重新操作';
        } else {
            $newstr = $findArr['read_ids'] . $user_id;
            $newstrArr = explode(',', trim($newstr, ','));
            $newstr = implode(',', array_unique($newstrArr));
            $newstr = ',' . $newstr . ',';
            $updData['read_ids'] = $newstr;
            $updData['read_num'] = $findArr['read_num'] + 1;
            $updArr = M('ActivInfo')->where('id=' . $_GET['id'])->save($updData);
            if ($updArr === FALSE) {
                $returnData['flag'] = 0;
                $returnData['msg'] = '操作失败,请重新操作';
            } else {
                $returnData['flag'] = 1;
                $returnData['msg'] = '操作成功';
//                数据处理
                $findArr['realname'] = $this->getRealnameById($findArr['user_id']);
                $findArr['lookUser'] = $this->getRealnameById($user_id);
                $findArr['comm_num'] = $this->getCommNum($findArr['id']);
                $findArr['like_flag'] = $this->checkReadLikeJoin($findArr['id'], 'like');

                $times = strtotime($findArr['start_time']);
                $findArr['start_date'] = date('Y.m.d', $times);
                $findArr['address_name'] = getConameById($findArr['address_id']);

                $findArr['comm_num'] = $this->getCommNum($findArr['id']);
                $findArr['join_flag'] = $this->checkReadLikeJoin($findArr['id'], 'join');
                $findArr['like_flag'] = $this->checkReadLikeJoin($findArr['id'], 'like');

                $picsInfo = $this->getAttachArr($findArr['id']);
                if ($picsInfo['flag'] == 1) {
                    $findArr['pics'] = $picsInfo['data'];
                } else {
                    $findArr['pics'] = 0;
                }
                $commList = $this->getCommList($findArr['id']);

                if ($commList['flag'] == 1) {
                    $findArr['commFlag'] = 1;
                    $findArr['comm'] = $commList['data'];
                } else {
                    $findArr['commFlag'] = 0;
                    $findArr['comm'] = $commList['msg'];
                }
                $returnData['data'] = $findArr;
            }
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
     * 获取评论条数
     * @param type $id
     * @return type
     */
    public function getCommNum($id) {
        $selectArr = M('ActivComm')->where('activity_id=' . $id)->count();
        return $selectArr;
    }

    /**
     * 获取评论列表
     * @param type $id
     */
    public function getCommList($id) {
        $selectArr = M('ActivComm')->where('activity_id=' . $id)->order('id asc')->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '暂无评论';
        } else {
            for ($i = 0; $i < count($selectArr); $i++) {
                $data[$i]['id'] = $selectArr[$i]['id'];
                $data[$i]['no'] = $i + 1;
                $data[$i]['tx'] = $selectArr[$i]['user_id'] % 13 + 1;
                $data[$i]['add_time'] = tranTime($selectArr[$i]['add_time']);
                $data[$i]['content'] = $selectArr[$i]['content'];
                $data[$i]['realname'] = $this->getRealnameById($selectArr[$i]['user_id']);
            }
            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        return $returnData;
    }

    /**
     * 添加评论
     */
    public function addComm() {
        $user_id = cookie('user_id');
        $data['activity_id'] = $_GET['id'];
        $data['user_id'] = $user_id;
        $data['content'] = $_GET['commContent'];
        $addArr = M('ActivComm')->add($data);
        if ($addArr === FALSE) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '评论失败！';
        } else {
            $returnData['flag'] = 1;
            $returnData['msg'] = '评论成功！';
        }
        $this->ajaxReturn($returnData);
    }

    /*
     * 参加活动
     */

    public function joinActiv() {
        $user_id = cookie('user_id');
        $returnData = $this->setReadLikeJoin($_GET['id'], 'join');
        $this->ajaxReturn($returnData);
    }

    /**
     * 收藏该活动
     */
    public function likeActiv() {
        $user_id = cookie('user_id');
        $returnData = $this->setReadLikeJoin($_GET['id'], 'like');
        $this->ajaxReturn($returnData);
    }

    /**
     * 取消参加活动
     */
    public function concelJoinActiv() {
        $user_id = cookie('user_id');
        $findArr = M('ActivInfo')->where('id=' . $_GET['id'])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
        } else {
            $newStr = str_replace(',' . $user_id . ',', ',', $findArr['join_ids']);
            $updData['join_ids'] = $newStr;
            $updData['join_num'] = (int) $findArr['join_num'] - 1;
            $updFlag = M('ActivInfo')->where('id=' . $_GET['id'])->save($updData);
            if ($updFlag === FALSE) {
                $returnData['flag'] = 0;
            } else {
                $returnData['flag'] = 1;
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 返回已读，已收藏，已参加状态
     * @param type $id
     * @param type $type
     * @return int
     */
    public function checkReadLikeJoin($id, $type) {
        $user_id = cookie('user_id');
        $findArr = M('ActivInfo')->where('id=' . $id)->find();
        if (empty($findArr)) {
            return 0;
        } else {
            $checkFlag = strpos($findArr[$type . '_ids'], ',' . $user_id . ',');
            if ($checkFlag === FALSE) {
                return 0;
            } else {
                return 1;
            }
        }
    }

    /**
     * 获取活动附件
     * @param type $activ_id
     * @return type
     */
    public function getAttachArr($activ_id) {
        $model = M(C('DB_ALL_ATTACH'));
        $selectArr = $model->where('module_name="activity" and module_info_id=' . $activ_id)->select();
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
     * 获取启用分类字串
     * @return string
     */
    public function getEnableCatIds() {
        $selectArr = M('ActivCat')->where('is_enable=1')->select();
        if (empty($selectArr)) {
            return '0,0';
        } else {
            foreach ($selectArr as $value) {
                $str .= ',' . $value['id'];
            }
            return '0' . $str;
        }
    }

}
