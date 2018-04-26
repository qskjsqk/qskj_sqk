package com.sanjieke.datarequest.tool;

import android.util.Log;

import com.sanjieke.datarequest.network.RequestManager;


public class Logger {
    public static int d(String tag, String msg) {
        if(RequestManager.isDebug()) {
            return Log.d(tag, msg);
        }
        return 0;
    }
}
