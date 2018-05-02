package com.zhcd.utils;


import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Locale;

public class TimeUtils {

    /**
     * 将long类型的时间戳转为字符串
     *
     * @param time long
     * @return yyyy.MM.dd
     */
    public static String getDateYMD(long time) {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy.MM.dd", Locale.CHINA);
        if (time > 0) {
            return sdf.format(time * 1000L);
        }
        return "";
    }

    /**
     * 将long类型的时间戳转为字符串
     *
     * @param time long
     * @return yyyy-MM-dd HH:mm
     */
    public static String getDateYMDHM(long time) {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy.MM.dd HH:mm", Locale.CHINA);
        if (time > 0) {
            return sdf.format(time * 1000L);
        }
        return "";
    }

    /**
     * 将long类型的时间戳转为字符串
     *
     * @param time long
     * @return yyyy-MM-dd HH:mm
     */
    public static String getDateYMDHMS(long time) {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy.MM.dd HH:mm:ss", Locale.CHINA);
        if (time > 0) {
            return sdf.format(time * 1000L);
        }
        return "";
    }


}
