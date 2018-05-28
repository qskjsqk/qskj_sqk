package com.zhcd.lysqk.module.action;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.action.view.ActionDetailSignBottomView;
import com.zhcd.lysqk.module.home.entity.ActionListEntity;
import com.zhcd.lysqk.module.sign.entity.ActionSignInfoEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.lysqk.tool.ImagePathUtil;
import com.zhcd.lysqk.view.CustomRecyclerView;
import com.zhcd.lysqk.view.GlidePieceRoundTransform;
import com.zhcd.utils.T;
import com.zhcd.utils.TimeUtils;
import com.zjinv.uilibrary.recyclerview.wrapper.LoadMoreWrapper;
import com.zjinv.uilibrary.recyclerview.zhy.wrapper.HeaderAndFooterWrapper;

import java.util.List;

public class ActionDetailSignActivity extends BaseActivity {
    private static final String ActionEntity = "listEntity";

    private ImageView actionLogo;
    private TextView actionName, actionValue, actionInfo;
    private ActionListEntity listEntity;
    private CustomRecyclerView recyclerView;
    private ActionDetailSignAdapter adapter;
    private HeaderAndFooterWrapper mHeaderAndFooterWrapper;
    private LoadMoreWrapper mLoadMoreWrapper;

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_action_detail_sign;
    }

    public static void start(Context context, ActionListEntity listEntity) {
        if (context != null) {
            Intent intent = new Intent(context, ActionDetailSignActivity.class);
            intent.putExtra(ActionEntity, listEntity);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("活动详情");
        titleBarBuilder.setBackText("活动列表");
        listEntity = (ActionListEntity) getIntent().getSerializableExtra(ActionEntity);
        actionLogo = (ImageView) findViewById(R.id.iv_action_logo);
        actionName = (TextView) findViewById(R.id.tv_action_name);
        actionValue = (TextView) findViewById(R.id.tv_action_value);
        actionInfo = (TextView) findViewById(R.id.tv_action_info);
        recyclerView = (CustomRecyclerView) findViewById(R.id.recyclerView);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        recyclerView.setNestedScrollingEnabled(false);
        adapter = new ActionDetailSignAdapter(this);

        initHeaderAndFooter();
        mLoadMoreWrapper = new LoadMoreWrapper(mHeaderAndFooterWrapper, recyclerView);
        recyclerView.setAdapter(mLoadMoreWrapper);
        setViewData();
    }

    @Override
    protected void onResume() {
        super.onResume();
        getData();
    }

    private void setViewData() {
        if (listEntity != null) {
            String imgUrl = ImagePathUtil.imageReallyUrl(listEntity.getPic_path());
            GlidePieceRoundTransform transformation = new GlidePieceRoundTransform(ActionDetailSignActivity.this, 8, GlidePieceRoundTransform.CornerType.TOP);
            Glide.with(ActionDetailSignActivity.this).load(imgUrl).bitmapTransform(transformation).into(actionLogo);
            actionName.setText("【" + listEntity.getCat_name() + "】" + listEntity.getTitle());
            actionValue.setText(listEntity.getIntegral() + "分");
            String content = listEntity.getLike_num() + "人收藏 / " + listEntity.getAddress_name() + " / " + TimeUtils.getDateYMD(listEntity.getStart_time());
            actionInfo.setText(content);
        }
    }

    private void initHeaderAndFooter() {
        mHeaderAndFooterWrapper = new HeaderAndFooterWrapper(adapter);
        ActionDetailSignBottomView bottomView = new ActionDetailSignBottomView(this);
        if (listEntity != null)
            bottomView.setActionId(listEntity.getId());
        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT);
        bottomView.setLayoutParams(params);
        mHeaderAndFooterWrapper.addFootView(bottomView);
    }

    private void getData() {
        if (listEntity != null && TextUtils.isEmpty(listEntity.getId()))
            return;
        showProgressDialog();
        ServiceProvider.getActivSigninPos(listEntity.getId(), new IDataResponse() {
            @Override
            public void onResponse(BaseData obj) {
                hideProgressDialog();
                if (ServiceProvider.errorFilter(obj)) {
                    List<ActionSignInfoEntity> infoList = (List<ActionSignInfoEntity>) obj.getData();
                    if (infoList != null && infoList.size() > 0) {
                        adapter.setData(infoList);
                        mLoadMoreWrapper.notifyDataSetChanged();
                        mLoadMoreWrapper.setmFinish(true);
                        mLoadMoreWrapper.setLoadingState(true, true);
                    } else {
                        mLoadMoreWrapper.setmFinish(true);
                        mLoadMoreWrapper.setLoadingState(true, true);
                    }
                } else {
                    if (obj != null)
                        T.showShort(obj.getMsg());
                    mLoadMoreWrapper.setmFinish(true);
                    mLoadMoreWrapper.setLoadingState(true, true);
                }

            }
        }, ActionDetailActivity.class.getSimpleName());
    }
}
