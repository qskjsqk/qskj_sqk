package com.zhcd.lysqk.net;



import com.sanjieke.datarequest.network.RequestManager;
import com.sanjieke.datarequest.neworkWrapper.BaseData;


/**
 * 网络请求
 */
public class ServiceProvider {
    public static final int DEVELOP = 0;
    public static final int ONLINE = 2;

    public static final String REQUEST_URL_ONLINE = "";
    public static final String REQUEST_URL_DEVELOP = "http://api.pre.sanjieke.cn/app";
    //    public static final String REQUEST_URL_DEVELOP = "http://api_m.pre.sanjieke.cn/app";
    private static int mIsDevelopEnv = 0;
    private static String REQUEST_URL = "";

    public static void setDevEnv() {
        if (DEVELOP == mIsDevelopEnv) {
            RequestManager.setDebug(true);
            REQUEST_URL = REQUEST_URL_DEVELOP;
        } else {
            RequestManager.setDebug(false);
            REQUEST_URL = REQUEST_URL_ONLINE;
        }
    }

    public static void setIsDevelopEnv(int mIsDevelopEnv) {
        ServiceProvider.mIsDevelopEnv = mIsDevelopEnv;
    }

    public static String getH5Url() {
        return REQUEST_URL;
    }



    public static boolean errorFilter(BaseData res) {
        boolean correct = false;
        if (res != null) {
            if (res.getCode() == ServiceCode.SUCCESS) {
                correct = true;
            }
        }

        return correct;
    }
}
