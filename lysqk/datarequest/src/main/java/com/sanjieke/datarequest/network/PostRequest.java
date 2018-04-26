package com.sanjieke.datarequest.network;


import com.alibaba.fastjson.JSON;
import com.android.volley.AuthFailureError;
import com.android.volley.Response;
import com.sanjieke.datarequest.tool.Logger;

import java.util.Collections;
import java.util.Map;

/**
 * 简单的post网络请求
 */
public class PostRequest extends SimpleRequest {

    private Map<String, Object> mParams = Collections.EMPTY_MAP;

    public PostRequest(String url, Response.Listener<SimpleResponse> listener, Response.ErrorListener errorListener) {
        super(Method.POST, url, listener, errorListener);
    }

    @Override
    public String getCacheKey() {
        String cacheKey = getUrl();
//        try {
//            cacheKey += new String(getBody());
//        } catch (AuthFailureError e) {
//            e.printStackTrace();
//        }
        return cacheKey;
    }

    @Override
    protected Map<String, String> getParams() throws AuthFailureError {
        return Collections.emptyMap();
    }

    /**
     * 给网络请求配置参数 用于post包体
     *
     * @param params 在post包体中的数据
     */
    public void setParams(Map<String, Object> params) {
        if (params != null && params.size() > 0) {
            mParams = params;
        }
    }

    @Override
    public byte[] getBody() throws AuthFailureError {
        String jsonStr = "";
        if(mParams!=null && mParams.size()>0) {
            jsonStr = JSON.toJSONString(mParams);
        }
        Logger.d("network_tag", jsonStr.toString());
        return jsonStr.getBytes();
    }

    @Override
    public String getBodyContentType() {
        return "application/json";
    }
}
