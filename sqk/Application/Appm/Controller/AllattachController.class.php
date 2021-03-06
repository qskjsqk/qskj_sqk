<?php

/**
 * @name AllattachController
 * @info 描述：附件操作控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:29:29
 */

namespace Appm\Controller;

use Think\Controller;
use Think\Upload;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class AllattachController extends Controller {

    public function index() {
        $this->assign();
        $this->display();
    }

    /**
     * 上传文件并入库
     * @return string
     */
    public function uploadFileADb() {
        $model = M(C('DB_ALL_ATTACH'));
        $fileExt = $_POST['file_ext'];
        $moduleName = $_POST['module_name'];
        //以模块名作为附件的子目录
        $filePath = C('UPLOAD_ROOT') . '/' . $moduleName . '/';
        // 检查目录是否存在
        if (is_dir($filePath)) {
            // 检查目录是否可写
            if (!is_writable($filePath)) {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '目录不可写';
                return $returnData;
            }
        } else {
            // 新建目录
            mkdir($filePath, 0777, true);
        }
        $fileInfo = $this->uploadFile($fileExt, $moduleName);
        if ($fileInfo['flag'] == 'error') {
            $returnData['flag'] = 'error';
            $returnData['msg'] = '上传附件失败！';
        } else {
            $subName = ltrim($fileInfo['file']['savepath'], "."); //附件子子目录(日期)
            $path = C('UPLOAD_ROOT') . $subName . $fileInfo['file']['savename']; //该文件全路径
            $addData['module_name'] = $moduleName;
            $addData['file_path'] = $path;
            $addData['file_real_name'] = $fileInfo['file']['name'];
            $addData['file_ext'] = $fileInfo['file']['ext'];
            $addData['file_size'] = $fileInfo['file']['size'];
            $flag = $model->add($addData);
            if ($flag > 0) {
                $returnData['flag'] = 'success';
                $returnData['msg'] = '上传附件入库成功！';
                $returnData['att_id'] = $flag;
            } else {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '上传附件入库失败';
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 上传文件(内部接口)
     * @author:hellbao
     * @param $file_ext 设置附件上传类型
     * @param $save_path 设置附件上传目录
     * @return array 返回的上传文件信息
     */
    public function uploadFile($file_ext, $save_path) {
        $file_size = C('UPLOAD_SIZE');
        $sub_name = array('date', 'Y-m-d');
        $upload = new \Think\Upload(); //实例化上传类
        $ext_arr = C('UPLOAD_EXT');
        $upload->maxSize = $file_size; // 设置附件上传大小
        $upload->exts = $ext_arr[$file_ext]; // 设置附件上传类型
        $upload->rootPath = C('UPLOAD_ROOT'); // 设置附件上传根目录
        $upload->savePath = './' . $save_path . '/'; // 设置附件上传（子）目录
        $upload->autoSub = true;
        $upload->subName = $sub_name;
        $upload->callback = ture;
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $info['flag'] = 'error';
            $info['msg'] = $upload->getError();
            return $info;
        } else {
            $info['flag'] = 'success';
            return $info;
        }
    }

    /**
     * 上传附件
     * @return string
     */
    public function uploadAt() {
        $model = M(C('DB_ALL_ATTACH'));
        $fileExt = 'image';
        $moduleName = "prop";
        //以模块名作为附件的子目录
        $filePath = C('UPLOAD_ROOT') . '/' . $moduleName . '/';
        // 检查目录是否存在
        if (is_dir($filePath)) {
            // 检查目录是否可写
            if (!is_writable($filePath)) {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '目录不可写';
                return $returnData;
            }
        } else {
            // 新建目录
            mkdir($filePath, 0777, true);
        }
        $fileInfo = $this->uploadFile($fileExt, $moduleName);
        if ($fileInfo['flag'] == 'error') {
            $returnData['flag'] = 'error';
            $returnData['msg'] = '上传附件失败！';
        } else {
            $subName = ltrim($fileInfo['file']['savepath'], "."); //附件子子目录(日期)
            $path = C('UPLOAD_ROOT') . $subName . $fileInfo['file']['savename']; //该文件全路径
            $addData['module_name'] = $moduleName;
            $addData['file_path'] = $path;
            $addData['file_real_name'] = $fileInfo['file']['name'];
            $addData['file_ext'] = $fileInfo['file']['ext'];
            $addData['file_size'] = $fileInfo['file']['size'];
            $flag = $model->add($addData);
            if ($flag > 0) {
                $returnData['flag'] = 'success';
                $returnData['msg'] = '上传附件入库成功！';
                $returnData['att_id'] = $flag;
                $returnData['url'] = $path;
            } else {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '上传附件入库失败';
            }
        }
        $this->ajaxReturn($returnData);
    }

}
