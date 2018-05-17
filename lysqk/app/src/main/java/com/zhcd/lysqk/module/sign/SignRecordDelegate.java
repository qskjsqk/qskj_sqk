package com.zhcd.lysqk.module.sign;

import android.content.Context;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.module.sign.entity.SignInfoLisEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.lysqk.tool.ImageLoaderUtils;
import com.zhcd.lysqk.tool.ImagePathUtil;
import com.zhcd.lysqk.view.GlidePieceRoundTransform;
import com.zhcd.utils.TimeUtils;
import com.zjinv.uilibrary.recyclerview.zhy.base.ItemViewDelegate;
import com.zjinv.uilibrary.recyclerview.zhy.base.ViewHolder;

public class SignRecordDelegate implements ItemViewDelegate<SignInfoLisEntity> {
    @Override
    public int getItemViewLayoutId() {
        return R.layout.sign_item_sign_record;
    }

    @Override
    public boolean isForViewType(SignInfoLisEntity item, int position) {
        if (item != null)
            return true;
        return false;
    }

    @Override
    public void convert(ViewHolder holder, SignInfoLisEntity item, int position) {
        holder.getConvertView().setTag(item);
        Context context = holder.getConvertView().getContext();
        ImageView ivUserHeard = holder.getView(R.id.iv_user_heard);
        String url = ImagePathUtil.imageReallyUrl(item.getTx_icon());
        ImageLoaderUtils.displayImage(context, url, ivUserHeard);
        ((TextView) holder.getView(R.id.tv_user_name)).setText(item.getRealname());
        ((TextView) holder.getView(R.id.tv_receive_time)).setText("时间：" + TimeUtils.getDateYMDHM(item.getAdd_time()));
        String content = "使用" + (item.getSign_type().equals("0") ? "二维码" : "社区卡") + "签到成功";
        ((TextView) holder.getView(R.id.tv_description)).setText(content);
    }
}
