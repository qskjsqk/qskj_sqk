package com.zhcd.lysqk.module.action;

import android.content.Context;
import android.content.Intent;
import android.text.TextUtils;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.sanjieke.datarequest.network.RequestManager;
import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.action.entity.ActionDetailEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.lysqk.view.GlidePieceRoundTransform;
import com.zhcd.utils.TimeUtils;

public class ActionDetailActivity extends BaseActivity {
    private static final String ActionId = "actionId";
    private String actionId;
    private ImageView actionLogo;
    private TextView actionName, actionValue, actionContent;
    private ActionDetailEntity detailEntity;

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_action_detail;
    }

    public static void start(Context context, String id) {
        if (context != null) {
            Intent intent = new Intent(context, ActionDetailActivity.class);
            intent.putExtra(ActionId, id);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("活动详情");
        titleBarBuilder.setBackText("活动列表");
        actionId = getIntent().getStringExtra(ActionId);
        actionLogo = (ImageView) findViewById(R.id.iv_action_logo);
        actionName = (TextView) findViewById(R.id.tv_action_name);
        actionValue = (TextView) findViewById(R.id.tv_action_value);
        actionContent = (TextView) findViewById(R.id.tv_action_content);
        getData();
    }

    private void getData() {
        if (TextUtils.isEmpty(actionId))
            return;
        ServiceProvider.getActivDetailPos(actionId, new IDataResponse() {
            @Override
            public void onResponse(BaseData obj) {
                if (ServiceProvider.errorFilter(obj)) {
                    detailEntity = (ActionDetailEntity) obj.getData();
                    viewSetData();
                }

            }
        }, ActionDetailActivity.class.getSimpleName());
    }

    private void viewSetData() {
        if (detailEntity != null) {
            if (detailEntity.getPic_list() != null && detailEntity.getPic_list().size() > 0) {
                String imgUrl = ServiceProvider.getImageBaseUrl() + detailEntity.getPic_list().get(0);

                GlidePieceRoundTransform transformation = new GlidePieceRoundTransform(ActionDetailActivity.this, 8, GlidePieceRoundTransform.CornerType.TOP);
                Glide.with(ActionDetailActivity.this).load(imgUrl).bitmapTransform(transformation).into(actionLogo);
            }
            actionName.setText("【" + detailEntity.getCat_id() + "】" + detailEntity.getTitle());
            actionValue.setText(detailEntity.getIntegral() + "分");
            String content = detailEntity.getLike_num() + "人收藏 / " + detailEntity.getAddress() + " / " + TimeUtils.getDateYMD(detailEntity.getStart_time());
            actionContent.setText(content);
        }
    }

    @Override
    protected void onDestroy() {
        RequestManager.cancelAll(ActionDetailActivity.class.getSimpleName());
        super.onDestroy();
    }
}
