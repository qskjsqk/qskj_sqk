<?php
/**
 * @name ActionlogController
 * @info 描述：操作日志控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:02:04
 */
namespace Health\Controller;
use Think\Controller;

class ActionlogController extends Controller {

    /**
     * 添加日志
     * @param type $controllerName
     * @param type $actionName
     * @param type $actionInfo
     * @return boolean
     */
     public function addLog($controllerName, $actionName, $actionInfo) {
        $data['c_name'] = $controllerName;
        $data['a_name'] = $actionName;
        $data['action_info'] = $actionInfo;

        if (session('realname') != NULL && session('realname') != NULL) {
            $data['user_name'] = session('realname');
        } else {
            $data['user_name'] = session('usr');
        }
        $data['ip'] = get_client_ip();
        $flag = M(C('DB_ACTION_LOG'))->add($data);
        if ($flag > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 显示日志列表
     */
    public function showLogList() {
        $model = M(C('DB_ACTION_LOG')); //实例化模型
        //生成查询条件
        $condition[] = array($_GET['action_info'], 'action_info', 'LIKE', 'b');
        $condition[] = array($_GET['log_time'], 'log_time', 'LIKE', 'b');
        $condition[] = array($_GET['user_name'], 'user_name', 'EQ');
        $where = creatWhere($condition);
        //分页
        $page = getPage($model, $where['where'], $pageCondition, C('PAGE_SIZE'));
        $logList = $model->where($where['where'])->order("id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
        $page = $page->show();
        //分配数据
        $this->assign('page', $page);
        $this->assign('logList',$logList);
        $this->assign('assignWhere',$where['assignWhere']);
        //显示
        $this->display();
    }

}
