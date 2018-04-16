<?php

/**
 * @name PropinfoController
 * @info 描述：物业服务控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-9 9:41:07
 */

namespace Appm\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class PropinfoController extends Controller {

    public function wuye_list() {
        $this->assign();
        $this->display();
    }

    public function wuye_form() {
        $this->assign();
        $this->display();
    }

    public function wuye_detail() {
        $this->assign();
        $this->display();
    }

    /**
     * 获取列表
     */
    public function getList() {
        $user_id = cookie('user_id');
        $page = $_POST['page'];
        $keyword = $_POST['keyword'];
        if ($_POST['type'] == 1) {
            $returnData = $this->getPropItemList($user_id, $page, $keyword);
        } else {
            $returnData = $this->getPropOpinList($user_id, $page, $keyword);
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取物业报修列表
     * @param type $user_id
     * @param type $page
     * @param type $keyword
     * @return type
     */
    public function getPropItemList($user_id, $page, $keyword) {
        $num = C('PAGE_NUM')['prop'] * $page;
        $selectArr = M('PropProbInfo')->where('user_id=' . $user_id . ' and pro_type=0 and (title like "%' . $keyword . '%" or content like "%' . $keyword . '%")')->order('id desc')->limit($num)->select();
        $count = M('PropProbInfo')->where('user_id=' . $user_id . ' and pro_type=0 and (title like "%' . $keyword . '%" or content like "%' . $keyword . '%")')->count();


        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $page;

        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            for ($i = 0; $i < count($selectArr); $i++) {
                $data[$i]['id'] = $selectArr[$i]['id'];
                $data[$i]['title'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['title']);
                $data[$i]['content'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['content']);
                $data[$i]['tel'] = $selectArr[$i]['tel'];
                $data[$i]['address'] = $selectArr[$i]['address'];
                $data[$i]['item'] = $selectArr[$i]['item'];
                $data[$i]['is_deal'] = $this->getDealState($selectArr[$i]['is_deal']);
                $data[$i]['add_time'] = tranTime($selectArr[$i]['add_time']);
                $data[$i]['reply'] = $selectArr[$i]['reply'];
            }
            $returnData['data'] = $data;
        }
        return $returnData;
    }

    /**
     * 获取物业诉求列表
     * @param type $user_id
     * @param type $page
     * @return type
     */
    public function getPropOpinList($user_id, $page, $keyword) {
        $num = C('PAGE_NUM')['prop'] * $page;
        $selectArr = M('PropProbInfo')->where('user_id=' . $user_id . ' and pro_type=1 and (title like "%' . $keyword . '%" or content like "%' . $keyword . '%")')->order('id desc')->limit($num)->select();
        $count = M('PropProbInfo')->where('user_id=' . $user_id . ' and pro_type=1 and (title like "%' . $keyword . '%" or content like "%' . $keyword . '%")')->count();

        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $page;

        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            for ($i = 0; $i < count($selectArr); $i++) {
                $data[$i]['id'] = $selectArr[$i]['id'];
                $data[$i]['title'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['title']);
                $data[$i]['content'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $selectArr[$i]['content']);
                $data[$i]['tel'] = $selectArr[$i]['tel'];
                $data[$i]['address'] = $selectArr[$i]['address'];
                $data[$i]['item'] = $selectArr[$i]['item'];
                $data[$i]['is_deal'] = $this->getDealState($selectArr[$i]['is_deal']);
                $data[$i]['add_time'] = tranTime($selectArr[$i]['add_time']);
                $data[$i]['reply'] = $selectArr[$i]['reply'];
            }
            $returnData['data'] = $data;
        }
        return $returnData;
    }

