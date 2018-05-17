package com.zhcd.lysqk.module.record;


import android.widget.TextView;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.module.record.entity.TradingRecordListEntity;
import com.zjinv.uilibrary.recyclerview.zhy.base.ItemViewDelegate;
import com.zjinv.uilibrary.recyclerview.zhy.base.ViewHolder;

public class TransactionRecordsDelegate implements ItemViewDelegate<TradingRecordListEntity> {
    @Override
    public int getItemViewLayoutId() {
        return R.layout.record_item_transaction_records;
    }

    @Override
    public boolean isForViewType(TradingRecordListEntity item, int position) {
        if (item != null)
            return true;
        return false;
    }

    @Override
    public void convert(ViewHolder holder, TradingRecordListEntity item, int position) {
        holder.getConvertView().setTag(item);
        ((TextView) holder.getView(R.id.tv_trading_desc)).setText(item.getTradingType());
        ((TextView) holder.getView(R.id.tv_trading_time)).setText(item.getTrading_time());
        ((TextView) holder.getView(R.id.tv_trading_user)).setText(item.getUser());
        ((TextView) holder.getView(R.id.tv_trading_integral)).setText(item.getTrading_integral());
    }
}
