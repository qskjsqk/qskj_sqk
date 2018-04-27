package com.zhcd.lysqk.module.home;

import android.os.Bundle;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseFragment;


public class ActionFragment extends BaseFragment {
    private SwipeRefreshLayout swipeRefreshLayout;
    private RecyclerView recyclerView;

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
        }
    }

    @Override
    protected void initData(Bundle savedInstanceState) {

    }


    @Override
    protected void initListener() {

    }
}
