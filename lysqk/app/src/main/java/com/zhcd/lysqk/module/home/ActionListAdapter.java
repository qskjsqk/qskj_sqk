package com.zhcd.lysqk.module.home;

import android.content.Context;

import com.zjinv.uilibrary.recyclerview.adapter.RVMultiTypeBaseAdapter;

public class ActionListAdapter extends RVMultiTypeBaseAdapter<Object> {

    public ActionListAdapter(Context context) {
        super(context);
        addItemViewDelegate(new ActionListDelegate());
    }
}
