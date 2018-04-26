package com.sanjieke.datarequest.tool;

import com.sanjieke.datarequest.BuildConfig;

/**
 * 只在编译环境下使用的Assert
 */
public class AssertDebug {

    public static void Assert(Object obj) {

        if (BuildConfig.DEBUG) {
            assert obj == null;
        }
    }
}
