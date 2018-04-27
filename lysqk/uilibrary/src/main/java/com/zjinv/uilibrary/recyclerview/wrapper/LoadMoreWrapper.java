package com.zjinv.uilibrary.recyclerview.wrapper;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;

import com.zjinv.uilibrary.R;


public class LoadMoreWrapper<T> extends LinearRVLoadMoreWrapper<T> {

    private View mLoadMoreView;
    private boolean mFinish = false;

    public boolean ismFinish() {
        return mFinish;
    }

    public void setmFinish(boolean mFinish) {
        this.mFinish = mFinish;
    }

    public LoadMoreWrapper(RecyclerView.Adapter adapter, RecyclerView recyclerView) {
        super(adapter, recyclerView);
    }

    @Override
    protected void setDefaultLoadMoreView(Context context) {
        mLoadMoreView = LayoutInflater.from(context).inflate(R.layout.loading_more, recyclerView, false);

        setLoadMoreView(mLoadMoreView, new LoadMoreAndNoMoreDataCallback() {

            @Override
            public void onShowLoadMore(View mLoadMoreView) {
                if (!mFinish) {
                    setLoadingState(mLoadMoreView, false);
                }

            }

            @Override
            public void onShowLoadFailed(View mLoadMoreView) {

            }

            @Override
            public void onShowNoMoreData(View mLoadMoreView) {
                setLoadingState(mLoadMoreView, true);
            }

        });
    }

    public void setLoadingState(boolean isNoMoreData) {
        setLoadingState(mLoadMoreView, isNoMoreData);
    }

    public void setLoadingState(boolean isNoMoreData, boolean isShowLadMore) {
        setLoadingState(mLoadMoreView, isNoMoreData, isShowLadMore);
    }

    private void setLoadingState(View mLoadMoreView, boolean isNoMoreData) {
        View loadingmore = mLoadMoreView.findViewById(R.id.loading_more);
        View noMore = mLoadMoreView.findViewById(R.id.no_more_data);
        if (mLoadMoreView.getVisibility() == View.GONE)
            mLoadMoreView.setVisibility(View.VISIBLE);
        if (isNoMoreData) {
            loadingmore.setVisibility(View.GONE);
            noMore.setVisibility(View.VISIBLE);
        } else {
            loadingmore.setVisibility(View.VISIBLE);
            noMore.setVisibility(View.GONE);
        }
    }

    private void setLoadingState(View mLoadMoreView, boolean isNoMoreData, boolean isShowLadMore) {
        View loadingmore = mLoadMoreView.findViewById(R.id.loading_more);
        View noMore = mLoadMoreView.findViewById(R.id.no_more_data);
        mLoadMoreView.setVisibility(View.VISIBLE);
        if (isNoMoreData) {
            if (isShowLadMore)
                mLoadMoreView.setVisibility(View.GONE);

            loadingmore.setVisibility(View.GONE);
            noMore.setVisibility(View.VISIBLE);
        } else {
            loadingmore.setVisibility(View.VISIBLE);
            noMore.setVisibility(View.GONE);
        }
    }


}
