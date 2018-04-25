package com.zhcd.lysqk.base;

import android.os.Bundle;

import com.zhcd.baseall.ZHBaseActivity;
import com.zhcd.lysqk.R;

/**
 * Created by bobby on 17/4/18.
 */

public abstract class BaseActivity extends ZHBaseActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getLayoutResId() != 0) {
            setContentView(getLayoutResId());
        }
        toolbar.setBackgroundColor(getResources().getColor(R.color.common_title_background));

        initView();
        initData();
    }

    protected abstract int getLayoutResId();

    protected void initView() {
    }

    protected void initData() {
    }

    @Override
    public void onStart() {
        super.onStart();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }

    @Override
    protected void onResume() {
        super.onResume();
    }

    @Override
    protected void onPause() {
        super.onPause();
    }


    @Override
    protected void onStop() {
        super.onStop();
    }


}
