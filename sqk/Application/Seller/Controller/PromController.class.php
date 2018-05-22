<?php

/**
 * @name PromController
 * @info 描述：广告管理控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-5-4 10:15:40
 */

namespace Seller\Controller;

use Think\Controller;
use Seller\Controller\BaseController;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class PromController extends BaseController {
    //put your code here

    /**
     * 初始化函数
     */
    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 获取我的广告列表
     */
    public function getMyPromList() {
        $sellerInfo = A('Seller')->getSellerInfo();
        $seller_id = cookie('seller_id');
        if ($_POST['type'] != 0) {
            $where['status'] = ['EQ', $_POST['type']];
        }
        $where['seller_id'] = ['EQ', $seller_id];
        $promArr = M('SellerPromInfo')->where($where)->order('id desc')->select();
        //调试sql
        $returnData['sql'] = M('SellerPromInfo')->getLastSql();

        $count = M('SellerPromInfo')->where($where)->count();
        $returnData['count'] = $count;

        $promStat['status1'] = M('SellerPromInfo')->where('seller_id=' . $seller_id . ' and status=1')->count();
        $promStat['status3'] = M('SellerPromInfo')->where('seller_id=' . $seller_id . ' and status=3')->count();
        $promStat['status02'] = M('SellerPromInfo')->where('seller_id=' . $seller_id . ' and (status=0 or status=2)')->count();

        $allReadNum = 0;
        if (empty($promArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($promArr); $i++) {
                $data[$i]['id'] = $promArr[$i]['id'];
                $data[$i]['title'] = $promArr[$i]['title'];
                $data[$i]['status'] = $promArr[$i]['status'];

                $data[$i]['content'] = strip_tags($promArr[$i]['content']);

                $data[$i]['read_num'] = $promArr[$i]['read_num'];
                $allReadNum += (int) $promArr[$i]['read_num'];

                $picsInfo = parent::getAttachArr('sellerProm', $promArr[$i]['id']);
                if ($picsInfo['flag'] == 1) {
                    $data[$i]['pics'] = $picsInfo['data'];
                } else {
                    $data[$i]['pics'] = 0;
                }
            }
            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        $returnData['promStat'] = $promStat;
        $returnData['allReadNum'] = $allReadNum;
        $returnData['sellerInfo'] = $sellerInfo;
        $this->ajaxReturn($returnData);
    }

    /**
     * 广告详情
     */
    public function prom_detail() {
        $id = $_GET['id'];
        $where['id'] = ['EQ', $id];
        $promInfo = M('seller_prom_info')->where($where)->find();
        $promInfo['pics'] = $this->getAttachArr('sellerProm', $id);
        $this->assign('promInfo', $promInfo);

        $this->display();
    }

    /**
     * 广告添加视图
     */
    public function prom_add() {
        $this->display();
    }

    /**
     * 广告修改视图
     */
    public function prom_edit() {
        $id = $_GET['id'];

        $where['id'] = ['EQ', $id];
        $promInfo = M('SellerPromInfo')->where($where)->find();
        $attachList = $this->getAttachArr('sellerProm', $id);
        if ($attachList['flag'] == 1) {
            $attachList = $attachList['data'];
            $this->assign('attachList', json_encode($attachList));
        }

        $this->assign('promInfo', $promInfo);
        $this->display('prom_add');
    }

    /**
     * 保存广告信息
     */
    public function savePromInfo() {
        $post = getFormData();

        $post['seller_id'] = cookie('seller_id');
        $post['status'] = 0;

        $returnData = parent::saveData(M('SellerPromInfo'), $post);
        if ($returnData['code'] == '500') {
            foreach ($post['files'] as $value) {
                $condition['id'] = array('EQ', $value);
                if ($returnData['flag'] == 'add') {
                    $data = array('module_info_id' => $returnData['dataID']);
                } else {
                    $data = array('module_info_id' => $post['id']);
                }
                M('SysAllAttach')->where($condition)->setField($data);
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 消耗积分兑换广告
     */
    public function exchangeAdInte() {
        $sellerInfo = M('seller_info')->find(cookie('seller_id'));
//        $number = \Think\Tool\GenerateUnique::generateExchangeNumber();
        //商家积分扣除
        $sellerIntegralFlag = M()->table($this->dbFix . 'seller_info')->where('id=' . cookie('seller_id'))
                ->setDec('integral_num', 2000);
        if ($sellerIntegralFlag) {
            $return['flag'] = 1;
            $return['msg'] = '扣除积分成功！';

            $sellerWx = M('seller_wechat_binding')->where('seller_id=' . cookie('seller_id'))->find();
            $incomeInfo = [
                'open_id' => $sellerWx['open_id'],
                'name' => $sellerInfo['name'],
                'type' => '商家兑换广告发布权限',
                'io' => '消费',
                'exchange_integral' => 2000,
                'integral_num' => $sellerInfo['integral_num']
            ];
            $flag = $this->sendTradingMsg($incomeInfo);
            $return['data'] = $flag;
        } else {
            $return['flag'] = 0;
            $return['msg'] = '扣除积分失败！';
        }
        $this->ajaxReturn($return, 'JSON');
    }

    /**
     * 发送微信通知（交易）
     * @param type $data
     */
    public function sendTradingMsg($data) {
        //设置模板消息
        $str = '{
	"touser": "' . $data['open_id'] . '",
	"template_id": "dnBhToLU9wd1oqirEZu9a-TfqZjwT2kCDvSpgEFqmoM",
	"url": "http://weixin.qq.com/download",
	"topcolor": "#FF0000",
	"data": {
		"first": {
			"value": "【梨园智能商圈】提醒您正在进行积分交易",
			"color": "#FFA500"
		},
		"account": {
			"value": "' . $data['name'] . '",
			"color": "#173177"
		},
		"time": {
			"value": "2018年05月21日 12:10:10",
			"color": "#173177"
		},
                "type": {
			"value": "' . $data['type'] . '",
			"color": "#173177"
		},
		"creditChange": {
			"value": "' . $data['io'] . '",
			"color": "#000"
		},
		"number": {
			"value": "' . $data['exchange_integral'] . '分",
			"color": "#173177"
		},
		"amount": {
			"value": "' . $data['integral_num'] . '分",
			"color": "#173177"
		},
		"remark": {
			"value": "",
			"color": "#173177"
		}
	}
}';
        //发送模板消息
        sendWxTemMsg($str);
    }

}
