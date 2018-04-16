<?php

/**
 * @name LinkmanController
 * @info 描述：紧急联系人控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-10 15:11:55
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。--

class LinkmanController extends Controller {

//------------------------------------------------------------------------------
    public function linkman_list() {
        $this->assign();
        $this->display();
    }
//------------------------------------------------------------------------------
    /**
     * 获取社区电话
     */
    public function getNeighbLinkList() {
        $selectArr = M('EmerServInfo')->where('cat_id=0')->order('id desc')->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            for($i=0;$i<count($selectArr);$i++){
                if($selectArr[$i]['tel']==''||$selectArr[$i]['tel']==null){
                    $selectArr[$i]['tel']=$selectArr[$i]['phone'];
                }
            }
            $returnData['data'] = $selectArr;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取紧急联系人
     */
    public function getHelpLinkList() {
        $user_id = cookie('user_id');
        $selectArr = M('EmerServInfo')->where('cat_id=1 and user_id=' . $user_id)->order('id desc')->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            for($i=0;$i<count($selectArr);$i++){
                if($selectArr[$i]['tel']==''||$selectArr[$i]['tel']==null){
                    $selectArr[$i]['tel']=$selectArr[$i]['phone'];
                }
            }
            $returnData['data'] = $selectArr;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取联系人详情
     */
    public function getLinkDetail() {
        $findArr = M('EmerServInfo')->where('id=' . $_GET['id'])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            $findArr['type'] = $this->checkNeighbOrHelp($findArr['cat_id']);
            $returnData['data'] = $findArr;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 判断是社区还是紧急：0社区，1紧急联系人
     * @param type $cat_id
     */
    public function checkNeighbOrHelp($cat_id) {
        if ($cat_id == 0) {
            return 1;
        } else {
            return 2;
        }
    }

    /**
     * delete info of linkman from db
     */
    public function delLinkMan() {
        $delFlag = M('EmerServInfo')->where('id=' . $_GET['id'])->delete();
        if ($delFlag === FALSE) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '删除失败，请重试';
        } else {
            $returnData['flag'] = 1;
            $returnData['msg'] = '删除成功';
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * save or create a new data into db
     */
    public function SaveOrCreateLinkMan() {
        $user_id = cookie('user_id');
        $param_arr = array();
        parse_str($_POST['form_data'], $param_arr); //str to arr
        if ($param_arr['id'] != 0) {
//            edit action
            $updData['realname'] = $param_arr['realname'];
            $updData['department'] = $param_arr['department'];
            $updData['tel'] = $param_arr['tel'];
            $updData['phone'] = $param_arr['phone'];
            $updData['comment'] = $param_arr['comment'];
            $updFlag = M('EmerServInfo')->where('id=' . $param_arr['id'])->save($updData);
            if ($updFlag === FALSE) {
                $returnData['flag'] = 0;
                $returnData['msg'] = "修改失败";
            } else {
                $returnData['flag'] = 1;
                $returnData['msg'] = "修改成功";
            }
        } else {
            $addData['cat_id'] = 1;
            $addData['user_id'] = $user_id;
            $addData['realname'] = $param_arr['realname'];
            $addData['department'] = $param_arr['department'];
            $addData['tel'] = $param_arr['tel'];
            $addData['phone'] = $param_arr['phone'];
            $addData['comment'] = $param_arr['comment'];
            $addFlag = M('EmerServInfo')->add($addData);
            if ($addFlag === FALSE) {
                $returnData['flag'] = 0;
                $returnData['msg'] = "添加失败";
            } else {
                $returnData['flag'] = 1;
                $returnData['msg'] = "添加成功";
            }
        }
        $this->ajaxReturn($returnData);
    }

}
