package com.zhcd.lysqk.module.home;


import com.zhcd.lysqk.R;
import com.zjinv.uilibrary.recyclerview.zhy.base.ItemViewDelegate;
import com.zjinv.uilibrary.recyclerview.zhy.base.ViewHolder;

public class ActionListDelegate implements ItemViewDelegate<Object> {
    @Override
    public int getItemViewLayoutId() {
        return R.layout.home_item_action_list;
    }

    @Override
    public boolean isForViewType(Object item, int position) {
        return false;
    }

    @Override
    public void convert(ViewHolder holder, Object o, int position) {

    }
}
