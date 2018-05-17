package com.zhcd.lysqk.module.home;


import android.content.Context;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.module.home.entity.ActionListEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.lysqk.tool.ImagePathUtil;
import com.zhcd.lysqk.view.GlidePieceRoundTransform;
import com.zhcd.utils.TimeUtils;
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
        Context context = holder.getConvertView().getContext();
        ImageView actionLogo = holder.getView(R.id.iv_action_logo);
        String imgUrl = ImagePathUtil.imageReallyUrl(item.getPic_path());

        GlidePieceRoundTransform transformation = new GlidePieceRoundTransform(context, 8, GlidePieceRoundTransform.CornerType.TOP);
        Glide.with(context).load(imgUrl).bitmapTransform(transformation).into(actionLogo);
        ((TextView) holder.getView(R.id.tv_action_name)).setText("【" + item.getCat_name() + "】" + item.getTitle());
        ((TextView) holder.getView(R.id.tv_action_value)).setText(item.getIntegral() + "分");
        String content = item.getLike_num() + "人收藏 / " + item.getAddress_name() + " / " + TimeUtils.getDateYMD(item.getStart_time());
        ((TextView) holder.getView(R.id.tv_action_content)).setText(content);
    }
}
