package com.zhcd.lysqk.module.login.entity;

public class LoginEntity {
    private String id;
    private String realname;
    private String address_id;
    private String address_name;
    private String com_integral;
    private String qrcode_path;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getRealname() {
        return realname;
    }

    public void setRealname(String realname) {
        this.realname = realname;
    }

    public String getAddress_id() {
        return address_id;
    }

    public void setAddress_id(String address_id) {
        this.address_id = address_id;
    }

    public String getAddress_name() {
        return address_name;
    }

    public void setAddress_name(String address_name) {
        this.address_name = address_name;
    }

    public String getCom_integral() {
        return com_integral;
    }

    public void setCom_integral(String com_integral) {
        this.com_integral = com_integral;
    }

    public String getQrcode_path() {
        return qrcode_path;
    }

    public void setQrcode_path(String qrcode_path) {
        this.qrcode_path = qrcode_path;
    }
}
