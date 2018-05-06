package com.zhcd.lysqk.net;


import com.sanjieke.datarequest.network.RequestManager;
import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.module.action.entity.ActionDetailEntity;
import com.zhcd.lysqk.module.home.entity.ActionListEntity;
import com.zhcd.lysqk.module.login.entity.LoginEntity;
import com.zhcd.lysqk.module.sign.entity.ActionSignInfoEntity;
import com.zhcd.lysqk.module.sign.entity.NewestSignUserInfoEntity;
import com.zhcd.lysqk.module.sign.entity.SigninInfoLisEntity;
import com.zhcd.lysqk.module.sign.entity.UserSignEntity;


/**
 * 网络请求
 */
public class ServiceProvider {
    public static final int DEVELOP = 0;
    public static final int ONLINE = 2;

    private static final String REQUEST_URL_ONLINE = "http://111.204.78.45:9100/index.php/admin/api";
    private static final String REQUEST_URL_DEVELOP = "http://111.204.78.45:9100/index.php/admin/api";
    private static final String IMAGE_URL_ONLINE = "http://111.204.78.45:9100/";
    private static final String IMAGE_URL_DEVELOP = "http://111.204.78.45:9100/";
    //    public static final String REQUEST_URL_DEVELOP = "http://api_m.pre.sanjieke.cn/app";
    private static int mIsDevelopEnv = 0;
    private static int mIsOnlineEnv = 1;
    private static String REQUEST_URL = "";
    private static String IMAGE_BASE_URL = "";


    public static void setDevEnv() {
        if (DEVELOP == mIsDevelopEnv) {
            RequestManager.setDebug(true);
            REQUEST_URL = REQUEST_URL_DEVELOP;
            IMAGE_BASE_URL = IMAGE_URL_DEVELOP;
        } else {
            RequestManager.setDebug(false);
            REQUEST_URL = REQUEST_URL_ONLINE;
            IMAGE_BASE_URL = IMAGE_URL_ONLINE;
        }
    }

    public static String getImageBaseUrl() {
        return IMAGE_BASE_URL;
    }

    public static void setIsDevelopEnv(int mIsDevelopEnv) {
        ServiceProvider.mIsDevelopEnv = mIsDevelopEnv;
    }

    /**
     * 签到程序检测登录
     */
    public static void checkLoginPos(String token_num, IDataResponse iHttpResponse, String flag) {
        ApiPostParams apiParams = new ApiPostParams();
        apiParams.with(Constants.token_num, token_num);
        DataRequestTool.post(REQUEST_URL, Namespace.checkLoginPos, apiParams, iHttpResponse, LoginEntity.class, flag);
    }

    /**
     * 获取本社区活动列表
     */
    public static void getActivListPos(String address_id, int page, IDataResponse iHttpResponse, String flag) {
        ApiPostParams apiParams = new ApiPostParams();
        apiParams.with(Constants.address_id, address_id);
        apiParams.with(Constants.page, String.valueOf(page));
        DataRequestTool.post(REQUEST_URL, Namespace.getActivListPos, apiParams, iHttpResponse, ActionListEntity.class, flag);
    }

    /**
     * 查看活动详情
     */
    public static void getActivDetailPos(String id, IDataResponse iHttpResponse, String flag) {
        ApiParams apiParams = new ApiParams();
        apiParams.with(Constants.id, id);
        DataRequestTool.get(REQUEST_URL, Namespace.getActivDetailPos, apiParams, iHttpResponse, ActionDetailEntity.class, flag);
    }

    /**
     * 获取活动签到信息
     */
    public static void getActivSigninPos(String id, IDataResponse iHttpResponse, String flag) {
        ApiParams apiParams = new ApiParams();
        apiParams.with(Constants.id, id);
        DataRequestTool.get(REQUEST_URL, Namespace.getActivSigninPos, apiParams, iHttpResponse, ActionSignInfoEntity.class, flag);
    }

    /**
     * 获取某一次签到的签到记录
     */
    public static void getSigninInfoListPos(String sign_id, IDataResponse iHttpResponse, String flag) {
        ApiPostParams apiParams = new ApiPostParams();
        apiParams.with(Constants.sign_id, sign_id);
        DataRequestTool.post(REQUEST_URL, Namespace.getSigninInfoListPos, apiParams, iHttpResponse, SigninInfoLisEntity.class, flag);
    }

    /**
     * 用户签到
     */
    public static void setUserSigninPos(String activity_id, String sign_id, String iccard_num, IDataResponse iHttpResponse, String flag) {
        ApiPostParams apiParams = new ApiPostParams();
        apiParams.with(Constants.activity_id, activity_id);
        apiParams.with(Constants.sign_id, sign_id);
        apiParams.with(Constants.iccard_num, iccard_num);
        DataRequestTool.post(REQUEST_URL, Namespace.setUserSigninPos, apiParams, iHttpResponse, UserSignEntity.class, flag);
    }

    /**
     * 获取最新用户签到信息
     */
    public static void getNewUserSigninPos(String activity_id, IDataResponse iHttpResponse, String flag) {
        ApiPostParams apiParams = new ApiPostParams();
        apiParams.with(Constants.activity_id, activity_id);
        DataRequestTool.post(REQUEST_URL, Namespace.getNewUserSigninPos, apiParams, iHttpResponse, NewestSignUserInfoEntity.class, flag);
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
