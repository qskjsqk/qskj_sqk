package com.zhcd.lysqk.net;


import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.DataRequestWrapper;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;

import java.lang.reflect.Type;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

/**
 * 构造url的工具
 */
public class DataRequestTool {

    public final static int REQUEST_SUCC = 10000;

    public final static int REQUEST_NO_DATA = 50000;

    public final static String TOKEN_KEY = "auth_token=";
    public final static String COOKIE_KEY = "cookie";

    //{client_id}＋ ':' + md5( {client_id} + {client_secret} + {X-APP-NONCE})
    public static String buildStringFromBundle(final Map<String, String> data) {
        StringBuffer sb = new StringBuffer();
        Iterator<String> keys = data.keySet().iterator();
        while (keys.hasNext()) {
            final String key = keys.next();
            String val = data.get(key);
            sb.append(key).append("=").append(val);
            sb.append("&");
        }
        int length = sb.length();
        if (length > 0) {
            sb.deleteCharAt(length - 1);
        }
        return sb.toString();
    }


    public static DataRequestWrapper get(String url, String method, final Map<String, String> bundle,
                                         final IDataResponse iHttpResponse, Type type, String flag) {
        return get(url, method, bundle, true, iHttpResponse, type, flag);
    }

    public static DataRequestWrapper get(String url, String method, final Map<String, String> bundle,
                                         boolean cookie, final IDataResponse iHttpResponse, Type type, String flag) {
        DataRequestWrapper.Builder builder = new DataRequestWrapper.Builder(DataRequestWrapper.DataRequestMethod.GET, url, iHttpResponse)
                .urlMethod(method)
                .header(bundle)
                .type(type)
                .tag(flag)
                .cache(false);
        Map<String, String> header = new HashMap<>();

        builder.httpHeader(header);
        return builder.build();
    }

    public static DataRequestWrapper post(String url, String method, final Map<String, Object> bundle, final IDataResponse iHttpResponse,
                                          Type type, String flag) {

        DataRequestWrapper.Builder builder = new DataRequestWrapper.Builder(DataRequestWrapper.DataRequestMethod.POST, url, iHttpResponse)
                .urlMethod(method)
                .param(bundle)
                .type(type)
                .tag(flag)
                .cache(false);
        Map<String, String> header = new HashMap<>();

        return builder.build();
    }

    public static DataRequestWrapper post(String url, String method, final Map<String, Object> bundle, final Map<String, String> httpHeader,
                                          final IDataResponse iHttpResponse, Type type, String flag) {

        DataRequestWrapper wrapper = new DataRequestWrapper.Builder(DataRequestWrapper.DataRequestMethod.POST, url, iHttpResponse)
                .urlMethod(method)
                .param(bundle)
                .httpHeader(httpHeader)
                .type(type)
                .tag(flag)
                .cache(false)
                .build();
        return wrapper;
    }

    public static DataRequestWrapper gzip(String url, String method, byte[] data, final IDataResponse iHttpResponse,
                                          Type type, String flag) {

        DataRequestWrapper wrapper = new DataRequestWrapper.Builder(DataRequestWrapper.DataRequestMethod.Gzip, url, iHttpResponse)
                .urlMethod(method)
                .gzipData(data)
                .type(type)
                .tag(flag)
                .build();
        return wrapper;
    }

    /**
     * 对于基本错误的统一处理
     *
     * @param res
     * @return
     */
    public static boolean noError(BaseData res) {
        boolean correct = false;
        if (res != null) {
            if ((res.getStatus() >= 0 && res.getStatus() <= REQUEST_SUCC) || res.getStatus() == REQUEST_NO_DATA) {
                correct = true;
            }
        }

        if (!correct) {
        }

        return correct;
    }
}
