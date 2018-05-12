<?php
/**
 * Created by PhpStorm.
 * User: zhangzhihui
 * Date: 2018/5/11
 * Time: 下午6:33
 */

/**
 * @name TradingController
 * @info 描述：用户交易记录控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-5-11 18:34:24
 */

namespace Appm\Controller;

use Think\Controller;
use Appm\Controller\BaseController;
use Think\Tool\Request;
use Appm\Model\TradingRecordModel;

class TradingController extends BaseController {

    public function _initialize() {
        parent::_initialize();
    }

    //异步获取用户交易记录列表
    public function getUserTradinglistSync() {
        $request = Request::all();
        $tradingModel = new TradingRecordModel();

        $request['user_id'] = cookie('user_id');
        $tradingList = $tradingModel->getUserTradingList($request);
        $this->ajaxReturn(syncData(0, '获取成功', $tradingList));
    }

    //交易详情
    public function trading_detail() {
        $request = Request::all();
        $tradingModel = new TradingRecordModel();
        $tradingInfo = $tradingModel->getTradingInfo($request['id'], cookie('user_id'));
        $this->assign('data', $tradingInfo);
        $this->display();
    }



}