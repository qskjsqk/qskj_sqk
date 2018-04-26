package com.sanjieke.datarequest.tool;

import android.content.Context;
import android.provider.Settings;
import android.text.TextUtils;

import java.net.NetworkInterface;
import java.util.Collections;
import java.util.List;

/**
 * Created by zhanggeng on 2017/12/11.
 */

public class PhoneUtils {
    public static String getAndroidId(Context context) {
        try {
            return Settings.Secure.getString(context.getContentResolver(), Settings.Secure.ANDROID_ID);
        } catch (Exception e) {
            return "";
        }
    }

    public static String getAddressMacByInterface() {
        try {
            List<NetworkInterface> all = Collections.list(NetworkInterface.getNetworkInterfaces());
            for (NetworkInterface nif : all) {
                if (nif.getName().equalsIgnoreCase("wlan0")) {
                    byte[] macBytes = nif.getHardwareAddress();
                    if (macBytes == null) {
                        return "";
                    }

                    StringBuilder res1 = new StringBuilder();
                    for (byte b : macBytes) {
                        res1.append(String.format("%02X", b));
                    }

                    if (res1.length() > 0) {
                        res1.deleteCharAt(res1.length() - 1);
                    }
                    return res1.toString();
                }
            }

        } catch (Exception e) {
            return "";
        }
        return "";
    }

    public static String getPhoneUUID(Context context) {
        if (context == null)
            return getPhoneBrand() + "_" + getPhoneModel();
        String androidId = getAndroidId(context);
        String macByInterface = getAddressMacByInterface();
        if (TextUtils.isEmpty(androidId)) {
            return "PhoneUUID";
        } else {
            return androidId;
        }
    }

    /**
     * 获取手机品牌
     */
    public static String getPhoneBrand() {
        return android.os.Build.BRAND;
    }

    /**
     * 获取手机型号
     */
    public static String getPhoneModel() {
        return android.os.Build.MODEL;
    }

    /**
     * 获取手机Android版本
     */
    public static String getPhoneSystemCode() {
        return android.os.Build.VERSION.RELEASE;
    }

}
