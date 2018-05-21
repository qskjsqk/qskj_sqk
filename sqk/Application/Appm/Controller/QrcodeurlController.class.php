<?php

/**
 * @name QrcodeurlController
 * @info 描述：二维码地址模块
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 12:07:00
 */

namespace Appm\Controller;

use Think\Controller;
use Think\Tool\GenerateUnique;
use Appm\Controller\BaseController;

class QrcodeurlController extends BaseController {

    protected $config;

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 扫描商家二维码
     */
    public function scan_seller() {
//        $wx['headimgurl'] = "http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKpN65upRlsfibjY7Lia7l1v99lf7kOAp6tNe2Oa0X07yR0Pqun2tLcwGXyrrR08tMavSIBVblnOhLA/132";
//        $wx['openid'] = "ozF060wIC0F5P5GLlrfw0OEMpeGM";
//        $wx['nickname'] = "忘忧草";
//        cookie('wxInfo', $wx, 3600 * 24 * 30);
        //判断用户是否存在

        $seller_id = $_GET['id'];

        $this->redirect('seller_detail?id=' . $seller_id);
    }

    /**
     * 商品详情页
     */
    public function goods_detail() {
        $id = $_GET['id'];
        $where['id'] = ['EQ', $id];
        $goodInfo = M('seller_integral_goods')->where($where)->find();
        $sellerInfo = M('seller_info')->where('id=' . $goodInfo['seller_id'])->find();
        $sellerInfo['address_name'] = getConameById($sellerInfo['address_id']);
        $this->assign('goodInfo', $goodInfo);
        $this->assign('sellerInfo', $sellerInfo);
//        dump($sellerInfo);
        $this->display();
    }

    /**
     * 商家详情页
     */
    public function seller_detail() {
        //不管有没有分配上
        $this->assign('user_id', cookie('user_id'));

        $id = $_GET['id'];
        //查询商家信息
        $where['id'] = ['EQ', $id];
        $sellerInfo = M('seller_info')->where($where)->find();
        $sellerInfo['address_name'] = getConameById($sellerInfo['address_id']);
        $this->assign('sellerInfo', $sellerInfo);

        //分配反馈类型信息
        $this->assign('compalintCat', M('seller_complaint_cat')->select());

        //查询产品信息
        $model = D('SellerIntegralGoods');
        $join = [
            ['goods_exchange_record', 'goods_id', 'seller_integral_goods', 'id'],
            ['seller_info', 'id', 'seller_integral_goods', 'seller_id'],
            ['sys_community_info', 'id', 'seller_integral_goods', 'address_id'],
        ];
        $field = ['seller_integral_goods.*', 'seller_info.name as seller_name', 'sys_community_info.com_name'];

        $lists = $where = $data = [];
        //用户只能看到已发布的商品
        $where[$this->dbFix . 'seller_integral_goods.status'] = 1;
        //只查询一个店的商品
        $where[$this->dbFix . 'seller_integral_goods.seller_id'] = $id;

        //设置连表,查询信息
        $lists = $model->joinDB($model, $join)->fieldDB($model, $field);

        $listsObj = $lists->whereDB($lists, $where)->group($this->dbFix . 'seller_integral_goods.id');
        $lists = $listsObj->order($this->dbFix . 'seller_integral_goods.id desc')->select();

        $this->assign('goodsList', $lists);

//        dump($sellerInfo);
        $this->display();
    }

    /**
     * 商家收款交易二维码
     */
    public function transfer_qrcode() {
        //不管有没有分配上
        $this->assign('user_id', cookie('user_id'));

        $id = $_GET['id'];
        //查询商家信息
        $where['id'] = ['EQ', $id];
        $sellerInfo = M('seller_info')->where($where)->find();
        $sellerInfo['address_name'] = getConameById($sellerInfo['address_id']);
        $this->assign('sellerInfo', $sellerInfo);

        //分配反馈类型信息
        $this->assign('compalintCat', M('seller_complaint_cat')->select());

        $this->display();
    }

