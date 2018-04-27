package com.zhcd.lysqk.module.record;


import com.zhcd.lysqk.R;
import com.zjinv.uilibrary.recyclerview.zhy.base.ItemViewDelegate;
import com.zjinv.uilibrary.recyclerview.zhy.base.ViewHolder;

public class TransactionRecordsDelegate implements ItemViewDelegate<Object> {
    @Override
    public int getItemViewLayoutId() {
        return R.layout.record_item_transaction_records;
    }

    @Override
    public boolean isForViewType(Object item, int position) {
        return false;
    }

    @Override
    public void convert(ViewHolder holder, Object o, int position) {

    }
}
