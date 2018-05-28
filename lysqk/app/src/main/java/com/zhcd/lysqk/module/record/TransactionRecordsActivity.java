package com.zhcd.lysqk.module.record;

import android.content.Context;
import android.content.Intent;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;

import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.SConstant;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.manager.LoginInfoManager;
import com.zhcd.lysqk.module.action.ActionDetailSignActivity;
import com.zhcd.lysqk.module.home.ActionFragment;
import com.zhcd.lysqk.module.home.ActionListAdapter;
import com.zhcd.lysqk.module.home.entity.ActionListEntity;
import com.zhcd.lysqk.module.login.entity.LoginEntity;
import com.zhcd.lysqk.module.record.entity.TradingRecordListEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.utils.T;
import com.zjinv.uilibrary.recyclerview.wrapper.LoadMoreWrapper;
import com.zjinv.uilibrary.recyclerview.zhy.MultiItemTypeAdapter;

import java.util.ArrayList;
import java.util.List;


public class TransactionRecordsActivity extends BaseActivity {

    private SwipeRefreshLayout swipeRefreshLayout;
    private RecyclerView recyclerView;
    private TransactionRecordsAdapter recordsAdapter;
    private int page;
    private LoginEntity loginEntity;
    private List<TradingRecordListEntity> recordList;
    private LoadMoreWrapper mLoadMoreWrapper;
    private boolean isLoadEnd;

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_transaction_records;
    }

    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, TransactionRecordsActivity.class);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("兑换记录");
        titleBarBuilder.setBackText("返回");
        swipeRefreshLayout = (SwipeRefreshLayout) findViewById(R.id.swipeRefreshLayout);
        recyclerView = (RecyclerView) findViewById(R.id.recyclerView);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        recordsAdapter = new TransactionRecordsAdapter(this);
        loginEntity = LoginInfoManager.getInstance().getLoginEntity();
        recordList = new ArrayList<>();
        recordsAdapter.setData(recordList);
        mLoadMoreWrapper = new LoadMoreWrapper(recordsAdapter, recyclerView);
        recyclerView.setAdapter(mLoadMoreWrapper);
        setListener();
        getData(true);
    }

    private void setListener() {
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                swipeRefreshLayout.setRefreshing(false);
                getData(true);
            }
        });
        mLoadMoreWrapper.setOnLoadMoreListener(new LoadMoreWrapper.OnLoadMoreListener() {
            @Override
            public void onLoadMoreRequested() {
                if (isLoadEnd) {
                    mLoadMoreWrapper.setmFinish(true);
                    mLoadMoreWrapper.setLoadingState(true);
                } else if (page > 1 && !mLoadMoreWrapper.ismFinish()) {
                    getData(false);
                }
            }
        });
    }

    private void getData(final boolean isRefresh) {
        if (LoginInfoManager.getInstance().isLogin() && loginEntity != null) {
            mLoadMoreWrapper.setLoadingState(false);
            if (isRefresh) {
                isLoadEnd = false;
                page = 1;
            }
            showProgressDialog();
            ServiceProvider.getTradingRecordList(loginEntity.getAddress_id(), page, new IDataResponse() {
                @Override
                public void onResponse(BaseData obj) {
                    hideProgressDialog();
                    mLoadMoreWrapper.setmFinish(false);
                    if (ServiceProvider.errorFilter(obj)) {
                        List<TradingRecordListEntity> list = (List<TradingRecordListEntity>) obj.getData();
                        if (isRefresh)
                            recordList.clear();
                        if (list != null ) {
                            recordList.addAll(list);
                            recordsAdapter.setData(recordList);
                            mLoadMoreWrapper.notifyDataSetChanged();
                            if (list.size() < SConstant.PAGE_NUM) {
                                isLoadEnd = true;
                                mLoadMoreWrapper.setmFinish(true);
                                mLoadMoreWrapper.setLoadingState(true);
                            } else {
                                page++;
                            }
                        } else {
                            mLoadMoreWrapper.setLoadingState(true);
                            mLoadMoreWrapper.setmFinish(true);
                        }

                    } else {
                        if (obj != null)
                            T.showShort(obj.getMsg());
                        mLoadMoreWrapper.setmFinish(true);
                        mLoadMoreWrapper.setLoadingState(true);
                    }
                }
            }, ActionFragment.class.getSimpleName());
        }
    }
}
