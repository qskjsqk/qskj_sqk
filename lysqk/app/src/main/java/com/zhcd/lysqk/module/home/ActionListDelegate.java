package com.zhcd.lysqk.module.home;


import android.widget.ImageView;
import android.widget.TextView;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.module.home.entity.ActionListEntity;
import com.zjinv.uilibrary.recyclerview.zhy.base.ItemViewDelegate;
import com.zjinv.uilibrary.recyclerview.zhy.base.ViewHolder;

public class ActionListDelegate implements ItemViewDelegate<ActionListEntity> {
    @Override
    public int getItemViewLayoutId() {
        return R.layout.home_item_action_list;
    }

    @Override
    public boolean isForViewType(ActionListEntity item, int position) {
        if (item != null)
            return true;
        return false;
    }

    @Override
    public void convert(ViewHolder holder, ActionListEntity item, int position) {
        holder.getConvertView().setTag(item);
        ImageView actionLogo = holder.getView(R.id.iv_action_logo);
        ((TextView) holder.getView(R.id.tv_action_name)).setText(item.getCat_name());
        ((TextView) holder.getView(R.id.tv_action_value)).setText(item.getIntegral());
        String content = item.getLike_num() + "人收藏 / " + item.getAddress_name() + " / " + item.getStart_time();
        ((TextView) holder.getView(R.id.tv_action_content)).setText(content);
    }
}
