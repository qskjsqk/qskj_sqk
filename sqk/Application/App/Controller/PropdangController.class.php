<?php

/**
 * @name PropdangController
 * @info 描述：物业服务 险情相关数据库
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-9 9:33:29
 */

namespace App\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class PropdangController extends Controller {

    /**
     * 获取险情上报列表
     * @param type $user_id
     * @return type
     */
    public function getPropDangList() {
        $user_id = cookie('user_id');
        $num = C('PAGE_NUM')['prop'] * $_POST['page'];
        $keyword = $_POST['keyword'];
        $selectArr = M('PropDangerInfo')->where('user_id=' . $user_id . ' and (title like "%' . $keyword . '%" or content like "%' . $keyword . '%")')->order('id desc')->limit($num)->select();
        $count = M('PropDangerInfo')->where('user_id=' . $user_id . ' and (title like "%' . $keyword . '%" or content like "%' . $keyword . '%")')->count();

        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        $returnData['page'] = $_POST['page'];

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
                $data[$i]['is_deal'] = $this->getDealState($selectArr[$i]['is_deal']);
                $data[$i]['add_time'] = tranTime($selectArr[$i]['add_time']);
                $data[$i]['reply'] = $selectArr[$i]['reply'];
            }
            $returnData['data'] = $data;
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取险情详情
     */
    public function getDangDetail() {
        $findArr = M('PropDangerInfo')->where('id=' . $_GET[id])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            $returnData['pro_type'] = '险情上报';
            $returnData['dang_cat'] = $this->getCatNameById($findArr['cat_id']);
            $returnData['title'] = $findArr['title'];
            $returnData['dang_level'] = $this->getDangerLevel($findArr['danger_level']);
            $returnData['content'] = $findArr['content'];
            $returnData['address'] = $findArr['address'];
            $returnData['tel'] = $findArr['tel'];
            $returnData['add_time'] = tranTime($findArr['add_time']);
            $returnData['is_deal'] = $this->getDealState($findArr['is_deal']);
            $returnData['reply'] = '<span class="mui-icon mui-icon-contact font20"></span> &nbsp;' . $findArr['reply'];
            $returnData['pic_ids'] = $this->getPicUrlArrByIds($findArr['pic_ids']);
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取危险等级
     * @param type $level
     * @return string
     */
    public function getDangerLevel($level) {
        switch ($level) {
            case 1:
                return '一级（特别危险）';
                break;
            case 2:
                return '二级（危险）';
                break;
            case 3:
                return '三级（可能危险）';
                break;
            default:
                return '暂无分级';
                break;
        }
    }

    /**
     * 通过分类id获取分类名称
     * @param type $cat_id
     * @return int
     */
    public function getCatNameById($cat_id) {
        $catArr = M('PropDangerCat')->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr['cat_name'];
        }
    }

    /**
     * 获取险情分类列表
     */
    public function getDangCatList() {
        $selectArr = M('PropDangerCat')->where('is_enable=1')->order('id desc')->select();
        if (empty($selectArr)) {
            $retrunData['flag'] = 0;
        } else {
            $retrunData['flag'] = 1;
            $retrunData['data'] = $selectArr;
        }
        $this->ajaxReturn($retrunData);
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
