package com.zhcd.lysqk.module.sign.entity;

import java.io.Serializable;

public class ActionSignInfoEntity implements Serializable{
    //    "id": "14",（签到编号）
//     "activity_id": "5",（活动编号）
//     "add_time": "2018-04-18 14:08:23",
//      "sign_num": "1",（第几次签到）
//       "sign_integral": "33",（本次签到得到分数）
//       "sign_qrcode_path": "Public/Temfile/qrcode/20180418140823.png",（签到二维码）
//       "sign_sum": "4",（本次签到人次）
//       "sign_status": "2"（本次签到状态 0未开启  1正在  2结束）
    //签到编号
    private String id;
    //活动编号
    private String activity_id;
    private long add_time;
    //第几次签到
    private String sign_num;
    //本次签到得到分数
    private String sign_integral;
    //签到二维码
    private String sign_qrcode_path;
    //本次签到人次
    private String signed_num;
    //本次签到状态 0未开启  1正在  2结束
    private String sign_status;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getActivity_id() {
        return activity_id;
    }

    public void setActivity_id(String activity_id) {
        this.activity_id = activity_id;
    }

    public long getAdd_time() {
        return add_time;
    }

    public void setAdd_time(long add_time) {
        this.add_time = add_time;
    }

    public String getSign_integral() {
        return sign_integral;
    }

    public void setSign_integral(String sign_integral) {
        this.sign_integral = sign_integral;
    }

    public String getSign_qrcode_path() {
        return sign_qrcode_path;
    }

    public void setSign_qrcode_path(String sign_qrcode_path) {
        this.sign_qrcode_path = sign_qrcode_path;
    }

    public String getSign_num() {
        return sign_num;
    }

    public void setSign_num(String sign_num) {
        this.sign_num = sign_num;
    }

    public String getSigned_num() {
        return signed_num;
    }

    public void setSigned_num(String signed_num) {
        this.signed_num = signed_num;
    }

    public String getSign_status() {
        return sign_status;
    }

    public void setSign_status(String sign_status) {
        this.sign_status = sign_status;
    }
}
