package com.zhcd.lysqk.net;


import com.sanjieke.utils.MD5Util;

public class Constants {

    public final static String phone = "phone";
    public final static String code = "code";
    public final static String password = "password";
    public final static String passwordAgain = "password_again";
    public final static String newPhone = "newPhone";
    public final static String newCode = "newCode";
    public final static String phoneCode = "phoneCode";
    public final static String uid = "uid";
    public final static String class_id = "class_id";
    public final static String classId = "classId";
    public final static String user_token = "user_token";
    public final static String passwordOld = "password_old";
    public final static String passwordNew = "password_new";
    public final static String real_name = "real_name";
    public final static String sex = "sex";
    public final static String birth_year = "birth_year";
    public final static String job = "job";
    public final static String work_year = "work_year";
    public final static String video_id = "video_id";
    public final static String coupon_code = "coupon_code";
    public final static String order_sn = "order_sn";
    public final static String driver = "driver";
    public final static String fq = "fq";
    public final static String wx_public_openid = "wx_public_openid";
    public final static String coupon = "coupon";


    public final static String Accept = "accept";
    public final static String ClientId = "sanjieke";
    public final static String ClientSecret = "B1B1Hu8!";
    public final static String X_APP_ACCESS_TOKEN = "x-app-access-token";
    public final static String X_APP_NONCE = "x-app-nonce";
    public final static String X_APP_USER_TOKEN = "x-app-user-token";

    //md5( {client_id} + {client_secret} + {X-APP-NONCE}
    public static String getAccessToken(String appNonce) {
        return MD5Util.MD5(ClientId + ClientSecret + appNonce);
    }

    public static String getAppNonce() {
        String strRand = "";
        for (int i = 0; i < 8; i++) {
            strRand += String.valueOf((int) (Math.random() * 10));
        }
        return strRand;
    }
}
