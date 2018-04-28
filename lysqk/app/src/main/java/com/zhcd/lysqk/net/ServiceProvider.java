package com.zhcd.lysqk.net;


import com.sanjieke.datarequest.network.RequestManager;
import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;


/**
 * 网络请求
 */
public class ServiceProvider {
    public static final int DEVELOP = 0;
    public static final int ONLINE = 2;

    public static final String REQUEST_URL_ONLINE = "";
    public static final String REQUEST_URL_DEVELOP = "http://111.204.78.45:9100/index.php/admin/api";
    //    public static final String REQUEST_URL_DEVELOP = "http://api_m.pre.sanjieke.cn/app";
    private static int mIsDevelopEnv = 0;
    private static int mIsOnlineEnv = 1;
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

    /**
     * 签到程序检测登录
     */
    public static void checkLoginPos(String token_num, IDataResponse iHttpResponse, String flag) {
        ApiPostParams apiParams = new ApiPostParams();
        apiParams.with(Constants.token_num, token_num);
        DataRequestTool.post(REQUEST_URL, Namespace.checkLoginPos, apiParams, iHttpResponse, String.class, flag);
    }

    public static boolean errorFilter(BaseData res) {
        boolean correct = false;
        if (res != null) {
            if (res.getStatus() == ServiceCode.SUCCESS) {
                correct = true;
            }
        }

        return correct;
    }
}
