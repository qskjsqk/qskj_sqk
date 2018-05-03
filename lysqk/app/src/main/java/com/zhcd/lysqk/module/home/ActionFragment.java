package com.zhcd.lysqk.module.home;

import android.os.Bundle;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;

import com.sanjieke.datarequest.network.RequestManager;
import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.SConstant;
import com.zhcd.lysqk.base.BaseFragment;
import com.zhcd.lysqk.manager.LoginInfoManager;
import com.zhcd.lysqk.module.action.ActionDetailActivity;
import com.zhcd.lysqk.module.home.entity.ActionListEntity;
import com.zhcd.lysqk.module.login.entity.LoginEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.utils.T;
import com.zjinv.uilibrary.recyclerview.wrapper.LoadMoreWrapper;
import com.zjinv.uilibrary.recyclerview.zhy.MultiItemTypeAdapter;

import java.util.ArrayList;
import java.util.List;


public class ActionFragment extends BaseFragment {
    private SwipeRefreshLayout swipeRefreshLayout;
    private RecyclerView recyclerView;
    private ActionListAdapter listAdapter;
    private int page;
    private LoginEntity loginEntity;
    private List<ActionListEntity> actionList;
    private LoadMoreWrapper mLoadMoreWrapper;

    private boolean isLoadEnd;

    @Override
    protected int getLayoutResId() {
        return R.layout.fragment_action;
    }

    @Override
    protected void beforeViewBind() {

    }

    @Override
    protected void initView() {
        if (rootView != null) {
            swipeRefreshLayout = (SwipeRefreshLayout) rootView.findViewById(R.id.swipeRefreshLayout);
            recyclerView = (RecyclerView) rootView.findViewById(R.id.recyclerView);
            recyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
            listAdapter = new ActionListAdapter(getActivity());
            loginEntity = LoginInfoManager.getInstance().getLoginEntity();
            actionList = new ArrayList<>();
            listAdapter.setData(actionList);
            mLoadMoreWrapper = new LoadMoreWrapper(listAdapter, recyclerView);
            recyclerView.setAdapter(mLoadMoreWrapper);
            setListener();
            getData(true);
        }
    }

    private void setListener() {
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                swipeRefreshLayout.setRefreshing(false);
                getData(true);
            }
        });
        listAdapter.setOnItemClickListener(new MultiItemTypeAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(View view, RecyclerView.ViewHolder holder, int position) {
                if (actionList != null && actionList.size() > position) {
                    ActionListEntity listEntity = actionList.get(position);
                    ActionDetailActivity.start(getActivity(), listEntity.getId());
                }
            }

            @Override
            public boolean onItemLongClick(View view, RecyclerView.ViewHolder holder, int position) {
                return false;
            }
        });
        mLoadMoreWrapper.setOnLoadMoreListener(new LoadMoreWrapper.OnLoadMoreListener() {
            @Override
            public void onLoadMoreRequested() {
                if (isLoadEnd) {
                    mLoadMoreWrapper.setmFinish(true);
                    mLoadMoreWrapper.setLoadingState(true);
                } else if (actionList != null && actionList.size() > 0 && !mLoadMoreWrapper.ismFinish()) {
                    getData(false);
                }
            }
        });
    }

    private void getData(final boolean isRefresh) {
        if (LoginInfoManager.getInstance().isLogin() && actionList != null) {
            mLoadMoreWrapper.setLoadingState(false);
            if (isRefresh) {
                isLoadEnd = false;
                page = 1;
            }
            String address_id = loginEntity.getAddress_id();
            address_id = "1";
            ServiceProvider.getActivListPos(address_id, page, new IDataResponse() {
                @Override
                public void onResponse(BaseData obj) {
                    if (ServiceProvider.errorFilter(obj)) {
                        List<ActionListEntity> list = (List<ActionListEntity>) obj.getData();
                        if (isRefresh)
                            actionList.clear();
                        if (list != null && list.size() > 0) {
                            actionList.addAll(list);
//                            actionList.addAll(list);
//                            actionList.addAll(list);
//                            actionList.addAll(list);
//                            actionList.addAll(list);
//                            actionList.addAll(list);
                            listAdapter.setData(actionList);
                            mLoadMoreWrapper.notifyDataSetChanged();
                            if (list.size() < SConstant.PAGE_NUM) {
                                isLoadEnd = true;
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

    @Override
    protected void initData(Bundle savedInstanceState) {

    }

    @Override
    public void onDestroy() {
        RequestManager.cancelAll(ActionFragment.class.getSimpleName());
        super.onDestroy();
    }

    @Override
    protected void initListener() {

    }
}
