package com.zhcd.lysqk.module.action;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
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
import com.zhcd.utils.T;
import com.zhcd.utils.TimeUtils;

import java.util.ArrayList;
import java.util.List;

public class ActionDetailActivity extends BaseActivity {
    private static final String ActionId = "actionId";
    private String actionId;
    private ImageView actionLogo;
    private TextView actionName, actionValue, actionInfo, startTime, actionAddress, signNum;
    private TextView actionSponsor, actionContacts, contactWay, endTime, actionContent;
    private ActionDetailEntity detailEntity;
    private RecyclerView photoAlbum;

    private ActionPhotoAlbumAdapter albumAdapter;

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
        titleBarBuilder.setBackText("返回");
        actionId = getIntent().getStringExtra(ActionId);
        actionLogo = (ImageView) findViewById(R.id.iv_action_logo);
        actionName = (TextView) findViewById(R.id.tv_action_name);
        actionValue = (TextView) findViewById(R.id.tv_action_value);
        actionInfo = (TextView) findViewById(R.id.tv_action_info);
        startTime = (TextView) findViewById(R.id.tv_start_time);
        actionAddress = (TextView) findViewById(R.id.tv_action_address);
        signNum = (TextView) findViewById(R.id.tv_sign_num);
        actionSponsor = (TextView) findViewById(R.id.tv_action_sponsor);
        actionContacts = (TextView) findViewById(R.id.tv_action_contacts);
        contactWay = (TextView) findViewById(R.id.tv_contact_way);
        endTime = (TextView) findViewById(R.id.tv_end_time);
        actionContent = (TextView) findViewById(R.id.tv_action_content);
        photoAlbum = (RecyclerView) findViewById(R.id.rv_photo_album);
        LinearLayoutManager manager = new LinearLayoutManager(this);
        manager.setOrientation(LinearLayoutManager.HORIZONTAL);
        photoAlbum.setLayoutManager(manager);
        albumAdapter = new ActionPhotoAlbumAdapter(this);
        photoAlbum.setAdapter(albumAdapter);
        getData();
    }

    @Override
    protected void onResume() {
        super.onResume();
    }

    private void getData() {
        if (TextUtils.isEmpty(actionId))
            return;
        showProgressDialog();
        ServiceProvider.getActivDetailPos(actionId, new IDataResponse() {
            @Override
            public void onResponse(BaseData obj) {
                hideProgressDialog();
                if (ServiceProvider.errorFilter(obj)) {
                    detailEntity = (ActionDetailEntity) obj.getData();
                    viewSetData();
                    setAdapterData();
                } else {
                    if (obj != null)
                        T.showShort(obj.getMsg());
                }

            }
        }, ActionDetailActivity.class.getSimpleName());
    }

    private void setAdapterData() {
        if (detailEntity != null && albumAdapter != null) {
            List<String> list = new ArrayList<>();
            list.addAll(detailEntity.getPic_list());
            list.addAll(detailEntity.getContent_pics());
            albumAdapter.setData(list);
        }
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
            String content = detailEntity.getLike_num() + "人收藏 / " + detailEntity.getAddress_name() + " / " + TimeUtils.getDateYMD(detailEntity.getStart_time());
            actionInfo.setText(content);
            startTime.setText(TimeUtils.getDateYMDHM(detailEntity.getStart_time()));
            endTime.setText(TimeUtils.getDateYMDHM(detailEntity.getEnd_time()));
            actionAddress.setText(detailEntity.getAddress());
            signNum.setText(detailEntity.getSignin_time() + "次");
            actionSponsor.setText(detailEntity.getInitiator());
            actionContacts.setText(detailEntity.getLink_name());
            contactWay.setText(detailEntity.getLink_tel());
            actionContent.setText(detailEntity.getContent());
        }
    }

    @Override
    protected void onDestroy() {
        RequestManager.cancelAll(ActionDetailActivity.class.getSimpleName());
        super.onDestroy();
    }
}
