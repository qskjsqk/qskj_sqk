package com.zhcd.lysqk.module.record.entity;


public class TradingRecordListEntity {
    //    "id": "12",     （交易id）
//            "trading_integral": "200",          （交易积分）
//            " trading_time": "2018-05-09 12:00:00",    （交易时间）
//            " tradingType: "感应卡扣分",    （交易方式）
//            "user": "13456782345",    （用户名）
    private String id;
    private String trading_integral;
    private String trading_time;
    private String tradingType;
    private String user;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
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

    public String getTradingType() {
        return tradingType;
    }

    public void setTradingType(String tradingType) {
        this.tradingType = tradingType;
    }

    public String getUser() {
        return user;
    }

    public void setUser(String user) {
        this.user = user;
    }
}
