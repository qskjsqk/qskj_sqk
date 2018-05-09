package com.zhcd.lysqk.module.action;

import android.content.Context;
import android.view.View;
import android.widget.TextView;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.module.sign.SignInfoActivity;
import com.zhcd.lysqk.module.sign.entity.ActionSignInfoEntity;
import com.zhcd.utils.T;
import com.zhcd.utils.TimeUtils;
import com.zjinv.uilibrary.recyclerview.zhy.base.ItemViewDelegate;
import com.zjinv.uilibrary.recyclerview.zhy.base.ViewHolder;

public class ActionDetailSignDelegate implements ItemViewDelegate<ActionSignInfoEntity> {
    @Override
    public int getItemViewLayoutId() {
        return R.layout.item_action_detail_sign;
    }

    @Override
    public boolean isForViewType(ActionSignInfoEntity item, int position) {
        if (item != null)
            return true;
        return false;
    }

    @Override
    public void convert(ViewHolder holder, final ActionSignInfoEntity item, int position) {
        holder.getConvertView().setTag(item);
        final Context context = holder.getConvertView().getContext();
        ((TextView) holder.getView(R.id.tv_sign_num_dec)).setText("第" + item.getSign_num() + "次签到");
        ((TextView) holder.getView(R.id.tv_signed_num_dec)).setText("已签到" + item.getSign_sum() + "人");
        holder.getView(R.id.tv_open_sign).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SignInfoActivity.start(context, item);
            }
        });
    }
}
