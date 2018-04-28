package com.zhcd.lysqk;

import com.sanjieke.datarequest.network.RequestManager;
import com.zhcd.baseall.ZHBaseApplication;
import com.zhcd.lysqk.net.ServiceProvider;

public class LYApplication extends ZHBaseApplication {
    @Override
    protected void onAppExit() {

    }

    @Override
    public void onCreate() {
        super.onCreate();
        RequestManager.init(LYApplication.getAppContext(), false);
        checkEnvironment();
    }

    private void checkEnvironment() {

        if (SConstant.BuildTypeOnline.equals(BuildConfig.FLAVOR)) {
            ServiceProvider.setIsDevelopEnv(1);
        } else {
            ServiceProvider.setIsDevelopEnv(0);
        }

        ServiceProvider.setDevEnv();
    }
}
