package com.zjinv.uilibrary.recyclerview.adapter;

import android.content.Context;

import com.zjinv.uilibrary.recyclerview.zhy.base.ViewHolder;

public abstract class RVSingleTypeBaseAdapter<T> extends RVMultiTypeBaseAdapter<T> {



    public RVSingleTypeBaseAdapter(Context context) {
        super(context);
        addItemViewDelegate(new RVSingleTypeDelegate<T>() {

            @Override
            public int getItemViewLayoutId() {
                return 0;
            }

            @Override
            public void convert(ViewHolder holder, T t, int position) {

            }
        });

    }



    protected abstract int getItemLayoutResId();

    protected abstract void convert(ViewHolder holder, T item, int position);
}
