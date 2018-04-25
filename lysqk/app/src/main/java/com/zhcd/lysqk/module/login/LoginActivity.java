package com.zhcd.lysqk.module.login;


import android.content.Context;
import android.content.Intent;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;

public class LoginActivity extends BaseActivity {
    @Override
    protected int getLayoutResId() {
        return R.layout.activity_login;
    }
    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, LoginActivity.class);
            context.startActivity(intent);
        }
    }
}
