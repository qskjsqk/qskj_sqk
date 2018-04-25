package com.zhcd.lysqk.module.sign;

import android.content.Context;
import android.content.Intent;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.login.LoginActivity;

public class SignActivity extends BaseActivity {
    @Override
    protected int getLayoutResId() {
        return R.layout.activity_sign;
    }

    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, SignActivity.class);
            context.startActivity(intent);
        }
    }
}
