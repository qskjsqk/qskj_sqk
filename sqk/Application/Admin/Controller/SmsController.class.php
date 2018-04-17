<?php

/**
 * @name SmsController
 * @info 描述：短信控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:02:04
 */

namespace Admin\Controller;

use Think\Controller;

class SmsController extends BaseDBController {

    protected $appkey;
    protected $sdkappid;
    protected $baseurl;
    protected $random;
    protected $time;
    protected $url;

    public function _initialize() {
        parent::_initialize();

        $this->sdkappid = '1400084969';
        $this->appkey = '30e2429df6664b38403c44018ddeb6b3';
        $this->baseurl = 'https://yun.tim.qq.com/v5/tlssmssvr/sendsms';
        $this->random = $this->time = time();
    }

    public function sendCode() {
        
        $getData['sdkappid'] = $this->sdkappid;
        $getData['random'] = $this->random;

        $sigData['appkey'] = $this->appkey;
        $sigData['random'] = $this->random;
        $sigData['time'] = $this->time;
        $sigData['mobile'] = '13521447599';

//        $data = $this->get_symbol_data();

        $extra->ext = '';
        $extra->extend = '';
        $extra->msg = '你的验证码是909090';
        $extra->sig = $this->createSign($sigData);
        $extra->tel->mobile = '13521447599';
        $extra->tel->nationcode = '86';
        $extra->time = $this->time;
        $extra->type = 0;

        $tPreSign = http_build_query($getData);

        $api_url = $this->baseurl . "?" . $tPreSign;
        dump($extra);
        dump($api_url);
        $tResult = $this->httpRequest($api_url, $extra);
        dump($tResult);
//        echo json_encode($tResult);
//        return $tResult;
    }

    /**
     * 返回加密签名
     * @param type $method
     * @param type $action
     * @param type $data
     * @return type
     */
    public function createSign($data) {
//        ksort($data);
        $msg = http_build_query($data);
//        $sign = hash_hmac('sha256', $msg, SECRET_KEY, true);
        $sign = hash('sha256', $msg, FALSE);
        return $sign;
    }

    /**
     * 发送请求
     *
     * @param string $url      请求地址
     * @param array  $dataObj  请求内容
     * @return string 应答json字符串
     */
    public function httpRequest($url, $dataObj) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataObj));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $ret = curl_exec($curl);
        if (false == $ret) {
            // curl_exec failed
            $result = "{ \"result\":" . -2 . ",\"errmsg\":\"" . curl_error($curl) . "\"}";
        } else {
            $rsp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "{ \"result\":" . -1 . ",\"errmsg\":\"" . $rsp
                        . " " . curl_error($curl) . "\"}";
            } else {
                $result = $ret;
            }
        }

        curl_close($curl);

        return $result;
    }

}
