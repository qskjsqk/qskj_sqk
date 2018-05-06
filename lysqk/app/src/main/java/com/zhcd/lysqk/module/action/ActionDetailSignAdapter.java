package com.zhcd.lysqk.module.action;

import android.content.Context;

import com.zhcd.lysqk.module.sign.entity.ActionSignInfoEntity;
import com.zjinv.uilibrary.recyclerview.adapter.RVMultiTypeBaseAdapter;

public class ActionDetailSignAdapter extends RVMultiTypeBaseAdapter<ActionSignInfoEntity> {
    public ActionDetailSignAdapter(Context context) {
        super(context);
        addItemViewDelegate(new ActionDetailSignDelegate());
    }
}
