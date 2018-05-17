package com.zhcd.lysqk.tool;

import com.zhcd.lysqk.net.ServiceProvider;

public class ImagePathUtil {
    public static String imageReallyUrl(String imageUrl) {
        if (imageUrl.toLowerCase().contains("http")) {
            return imageUrl;
        }
        return ServiceProvider.getImageBaseUrl() + imageUrl;
    }
}
