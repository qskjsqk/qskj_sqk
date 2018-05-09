package com.zhcd.lysqk.module.sign;

import android.content.Context;

import com.zhcd.lysqk.module.sign.entity.SignInfoLisEntity;
import com.zjinv.uilibrary.recyclerview.adapter.RVMultiTypeBaseAdapter;

public class SignRecordAdapter extends RVMultiTypeBaseAdapter<SignInfoLisEntity> {
    public SignRecordAdapter(Context context) {
        super(context);
        addItemViewDelegate(new SignRecordDelegate());
    }
}
