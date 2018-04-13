<?php

/**
 * @name ApiController
 * @info 描述：健康接口控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-16 16:20:28
 */

namespace Health\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class ApiController extends Controller {

    public function index() {
//        $xuetang = '{"data":{"bloodsugar":"5.1","medicId":"01C89AA2B26A488090CCF5F53B5E83B8","physicalID":"BT170307164138609000000001488880089683","suggestion":null,"time":"2017-03-07 18:07:46","type":0},"did":"JKJ1609193210000882","dtype":"9","idcard":"110223197703010012","phone":"13966668888","type":6}';
//        $tizhong = '{"data":{"height":"0.0","medicId":"01C89AA2B26A488090CCF5F53B5E83B8","physicalID":"BT170307164138609000000001488942884271","suggestion":null,"time":"2017-03-08 11:31:56","weight":"96.9"},"did":"JKJ1609193210000882","dtype":"9","idcard":"110223197703010012","phone":"13966668888","type":9}';
//        $xueyang = '{"data":{"bloodoxygen":99,"medicId":"01C89AA2B26A488090CCF5F53B5E83B8","physicalID":"BT170307164138609000000001488942884271","pulse":84,"suggestion":{"common":"气功养生，学会吐纳法：吐气的时候，不能把嘴张得太大，要无声，长气，吐完为止。来回的吐气锻炼肺活量，气体大量的平缓的与身体废气交换。","doctor":"针对每个穴位按摩，会对气血等进行滋养。","food":"用富含饱和脂肪酸的猪油、牛油、洋油、奶油、黄油，不要吃垃圾食品、或者加工过的食品","item":"SPO2","sport":"登山，是良好的户外运动，取其景致自然，空气新鲜，加大氧气所占气体容量"},"time":"2017-03-08 12:01:19"},"did":"JKJ1609193210000882","dtype":"9","idcard":"110223197703010012","phone":"13966668888","type":5}';
//        $xueya = '{"data":{"systolic": 120,"diastolic": 80,"pulse": 90,"medicId":"01C89AA2B26A488090CCF5F53B5E83B8","physicalID":"BT170307164138609000000001488880089683","suggestion":null,"time":"2017-03-07 18:07:46"},"did":"JKJ1609193210000882","dtype":"9","idcard":"110223197703010012","phone":"13966668888","type":7}';
//        $tiwen = '{"data":{"medicId":"01C89AA2B26A488090CCF5F53B5E83B8","physicalID":"BT170307164138609000000001488942884271","suggestion":{"common":"建议坚持体育锻炼，每天慢跑超过30分钟，可以保持敏捷思维，旺盛精力，良好食欲","doctor":"利用揉捏的动作加上按摩霜对于脂肪的改善：按摩可以提高皮肤的温度，大量消耗能量，促进肠蠕动，减少肠道对营养的吸收，促进血液循环，让多余的水分排出体内。","food":"饮食上，早餐食用红枣薏米山药粥，用红枣、薏米、山药煮成粥，红枣可以补血；山药有健脾的作用；薏米有助于散除湿气。用生姜泡红茶，生姜中的辛辣成分能燃烧体内的","item":"TEMPERATURE","sport":"建议坚持体育锻炼，每天慢跑超过30分钟，可以保持敏捷思维，旺盛精力，良好食欲"},"temperature":"36.6","time":"2017-03-08 13:58:11"},"did":"JKJ1609193210000882","dtype":"9","idcard":"110223197703010012","phone":"13966668888","type":3}';
        
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : "";
        $addFlag = M('DeviceDataInfo')->add(array('data'=>$postStr));
        $recArr = json_decode($postStr, TRUE);
        if (!empty($recArr['type'])) {
            $deviceId = $this->getDeviceIdByDidAndDtype($recArr['did'], $recArr['dtype']);
            $userId = $this->getUserIdByIdcard($recArr['idcard']);

            $data['device_id'] = $deviceId;
            $data['user_id'] = $userId;
            $data['idcard'] = $recArr['idcard'];
            $data['tel'] = $recArr['phone'];
            $data['medicid'] = $recArr['data']['medicId'];
            $data['physicalid'] = $recArr['data']['physicalID'];
            $data['time'] = $recArr['data']['time'];

            if ($deviceId != 0) {
                switch ($recArr['type']) {
                    //血糖
                    case 6:
                        $data['type'] = $recArr['data']['type'];
                        $data['bloodsugar'] = $recArr['data']['bloodsugar'];
                        $addFlag = M('DeviceSugar')->add($data);
                        break;
                    //体重
                    case 9:
                        $data['height'] = $recArr['data']['height'];
                        $data['weight'] = $recArr['data']['weight'];
                        $addFlag = M('DeviceWeight')->add($data);
                        break;
                    //血氧
                    case 5:
                        $data['bloodoxygen'] = $recArr['data']['bloodoxygen'];
                        $data['pulse'] = $recArr['data']['pulse'];
                        if ($recArr['data']['suggestion'] != null) {
                            $data['sugcommon'] = $recArr['data']['suggestion']['common'];
                            $data['sugsport'] = $recArr['data']['suggestion']['sport'];
                            $data['sugfood'] = $recArr['data']['suggestion']['food'];
                            $data['sugdoctor'] = $recArr['data']['suggestion']['doctor'];
                        }
                        $addFlag = M('DeviceBloodsatur')->add($data);
                        break;
                    //血压
                    case 7:
                        $data['systolic'] = $recArr['data']['systolic'];
                        $data['diastolic'] = $recArr['data']['diastolic'];
                        $data['pulse'] = $recArr['data']['pulse'];
                        if ($recArr['data']['suggestion'] != null) {
                            $data['sugcommon'] = $recArr['data']['suggestion']['common'];
                            $data['sugsport'] = $recArr['data']['suggestion']['sport'];
                            $data['sugfood'] = $recArr['data']['suggestion']['food'];
                            $data['sugdoctor'] = $recArr['data']['suggestion']['doctor'];
                        }
                        $addFlag = M('DeviceBloodpress')->add($data);
                        break;
                    //体温
                    case 3:
                        $data['temperature'] = $recArr['data']['temperature'];
                        if ($recArr['data']['suggestion'] != null) {
                            $data['sugcommon'] = $recArr['data']['suggestion']['common'];
                            $data['sugsport'] = $recArr['data']['suggestion']['sport'];
                            $data['sugfood'] = $recArr['data']['suggestion']['food'];
                            $data['sugdoctor'] = $recArr['data']['suggestion']['doctor'];
                        }
                        $addFlag = M('DeviceTemptr')->add($data);
                        break;

                    default:
                        $addFlag = 0;
                        break;
                }
            }
        }
        if ($addFlag > 0) {
            $return['flag'] = 1;
            $return['msg'] = '信息入库成功';
        } else {
            $return['flag'] = 0;
            $return['msg'] = '信息入库失败';
        }
//        dump($data);
//        dump($return);
        echo 'API设备数据接口已接通，接受数据中……';
    }

    /**
     * 通过设备编号和设备类型获取设备id
     * @param type $did
     * @param type $dtype
     * @return int
     */
    public function getDeviceIdByDidAndDtype($did, $dtype) {
        $findArr = M('DeviceInfo')->where('did="' . $did . '" and dtype="' . $dtype . '"')->find();
        if (empty($findArr)) {
            return 0;
        } else {
            return $findArr['id'];
        }
    }

    /**
     * 通过身份证号获取用户id
     * @param type $idcard
     * @return int
     */
    public function getUserIdByIdcard($idcard) {
        $findArr = M('SysUserInfo')->where('idcard_num="' . $idcard . '" and rns_type=1')->find();
        if (empty($findArr)) {
            return 0;
        } else {
            return $findArr['id'];
        }
    }
    
    /**
     * 获取血糖测试状态
     * @param type $type
     * @return string
     */
    public function getSugarCheckType($type) {
        switch ($type) {
            case 0:
                return '未知';
                break;
            case 1:
                return '空腹';
                break;
            case 2:
                return '餐前';
                break;
            case 3:
                return '餐后';
                break;
            default:
                break;
        }
    }

}
