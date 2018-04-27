package com.zhcd.lysqk.module.record;

import android.content.Context;

import com.zjinv.uilibrary.recyclerview.adapter.RVMultiTypeBaseAdapter;


public class TransactionRecordsAdapter extends RVMultiTypeBaseAdapter<Object> {
    public TransactionRecordsAdapter(Context context) {
        super(context);
        addItemViewDelegate(new TransactionRecordsDelegate());
    }
}
