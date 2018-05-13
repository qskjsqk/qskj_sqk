package com.zhcd.lysqk.module.record.entity;

import java.io.Serializable;

public class ReceivePointsEntity implements Serializable {
    //    "id": "13456753456",
//            "user": "13456753456",     （用户名）
//            "trading_integral": "200",          （交易积分）
//            " trading_time": "2018-05-09 13:00:00",    （交易时间）
    private String id;
    private String user;
    private String trading_integral;
    private String trading_time;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getUser() {
        return user;
    }

    public void setUser(String user) {
        this.user = user;
    }

    public String getTrading_integral() {
        return trading_integral;
    }

    public void setTrading_integral(String trading_integral) {
        this.trading_integral = trading_integral;
    }

    public String getTrading_time() {
        return trading_time;
    }

    public void setTrading_time(String trading_time) {
        this.trading_time = trading_time;
    }
}
