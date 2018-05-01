package com.zhcd.lysqk.net;


import java.util.HashMap;
import java.util.List;

public class ApiPostParams extends HashMap<String, Object> {
    private static final long serialVersionUID = 8112047472727256876L;


    public ApiPostParams with(String key, String value) {
        put(key, value);
        return this;
    }
}
