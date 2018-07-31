package com.zhcd.lysqk.tool;

import android.text.TextUtils;

import com.zhcd.lysqk.net.ServiceProvider;

public class ImagePathUtil {
    public static String imageReallyUrl(String imageUrl) {
        if (!TextUtils.isEmpty(imageUrl) && imageUrl.toLowerCase().contains("http")) {
            return imageUrl;
        }
        return ServiceProvider.getImageBaseUrl() + imageUrl;
    }
}
