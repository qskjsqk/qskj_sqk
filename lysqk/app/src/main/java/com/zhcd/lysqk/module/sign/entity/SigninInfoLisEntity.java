package com.zhcd.lysqk.module.sign.entity;

public class SigninInfoLisEntity {
    private String id;
    //签到时间
    private String sign_id;
    private long add_time;
    //用户id
    private String user_id;
    //获得分数
    private String sign_integral;
    //签到方式 0扫描二维码  1读卡签到
    private String sign_type;
    //姓名
    private String realname;
    //头像
    private String tx_icon;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getSign_id() {
        return sign_id;
    }

    public void setSign_id(String sign_id) {
        this.sign_id = sign_id;
    }

    public long getAdd_time() {
        return add_time;
    }

    public void setAdd_time(long add_time) {
        this.add_time = add_time;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getSign_integral() {
        return sign_integral;
    }

    public void setSign_integral(String sign_integral) {
        this.sign_integral = sign_integral;
    }

    public String getSign_type() {
        return sign_type;
    }

    public void setSign_type(String sign_type) {
        this.sign_type = sign_type;
    }

    public String getRealname() {
        return realname;
    }

    public void setRealname(String realname) {
        this.realname = realname;
    }

    public String getTx_icon() {
        return tx_icon;
    }

    public void setTx_icon(String tx_icon) {
        this.tx_icon = tx_icon;
    }
}
