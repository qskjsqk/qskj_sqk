package com.zhcd.lysqk.module.sign;

import android.content.Context;
import android.content.Intent;

import com.sanjieke.datarequest.network.RequestManager;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;

public class SignRecordActivity extends BaseActivity {
    @Override
    protected int getLayoutResId() {
        return R.layout.activity_sign_recode;
    }

    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, SignRecordActivity.class);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("签到记录");
        titleBarBuilder.setBackText("签到页面");
    }
    @Override
    protected void onDestroy() {
        RequestManager.cancelAll(SignRecordActivity.class.getSimpleName());
        super.onDestroy();
    }
}
