package com.zhcd.lysqk.module.sign;

import android.content.Context;

import com.zjinv.uilibrary.recyclerview.adapter.RVMultiTypeBaseAdapter;

public class SignRecordAdapter extends RVMultiTypeBaseAdapter<Object> {
    public SignRecordAdapter(Context context) {
        super(context);
        addItemViewDelegate(new SignRecordDelegate());
    }
}
