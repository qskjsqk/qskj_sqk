package com.zhcd.lysqk.module.record;

import android.content.Context;

import com.zhcd.lysqk.module.record.entity.TradingRecordListEntity;
import com.zjinv.uilibrary.recyclerview.adapter.RVMultiTypeBaseAdapter;


public class TransactionRecordsAdapter extends RVMultiTypeBaseAdapter<TradingRecordListEntity> {
    public TransactionRecordsAdapter(Context context) {
        super(context);
        addItemViewDelegate(new TransactionRecordsDelegate());
    }
}
