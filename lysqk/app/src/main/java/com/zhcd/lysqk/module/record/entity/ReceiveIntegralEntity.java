package com.zhcd.lysqk.module.record.entity;


public class ReceiveIntegralEntity {
    //    "usr": "13456753456",     （用户名）
//            "integral_num": "200",          （用户剩余积分）
//            " com_name": "翠景北里社区",    （社区名称）
    private String user;
    private String integral_num;
    private String com_name;
    private String tx_path;//用户头像

    public String getUser() {
        return user;
    }

    public void setUser(String user) {
        this.user = user;
    }

    public String getIntegral_num() {
        return integral_num;
    }

    public void setIntegral_num(String integral_num) {
        this.integral_num = integral_num;
    }

    public String getCom_name() {
        return com_name;
    }

    public void setCom_name(String com_name) {
        this.com_name = com_name;
    }

    public String getTx_path() {
        return tx_path;
    }

    public void setTx_path(String tx_path) {
        this.tx_path = tx_path;
    }
}
