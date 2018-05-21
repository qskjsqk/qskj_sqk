package com.zhcd.lysqk.module.sign;

import android.content.Context;
import android.content.Intent;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.view.View;

import com.sanjieke.datarequest.network.RequestManager;
import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.SConstant;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.manager.LoginInfoManager;
import com.zhcd.lysqk.module.action.ActionDetailSignActivity;
import com.zhcd.lysqk.module.home.ActionListAdapter;
import com.zhcd.lysqk.module.home.entity.ActionListEntity;
import com.zhcd.lysqk.module.sign.entity.SignInfoLisEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.utils.T;
import com.zjinv.uilibrary.recyclerview.wrapper.LoadMoreWrapper;
import com.zjinv.uilibrary.recyclerview.zhy.MultiItemTypeAdapter;

import java.util.ArrayList;
import java.util.List;

public class SignRecordActivity extends BaseActivity {
    private static final String SignId = "sign_id";
    private SwipeRefreshLayout swipeRefreshLayout;
    private RecyclerView recyclerView;
    private String signId;
    private SignRecordAdapter recordAdapter;
    private List<SignInfoLisEntity> mList;
    private LoadMoreWrapper mLoadMoreWrapper;


    @Override
    protected int getLayoutResId() {
        return R.layout.activity_sign_recode;
    }

    public static void start(Context context, String signId) {
        if (context != null) {
            Intent intent = new Intent(context, SignRecordActivity.class);
            intent.putExtra(SignId, signId);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("签到记录");
        titleBarBuilder.setBackText("签到页面");
        signId = getIntent().getStringExtra(SignId);
        swipeRefreshLayout = (SwipeRefreshLayout) findViewById(R.id.swipeRefreshLayout);
        recyclerView = (RecyclerView) findViewById(R.id.recyclerView);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        recordAdapter = new SignRecordAdapter(this);
        mList = new ArrayList<>();
        recordAdapter.setData(mList);
        mLoadMoreWrapper = new LoadMoreWrapper(recordAdapter, recyclerView);
        recyclerView.setAdapter(mLoadMoreWrapper);
        setListener();
        getData();
    }

    private void setListener() {
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                swipeRefreshLayout.setRefreshing(false);
                getData();
            }
        });

    }

    private void getData() {
        if (TextUtils.isEmpty(signId))
            return;
        showProgressDialog();
        ServiceProvider.getSigninInfoListPos(signId, new IDataResponse() {
            @Override
            public void onResponse(BaseData obj) {
                hideProgressDialog();
                if (ServiceProvider.errorFilter(obj)) {
                    List<SignInfoLisEntity> list = (List<SignInfoLisEntity>) obj.getData();
                    if (list != null && list.size() > 0) {
                        mList.clear();
                        mList.addAll(list);
                        recordAdapter.setData(mList);
                        mLoadMoreWrapper.notifyDataSetChanged();
                    }
                    mLoadMoreWrapper.setLoadingState(true);
                    mLoadMoreWrapper.setmFinish(true);
                } else {
                    if (obj != null)
                        T.showShort(obj.getMsg());
                    mLoadMoreWrapper.setLoadingState(true);
                    mLoadMoreWrapper.setmFinish(true);
                }
            }
        }, SignRecordActivity.class.getSimpleName());
    }

    @Override
    protected void onDestroy() {
        RequestManager.cancelAll(SignRecordActivity.class.getSimpleName());
        super.onDestroy();
    }
}