    /**
     * 获取物业详情
     */
    public function getPropDetail() {
        $findArr = M('PropProbInfo')->where('id=' . $_GET[id])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            $returnData['type'] = $findArr['pro_type'];
            $returnData['pro_type'] = $findArr['pro_type'] == 0 ? '物业报修' : '意见反馈';
            $returnData['title'] = $findArr['title'];
            $returnData['content'] = $findArr['content'];
            $returnData['address'] = $findArr['address'];
            $returnData['tel'] = $findArr['tel'];
            $returnData['add_time'] = tranTime($findArr['add_time']);
            $returnData['is_deal'] = $this->getDealState($findArr['is_deal']);
            $returnData['reply'] = '<span class="mui-icon mui-icon-contact font20"></span> &nbsp;' . $findArr['reply'];
            $returnData['pic_ids'] = $this->getPicUrlArrByIds($findArr['pic_ids']);
            $returnData['item'] = $this->getItemCat($findArr['item']);
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取报修分类名称
     * @param type $item
     * @return string
     */
    public function getItemCat($item) {
        switch ($item) {
            case 1:
                return '公共部位维修';
                break;
            case 2:
                return '共用设施设备';
                break;
            case 3:
                return '自用部位维修';
                break;
            case 4:
                return '其他';
                break;

            default:
                break;
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
     * 获取处理状态
     * @param type $is_deal
     * @return string
     */
    public function getDealState($is_deal) {
        switch ($is_deal) {
            case 0:
                return '<font class="fontblack">待处理</font>';
                break;
            case 1:
                return '<font class="fontorder">处理中</font>';
                break;
            case 2:
                return '<font class="fontgreen">已处理</font>';
                break;
            case 3:
                return '<font class="font999">延时处理</font>';
                break;
            default:
                break;
        }
    }

    /**
     * 提交反馈
     */
    public function createPropDang() {
        $user_id = cookie('user_id');
        $param_arr = array();
        parse_str($_POST['form_data'], $param_arr); //转换数组
        if ($param_arr['type'] == 0) {
//      险情上报
            $createData['cat_id'] = $param_arr['cat_id'];
            $createData['user_id'] = $user_id;
            $createData['title'] = $param_arr['title'];
            $createData['content'] = $param_arr['content'];
            $createData['danger_level'] = $param_arr['danger_level'];
            $createData['address'] = $param_arr['address'];
            $createData['tel'] = $param_arr['tel'];
            $createData['pic_ids'] = $this->dealFileArr($param_arr['files']);
            $createData['reply'] = '您的上报已提交。';
            $flag = M('PropDangerInfo')->add($createData);
        } elseif ($param_arr['type'] == 1) {
//      物业报修    
            $createData['pro_type'] = 0;
            $createData['item'] = $param_arr['item'];
            $createData['user_id'] = $user_id;
            $createData['title'] = $param_arr['title'];
            $createData['content'] = $param_arr['content'];
            $createData['address'] = $param_arr['address'];
            $createData['tel'] = $param_arr['tel'];
            $createData['pic_ids'] = $this->dealFileArr($param_arr['files']);
            $createData['reply'] = '您的报修已提交。';
            $flag = M('PropProbInfo')->add($createData);
        } else {
//      意见反馈   
            $createData['pro_type'] = 1;
            $createData['user_id'] = $user_id;
            $createData['title'] = $param_arr['title'];
            $createData['content'] = $param_arr['content'];
            $createData['tel'] = $param_arr['tel'];
            $createData['address'] = "无";
            $createData['pic_ids'] = $this->dealFileArr($param_arr['files']);
            $createData['reply'] = '您的问题已提交。';
            $flag = M('PropProbInfo')->add($createData);
        }
        if ($flag > 0) {
            $returnData['flag'] = 1;
            $returnData['type'] = $param_arr['type'];
        } else {
            $returnData['flag'] = 0;
            $returnData['type'] = $param_arr['type'];
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 处理图片id数组
     * @param type $arr
     * @return string
     */
    public function dealFileArr($arr) {
        if (count($arr) == 0) {
            return ',';
        } else {
            foreach ($arr as $value) {
                $str.=',' . $value;
            }
            return $str . ',';
        }
    }

    /**
     * 获取图片路径数组通过ids
     * @param type $pic_ids
     * @return type
     */
    public function getPicUrlArrByIds($pic_ids) {
        if ($pic_ids == ',') {
            $returnData['flag'] = 0;
        } else {
            $pic_ids = trim($pic_ids, ',');
            $model = M(C('DB_ALL_ATTACH'));
            $picArr = $model->where('id in (' . $pic_ids . ')')->select();
            if (empty($picArr)) {
                $returnData['flag'] = 0;
            } else {
                $returnData['flag'] = 1;
                for ($i = 0; $i < count($picArr); $i++) {
                    $data[$i]['url'] = $picArr[$i]['file_path'];
                }
                $returnData['data'] = $data;
            }
        }
        return $returnData;
    }

}