    /**
     * 社区收款交易二维码
     */
    public function transfer_comm() {
        //不管有没有分配上
        $this->assign('user_id', cookie('user_id'));

        $userInfo = M('sys_userapp_info')->where('id=' . cookie('user_id'))->find();
        $this->assign('userInfo', $userInfo);

        $id = $_GET['id'];
        //查询商家信息
        $where['id'] = ['EQ', $id];
        $commInfo = M('sys_community_info')->where($where)->find();
        $this->assign('commInfo', $commInfo);

        $this->display();
    }

    /**
     * 用户扫描签到二维码
     */
    public function activ_signin() {
        //不管有没有分配上
        $this->assign('user_id', cookie('user_id'));

        $myInfo = M('sys_userapp_info')->where('id=' . cookie('user_id'))->find();
        $myInfo['address_name'] = getConameById($myInfo['address_id']);
        $this->assign('myInfo', $myInfo);

        $id = $_GET['id'];
        //查询签到信息
        $where['id'] = ['EQ', $id];
        $signInfo = M('activ_signin')->where($where)->find();
        $signInfo['signed_num'] = M('activ_signin_info')->where('sign_id=' . $signInfo['id'])->count();

        $activInfo = M('activ_info')->field('id,cat_id,like_num,integral,address_id,title,start_time')->where('id=' . $signInfo['activity_id'])->find();
        $activInfo['cat_name'] = $this->getDataKey(M('activ_cat'), $activInfo['cat_id'], 'cat_name');
        $activInfo['address_name'] = getConameById($activInfo['address_id']);
        $activInfo['start_time'] = tranTimeToCom($activInfo['start_time']);

        $this->assign('signInfo', $signInfo);
        $this->assign('activInfo', $activInfo);


        $this->display();
    }

