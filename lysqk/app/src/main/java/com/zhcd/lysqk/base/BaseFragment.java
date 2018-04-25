package com.zhcd.lysqk.base;

import android.view.View;

import com.zhcd.baseall.ZHBaseFragment;
import com.zhcd.lysqk.R;


public abstract class BaseFragment extends ZHBaseFragment {

    @Override
    protected void bindView(View view) {
        toolbar.setBackgroundColor(getResources().getColor(R.color.common_title_background));
        hideStatusBarHight();
    }

    @Override
    protected void unBindView() {
    }

    public void onRefresh() {
    }

    @Override
    public void onResume() {
        super.onResume();

    }

    @Override
    public void onPause() {
        super.onPause();

    }

}
