<?php

/**
 * @name IndexController
 * @info 描述：App入口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 13:35:49
 */

namespace App\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class IndexController extends Controller {

//    视图
//------------------------------------------------------------------------------    
    public function index() {
        if ($_COOKIE['user_id'] == null) {
            $this->redirect('Login/index');
        } else {
            $this->redirect('Index/main');
        }
    }

    public function main() {
        $this->assign();
        $this->display();
    }

//------------------------------------------------------------------------------
    /**
     * 系统首页
     */
    public function mainInfo() {
        $returnData['notice'] = $this->getMainNotice();
        $returnData['activity'] = $this->getMainActivity();
        $returnData['slider'] = $this->getSlider();
        $this->ajaxReturn($returnData);
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
                $str.=',' . $value['id'];
            }
            return '0' . $str;
        }
    }

    /**
     * 获取首页通知公告列表
     * @return type
     */
    public function getMainNotice() {
        $noticeArr = M('NoticeInfo')->where('cat_id in ('.$this->getEnableCatIds(M('NoticeCat'), 1).') and is_publish=1')->order('id desc')->limit(3)->select();
        $noticeC = A('Notice');
        for ($i = 0; $i < count($noticeArr); $i++) {
            $returnData[$i]['id'] = $noticeArr[$i]['id'];
            $returnData[$i]['title'] = $noticeArr[$i]['title'];
            $returnData[$i]['cat_name'] = $noticeC->getCatNameById($noticeArr[$i]['cat_id']);
            $returnData[$i]['add_time'] = tranTime($noticeArr[$i]['add_time']);
            $returnData[$i]['content'] = $noticeArr[$i]['content'];
        }
        return $returnData;
    }

    /**
     * 获取首页活动列表
     * @return type
     */
    public function getMainActivity() {
        $activityArr = M('ActivInfo')->where('cat_id in ('.$this->getEnableCatIds(M('ActivCat'), 0).') and is_publish=1')->order('id desc')->limit(3)->select();
        $activityC = A('Activity');
        for ($i = 0; $i < count($activityArr); $i++) {
            $returnData[$i]['id'] = $activityArr[$i]['id'];
            $returnData[$i]['title'] = $activityArr[$i]['title'];
            $returnData[$i]['cat_name'] = $activityC->getCatNameById($activityArr[$i]['cat_id']);
            $returnData[$i]['add_time'] = tranTime($activityArr[$i]['add_time']);
            $returnData[$i]['content'] = $activityArr[$i]['content'];
        }
        return $returnData;
    }

    /**
     * 获取首页轮播图
     * @return type
     */
    public function getSlider() {

        $findArr = M('ActivCat')->where('is_enable=1 and sys_name="slider"')->find();
        if (empty($findArr)) {
            $returnData = 0;
        } else {
            $selectArr = M('ActivInfo')->where('cat_id=' . $findArr['id'])->select();
            if (empty($selectArr)) {
                $returnData = 0;
            } else {
                foreach ($selectArr as $value) {
                    $str.=',' . $value['id'];
                }
                $str = ltrim($str,',');
                $model = M(C('DB_ALL_ATTACH'));
                $attachArr = $model->where('module_name="activity" and module_info_id in (' . $str . ')')->order('id desc')->select();
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
        }
        return $returnData;
    }

    /**
     * 调试代码
     */
    public function zxw() {
        $select = M('DeviceSugar')->select();
        for ($i = 0; $i < 100; $i++) {

            $flag = M('DeviceSugar')->add($select[$i]);
            echo $flag . '-------</br>';
        }
//        for ($i = 0; $i < count($select); $i++) {
//            $select[$i]['time'] = date('Y-m-d H:i:s',strtotime($select[$i]['time'])+3600*24*$i);
//            $flog = M('DeviceBloodpress')->where('id='.$select[$i]['id'])->save($select[$i]);
//            echo $flag . '-------</br>';
//            dump($select[$i]);
//        }
    }


}