    /**
     * 用户扫码签到
     */
    public function signIn() {
        $user_id = $_POST['user_id'];
        $sign_id = $_POST['sign_id'];
        $sign_integral = $_POST['sign_integral'];
        $activity_id = $_POST['activity_id'];

        $swhere['sign_id'] = ['EQ', $sign_id];
        $swhere['user_id'] = ['EQ', $user_id];
        $signInfoInfo = M('activ_signin_info')->where($swhere)->find();
        $userInfo = M('sys_userapp_info')->field('realname,id,tx_path,tel')->where('id=' . $user_id)->find();

//        dump($signInfoInfo);exit;

        if (!empty($signInfoInfo)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '您已签到，请勿重复签到！';
        } else {
            $addArr['sign_type'] = 0;
            $addArr['user_id'] = $user_id;
            $addArr['sign_id'] = $sign_id;
            $addArr['realname'] = $userInfo['realname'];
            $addArr['sign_integral'] = $sign_integral;

            $tranModel = M();

            $tranModel->startTrans(); // 开启事务
            //signinfo表入数据
            $addFlag = $tranModel->table($this->dbFix . 'activ_signin_info')->add($addArr);

            //用户增加分数和经验值
            $userIntegralFlag = $tranModel->table($this->dbFix . 'sys_userapp_info')->where('id=' . $user_id)
                    ->setInc('integral_num', $sign_integral);
            $userExpFlag = $tranModel->table($this->dbFix . 'sys_userapp_info')->where('id=' . $user_id)
                    ->setInc('exp_num', $sign_integral);
            //更新activ_info表
            $activInfo = M('activ_info')->field($activInfo)->where('id=' . $activity_id)->find();
            $activJoinNumFlag = $tranModel->table($this->dbFix . 'activ_info')->where('id=' . $activity_id)
                    ->setInc('join_num', 1);
            $activJoinIdsFlag = $tranModel->table($this->dbFix . 'activ_info')->where('id=' . $activity_id)
                    ->save(['join_ids' => $activInfo['join_ids'] . $user_id . ',']);
            $flag = $addFlag && $userIntegralFlag && $userExpFlag && $activJoinNumFlag && $activJoinIdsFlag;
            if ($flag) {
                $tranModel->commit(); // 成功则提交事务 
                $returnData['flag'] = 1;
                $returnData['msg'] = '签到成功';
                $returnData['data'] = [
                    'realname' => $userInfo['realname'],
                    'wx_num' => $userInfo['wx_num'],
                    'tel' => $userInfo['tel'],
                    'sign_integral' => $sign_integral,
                    'sign_type' => '用户扫码签到',
                    'sign_time' => date('Y.m.d H:i:s', time()),
                    'title' => $activInfo['title'],
                    'address' => $activInfo['address'],
                ];
                $this->sendSignMsg($returnData['data']);
            } else {
                $tranModel->rollback(); // 否则将事务回滚 
                $returnData['flag'] = 0;
                $returnData['msg'] = '签到失败，请重试！';
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 提交入库反馈信息
     */
    public function InsertComplaint() {
        $post = getFormData();
        if ($post['user_id'] != 0) {
            $returnData['flag'] = 1;
            $flag = M('seller_complaint')->add($post);
            if ($flag) {
                $returnData['flag'] = 1;
                $returnData['msg'] = '已经收到您的反馈！';
            } else {
                $returnData['flag'] = 0;
                $returnData['msg'] = '提交失败，请重试！';
            }
        } else {
            $returnData['flag'] = 0;
            $returnData['msg'] = '用户未登录！';
        }
//        dump($);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 进行商品交易
     */
    public function exchangeGoods() {
        //入库商品交易表
        $addArr = $_POST;
        $addArr['user_id'] = cookie('user_id');
        $addArr['exchange_number'] = \Think\Tool\GenerateUnique::generateExchangeNumber();
        $addArr['exchange_method_id'] = 1;
        $addArr['status'] = 1;

        $tranModel = M();

        $tranModel->startTrans(); // 开启事务  
        //入库商品交易表
        $relation_id = $tranModel->table($this->dbFix . 'goods_exchange_record')->add($addArr);
        //入库交易总表
        $tradingData = [
            'income_id' => $_POST['seller_id'],
            'payment_id' => cookie('user_id'),
            'income_type' => 2,
            'payment_type' => 3,
            'trading_number' => $addArr['exchange_number'],
            'trading_integral' => $_POST['exchange_integral'],
            'exchange_method_id' => 1,
            'relation_id' => $relation_id,
            'status' => 1,
        ];
        $tradingFlag = $tranModel->table($this->dbFix . 'integral_trading_record')->add($tradingData);
        //商家积分增值
        $sellerIntegralFlag = $tranModel->table($this->dbFix . 'seller_info')->where('id=' . $_POST['seller_id'])
                ->setInc('integral_num', $_POST['exchange_integral']);
        $sellerExpFlag = $tranModel->table($this->dbFix . 'seller_info')->where('id=' . $_POST['seller_id'])
                ->setInc('exp_num', $_POST['exchange_integral']);
        //用户积分减值
        $userFlag = $tranModel->table($this->dbFix . 'sys_userapp_info')->where('id=' . cookie('user_id'))
                ->setDec('integral_num', $_POST['exchange_integral']);

        $flag = $relation_id && $tradingFlag && $sellerIntegralFlag && $sellerExpFlag && $userFlag;

        if ($flag) {
            $tranModel->commit(); // 成功则提交事务  
            $returnData['flag'] = 1;
            $returnData['msg'] = '交易成功';
            $returnData['data'] = $addArr;
            $returnData['data']['seller_name'] = $this->getDataKey(M('seller_info'), $returnData['data']['seller_id'], 'name');
            $returnData['data']['user_name'] = $this->getDataKey(M('sys_userapp_info'), $returnData['data']['user_id'], 'realname');
            $returnData['data']['good_name'] = $this->getDataKey(M('seller_integral_goods'), $returnData['data']['goods_id'], 'goods_name');
            $returnData['data']['time'] = date('Y.m.d H:i:s', time());
        } else {
            $tranModel->rollback(); // 否则将事务回滚  
            $returnData['flag'] = 0;
            $returnData['msg'] = '兑换失败，请重试';
        }

        $this->ajaxReturn($returnData, "JSON");
    }

    /**
     * 进行转账交易
     */
    public function transrerIntegral() {
        //入库商品交易表
        $addArr = $_POST;

        $addArr['trading_number'] = \Think\Tool\GenerateUnique::generateExchangeNumber();

        $tranModel = M();
        //开启事务  
        $tranModel->startTrans();

        //入库交易总表
        $tradingData = [
            'income_id' => $_POST['seller_id'],
            'payment_id' => cookie('user_id'),
            'income_type' => 2,
            'payment_type' => 3,
            'trading_integral' => $_POST['exchange_integral'],
            'trading_number' => $addArr['trading_number'],
            'exchange_method_id' => 0,
            'relation_id' => 0,
            'status' => 1,
        ];
        $tradingFlag = $tranModel->table($this->dbFix . 'integral_trading_record')->add($tradingData);
        //商家积分增值
        $sellerIntegralFlag = $tranModel->table($this->dbFix . 'seller_info')->where('id=' . $_POST['seller_id'])
                ->setInc('integral_num', $_POST['exchange_integral']);
        $sellerExpFlag = $tranModel->table($this->dbFix . 'seller_info')->where('id=' . $_POST['seller_id'])
                ->setInc('exp_num', $_POST['exchange_integral']);
        //用户积分减值
        $userFlag = $tranModel->table($this->dbFix . 'sys_userapp_info')->where('id=' . cookie('user_id'))
                ->setDec('integral_num', $_POST['exchange_integral']);

        $flag = $tradingFlag && $sellerIntegralFlag && $sellerExpFlag && $userFlag;

        if ($flag) {
            $tranModel->commit(); // 成功则提交事务  
            $returnData['flag'] = 1;
            $returnData['msg'] = '交易成功';
            $returnData['data'] = $addArr;
            $returnData['data']['seller_name'] = $this->getDataKey(M('seller_info'), $returnData['data']['seller_id'], 'name');
            $returnData['data']['user_name'] = $this->getDataKey(M('sys_userapp_info'), cookie('user_id'), 'realname');
            $returnData['data']['time'] = date('Y.m.d H:i:s', time());

            //提醒消息
            $sellerWx = M('seller_wechat_binding')->where('seller_id=' . $_POST['seller_id'])->find();
            $sellerInfo = M('seller_info')->find($_POST['seller_id']);
            $incomeInfo = [
                'open_id' => $sellerWx['open_id'],
                'name' => $returnData['data']['seller_name'],
                'type' => '用户扫码转账',
                'io' => '收取',
                'exchange_integral' => $_POST['exchange_integral'],
                'integral_num' => $sellerInfo['integral_num']
            ];
            $this->sendTradingMsg($incomeInfo);
            $userWx = M('sys_userapp_info')->find(cookie('user_id'));
            $paymentInfo = [
                'open_id' => $userWx['wx_num'],
                'name' => $userWx['realname'],
                'type' => '用户扫码转账',
                'io' => '消费',
                'exchange_integral' => $_POST['exchange_integral'],
                'integral_num' => $userWx['integral_num']
            ];
            $this->sendTradingMsg($paymentInfo);
        } else {
            $tranModel->rollback(); // 否则将事务回滚  
            $returnData['flag'] = 0;
            $returnData['msg'] = '兑换失败，请重试';
        }

        $this->ajaxReturn($returnData, "JSON");
    }

    /**
     * 用户与社区进行转账交易
     */
    public function transrerIntegralComm() {
        $addArr = $_POST;

        $addArr['trading_number'] = \Think\Tool\GenerateUnique::generateExchangeNumber();

        $tranModel = M();
        //开启事务  
        $tranModel->startTrans();

        //入库交易总表
        $tradingData = [
            'income_id' => $_POST['comm_id'],
            'payment_id' => cookie('user_id'),
            'income_type' => 1,
            'payment_type' => 3,
            'trading_integral' => $_POST['exchange_integral'],
            'trading_number' => $addArr['trading_number'],
            'exchange_method_id' => 5,
            'relation_id' => 0,
            'status' => 1,
        ];
        $tradingFlag = $tranModel->table($this->dbFix . 'integral_trading_record')->add($tradingData);
        //商家积分增值
        $commIntegralFlag = $tranModel->table($this->dbFix . 'sys_community_info')->where('id=' . $_POST['comm_id'])
                ->setInc('com_integral', $_POST['exchange_integral']);
        //用户积分减值
        $userFlag = $tranModel->table($this->dbFix . 'sys_userapp_info')->where('id=' . cookie('user_id'))
                ->setDec('integral_num', $_POST['exchange_integral']);

        $flag = $tradingFlag && $commIntegralFlag && $userFlag;

        if ($flag) {
            $tranModel->commit(); // 成功则提交事务  
            $returnData['flag'] = 1;
            $returnData['msg'] = '交易成功';
            $returnData['data'] = $addArr;
            $returnData['data']['comm_name'] = $this->getDataKey(M('sys_community_info'), $returnData['data']['comm_id'], 'com_name');
            $returnData['data']['user_name'] = $this->getDataKey(M('sys_userapp_info'), cookie('user_id'), 'realname');
            $returnData['data']['time'] = date('Y.m.d H:i:s', time());
        } else {
            $tranModel->rollback(); // 否则将事务回滚  
            $returnData['flag'] = 0;
            $returnData['msg'] = '兑换失败，请重试';
        }

        $this->ajaxReturn($returnData, "JSON");
    }

    /**
     * 发送微信通知（签到）
     * @param type $data
     */
    public function sendSignMsg($data) {
        //设置模板消息
        $str = '{
	"touser": "' . $data['wx_num'] . '",
	"template_id": "l6t0WSabIXd3JHgus-7T6QAUcG5bCLeuSltLetzR-OM",
	"url": "http://weixin.qq.com/download",
	"topcolor": "#FF0000",
	"data": {
		"first": {
			"value": "亲爱的“' . $data['realname'] . '”,通过' . $data['sign_type'] . '签到",
			"color": "#FFA500"
		},
		"keyword1": {
			"value": "' . $data['title'] . '",
			"color": "#173177"
		},
                "keyword2": {
			"value": "' . date('Y年m月d日 H:i:s') . '",
			"color": "#173177"
		},
                "keyword3": {
			"value": "' . $data['address'] . '",
			"color": "#173177"
		},
		"remark": {
			"value": "非常感谢您的到来，您可以获得【' . $data['sign_integral'] . '】积分！",
			"color": "#173177"
		}
	}
}';
        //发送模板消息
        sendWxTemMsg($str);
    }

    /**
     * 发送微信通知（交易）
     * @param type $data
     */
    public function sendTradingMsg($data) {
        //设置模板消息
        $str = '{
	"touser": "'.$data['open_id'].'",
	"template_id": "dnBhToLU9wd1oqirEZu9a-TfqZjwT2kCDvSpgEFqmoM",
	"url": "http://weixin.qq.com/download",
	"topcolor": "#FF0000",
	"data": {
		"first": {
			"value": "【梨园智能商圈】提醒您正在进行积分交易",
			"color": "#FFA500"
		},
		"account": {
			"value": "'.$data['name'].'",
			"color": "#173177"
		},
		"time": {
			"value": "2018年05月21日 12:10:10",
			"color": "#173177"
		},
                "type": {
			"value": "'.$data['type'].'",
			"color": "#173177"
		},
		"creditChange": {
			"value": "'.$data['io'].'",
			"color": "#000"
		},
		"number": {
			"value": "'.$data['exchange_integral'].'分",
			"color": "#173177"
		},
		"amount": {
			"value": "'.$data['integral_num'].'分",
			"color": "#173177"
		},
		"remark": {
			"value": "",
			"color": "#173177"
		}
	}
}';
        //调用公共方法curl_post，发送模板消息
        sendWxTemMsg($str);
    }

}
