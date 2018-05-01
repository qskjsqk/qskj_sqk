package com.zhcd.lysqk.manager;

import com.zhcd.lysqk.module.login.entity.LoginEntity;

public class LoginInfoManager {
    private static LoginInfoManager instance;
    private LoginEntity loginEntity;

    public static LoginInfoManager getInstance() {
        if (instance == null)
            instance = new LoginInfoManager();
        return instance;
    }

    public LoginEntity getLoginEntity() {
        return loginEntity;
    }

    public boolean isLogin() {
        return loginEntity != null;
    }

    public void loginSuccess(LoginEntity loginEntity) {
        this.loginEntity = loginEntity;
    }
}
