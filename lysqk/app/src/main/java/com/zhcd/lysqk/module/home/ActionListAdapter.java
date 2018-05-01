package com.zhcd.lysqk.module.home;

import android.content.Context;

import com.zhcd.lysqk.module.home.entity.ActionListEntity;
import com.zjinv.uilibrary.recyclerview.adapter.RVMultiTypeBaseAdapter;

public class ActionListAdapter extends RVMultiTypeBaseAdapter<ActionListEntity> {

    public ActionListAdapter(Context context) {
        super(context);
        addItemViewDelegate(new ActionListDelegate());
    }
}
