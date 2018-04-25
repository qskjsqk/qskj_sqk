package com.zhcd.lysqk;


import android.os.Handler;
import android.text.TextUtils;

import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.login.LoginActivity;


public class LoadingActivity extends BaseActivity {



    @Override
    protected int getLayoutResId() {
        return R.layout.activity_loading;
    }

    private void startActivity() {
//        String userToken = (String) SPUtils.get(this, UserInfoManager.userToken, "");
//        if (TextUtils.isEmpty(userToken)) {
            LoginActivity.start(LoadingActivity.this);
            finish();
//        } else {
//            UserInfoManager.getInstance().updateUserInfo(LoadingActivity.this);
//            HomeActivity.start(LoadingActivity.this, HomeActivity.COURSE_TAB);
//            finish();
//        }
    }

    @Override
    protected void initView() {
        hideCommonBaseTitle();
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                startActivity();
            }
        }, 1000);
    }
}
