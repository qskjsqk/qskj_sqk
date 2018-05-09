package com.zhcd.lysqk.module.sign.entity;

public class UserSignEntity {
    //    "sign_type": 1,  (签到方式 0扫描二维码  1读卡签到)
//    "user_id": "116", (用户id)
//    "sign_id": "15",(签到id)
//     "realname": "张小依", (姓名)
//     "sign_integral": "33"，（获得分数）
//     "new_id ": "15" （签到最新id）
    //签到方式 0扫描二维码  1读卡签到
    private String sign_type;
    //用户id
    private String user_id;
    //签到id
    private String sign_id;
    //姓名
    private String realname;
    //获得分数
    private String sign_integral;
    //签到最新id
    private String new_id;
    //   签到时间
    private long add_time;
    //tx_path  头像
    private String tx_path;
    //本次签到已签到人次
    private String count;

    public String getSign_type() {
        return sign_type;
    }

    public void setSign_type(String sign_type) {
        this.sign_type = sign_type;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getSign_id() {
        return sign_id;
    }

    public void setSign_id(String sign_id) {
        this.sign_id = sign_id;
    }

    public String getRealname() {
        return realname;
    }

    public void setRealname(String realname) {
        this.realname = realname;
    }

    public String getSign_integral() {
        return sign_integral;
    }

    public void setSign_integral(String sign_integral) {
        this.sign_integral = sign_integral;
    }

    public String getNew_id() {
        return new_id;
    }

    public void setNew_id(String new_id) {
        this.new_id = new_id;
    }

    public long getAdd_time() {
        return add_time;
    }

    public void setAdd_time(long add_time) {
        this.add_time = add_time;
    }

    public String getTx_path() {
        return tx_path;
    }

    public void setTx_path(String tx_path) {
        this.tx_path = tx_path;
    }

    public String getCount() {
        return count;
    }

    public void setCount(String count) {
        this.count = count;
    }
}
