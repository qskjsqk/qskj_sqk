package com.zhcd.lysqk.module.sign;

import com.zhcd.lysqk.R;
import com.zjinv.uilibrary.recyclerview.zhy.base.ItemViewDelegate;
import com.zjinv.uilibrary.recyclerview.zhy.base.ViewHolder;

public class SignRecordDelegate implements ItemViewDelegate<Object> {
    @Override
    public int getItemViewLayoutId() {
        return R.layout.sign_item_sign_record;
    }

    @Override
    public boolean isForViewType(Object item, int position) {
        return false;
    }

    @Override
    public void convert(ViewHolder holder, Object o, int position) {

    }
}
