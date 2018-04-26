package com.sanjieke.datarequest.network;

import android.os.Handler;

import com.android.volley.ExecutorDelivery;
import com.android.volley.Request;
import com.android.volley.Response;

import java.util.concurrent.ExecutorService;


public class Delivery extends ExecutorDelivery {
    public Delivery(Handler handler) {
        super(handler);
    }

    public Delivery(ExecutorService executorService) {
        super(executorService);
    }

    @Override
    public void postResponse(Request<?> request, Response<?> response, Runnable runnable) {
        Object result = response.result;
        if (result instanceof  SimpleResponse){
            ((SimpleResponse) result).intermediate=response.intermediate;
        }
        super.postResponse(request, response, runnable);
    }
}
