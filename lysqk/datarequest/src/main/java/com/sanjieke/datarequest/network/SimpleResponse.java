package com.sanjieke.datarequest.network;


public class SimpleResponse {
    public String response;
    public boolean intermediate = false;//是否是中间数据

    public SimpleResponse(String data) {
        if (!RequestManager.isDebug() ) {
            response = data.toUpperCase();
        } else {
            response = data;
        }
    }

    @Override
    public String toString() {
        return response;
    }
}
